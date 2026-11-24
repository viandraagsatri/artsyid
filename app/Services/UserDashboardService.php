<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserDashboardService
{
    public const ACTIVE_STATUSES = [
        'pending_review',
        'awaiting_dp',
        'on_progress',
        'review',
        'revision',
        'awaiting_final_payment',
    ];

    public function getMetrics(User $client): array
    {
        $activeOrdersCount = Order::where('client_id', $client->id)
            ->whereIn('status', self::ACTIVE_STATUSES)
            ->count();

        $activeOrderIds = Order::where('client_id', $client->id)
            ->whereIn('status', self::ACTIVE_STATUSES)
            ->pluck('id');

        $escrowBalance = Payment::whereHas('invoice', function ($q) use ($activeOrderIds) {
                $q->whereIn('order_id', $activeOrderIds);
            })
            ->whereIn('payment_status', ['settlement', 'capture', 'success'])
            ->sum('amount');

        $waitingApprovalCount = Order::where('client_id', $client->id)
            ->where('status', 'review')
            ->count();

        $completedOrdersCount = Order::where('client_id', $client->id)
            ->where('status', 'completed')
            ->count();

        return [
            'activeOrdersCount'    => $activeOrdersCount,
            'escrowBalance'        => (float) $escrowBalance,
            'waitingApprovalCount' => $waitingApprovalCount,
            'completedOrdersCount' => $completedOrdersCount,
        ];
    }


    public function getActionRequiredOrder(User $client): ?Order
    {
        return Order::with(['artist', 'commissionMenu', 'tracks' => function ($q) {
                $q->orderBy('step_order');
            }])
            ->where('client_id', $client->id)
            ->whereIn('status', ['review', 'awaiting_dp', 'awaiting_final_payment'])
            ->orderByRaw("CASE WHEN status = 'review' THEN 1 WHEN status = 'awaiting_final_payment' THEN 2 ELSE 3 END")
            ->latest('updated_at')
            ->first();
    }

    public function getActiveOrders(User $client, int $limit = 5): Collection
    {
        return Order::with([
                'artist',
                'artist.artistProfile',
                'commissionMenu',
                'tracks' => function ($q) {
                    $q->orderBy('step_order');
                },
                'invoices.payments',
            ])
            ->where('client_id', $client->id)
            ->whereIn('status', self::ACTIVE_STATUSES)
            ->latest('updated_at')
            ->take($limit)
            ->get();
    }

    public function getCompletedOrders(User $client, int $limit = 5): Collection
    {
        return Order::with(['artist', 'commissionMenu', 'review'])
            ->where('client_id', $client->id)
            ->where('status', 'completed')
            ->latest('updated_at')
            ->take($limit)
            ->get();
    }
 
    public function getDashboardData(User $client): array
    {
        $metrics = $this->getMetrics($client);
        $actionOrder = $this->getActionRequiredOrder($client);
        $activeOrders = $this->getActiveOrders($client);

        return compact('metrics', 'actionOrder', 'activeOrders', 'client');
    }
}
