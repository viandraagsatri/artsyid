<?php

namespace App\Services;

use App\Models\ArtistApplication;
use App\Models\ArtistReport;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Payout;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class AdminDashboardService
{
    public function getMetrics(): array
    {
        $latestStatusSql = '(SELECT status FROM artist_applications WHERE artist_applications.user_id = users.id ORDER BY id DESC LIMIT 1)';

        $pendingApplicationsCount = User::whereHas('artistApplications')
            ->whereRaw("{$latestStatusSql} = ?", ['pending'])
            ->count();

        $pendingPayoutsCount = Payout::where('status', 'pending')->count();
        $pendingPayoutsAmount = Payout::where('status', 'pending')->sum('amount');

        $totalEscrowTransacted = Payment::whereIn('payment_status', AdminPaymentService::SUCCESS_STATUSES)
            ->sum('amount');

        $activeOrdersCount = Order::whereIn('status', [
            'pending_review',
            'awaiting_dp',
            'on_progress',
            'review',
            'revision',
            'awaiting_final_payment',
        ])->count();

        $completedOrdersCount = Order::where('status', 'completed')->count();
        $totalUsersCount = User::where('role', 'user')->count();
        $totalArtistsCount = User::where('role', 'artist')->count();
        $pendingReportsCount = ArtistReport::where('status', 'pending')->count();

        return [
            'pendingApplicationsCount' => $pendingApplicationsCount,
            'pendingPayoutsCount'      => $pendingPayoutsCount,
            'pendingPayoutsAmount'     => (float) $pendingPayoutsAmount,
            'totalEscrowTransacted'    => (float) $totalEscrowTransacted,
            'activeOrdersCount'        => $activeOrdersCount,
            'completedOrdersCount'     => $completedOrdersCount,
            'totalUsersCount'          => $totalUsersCount,
            'totalArtistsCount'        => $totalArtistsCount,
            'pendingReportsCount'      => $pendingReportsCount,
        ];
    }

    public function getActionRequiredItems(): array
    {
        $metrics = $this->getMetrics();

        $items = [];

        if ($metrics['pendingApplicationsCount'] > 0) {
            $items[] = [
                'type'        => 'application',
                'title'       => "{$metrics['pendingApplicationsCount']} Pengajuan Artist Menunggu Verifikasi",
                'description' => 'Ada pendaftar artist baru yang menunggu peninjauan rekening bank dan portofolio.',
                'link'        => route('admin.applications.index', ['status' => 'pending']),
                'icon'        => 'fa-solid fa-id-card-clip',
                'badge'       => 'Verifikasi Segera',
                'color'       => 'amber',
            ];
        }

        if ($metrics['pendingPayoutsCount'] > 0) {
            $formattedAmount = 'Rp ' . number_format($metrics['pendingPayoutsAmount'], 0, ',', '.');
            $items[] = [
                'type'        => 'payout',
                'title'       => "{$metrics['pendingPayoutsCount']} Antrean Pencairan Dana ({$formattedAmount})",
                'description' => 'Artist telah menyelesaikan tahapan dan dana siap ditransfer secara manual.',
                'link'        => route('admin.payouts.index'),
                'icon'        => 'fa-solid fa-money-bill-transfer',
                'badge'       => 'Perlu Transfer',
                'color'       => 'sky',
            ];
        }

        if ($metrics['pendingReportsCount'] > 0) {
            $items[] = [
                'type'        => 'report',
                'title'       => "{$metrics['pendingReportsCount']} Laporan Sengketa Pengguna",
                'description' => 'Terdapat laporan pelanggaran atau sengketa transaksi yang perlu ditindaklanjuti.',
                'link'        => route('admin.reports.index'),
                'icon'        => 'fa-solid fa-triangle-exclamation',
                'badge'       => 'Tinjau Sengketa',
                'color'       => 'rose',
            ];
        }

        return $items;
    }

    public function getRecentOrders(int $limit = 5): Collection
    {
        return Order::with(['client', 'artist', 'commissionMenu'])
            ->latest('id')
            ->take($limit)
            ->get();
    }

    public function getRecentApplications(int $limit = 5): Collection
    {
        return ArtistApplication::with(['user', 'user.artistProfile'])
            ->latest('id')
            ->take($limit)
            ->get();
    }

    public function getDashboardData(): array
    {
        $metrics = $this->getMetrics();
        $actionItems = $this->getActionRequiredItems();
        $recentOrders = $this->getRecentOrders();
        $recentApplications = $this->getRecentApplications();

        return compact('metrics', 'actionItems', 'recentOrders', 'recentApplications');
    }
}
