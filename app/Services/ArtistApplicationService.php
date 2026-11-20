<?php

namespace App\Services;

use App\Models\ArtistApplication;
use App\Models\ArtistProfile;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ArtistApplicationService
{
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
        });
    }

    public function getApplicationsForAdmin(string $status = 'all', ?string $search = null, int $perPage = 10): LengthAwarePaginator
    {
        $query = User::whereHas('artistApplications')
            ->with([
                'artistProfile',
                'artistApplications' => function ($q) {
                    $q->orderByDesc('id');
                }
            ]);

        $latestStatusSql = '(SELECT status FROM artist_applications WHERE artist_applications.user_id = users.id ORDER BY id DESC LIMIT 1)';

        if ($status !== 'all' && in_array($status, ['pending', 'approved', 'rejected'])) {
            $query->whereRaw("{$latestStatusSql} = ?", [$status]);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        return $query->latest('id')->paginate($perPage)->withQueryString();
    }

    public function getApplicationStats(): array
    {
        $latestStatusSql = '(SELECT status FROM artist_applications WHERE artist_applications.user_id = users.id ORDER BY id DESC LIMIT 1)';

        $total = User::whereHas('artistApplications')->count();
        $pending = User::whereHas('artistApplications')->whereRaw("{$latestStatusSql} = ?", ['pending'])->count();
        $approved = User::whereHas('artistApplications')->whereRaw("{$latestStatusSql} = ?", ['approved'])->count();
        $rejected = User::whereHas('artistApplications')->whereRaw("{$latestStatusSql} = ?", ['rejected'])->count();

        return compact('total', 'pending', 'approved', 'rejected');
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
            $pastRejections = $allApps
                ->where('status', 'rejected')
                ->groupBy(function ($app) {
                    return $app->updated_at ? $app->updated_at->format('Y-m-d H:i:s') : ($app->created_at ? $app->created_at->format('Y-m-d H:i:s') : $app->id);
                })
                ->map(function ($batch) {
                    $first = $batch->first();
                    return [
                        'date'  => $first->updated_at ? $first->updated_at->timezone('Asia/Jakarta')->translatedFormat('d F Y, H:i') . ' WIB' : '-',
                        'notes' => $first->admin_notes ?: 'Tanpa catatan',
                        'links' => $batch->pluck('verification_file_url')->unique()->values()->toArray(),
                    ];
                })
                ->values()
                ->toArray();
        } else {
            $latestUpdateKey = $latestApp->updated_at ? $latestApp->updated_at->format('Y-m-d H:i:s') : ($latestApp->created_at ? $latestApp->created_at->format('Y-m-d H:i:s') : null);

            $activeBatch = $allApps->filter(function ($app) use ($appStatus, $latestUpdateKey) {
                $appKey = $app->updated_at ? $app->updated_at->format('Y-m-d H:i:s') : ($app->created_at ? $app->created_at->format('Y-m-d H:i:s') : null);
                return $app->status === $appStatus && $appKey === $latestUpdateKey;
            });

            $pastRejections = $allApps
                ->filter(function ($app) use ($latestUpdateKey) {
                    $appKey = $app->updated_at ? $app->updated_at->format('Y-m-d H:i:s') : ($app->created_at ? $app->created_at->format('Y-m-d H:i:s') : null);
                    return $app->status === 'rejected' && $appKey !== $latestUpdateKey;
                })
                ->groupBy(function ($app) {
                    return $app->updated_at ? $app->updated_at->format('Y-m-d H:i:s') : ($app->created_at ? $app->created_at->format('Y-m-d H:i:s') : $app->id);
                })
                ->map(function ($batch) {
                    $first = $batch->first();
                    return [
                        'date'  => $first->updated_at ? $first->updated_at->timezone('Asia/Jakarta')->translatedFormat('d F Y, H:i') . ' WIB' : '-',
                        'notes' => $first->admin_notes ?: 'Tanpa catatan',
                        'links' => $batch->pluck('verification_file_url')->unique()->values()->toArray(),
                    ];
                })
                ->values()
                ->toArray();
        }

        $activeLinks = $activeBatch->pluck('verification_file_url')->unique()->values()->toArray();
        $activeNotes = $latestApp ? $latestApp->admin_notes : null;

        $tos = $profile ? ($profile->tos ?? []) : [];
        $bisaList = $tos['bisa_digambar'] ?? [];
        $tidakList = $tos['tidak_menerima'] ?? [];

        $isReapplication = $appStatus === 'pending' && count($pastRejections) > 0;

        return [
            'profile'         => $profile,
            'latestApp'       => $latestApp,
            'appStatus'       => $appStatus,
            'activeLinks'     => $activeLinks,
            'activeNotes'     => $activeNotes,
            'pastRejections'  => $pastRejections,
            'isReapplication' => $isReapplication,
            'bisaList'        => $bisaList,
            'tidakList'       => $tidakList,
        ];
    }

    public function approveApplication(User $user, ?string $adminNotes = null): void
    {
        DB::transaction(function () use ($user, $adminNotes) {
            ArtistApplication::where('user_id', $user->id)
                ->where('status', 'pending')
                ->update([
                    'status'      => 'approved',
                    'admin_notes' => $adminNotes,
                    'updated_at'  => now(),
                ]);

            $user->update([
                'role' => 'artist',
            ]);

            Notification::create([
                'user_id'    => $user->id,
                'title'      => 'Pengajuan Artist Disetujui!',
                'message'    => 'Selamat! Pengajuan kamu menjadi artist di Artsy ID telah disetujui admin. Kamu sekarang dapat mengatur katalog komisi dan portofolio.',
                'link_url'   => route('profile.katalog'),
                'is_read'    => false,
            ]);
        });
    }

    public function rejectApplication(User $user, string $adminNotes): void
    {
        DB::transaction(function () use ($user, $adminNotes) {
            ArtistApplication::where('user_id', $user->id)
                ->where('status', 'pending')
                ->update([
                    'status'      => 'rejected',
                    'admin_notes' => $adminNotes,
                    'updated_at'  => now(),
                ]);

            Notification::create([
                'user_id'    => $user->id,
                'title'      => 'Pengajuan Artist Ditolak',
                'message'    => 'Mohon maaf, pengajuan menjadi artist belum dapat kami setujui. Alasan: ' . $adminNotes,
                'link_url'   => route('register.artist'),
                'is_read'    => false,
            ]);
        });
    }

    private function toLines(string $text): array
    {
        return array_values(array_filter(array_map('trim', preg_split('/\R/', $text))));
    }
}
