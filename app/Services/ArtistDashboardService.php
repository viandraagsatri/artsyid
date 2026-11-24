<?php

namespace App\Services;

use App\Models\CommissionMenu;
use App\Models\Order;
use App\Models\Payout;
use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class ArtistDashboardService
{
  
    public const ACTIVE_STATUSES = [
        'awaiting_dp',
        'on_progress',
        'review',
        'revision',
        'awaiting_final_payment',
    ];

    public function getMetrics(User $artist): array
    {
        $activeOrdersCount = Order::where('artist_id', $artist->id)
            ->whereIn('status', self::ACTIVE_STATUSES)
            ->count();

        $pendingReviewCount = Order::where('artist_id', $artist->id)
            ->where('status', 'pending_review')
            ->count();

        $completedOrdersCount = Order::where('artist_id', $artist->id)
            ->where('status', 'completed')
            ->count();

        $totalEarnings = Payout::where('artist_id', $artist->id)
            ->where('status', 'paid')
            ->sum('amount');

        $pendingPayouts = Payout::where('artist_id', $artist->id)
            ->where('status', 'pending')
            ->sum('amount');

        $commissionMenusCount = CommissionMenu::where('artist_id', $artist->id)->count();
        $portfoliosCount = Portfolio::where('artist_id', $artist->id)->count();

        return [
            'activeOrdersCount'    => $activeOrdersCount,
            'pendingReviewCount'   => $pendingReviewCount,
            'completedOrdersCount' => $completedOrdersCount,
            'totalEarnings'        => (float) $totalEarnings,
            'pendingPayouts'       => (float) $pendingPayouts,
            'commissionMenusCount' => $commissionMenusCount,
            'portfoliosCount'      => $portfoliosCount,
        ];
    }

    public function getPendingReviewOrders(User $artist, int $limit = 5): Collection
    {
        return Order::with(['client', 'commissionMenu', 'addons.addon'])
            ->where('artist_id', $artist->id)
            ->where('status', 'pending_review')
            ->latest('created_at')
            ->take($limit)
            ->get();
    }

    public function getActiveOrders(User $artist, int $limit = 5): Collection
    {
        return Order::with([
                'client',
                'commissionMenu',
                'tracks' => function ($q) {
                    $q->orderBy('step_order');
                },
            ])
            ->where('artist_id', $artist->id)
            ->whereIn('status', self::ACTIVE_STATUSES)
            ->latest('updated_at')
            ->take($limit)
            ->get();
    }

    public function getCommissionMenusSummary(User $artist, int $limit = 4): Collection
    {
        return CommissionMenu::with(['category', 'samples'])
            ->where('artist_id', $artist->id)
            ->latest('id')
            ->take($limit)
            ->get();
    }

    public function getRecentPortfolios(User $artist, int $limit = 6): Collection
    {
        return Portfolio::where('artist_id', $artist->id)
            ->latest('id')
            ->take($limit)
            ->get();
    }

    public function getDashboardData(User $artist): array
    {
        $metrics = $this->getMetrics($artist);
        $pendingReviews = $this->getPendingReviewOrders($artist);
        $activeOrders = $this->getActiveOrders($artist);
        $menus = $this->getCommissionMenusSummary($artist);
        $portfolios = $this->getRecentPortfolios($artist);
        $profile = $artist->artistProfile;

        return compact('metrics', 'pendingReviews', 'activeOrders', 'menus', 'portfolios', 'profile', 'artist');
    }
}
