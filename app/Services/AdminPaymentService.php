<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderTrack;
use App\Models\Payment;
use App\Models\Payout;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AdminPaymentService
{
    public function __construct(
        private NotificationService $notificationService
    ) {}
    public const ALLOWED_STATUS_FILTERS = ['all', 'pending', 'success', 'failed'];

    public const ALLOWED_INVOICE_TYPES = ['all', 'dp', 'final', 'dynamic'];

    public const SUCCESS_STATUSES = ['settlement', 'approved'];

    public const FAILED_STATUSES = ['expire', 'cancel', 'deny', 'rejected'];

    public const PAYMENT_STATUS_LABELS = [
        'pending'    => 'Menunggu',
        'settlement' => 'Settlement',
        'approved'   => 'Disetujui Admin',
        'expire'     => 'Kedaluwarsa',
        'cancel'     => 'Dibatalkan',
        'deny'       => 'Ditolak Gateway',
        'rejected'   => 'Ditolak Admin',
    ];

    public const INVOICE_TYPE_LABELS = [
        'dp'      => 'DP',
        'final'   => 'Pelunasan',
        'dynamic' => 'Dynamic Add-on',
    ];

    public const INVOICE_STATUS_LABELS = [
        'unpaid'    => 'Belum Lunas',
        'paid'      => 'Lunas',
        'expired'   => 'Kedaluwarsa',
        'cancelled' => 'Dibatalkan',
    ];

    public const ORDER_STATUS_LABELS = [
        'pending_review'         => 'Menunggu Review Artist',
        'rejected'               => 'Ditolak Artist',
        'awaiting_dp'            => 'Menunggu Pembayaran DP',
        'on_progress'            => 'Sedang Dikerjakan',
        'review'                 => 'Menunggu Review Client',
        'revision'               => 'Dalam Revisi',
        'awaiting_final_payment' => 'Menunggu Pelunasan',
        'completed'              => 'Selesai',
        'cancelled'              => 'Dibatalkan',
        'refunded'               => 'Sudah Di-refund',
    ];

    public const SENSITIVE_PAYLOAD_PATTERN = '/^(.*_)?(secret|password|passwd|server_key|client_secret|snap_token|access_token|refresh_token|token|authorization|api_key|signature_key)$/i';


    public function normalizeDateRange(?string $dateFrom, ?string $dateTo): array
    {
        $from = $this->parseStrictDate($dateFrom);
        $to = $this->parseStrictDate($dateTo);

        if ($from !== null && $to !== null && $from->gt($to)) {
            [$from, $to] = [$to, $from];
        }

        return [
            'date_from' => $from ? $from->format('Y-m-d') : '',
            'date_to'   => $to ? $to->format('Y-m-d') : '',
        ];
    }

    public function getStats(): array
    {
        $successQuery = Payment::whereIn('payment_status', self::SUCCESS_STATUSES);
        $pendingQuery = Payment::where('payment_status', 'pending');

        $mismatchCount = Payment::where(function (Builder $q) {
            $q->where(function (Builder $sub) {
                $sub->whereIn('payment_status', self::SUCCESS_STATUSES)
                    ->whereHas('invoice', function (Builder $iq) {
                        $iq->where(function (Builder $inner) {
                            $inner->where('status', '!=', 'paid')
                                ->orWhereRaw('ABS(payments.amount - invoices.amount) > 0.01');
                        });
                    });
            })->orWhere(function (Builder $sub) {
                $sub->where('payment_status', 'pending')
                    ->whereHas('invoice', function (Builder $iq) {
                        $iq->where(function (Builder $inner) {
                            $inner->where('status', 'paid')
                                ->orWhereRaw('ABS(payments.amount - invoices.amount) > 0.01');
                        });
                    });
            });
        })->count();

        return [
            'total_count'    => Payment::count(),
            'success_count'  => (clone $successQuery)->count(),
            'success_amount' => (float) (clone $successQuery)->sum('amount'),
            'pending_count'  => (clone $pendingQuery)->count(),
            'pending_amount' => (float) (clone $pendingQuery)->sum('amount'),
            'failed_count'   => Payment::whereIn('payment_status', self::FAILED_STATUSES)->count(),
            'mismatch_count' => $mismatchCount,
        ];
    }


    public function getInvoiceTypeCountsForFilter(
        string $statusFilter = 'all',
        ?string $dateFrom = null,
        ?string $dateTo = null,
        ?string $search = null
    ): array {
        $base = Payment::query();
        $this->applyStatusFilter($base, $statusFilter);
        $this->applyDateRangeFilter($base, $dateFrom, $dateTo);
        $this->applySearchFilter($base, $search);

        return [
            'all'     => (clone $base)->count(),
            'dp'      => (clone $base)->whereHas('invoice', fn (Builder $q) => $q->where('invoice_type', 'dp'))->count(),
            'final'   => (clone $base)->whereHas('invoice', fn (Builder $q) => $q->where('invoice_type', 'final'))->count(),
            'dynamic' => (clone $base)->whereHas('invoice', fn (Builder $q) => $q->where('invoice_type', 'dynamic'))->count(),
        ];
    }

    public function getStatusCountsForFilter(
        string $invoiceType = 'all',
        ?string $dateFrom = null,
        ?string $dateTo = null,
        ?string $search = null
    ): array {
        $base = Payment::query();
        if (in_array($invoiceType, ['dp', 'final', 'dynamic'], true)) {
            $base->whereHas('invoice', fn (Builder $q) => $q->where('invoice_type', $invoiceType));
        }
        $this->applyDateRangeFilter($base, $dateFrom, $dateTo);
        $this->applySearchFilter($base, $search);

        return [
            'all'     => (clone $base)->count(),
            'pending' => (clone $base)->where('payment_status', 'pending')->count(),
            'success' => (clone $base)->whereIn('payment_status', self::SUCCESS_STATUSES)->count(),
            'failed'  => (clone $base)->whereIn('payment_status', self::FAILED_STATUSES)->count(),
        ];
    }

    public function buildFilteredQuery(
        string $statusFilter = 'all',
        string $invoiceType = 'all',
        ?string $search = null,
        ?string $dateFrom = null,
        ?string $dateTo = null
    ): Builder {
        $query = Payment::query()
            ->with([
                'invoice.items',
                'invoice.order.client:id,name,email',
                'invoice.order.artist:id,name,email',
                'invoice.order.commissionMenu:id,title',
                'verifiedByAdmin:id,name,email',
            ]);

        $this->applyStatusFilter($query, $statusFilter);

        if (in_array($invoiceType, ['dp', 'final', 'dynamic'], true)) {
            $query->whereHas('invoice', fn (Builder $q) => $q->where('invoice_type', $invoiceType));
        }

        $this->applyDateRangeFilter($query, $dateFrom, $dateTo);
        $this->applySearchFilter($query, $search);

        return $query->latest('id');
    }

    public function getPaymentsForAdmin(
        string $statusFilter = 'all',
        string $invoiceType = 'all',
        ?string $search = null,
        ?string $dateFrom = null,
        ?string $dateTo = null,
        int $perPage = 10
    ): LengthAwarePaginator {
        return $this->buildFilteredQuery($statusFilter, $invoiceType, $search, $dateFrom, $dateTo)
            ->paginate($perPage)
            ->withQueryString();
    }

    public function getPaymentsForExport(
        string $statusFilter = 'all',
        string $invoiceType = 'all',
        ?string $search = null,
        ?string $dateFrom = null,
        ?string $dateTo = null
    ): EloquentCollection {
        return $this->buildFilteredQuery($statusFilter, $invoiceType, $search, $dateFrom, $dateTo)
            ->get();
    }


    public function canApprove(Payment $payment): array
    {
        if ($payment->payment_status !== 'pending') {
            return [
                'allowed' => false,
                'reason'  => 'Hanya transaksi berstatus Menunggu yang dapat disetujui melalui rekonsiliasi admin.',
            ];
        }

        $invoice = $payment->invoice;
        $order = $invoice?->order;

        if (!$invoice || !$order) {
            return [
                'allowed' => false,
                'reason'  => 'Data invoice atau pesanan terkait tidak lengkap.',
            ];
        }

        if ($invoice->status === 'paid') {
            return [
                'allowed' => false,
                'reason'  => 'Invoice terkait sudah berstatus lunas.',
            ];
        }

        if ($invoice->status !== 'unpaid') {
            $statusLabel = self::INVOICE_STATUS_LABELS[$invoice->status] ?? $invoice->status;

            return [
                'allowed' => false,
                'reason'  => "Invoice terkait berstatus {$statusLabel} dan tidak dapat dilunasi.",
            ];
        }

        if ($order->status === 'pending_review') {
            return [
                'allowed' => false,
                'reason'  => 'Pesanan terkait masih menunggu konfirmasi Artist sehingga pembayaran belum dapat disetujui.',
            ];
        }

        if (in_array($order->status, ['cancelled', 'rejected', 'refunded'], true)) {
            return [
                'allowed' => false,
                'reason'  => 'Pesanan terkait sudah dibatalkan, ditolak, atau di-refund.',
            ];
        }

        $orderStatusLabel = self::ORDER_STATUS_LABELS[$order->status ?? ''] ?? $order->status;

        if ($invoice->invoice_type === 'dp' && $order->status !== 'awaiting_dp') {
            return [
                'allowed' => false,
                'reason'  => "Invoice DP hanya dapat disetujui saat pesanan berstatus Menunggu Pembayaran DP (status saat ini: {$orderStatusLabel}).",
            ];
        }

        if ($invoice->invoice_type === 'final' && $order->status !== 'awaiting_final_payment') {
            return [
                'allowed' => false,
                'reason'  => "Invoice Pelunasan hanya dapat disetujui saat pesanan berstatus Menunggu Pelunasan (status saat ini: {$orderStatusLabel}).",
            ];
        }

        if ($invoice->invoice_type === 'dynamic' && $order->status === 'completed') {
            return [
                'allowed' => false,
                'reason'  => 'Invoice Dynamic Add-on tidak dapat disetujui secara manual setelah pesanan selesai.',
            ];
        }

        if ((float) $payment->amount <= 0) {
            return [
                'allowed' => false,
                'reason'  => 'Nominal pembayaran harus lebih besar dari Rp 0.',
            ];
        }

        if (abs((float) $payment->amount - (float) $invoice->amount) > 0.01) {
            return [
                'allowed' => false,
                'reason'  => 'Nominal pembayaran tidak sesuai dengan nominal tagihan invoice.',
            ];
        }

        return ['allowed' => true, 'reason' => null];
    }

    public function canReject(Payment $payment): bool
    {
        if ($payment->payment_status !== 'pending') {
            return false;
        }

        $invoice = $payment->invoice;

        return $invoice === null || $invoice->status !== 'paid';
    }

    public function sanitizeProofUrl(?string $proof): ?string
    {
        $trimmed = trim((string) $proof);
        if ($trimmed === '' || str_starts_with($trimmed, '//') || str_contains($trimmed, '..')) {
            return null;
        }

        if (preg_match('/^(javascript|data|vbscript):/i', $trimmed)) {
            return null;
        }

        if (preg_match('#^https?://#i', $trimmed)) {
            if (filter_var($trimmed, FILTER_VALIDATE_URL) === false) {
                return null;
            }
            $scheme = strtolower((string) parse_url($trimmed, PHP_URL_SCHEME));

            return in_array($scheme, ['http', 'https'], true) ? $trimmed : null;
        }

        if (str_contains($trimmed, ':')) {
            return null;
        }

        if (str_starts_with($trimmed, '/')) {
            return $trimmed;
        }

        return asset('storage/' . ltrim($trimmed, '/'));
    }

    public function sanitizePayloadForDisplay(?array $payload): ?string
    {
        if (empty($payload)) {
            return null;
        }

        $sanitized = $this->redactArrayRecursively($payload);

        return json_encode($sanitized, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?: null;
    }

    public function sanitizeCsvCell(mixed $value): string
    {
        $normalized = str_replace(["\r\n", "\r", "\n", "\0"], ' ', (string) ($value ?? ''));

        if ($normalized !== '' && preg_match('/^[\s]*[=+\-@\t\r]/', $normalized)) {
            return "'" . $normalized;
        }

        return $normalized;
    }

    public function formatRupiah(mixed $amount): string
    {
        return 'Rp ' . number_format((float) $amount, 0, ',', '.');
    }

    public function formatPaymentMethod(?string $method): string
    {
        $trimmed = trim((string) $method);
        if ($trimmed === '') {
            return 'Belum dipilih';
        }

        return match (strtolower($trimmed)) {
            'bank_transfer' => 'Virtual Account / Bank Transfer',
            'qris'          => 'QRIS',
            'gopay'         => 'GoPay',
            'shopeepay'     => 'ShopeePay',
            'credit_card'   => 'Kartu Kredit',
            'cstore'        => 'Gerai Ritel',
            'echannel'      => 'Mandiri Bill Payment',
            default         => ucwords(str_replace('_', ' ', $trimmed)),
        };
    }

    public function buildPaymentModalPayload(Payment $payment): array
    {
        $invoice = $payment->invoice;
        $order = $invoice?->order;
        $client = $order?->client;
        $artist = $order?->artist;
        $approvalCheck = $this->canApprove($payment);

        $paymentAmount = (float) $payment->amount;
        $invoiceAmount = (float) ($invoice?->amount ?? 0);
        $amountMismatch = $invoice !== null && abs($paymentAmount - $invoiceAmount) > 0.01;

        $statusMismatch = (in_array($payment->payment_status, self::SUCCESS_STATUSES, true) && $invoice !== null && $invoice->status !== 'paid')
            || ($payment->payment_status === 'pending' && $invoice !== null && $invoice->status === 'paid');

        $payloadData = is_array($payment->payload) ? $payment->payload : [];
        $adminAudit = is_array($payloadData['admin_audit'] ?? null) ? $payloadData['admin_audit'] : null;

        $referenceCode = $payment->transaction_id ?: sprintf('PAY-%05d', $payment->id);

        $items = $invoice
            ? $invoice->items->map(fn ($item) => [
                'item_name' => $item->item_name,
                'qty'       => (int) $item->qty,
                'price'     => $this->formatRupiah($item->price),
                'subtotal'  => $this->formatRupiah($item->subtotal),
            ])->values()->toArray()
            : [];

        return [
            'id'                     => $payment->id,
            'reference_code'         => $referenceCode,
            'transaction_id'         => $payment->transaction_id,
            'amount'                 => $paymentAmount,
            'amount_formatted'       => $this->formatRupiah($paymentAmount),
            'payment_method'         => $payment->payment_method,
            'payment_method_label'   => $this->formatPaymentMethod($payment->payment_method),
            'payment_status'         => $payment->payment_status,
            'payment_status_label'   => self::PAYMENT_STATUS_LABELS[$payment->payment_status ?? ''] ?? $payment->payment_status,
            'paid_at_formatted'      => $this->formatTimestamp($payment->paid_at),
            'created_at_formatted'   => $this->formatTimestamp($payment->created_at),
            'verified_at_formatted'  => $this->formatTimestamp($payment->verified_at),
            'verified_by_admin_name' => $payment->verifiedByAdmin?->name,
            'proof_url'              => $this->sanitizeProofUrl($payment->proof_of_payment),
            'sanitized_payload_json' => $this->sanitizePayloadForDisplay($payloadData),
            'admin_audit_note'       => $adminAudit['reason'] ?? ($adminAudit['notes'] ?? null),
            'invoice'                => $invoice ? [
                'id'               => $invoice->id,
                'invoice_number'   => $invoice->invoice_number,
                'invoice_type'     => $invoice->invoice_type,
                'type_label'       => self::INVOICE_TYPE_LABELS[$invoice->invoice_type ?? ''] ?? strtoupper((string) $invoice->invoice_type),
                'amount'           => $invoiceAmount,
                'amount_formatted' => $this->formatRupiah($invoiceAmount),
                'status'           => $invoice->status,
                'status_label'     => self::INVOICE_STATUS_LABELS[$invoice->status ?? ''] ?? $invoice->status,
                'due_date'         => $this->formatTimestamp($invoice->due_date),
                'paid_at'          => $this->formatTimestamp($invoice->paid_at),
            ] : null,
            'invoice_items'          => $items,
            'order'                  => $order ? [
                'id'                   => $order->id,
                'order_number'         => $order->order_number,
                'status'               => $order->status,
                'status_label'         => self::ORDER_STATUS_LABELS[$order->status ?? ''] ?? $order->status,
                'menu_title'           => $order->commissionMenu?->title ?? '-',
                'total_formatted'      => $this->formatRupiah($order->total_amount),
                'client_name'          => $client?->name ?? 'Pengguna Terhapus',
                'client_email'         => $client?->email ?? '-',
                'artist_name'          => $artist?->name ?? 'Artist Terhapus',
                'artist_email'         => $artist?->email ?? '-',
            ] : null,
            'amount_mismatch'        => $amountMismatch,
            'status_mismatch'        => $statusMismatch,
            'can_approve'            => $approvalCheck['allowed'],
            'approve_blocked_reason' => $approvalCheck['reason'],
            'can_reject'             => $this->canReject($payment),
            'approve_url'            => route('admin.payments.approve', $payment->id),
            'reject_url'             => route('admin.payments.reject', $payment->id),
        ];
    }

    public function approvePayment(Payment $payment, User $admin, ?string $notes = null): Payment
    {
        return DB::transaction(function () use ($payment, $admin, $notes) {
            $lockedPayment = Payment::whereKey($payment->id)->lockForUpdate()->firstOrFail();
            $lockedInvoice = $lockedPayment->invoice_id
                ? Invoice::whereKey($lockedPayment->invoice_id)->lockForUpdate()->first()
                : null;
            $lockedOrder = $lockedInvoice?->order_id
                ? Order::whereKey($lockedInvoice->order_id)->lockForUpdate()->first()
                : null;

            $lockedPayment->setRelation('invoice', $lockedInvoice);
            if ($lockedInvoice) {
                $lockedInvoice->setRelation('order', $lockedOrder);
            }

            $check = $this->canApprove($lockedPayment);
            if (!$check['allowed']) {
                throw new \DomainException($check['reason'] ?? 'Transaksi ini tidak memenuhi syarat untuk disetujui.');
            }

            $now = now();
            $effectivePaidAt = $lockedPayment->paid_at ?? $now;
            $cleanNotes = trim((string) $notes);

            $payload = is_array($lockedPayment->payload) ? $lockedPayment->payload : [];
            $payload['admin_audit'] = array_filter([
                'action'     => 'approved',
                'admin_id'   => $admin->id,
                'admin_name' => $admin->name,
                'notes'      => $cleanNotes !== '' ? $cleanNotes : null,
                'audited_at' => $now->timezone('Asia/Jakarta')->toIso8601String(),
            ], fn ($v) => $v !== null);

            $lockedPayment->update([
                'payment_status'       => 'approved',
                'paid_at'              => $effectivePaidAt,
                'verified_by_admin_id' => $admin->id,
                'verified_at'          => $now,
                'payload'              => $payload,
            ]);

            Payment::where('invoice_id', $lockedInvoice->id)
                ->where('id', '!=', $lockedPayment->id)
                ->where('payment_status', 'pending')
                ->update(['payment_status' => 'cancel']);

            $lockedInvoice->update([
                'status'  => 'paid',
                'paid_at' => $effectivePaidAt,
            ]);

            $this->advanceOrderAfterInvoicePaid($lockedInvoice, $lockedOrder);

            return $lockedPayment->fresh([
                'invoice.items',
                'invoice.order.client',
                'invoice.order.artist',
                'verifiedByAdmin',
            ]);
        });
    }

    public function rejectPayment(Payment $payment, User $admin, string $reason): Payment
    {
        return DB::transaction(function () use ($payment, $admin, $reason) {
            $lockedPayment = Payment::whereKey($payment->id)->lockForUpdate()->firstOrFail();
            $lockedInvoice = $lockedPayment->invoice_id
                ? Invoice::whereKey($lockedPayment->invoice_id)->lockForUpdate()->first()
                : null;
            $lockedOrder = $lockedInvoice?->order_id
                ? Order::whereKey($lockedInvoice->order_id)->first()
                : null;

            $lockedPayment->setRelation('invoice', $lockedInvoice);

            if ($lockedPayment->payment_status !== 'pending') {
                throw new \DomainException('Hanya transaksi berstatus Menunggu yang dapat ditolak.');
            }

            if ($lockedInvoice && $lockedInvoice->status === 'paid') {
                throw new \DomainException('Transaksi tidak dapat ditolak karena invoice terkait sudah berstatus lunas.');
            }

            $cleanReason = trim($reason);
            $now = now();

            $payload = is_array($lockedPayment->payload) ? $lockedPayment->payload : [];
            $payload['admin_audit'] = [
                'action'     => 'rejected',
                'admin_id'   => $admin->id,
                'admin_name' => $admin->name,
                'reason'     => $cleanReason,
                'audited_at' => $now->timezone('Asia/Jakarta')->toIso8601String(),
            ];

            $lockedPayment->update([
                'payment_status'       => 'rejected',
                'verified_by_admin_id' => $admin->id,
                'verified_at'          => $now,
                'payload'              => $payload,
            ]);

            if ($lockedOrder) {
                $invoiceLabel = $lockedInvoice?->invoice_number ?? "Order #{$lockedOrder->order_number}";
                $this->notificationService->notifyUser(
                    $lockedOrder->client_id,
                    'Pembayaran Ditolak',
                    "Transaksi pembayaran untuk invoice {$invoiceLabel} ditolak pada audit admin. Alasan: {$cleanReason}. Silakan lakukan pembayaran kembali melalui Midtrans Snap.",
                    route('user.invoices.index'),
                    'user'
                );
            }

            return $lockedPayment->fresh([
                'invoice.items',
                'invoice.order.client',
                'invoice.order.artist',
                'verifiedByAdmin',
            ]);
        });
    }

    private function advanceOrderAfterInvoicePaid(Invoice $invoice, Order $order): void
    {
        if ($invoice->invoice_type === 'dp') {
            if ($order->status === 'awaiting_dp') {
                $order->update(['status' => 'on_progress']);
            }

            if ($order->tracks()->count() === 0) {
                foreach ([
                    1 => 'Sketsa',
                    2 => 'Line Art',
                    3 => 'Coloring',
                    4 => 'Rendering',
                ] as $stepOrder => $stageName) {
                    OrderTrack::create([
                        'order_id'   => $order->id,
                        'step_order' => $stepOrder,
                        'stage_name' => $stageName,
                        'status'     => 'pending',
                    ]);
                }
            }

            $this->notificationService->notifyUser(
                $order->client_id,
                'Pembayaran DP Terverifikasi',
                "Pembayaran DP untuk pesanan #{$order->order_number} ({$invoice->invoice_number}) telah diverifikasi. Dana aman di Escrow dan pengerjaan dimulai.",
                route('user.orders.index'),
                'user'
            );

            $this->notificationService->notifyUser(
                $order->artist_id,
                'DP Pesanan Masuk Escrow',
                "Client telah melunasi DP untuk pesanan #{$order->order_number}. Silakan mulai mengerjakan tahap Sketsa.",
                route('artist.orders.index'),
                'artist'
            );

            return;
        }

        if ($invoice->invoice_type === 'final') {
            if ($order->status === 'awaiting_final_payment') {
                $order->update(['status' => 'completed']);
            }

            $hasFinalPayout = Payout::where('order_id', $order->id)
                ->where('payout_stage', 'final')
                ->exists();

            if (!$hasFinalPayout) {
                $alreadyQueued = (float) Payout::where('order_id', $order->id)->sum('amount');
                $paidInvoicesTotal = (float) Invoice::where('order_id', $order->id)
                    ->where('status', 'paid')
                    ->sum('amount');
                $remainingPayout = $paidInvoicesTotal - $alreadyQueued;
                $payoutAmount = $remainingPayout > 0.01 ? $remainingPayout : (float) $invoice->amount;

                $finalPayout = Payout::create([
                    'artist_id'    => $order->artist_id,
                    'order_id'     => $order->id,
                    'payout_stage' => 'final',
                    'amount'       => $payoutAmount,
                    'status'       => 'pending',
                ]);

                $this->notificationService->notifyPayoutQueued($finalPayout, $order);
            }

            $this->notificationService->notifyUser(
                $order->client_id,
                'Pelunasan Selesai & Karya Siap Diunduh',
                "Pelunasan untuk pesanan #{$order->order_number} ({$invoice->invoice_number}) telah terverifikasi. Berkas karya final tanpa watermark kini tersedia.",
                route('user.completed.index'),
                'user'
            );

            $this->notificationService->notifyUser(
                $order->artist_id,
                'Pelunasan Client Masuk Antrean Payout',
                "Pesanan #{$order->order_number} telah dilunasi Client. Pencairan dana komisi penuh sedang diantrekan ke Administrator.",
                route('artist.payouts.index'),
                'artist'
            );

            return;
        }

        $this->notificationService->notifyUser(
            $order->client_id,
            'Pembayaran Add-on Terverifikasi',
            "Pembayaran invoice tambahan {$invoice->invoice_number} untuk pesanan #{$order->order_number} telah diverifikasi.",
            route('user.invoices.index'),
            'user'
        );

        $this->notificationService->notifyUser(
            $order->artist_id,
            'Invoice Tambahan Telah Dibayar',
            "Client telah melunasi invoice tambahan {$invoice->invoice_number} untuk pesanan #{$order->order_number}.",
            route('artist.orders.index'),
            'artist'
        );
    }

    private function applyStatusFilter(Builder $query, string $statusFilter): void
    {
        if ($statusFilter === 'pending') {
            $query->where('payment_status', 'pending');
        } elseif ($statusFilter === 'success') {
            $query->whereIn('payment_status', self::SUCCESS_STATUSES);
        } elseif ($statusFilter === 'failed') {
            $query->whereIn('payment_status', self::FAILED_STATUSES);
        }
    }

    private function applyDateRangeFilter(Builder $query, ?string $dateFrom, ?string $dateTo): void
    {
        $normalized = $this->normalizeDateRange($dateFrom, $dateTo);
        $appTimezone = (string) config('app.timezone', 'UTC');

        if ($normalized['date_from'] !== '') {
            $start = Carbon::createFromFormat('Y-m-d', $normalized['date_from'], 'Asia/Jakarta')
                ->startOfDay()
                ->timezone($appTimezone)
                ->format('Y-m-d H:i:s');
            $query->whereRaw('COALESCE(paid_at, created_at) >= ?', [$start]);
        }

        if ($normalized['date_to'] !== '') {
            $end = Carbon::createFromFormat('Y-m-d', $normalized['date_to'], 'Asia/Jakarta')
                ->endOfDay()
                ->timezone($appTimezone)
                ->format('Y-m-d H:i:s');
            $query->whereRaw('COALESCE(paid_at, created_at) <= ?', [$end]);
        }
    }

    private function applySearchFilter(Builder $query, ?string $search): void
    {
        $trimmedSearch = trim((string) $search);
        if ($trimmedSearch === '') {
            return;
        }

        $term = '%' . mb_strtolower($trimmedSearch) . '%';
        $query->where(function (Builder $q) use ($term) {
            $q->whereRaw('LOWER(COALESCE(transaction_id, \'\')) LIKE ?', [$term])
                ->orWhereRaw('LOWER(COALESCE(payment_method, \'\')) LIKE ?', [$term])
                ->orWhereHas('invoice', function (Builder $iq) use ($term) {
                    $iq->where(function (Builder $innerInv) use ($term) {
                        $innerInv->whereRaw('LOWER(invoice_number) LIKE ?', [$term])
                            ->orWhereHas('order', function (Builder $oq) use ($term) {
                                $oq->where(function (Builder $innerOrd) use ($term) {
                                    $innerOrd->whereRaw('LOWER(order_number) LIKE ?', [$term])
                                        ->orWhereHas('client', function (Builder $uq) use ($term) {
                                            $uq->where(function (Builder $u) use ($term) {
                                                $u->whereRaw('LOWER(name) LIKE ?', [$term])
                                                    ->orWhereRaw('LOWER(email) LIKE ?', [$term]);
                                            });
                                        })
                                        ->orWhereHas('artist', function (Builder $aq) use ($term) {
                                            $aq->where(function (Builder $a) use ($term) {
                                                $a->whereRaw('LOWER(name) LIKE ?', [$term])
                                                    ->orWhereRaw('LOWER(email) LIKE ?', [$term]);
                                            });
                                        });
                                });
                            });
                    });
                });
        });
    }

    private function parseStrictDate(?string $value): ?Carbon
    {
        $trimmed = trim((string) $value);
        if ($trimmed === '') {
            return null;
        }

        try {
            $parsed = Carbon::createFromFormat('Y-m-d', $trimmed, 'Asia/Jakarta');
            if ($parsed !== false && $parsed->format('Y-m-d') === $trimmed) {
                return $parsed->startOfDay();
            }
        } catch (\Throwable) {
            return null;
        }

        return null;
    }

    private function formatTimestamp(?Carbon $timestamp): ?string
    {
        if (!$timestamp) {
            return null;
        }

        return $timestamp->timezone('Asia/Jakarta')->translatedFormat('d M Y, H:i') . ' WIB';
    }

    private function redactArrayRecursively(array $data): array
    {
        $result = [];

        foreach ($data as $key => $value) {
            if (is_string($key) && preg_match(self::SENSITIVE_PAYLOAD_PATTERN, $key)) {
                $result[$key] = '[REDACTED]';
                continue;
            }

            if (is_array($value)) {
                $result[$key] = $this->redactArrayRecursively($value);
                continue;
            }

            $result[$key] = $value;
        }

        return $result;
    }
}
