<?php

namespace App\Services;

use App\Models\ArtistReport;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Payout;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class SidebarIndicatorService
{
    public function getIndicatorsForUser(?User $user): array
    {
        $indicators = [
            'admin' => [
                'payouts'      => false,
                'payments'     => false,
                'applications' => false,
                'reports'      => false,
            ],
            'artist' => [
                'orders'  => false,
                'tracker' => false,
                'payouts' => false,
            ],
            'user' => [
                'orders'   => false,
                'invoices' => false,
            ],
        ];

        if (!$user) {
            return $indicators;
        }

        return match ($user->role) {
            'admin' => [
                ...$indicators,
                'admin' => $this->getAdminIndicators(),
            ],
            'artist' => [
                ...$indicators,
                'artist' => $this->getArtistIndicators($user),
            ],
            'user' => [
                ...$indicators,
                'user' => $this->getClientIndicators($user),
            ],
            default => $indicators,
        };
    }

    private function getAdminIndicators(): array
    {
        $hasPendingPayouts = Payout::where('status', 'pending')->exists();

        $hasPendingOrMismatchedPayments = Payment::where('payment_status', 'pending')
            ->orWhere(function (Builder $q) {
                $q->whereIn('payment_status', AdminPaymentService::SUCCESS_STATUSES)
                    ->whereHas('invoice', function (Builder $iq) {
                        $iq->where(function (Builder $inner) {
                            $inner->where('status', '!=', 'paid')
                                ->orWhereRaw('ABS(payments.amount - invoices.amount) > 0.01');
                        });
                    });
            })
            ->exists();

        $latestStatusSql = '(SELECT status FROM artist_applications WHERE artist_applications.user_id = users.id ORDER BY id DESC LIMIT 1)';
        $hasPendingApplications = User::whereHas('artistApplications')
            ->whereRaw("{$latestStatusSql} = ?", ['pending'])
            ->exists();

        $hasPendingReports = ArtistReport::where('status', 'pending')->exists();

        return [
            'payouts'      => $hasPendingPayouts,
            'payments'     => $hasPendingOrMismatchedPayments,
            'applications' => $hasPendingApplications,
            'reports'      => $hasPendingReports,
        ];
    }

    private function getArtistIndicators(User $artist): array
    {
        $hasPendingOrders = Order::where('artist_id', $artist->id)
            ->where('status', 'pending_review')
            ->exists();

        $hasWipTasks = Order::where('artist_id', $artist->id)
            ->where(function (Builder $q) {
                $q->where('status', 'revision')
                    ->orWhere(function (Builder $sub) {
                        $sub->where('status', 'on_progress')
                            ->whereDoesntHave('tracks', function (Builder $tq) {
                                $tq->where('status', 'review');
                            });
                    })
                    ->orWhere(function (Builder $sub) {
                        $sub->whereNotIn('status', ['completed', 'cancelled', 'refunded', 'rejected'])
                            ->whereHas('tracks', function (Builder $tq) {
                                $tq->where('status', 'revision');
                            });
                    });
            })
            ->exists();

        $hasPendingPayouts = Payout::where('artist_id', $artist->id)
            ->where('status', 'pending')
            ->exists();

        return [
            'orders'  => $hasPendingOrders,
            'tracker' => $hasWipTasks,
            'payouts' => $hasPendingPayouts,
        ];
    }

    private function getClientIndicators(User $client): array
    {
        $hasOrdersAwaitingApproval = Order::where('client_id', $client->id)
            ->where(function (Builder $q) {
                $q->where('status', 'review')
                    ->orWhere(function (Builder $sub) {
                        $sub->whereNotIn('status', ['completed', 'cancelled', 'refunded', 'rejected'])
                            ->whereHas('tracks', function (Builder $tq) {
                                $tq->where('status', 'review');
                            });
                    });
            })
            ->exists();

        $hasUnpaidInvoices = Invoice::where('status', 'unpaid')
            ->whereHas('order', function (Builder $q) use ($client) {
                $q->where('client_id', $client->id)
                    ->whereNotIn('status', ['rejected', 'cancelled', 'refunded']);
            })
            ->exists();

        return [
            'orders'   => $hasOrdersAwaitingApproval,
            'invoices' => $hasUnpaidInvoices,
        ];
    }
}
