<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ApprovePaymentRequest;
use App\Http\Requests\Admin\RejectPaymentRequest;
use App\Models\Payment;
use App\Services\AdminPaymentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PaymentController extends Controller
{
    public function index(Request $request, AdminPaymentService $service)
    {
        [$status, $invoiceType, $search, $dateFrom, $dateTo] = $this->resolveFilters($request, $service);

        $payments = $service->getPaymentsForAdmin($status, $invoiceType, $search !== '' ? $search : null, $dateFrom, $dateTo);
        $stats = $service->getStats();
        $statusCounts = $service->getStatusCountsForFilter(
            $invoiceType,
            $dateFrom,
            $dateTo,
            $search !== '' ? $search : null
        );
        $invoiceTypeCounts = $service->getInvoiceTypeCountsForFilter(
            $status,
            $dateFrom,
            $dateTo,
            $search !== '' ? $search : null
        );

        return view('admin.payments.index', compact(
            'payments',
            'stats',
            'statusCounts',
            'invoiceTypeCounts',
            'status',
            'invoiceType',
            'search',
            'dateFrom',
            'dateTo',
            'service'
        ));
    }

    public function export(Request $request, AdminPaymentService $service): StreamedResponse|RedirectResponse
    {
        [$status, $invoiceType, $search, $dateFrom, $dateTo] = $this->resolveFilters($request, $service);
        $records = $service->getPaymentsForExport($status, $invoiceType, $search !== '' ? $search : null, $dateFrom, $dateTo);

        if ($records->isEmpty()) {
            $params = array_filter([
                'status'       => $status !== 'all' ? $status : null,
                'invoice_type' => $invoiceType !== 'all' ? $invoiceType : null,
                'search'       => $search !== '' ? $search : null,
                'date_from'    => $dateFrom !== '' ? $dateFrom : null,
                'date_to'      => $dateTo !== '' ? $dateTo : null,
            ], fn ($v) => $v !== null);

            return redirect()
                ->route('admin.payments.index', $params)
                ->withErrors([
                    'export' => 'Data transaksi kosong. Tidak ada data yang ditampilkan untuk diekspor ke CSV.',
                ]);
        }

        $filename = 'audit-transaksi-artsyid-' . now()->timezone('Asia/Jakarta')->format('Ymd-His') . '.csv';

        return response()->streamDownload(function () use ($records, $service) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");

            fputcsv($handle, [
                'Referensi Transaksi',
                'Nomor Invoice',
                'Jenis Invoice',
                'Status Invoice',
                'Nomor Order',
                'Client',
                'Artist',
                'Nominal Pembayaran (Rp)',
                'Nominal Tagihan (Rp)',
                'Metode Pembayaran',
                'Status Transaksi',
                'Waktu Dibuat (WIB)',
                'Waktu Dibayar (WIB)',
                'Diverifikasi Oleh',
            ], ',', '"', '');

            foreach ($records as $payment) {
                $invoice = $payment->invoice;
                $order = $invoice?->order;
                $reference = $payment->transaction_id ?: sprintf('PAY-%05d', $payment->id);

                fputcsv($handle, array_map([$service, 'sanitizeCsvCell'], [
                    $reference,
                    $invoice?->invoice_number ?? '-',
                    AdminPaymentService::INVOICE_TYPE_LABELS[$invoice?->invoice_type ?? ''] ?? ($invoice?->invoice_type ?? '-'),
                    AdminPaymentService::INVOICE_STATUS_LABELS[$invoice?->status ?? ''] ?? ($invoice?->status ?? '-'),
                    $order?->order_number ?? '-',
                    $order?->client?->name ?? 'Pengguna Terhapus',
                    $order?->artist?->name ?? 'Artist Terhapus',
                    number_format((float) $payment->amount, 2, '.', ''),
                    number_format((float) ($invoice?->amount ?? 0), 2, '.', ''),
                    $service->formatPaymentMethod($payment->payment_method),
                    AdminPaymentService::PAYMENT_STATUS_LABELS[$payment->payment_status ?? ''] ?? $payment->payment_status,
                    $payment->created_at?->timezone('Asia/Jakarta')->format('Y-m-d H:i:s') ?? '-',
                    $payment->paid_at?->timezone('Asia/Jakarta')->format('Y-m-d H:i:s') ?? 'Belum dibayar',
                    $payment->verifiedByAdmin?->name ?? '-',
                ]), ',', '"', '');
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function approve(ApprovePaymentRequest $request, Payment $payment, AdminPaymentService $service)
    {
        try {
            $updated = $service->approvePayment($payment, Auth::user(), $request->validated('audit_notes'));
            $ref = $updated->transaction_id ?: sprintf('PAY-%05d', $updated->id);

            return back()->with('success', "Transaksi {$ref} berhasil disetujui dan status invoice terkait diperbarui menjadi lunas.");
        } catch (\DomainException $e) {
            return back()->withErrors(['payment_action' => $e->getMessage()]);
        }
    }

    public function reject(RejectPaymentRequest $request, Payment $payment, AdminPaymentService $service)
    {
        try {
            $updated = $service->rejectPayment($payment, Auth::user(), $request->validated('rejection_reason'));
            $ref = $updated->transaction_id ?: sprintf('PAY-%05d', $updated->id);

            return back()->with('success', "Transaksi {$ref} telah ditolak. Tagihan invoice tetap terbuka agar Client dapat mengulang pembayaran melalui Midtrans Snap.");
        } catch (\DomainException $e) {
            return back()->withErrors(['payment_action' => $e->getMessage()]);
        }
    }


    private function resolveFilters(Request $request, AdminPaymentService $service): array
    {
        $status = (string) $request->query('status', 'all');
        if (!in_array($status, AdminPaymentService::ALLOWED_STATUS_FILTERS, true)) {
            $status = 'all';
        }

        $invoiceType = (string) $request->query('invoice_type', 'all');
        if (!in_array($invoiceType, AdminPaymentService::ALLOWED_INVOICE_TYPES, true)) {
            $invoiceType = 'all';
        }

        $search = trim((string) $request->query('search', ''));
        $dates = $service->normalizeDateRange(
            $request->query('date_from'),
            $request->query('date_to')
        );

        return [$status, $invoiceType, $search, $dates['date_from'], $dates['date_to']];
    }
}
