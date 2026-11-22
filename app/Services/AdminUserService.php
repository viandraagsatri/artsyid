<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AdminUserService
{
    public function __construct(
        private NotificationService $notificationService
    ) {}
    public const ALLOWED_ROLES = ['all', 'user', 'artist', 'admin'];

    public const ALLOWED_STATUSES = ['all', 'active', 'blocked', 'reported'];

    public function getStats(): array
    {
        return [
            'total'    => User::count(),
            'clients'  => User::where('role', 'user')->count(),
            'artists'  => User::where('role', 'artist')->count(),
            'admins'   => User::where('role', 'admin')->count(),
            'active'   => User::where('is_blocked', false)->count(),
            'blocked'  => User::where('is_blocked', true)->count(),
            'reported' => User::where('role', 'artist')->whereHas('reportsAgainst')->count(),
        ];
    }

    public function getStatusCountsForRole(string $role = 'all'): array
    {
        $base = User::query();

        if (in_array($role, ['user', 'artist', 'admin'], true)) {
            $base->where('role', $role);
        }

        return [
            'all'      => (clone $base)->count(),
            'active'   => (clone $base)->where('is_blocked', false)->count(),
            'blocked'  => (clone $base)->where('is_blocked', true)->count(),
            'reported' => in_array($role, ['all', 'artist'], true)
                ? (clone $base)->where('role', 'artist')->whereHas('reportsAgainst')->count()
                : 0,
        ];
    }

    public function getUsersForAdmin(
        string $role = 'all',
        string $status = 'all',
        ?string $search = null,
        int $perPage = 10
    ): LengthAwarePaginator {
        $query = User::query()
            ->with([
                'artistProfile',
                'artistApplications' => function ($q) {
                    $q->select(['id', 'user_id', 'status', 'created_at'])->latest('id');
                },
                'reportsAgainst' => function ($q) {
                    $q->with(['reporter:id,name,email', 'order:id,order_number'])->latest('id');
                },
            ])
            ->withCount([
                'ordersAsClient',
                'ordersAsArtist',
                'commissionMenus',
                'portfolios',
                'reportsAgainst',
                'reviewsGiven',
                'reportsFiled',
                'payoutsProcessed',
                'reportsHandled',
            ]);

        if (in_array($role, ['user', 'artist', 'admin'], true)) {
            $query->where('role', $role);
        }

        if ($status === 'active') {
            $query->where('is_blocked', false);
        } elseif ($status === 'blocked') {
            $query->where('is_blocked', true);
        } elseif ($status === 'reported') {
            $query->where('role', 'artist')->whereHas('reportsAgainst');
        }

        $trimmedSearch = trim((string) $search);
        if ($trimmedSearch !== '') {
            $term = '%' . mb_strtolower($trimmedSearch) . '%';
            $query->where(function ($q) use ($term) {
                $q->whereRaw('LOWER(name) LIKE ?', [$term])
                    ->orWhereRaw('LOWER(email) LIKE ?', [$term]);
            });
        }

        if ($status === 'reported') {
            $query->orderByDesc('reports_against_count')->latest('id');
        } else {
            $query->latest('id');
        }

        return $query->paginate($perPage)->withQueryString();
    }

    public function buildUserModalPayload(User $user): array
    {
        $isArtist = $user->role === 'artist';
        $reports = $isArtist ? ($user->reportsAgainst ?? collect()) : collect();
        $uniqueReporters = $isArtist ? $reports->pluck('reporter_id')->unique()->count() : 0;
        $reportsAgainstCount = $isArtist ? (int) ($user->reports_against_count ?? $reports->count()) : 0;

        $createdAtFormatted = $user->created_at
            ? $user->created_at->timezone('Asia/Jakarta')->translatedFormat('d F Y, H:i') . ' WIB'
            : '-';

        $blockedAtFormatted = $user->blocked_at
            ? $user->blocked_at->timezone('Asia/Jakarta')->translatedFormat('d F Y, H:i') . ' WIB'
            : null;

        $recentReports = $isArtist
            ? $reports->take(5)->map(function ($report) {
                return [
                    'reason'        => $report->reason,
                    'status'        => $report->status,
                    'reporter_name' => $report->reporter?->name ?? 'Pengguna Terhapus',
                    'order_number'  => $report->order?->order_number,
                    'date'          => $report->created_at
                        ? $report->created_at->timezone('Asia/Jakarta')->translatedFormat('d M Y, H:i') . ' WIB'
                        : '-',
                ];
            })->values()->toArray()
            : [];

        $ordersAsClientCount = (int) ($user->orders_as_client_count ?? 0);
        $ordersAsArtistCount = (int) ($user->orders_as_artist_count ?? 0);
        $commissionMenusCount = (int) ($user->commission_menus_count ?? 0);
        $portfoliosCount = (int) ($user->portfolios_count ?? 0);
        $reviewsGivenCount = (int) ($user->reviews_given_count ?? 0);
        $reportsFiledCount = (int) ($user->reports_filed_count ?? 0);
        $payoutsProcessedCount = (int) ($user->payouts_processed_count ?? 0);
        $reportsHandledCount = (int) ($user->reports_handled_count ?? 0);

        $artistApplication = null;
        if ($user->role === 'user') {
            $latestApp = ($user->artistApplications ?? collect())->first();
            if ($latestApp && in_array($latestApp->status, ['pending', 'rejected'], true)) {
                $artistApplication = [
                    'status' => $latestApp->status,
                    'label'  => $latestApp->status === 'pending'
                        ? 'Menunggu Verifikasi Admin'
                        : 'Pengajuan Terakhir Ditolak',
                    'url'    => route('admin.applications.index', [
                        'status' => $latestApp->status,
                        'search' => $user->email,
                    ]),
                ];
            }
        }

        if ($user->role === 'artist') {
            $roleMetricsTitle = 'Aktivitas Artist';
            $roleMetrics = [
                ['label' => 'Order Garapan', 'value' => $ordersAsArtistCount, 'tone' => 'default'],
                ['label' => 'Menu Komisi', 'value' => $commissionMenusCount, 'tone' => 'default'],
                ['label' => 'Portofolio', 'value' => $portfoliosCount, 'tone' => 'default'],
                [
                    'label' => 'Laporan Masuk',
                    'value' => $reportsAgainstCount,
                    'tone'  => $uniqueReporters > 3 ? 'danger' : ($reportsAgainstCount > 0 ? 'warning' : 'default'),
                ],
            ];
        } elseif ($user->role === 'admin') {
            $roleMetricsTitle = 'Aktivitas Operasional Admin';
            $roleMetrics = [
                ['label' => 'Payout Diproses', 'value' => $payoutsProcessedCount, 'tone' => 'default'],
                ['label' => 'Laporan Ditangani', 'value' => $reportsHandledCount, 'tone' => 'default'],
            ];
        } else {
            $roleMetricsTitle = 'Aktivitas Client';
            $roleMetrics = [
                ['label' => 'Pesanan Dibuat', 'value' => $ordersAsClientCount, 'tone' => 'default'],
                ['label' => 'Ulasan Diberikan', 'value' => $reviewsGivenCount, 'tone' => 'default'],
                ['label' => 'Laporan Diajukan', 'value' => $reportsFiledCount, 'tone' => 'default'],
            ];
        }

        $profile = $isArtist ? $user->artistProfile : null;

        return [
            'id'                      => $user->id,
            'name'                    => $user->name,
            'email'                   => $user->email,
            'role'                    => $user->role,
            'bio'                     => $user->bio,
            'is_blocked'              => (bool) $user->is_blocked,
            'blocked_at_formatted'    => $blockedAtFormatted,
            'block_reason'            => $user->block_reason,
            'created_at_formatted'    => $createdAtFormatted,
            'orders_as_client_count'  => $ordersAsClientCount,
            'orders_as_artist_count'  => $ordersAsArtistCount,
            'commission_menus_count'  => $commissionMenusCount,
            'portfolios_count'        => $portfoliosCount,
            'reports_against_count'   => $reportsAgainstCount,
            'reviews_given_count'     => $reviewsGivenCount,
            'reports_filed_count'     => $reportsFiledCount,
            'payouts_processed_count' => $payoutsProcessedCount,
            'reports_handled_count'   => $reportsHandledCount,
            'unique_reporters_count'  => $uniqueReporters,
            'is_high_risk'            => $isArtist && $uniqueReporters > 3,
            'role_metrics_title'      => $roleMetricsTitle,
            'role_metrics'            => $roleMetrics,
            'artist_application'      => $artistApplication,
            'artist_profile'          => $profile ? [
                'bank_name'      => $profile->bank_name,
                'account_number' => $profile->account_number,
                'account_holder' => $profile->account_holder,
            ] : null,
            'recent_reports'          => $recentReports,
            'update_url'              => route('admin.users.update', $user->id),
            'block_url'               => route('admin.users.block', $user->id),
            'unblock_url'             => route('admin.users.unblock', $user->id),
        ];
    }

    public function updateUser(User $target, User $admin, string $newRole): User
    {
        if ($target->id === $admin->id) {
            throw new \DomainException('Anda tidak dapat mengubah role akun Anda sendiri.');
        }

        if ($target->role === 'artist') {
            throw new \DomainException('Role akun Artist tidak dapat diubah melalui halaman Kelola Pengguna.');
        }

        if (!in_array($newRole, ['user', 'admin'], true)) {
            throw new \DomainException('Role hanya dapat diubah antara user dan admin.');
        }

        if ($target->role === $newRole) {
            throw new \DomainException('Role yang dipilih sama dengan role akun saat ini.');
        }

        if ($target->is_blocked && $newRole === 'admin') {
            throw new \DomainException('Akun yang sedang diblokir tidak dapat diubah menjadi Administrator. Buka blokir terlebih dahulu.');
        }

        if ($newRole === 'admin' && $target->artistApplications()->where('status', 'pending')->exists()) {
            throw new \DomainException('Pengguna ini masih memiliki pengajuan Artist berstatus menunggu verifikasi. Tinjau atau tolak pengajuannya terlebih dahulu.');
        }

        DB::transaction(function () use ($target, $newRole) {
            $oldRole = $target->role;

            $target->update([
                'role' => $newRole,
            ]);

            $this->notificationService->notifyUser(
                $target,
                'Perubahan Role Akun',
                "Role akun Anda diperbarui oleh administrator dari {$oldRole} menjadi {$newRole}.",
                route('dashboard')
            );
        });

        return $target->fresh();
    }

    public function blockUser(User $target, User $admin, string $reason): User
    {
        if ($target->id === $admin->id) {
            throw new \DomainException('Anda tidak dapat memblokir akun Anda sendiri.');
        }

        if ($target->role === 'admin') {
            throw new \DomainException('Akun Administrator tidak dapat diblokir.');
        }

        if ($target->is_blocked) {
            throw new \DomainException('Akun pengguna ini sudah dalam status diblokir.');
        }

        DB::transaction(function () use ($target, $reason) {
            $cleanReason = trim($reason);

            $target->update([
                'is_blocked'   => true,
                'blocked_at'   => now(),
                'block_reason' => $cleanReason,
            ]);

            if (Schema::hasTable('sessions')) {
                DB::table('sessions')->where('user_id', $target->id)->delete();
            }

            $this->notificationService->notifyUser(
                $target,
                'Akun Anda Diblokir',
                'Akun Anda telah diblokir oleh administrator. Alasan: ' . $cleanReason,
                null
            );
        });

        return $target->fresh();
    }

    public function unblockUser(User $target, User $admin): User
    {
        if (!$target->is_blocked) {
            throw new \DomainException('Akun pengguna ini tidak dalam status diblokir.');
        }

        DB::transaction(function () use ($target) {
            $target->update([
                'is_blocked'   => false,
                'blocked_at'   => null,
                'block_reason' => null,
            ]);

            $this->notificationService->notifyUser(
                $target,
                'Akun Anda Diaktifkan Kembali',
                'Pemblokiran akun Anda telah dicabut oleh administrator. Anda kini dapat kembali menggunakan Artsy ID.',
                route('dashboard')
            );
        });

        return $target->fresh();
    }
}
