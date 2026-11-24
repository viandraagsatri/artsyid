<?php

namespace App\Services;

use App\Models\ArtistApplication;
use App\Models\ArtistProfile;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ArtistApplicationService
{
    public const ALLOWED_STATUS_FILTERS = ['all', 'pending', 'approved', 'rejected'];

    public function __construct(
        private NotificationService $notificationService
    ) {}

    public function hasPendingApplication(int $userId): bool
    {
        return ArtistApplication::where('user_id', $userId)
            ->where('status', 'pending')
            ->exists();
    }

    public function getLastRejectedApplication(int $userId): ?ArtistApplication
    {
        if ($this->hasPendingApplication($userId)) {
            return null;
        }

        return ArtistApplication::where('user_id', $userId)
            ->where('status', 'rejected')
            ->orderByDesc('updated_at')
            ->orderByDesc('id')
            ->first();
    }

    public function getLastRejectedLinks(int $userId): array
    {
        $lastRejected = $this->getLastRejectedApplication($userId);
        if (!$lastRejected) {
            return [];
        }

        return ArtistApplication::where('user_id', $userId)
            ->where('status', 'rejected')
            ->where(function ($q) use ($lastRejected) {
                if ($lastRejected->updated_at) {
                    $q->where('updated_at', $lastRejected->updated_at);
                } else {
                    $q->where('created_at', $lastRejected->created_at);
                }
            })
            ->pluck('verification_file_url')
            ->unique()
            ->values()
            ->toArray();
    }

    public function getApplicationHistory(int $userId)
    {
        return ArtistApplication::where('user_id', $userId)
            ->latest('id')
            ->get();
    }

    public function storeApplication(User $user, array $data): void
    {
        DB::transaction(function () use ($user, $data) {
            $isReapplication = ArtistApplication::where('user_id', $user->id)
                ->where('status', 'rejected')
                ->exists();

            ArtistProfile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'bank_name'      => $data['bank_name'],
                    'account_number' => $data['account_number'],
                    'account_holder' => $data['account_holder'],
                    'tos'            => [
                        'bisa_digambar'  => $this->toLines($data['tos_bisa']),
                        'tidak_menerima' => $this->toLines($data['tos_tidak']),
                    ],
                ]
            );

            $now = now();
            foreach ($data['portfolio_links'] as $link) {
                ArtistApplication::create([
                    'user_id'               => $user->id,
                    'verification_file_url' => $link,
                    'created_at'            => $now,
                    'updated_at'            => $now,
                ]);
            }

            $this->notificationService->notifyNewArtistApplication($user, $isReapplication);
        });
    }

    public function getApplicationsForAdmin(string $status = 'all', ?string $search = null, int $perPage = 10): LengthAwarePaginator
    {
        $normalizedStatus = in_array($status, self::ALLOWED_STATUS_FILTERS, true) ? $status : 'all';

        $query = User::whereHas('artistApplications')
            ->with([
                'artistProfile',
                'artistApplications' => function ($q) {
                    $q->orderByDesc('id');
                },
            ]);

        $latestStatusSql = '(SELECT status FROM artist_applications WHERE artist_applications.user_id = users.id ORDER BY id DESC LIMIT 1)';

        if ($normalizedStatus !== 'all') {
            $query->whereRaw("{$latestStatusSql} = ?", [$normalizedStatus]);
        }

        $this->applySearchFilter($query, $search);

        return $query
            ->orderByRaw('(SELECT MAX(id) FROM artist_applications WHERE artist_applications.user_id = users.id) DESC')
            ->orderByDesc('id')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function getApplicationStats(): array
    {
        return $this->getStatusCountsForSearch(null);
    }

    public function getStatusCountsForSearch(?string $search = null): array
    {
        $latestStatusSql = '(SELECT status FROM artist_applications WHERE artist_applications.user_id = users.id ORDER BY id DESC LIMIT 1)';

        $base = User::whereHas('artistApplications');
        $this->applySearchFilter($base, $search);

        $total = (clone $base)->count();
        $pending = (clone $base)->whereRaw("{$latestStatusSql} = ?", ['pending'])->count();
        $approved = (clone $base)->whereRaw("{$latestStatusSql} = ?", ['approved'])->count();
        $rejected = (clone $base)->whereRaw("{$latestStatusSql} = ?", ['rejected'])->count();

        return compact('total', 'pending', 'approved', 'rejected');
    }

    public function sanitizeExternalUrl(?string $url): ?string
    {
        $trimmed = trim((string) $url);
        if ($trimmed === '' || !preg_match('#^https?://#i', $trimmed)) {
            return null;
        }

        if (filter_var($trimmed, FILTER_VALIDATE_URL) === false) {
            return null;
        }

        $scheme = strtolower((string) parse_url($trimmed, PHP_URL_SCHEME));

        return in_array($scheme, ['http', 'https'], true) ? $trimmed : null;
    }

    public function resolveApplicantCardData(User $applicant): array
    {
        $profile = $applicant->artistProfile;
        $allApps = ($applicant->artistApplications ?? collect())->sortByDesc('id')->values();
        $latestApp = $allApps->first();
        $appStatus = $latestApp ? $latestApp->status : 'pending';

        if (!$latestApp) {
            $activeBatch = collect();
            $pastRejections = [];
        } elseif ($appStatus === 'pending') {
            $activeBatch = $allApps->where('status', 'pending');
            $pastRejections = $this->formatRejectionBatches($allApps->where('status', 'rejected'));
        } else {
            $latestUpdateKey = $this->resolveBatchTimestampKey($latestApp);

            $activeBatch = $allApps->filter(function ($app) use ($appStatus, $latestUpdateKey) {
                return $app->status === $appStatus && $this->resolveBatchTimestampKey($app) === $latestUpdateKey;
            });

            $pastRejections = $this->formatRejectionBatches(
                $allApps->filter(function ($app) use ($latestUpdateKey) {
                    return $app->status === 'rejected' && $this->resolveBatchTimestampKey($app) !== $latestUpdateKey;
                })
            );
        }

        $activeLinks = $activeBatch->pluck('verification_file_url')->unique()->values()->toArray();
        $safeActiveLinks = array_map(fn ($link) => [
            'url'  => $link,
            'href' => $this->sanitizeExternalUrl($link),
        ], $activeLinks);
        $activeNotes = $latestApp ? $latestApp->admin_notes : null;

        $tos = $profile ? ($profile->tos ?? []) : [];
        $bisaList = $tos['bisa_digambar'] ?? [];
        $tidakList = $tos['tidak_menerima'] ?? [];

        $isReapplication = $appStatus === 'pending' && count($pastRejections) > 0;
        $isBlocked = (bool) $applicant->is_blocked;
        $hasPendingBatch = $allApps->contains('status', 'pending');
        $canApprove = $appStatus === 'pending' && $hasPendingBatch && $applicant->role === 'user' && !$isBlocked;
        $canReject = $appStatus === 'pending' && $hasPendingBatch && $applicant->role === 'user';

        return [
            'profile'         => $profile,
            'latestApp'       => $latestApp,
            'appStatus'       => $appStatus,
            'activeLinks'     => $activeLinks,
            'safeActiveLinks' => $safeActiveLinks,
            'activeNotes'     => $activeNotes,
            'pastRejections'  => $pastRejections,
            'isReapplication' => $isReapplication,
            'isBlocked'       => $isBlocked,
            'canApprove'      => $canApprove,
            'canReject'       => $canReject,
            'bisaList'        => $bisaList,
            'tidakList'       => $tidakList,
        ];
    }

    public function approveApplication(User $user, ?string $adminNotes = null): void
    {
        DB::transaction(function () use ($user, $adminNotes) {
            $lockedUser = User::whereKey($user->id)->lockForUpdate()->firstOrFail();

            if ($lockedUser->role !== 'user') {
                throw new \DomainException('Hanya akun Client (user) yang dapat disetujui menjadi Artist.');
            }

            if ($lockedUser->is_blocked) {
                throw new \DomainException('Akun yang sedang diblokir tidak dapat disetujui menjadi Artist.');
            }

            $pendingQuery = ArtistApplication::where('user_id', $lockedUser->id)
                ->where('status', 'pending');

            if (!(clone $pendingQuery)->lockForUpdate()->exists()) {
                throw new \DomainException('Tidak ada pengajuan artist berstatus menunggu untuk akun ini.');
            }

            $cleanNotes = trim((string) $adminNotes);
            $notesToSave = $cleanNotes !== '' ? $cleanNotes : null;

            $pendingQuery->update([
                'status'      => 'approved',
                'admin_notes' => $notesToSave,
                'updated_at'  => now(),
            ]);

            $lockedUser->update([
                'role' => 'artist',
            ]);

            $this->notificationService->notifyUser(
                $lockedUser,
                'Pengajuan Artist Disetujui!',
                'Selamat! Pengajuan kamu menjadi artist di Artsy ID telah disetujui admin. Kamu sekarang dapat mengatur katalog komisi dan portofolio.',
                route('profile.katalog'),
                'artist'
            );
        });
    }

    public function rejectApplication(User $user, string $adminNotes): void
    {
        DB::transaction(function () use ($user, $adminNotes) {
            $lockedUser = User::whereKey($user->id)->lockForUpdate()->firstOrFail();

            if ($lockedUser->role !== 'user') {
                throw new \DomainException('Pengajuan hanya dapat ditolak untuk akun berstatus Client (user).');
            }

            $cleanNotes = trim($adminNotes);
            if (mb_strlen($cleanNotes) < 5) {
                throw new \DomainException('Alasan penolakan minimal 5 karakter.');
            }

            $pendingQuery = ArtistApplication::where('user_id', $lockedUser->id)
                ->where('status', 'pending');

            if (!(clone $pendingQuery)->lockForUpdate()->exists()) {
                throw new \DomainException('Tidak ada pengajuan artist berstatus menunggu untuk akun ini.');
            }

            $pendingQuery->update([
                'status'      => 'rejected',
                'admin_notes' => $cleanNotes,
                'updated_at'  => now(),
            ]);

            $this->notificationService->notifyUser(
                $lockedUser,
                'Pengajuan Artist Ditolak',
                'Mohon maaf, pengajuan menjadi artist belum dapat kami setujui. Alasan: ' . $cleanNotes,
                route('register.artist'),
                'user'
            );
        });
    }

    private function applySearchFilter(Builder $query, ?string $search): void
    {
        $trimmed = trim((string) $search);
        if ($trimmed === '') {
            return;
        }

        $term = '%' . mb_strtolower($trimmed) . '%';
        $query->where(function (Builder $q) use ($term) {
            $q->whereRaw('LOWER(name) LIKE ?', [$term])
                ->orWhereRaw('LOWER(email) LIKE ?', [$term]);
        });
    }

    private function formatRejectionBatches(Collection $rejectedApps): array
    {
        return $rejectedApps
            ->groupBy(fn ($app) => $this->resolveBatchTimestampKey($app) ?? $app->id)
            ->map(function (Collection $batch) {
                $first = $batch->first();
                $uniqueUrls = $batch->pluck('verification_file_url')->unique()->values()->toArray();

                return [
                    'date'      => $first->updated_at ? $first->updated_at->timezone('Asia/Jakarta')->translatedFormat('d F Y, H:i') . ' WIB' : '-',
                    'notes'     => $first->admin_notes ?: 'Tanpa catatan',
                    'links'     => $uniqueUrls,
                    'safeLinks' => array_map(fn ($url) => [
                        'url'  => $url,
                        'href' => $this->sanitizeExternalUrl($url),
                    ], $uniqueUrls),
                ];
            })
            ->values()
            ->toArray();
    }

    private function resolveBatchTimestampKey(ArtistApplication $app): ?string
    {
        if ($app->updated_at) {
            return $app->updated_at->format('Y-m-d H:i:s');
        }

        return $app->created_at ? $app->created_at->format('Y-m-d H:i:s') : null;
    }

    private function toLines(string $text): array
    {
        return array_values(array_filter(array_map('trim', preg_split('/\R/', $text))));
    }
}
