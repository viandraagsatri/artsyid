@extends('layouts.app', ['title' => 'Audit Transaksi - Admin Artsy ID'])

@section('content')
    <div class="flex h-screen overflow-hidden bg-bg-light text-slate-body font-sans">

        <div id="sidebar-backdrop"
            class="fixed inset-0 bg-slate-dark/50 backdrop-blur-xs z-20 hidden lg:hidden transition-opacity duration-200">
        </div>

        <div id="sidebar-drawer"
            class="fixed inset-y-0 left-0 z-30 transform -translate-x-full lg:translate-x-0 lg:static lg:inset-auto transition-transform duration-200 ease-in-out shrink-0">
            @include('layouts.sidebar')
        </div>

        <div class="flex-1 flex flex-col h-screen overflow-y-auto min-w-0">
            @include('layouts.header')

            <main class="p-4 sm:p-6 lg:p-8 space-y-6 max-w-7xl w-full mx-auto">

                @if (session('success'))
                    <div role="status"
                        class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm font-semibold flex items-center justify-between gap-3 shadow-2xs">
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-circle-check text-emerald-700 text-base shrink-0" aria-hidden="true"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                        <button type="button" onclick="this.parentElement.remove()" aria-label="Tutup notifikasi"
                            class="cursor-pointer min-w-11 min-h-11 sm:min-w-8 sm:min-h-8 rounded-lg text-emerald-800 hover:bg-emerald-100 font-bold flex items-center justify-center transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-dark">
                            <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                        </button>
                    </div>
                @endif

                @if ($errors->any())
                    <div role="alert"
                        class="p-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 text-xs sm:text-sm font-semibold flex items-center justify-between gap-3 shadow-2xs">
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-triangle-exclamation text-red-700 text-base shrink-0" aria-hidden="true"></i>
                            <span>{{ $errors->first() }}</span>
                        </div>
                        <button type="button" onclick="this.parentElement.remove()" aria-label="Tutup peringatan"
                            class="cursor-pointer min-w-11 min-h-11 sm:min-w-8 sm:min-h-8 rounded-lg text-red-800 hover:bg-red-100 font-bold flex items-center justify-center transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-dark">
                            <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                        </button>
                    </div>
                @endif

                <div id="export-empty-alert" role="alert" tabindex="-1"
                    class="hidden p-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 text-xs sm:text-sm font-semibold flex items-center justify-between gap-3 shadow-2xs">
                    <div class="flex items-center gap-2.5">
                        <i class="fa-solid fa-triangle-exclamation text-red-700 text-base shrink-0" aria-hidden="true"></i>
                        <span>Data transaksi kosong. Tidak ada data yang ditampilkan untuk diekspor ke CSV.</span>
                    </div>
                    <button type="button" id="close-export-empty-alert" aria-label="Tutup peringatan ekspor kosong"
                        class="cursor-pointer min-w-11 min-h-11 sm:min-w-8 sm:min-h-8 rounded-lg text-red-800 hover:bg-red-100 font-bold flex items-center justify-center transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-dark">
                        <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                    </button>
                </div>

                <div class="bg-white rounded-2xl border border-stone-200/90 shadow-2xs p-5 sm:p-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-xl sm:text-2xl font-black font-heading text-slate-dark mt-1.5">
                            Audit Transaksi
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-muted mt-0.5">
                            Pantau alur dana escrow, status pembayaran, dan semua transaksi.
                        </p>
                    </div>
                    <div class="flex flex-wrap items-center gap-2 shrink-0">
                        @if ($payments->isEmpty())
                            <button type="button" id="empty-export-btn" aria-describedby="export-empty-alert"
                                class="cursor-pointer min-h-11 sm:min-h-0 px-4 py-2 rounded-xl bg-stone-100 hover:bg-stone-200 border border-stone-200 text-slate-muted font-bold text-xs font-heading transition flex items-center justify-center gap-2 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-dark">
                                <i class="fa-solid fa-file-csv text-xs" aria-hidden="true"></i>
                                <span>Ekspor CSV</span>
                            </button>
                        @else
                            <a href="{{ route('admin.payments.export', ['status' => $status, 'invoice_type' => $invoiceType, 'search' => $search, 'date_from' => $dateFrom, 'date_to' => $dateTo]) }}"
                                class="cursor-pointer min-h-11 sm:min-h-0 px-4 py-2 rounded-xl bg-pastel-200 hover:bg-pastel-300 border border-pastel-300 text-slate-dark font-bold text-xs font-heading transition flex items-center justify-center gap-2 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-dark">
                                <i class="fa-solid fa-file-csv text-xs" aria-hidden="true"></i>
                                <span>Ekspor CSV ({{ $payments->total() }})</span>
                            </a>
                        @endif
                        <a href="{{ route('admin.payments.index') }}"
                            class="cursor-pointer min-h-11 sm:min-h-0 px-4 py-2 rounded-xl bg-stone-100 hover:bg-stone-200 text-slate-dark font-bold text-xs font-heading transition flex items-center justify-center gap-2 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-dark">
                            <i class="fa-solid fa-rotate text-xs" aria-hidden="true"></i>
                            <span>Segarkan</span>
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                    <div class="bg-white p-4 sm:p-5 rounded-2xl border border-stone-200/90 shadow-2xs flex items-center justify-between gap-2">
                        <div class="min-w-0">
                            <span class="text-[11px] sm:text-xs text-slate-muted font-medium block">Dana Masuk Escrow</span>
                            <span class="text-lg sm:text-xl font-black font-heading text-slate-dark mt-1 block tabular-nums truncate">
                                {{ $service->formatRupiah($stats['success_amount']) }}
                            </span>
                            <span class="text-[11px] text-slate-muted block mt-0.5">
                                {{ $stats['success_count'] }} transaksi berhasil
                            </span>
                        </div>
                        <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-emerald-50 text-emerald-800 border border-emerald-200 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-shield-halved text-sm sm:text-base" aria-hidden="true"></i>
                        </div>
                    </div>

                    <div class="bg-white p-4 sm:p-5 rounded-2xl border border-stone-200/90 shadow-2xs flex items-center justify-between gap-2">
                        <div class="min-w-0">
                            <span class="text-[11px] sm:text-xs text-slate-muted font-medium block">Menunggu Verifikasi</span>
                            <span class="text-xl sm:text-2xl font-black font-heading {{ $stats['pending_count'] > 0 ? 'text-sky-800' : 'text-slate-dark' }} mt-1 block tabular-nums">
                                {{ $stats['pending_count'] }}
                            </span>
                            <span class="text-[11px] text-slate-muted block mt-0.5 tabular-nums truncate">
                                {{ $service->formatRupiah($stats['pending_amount']) }} tertahan
                            </span>
                        </div>
                        <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-sky-50 text-sky-800 border border-sky-200 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-clock text-sm sm:text-base" aria-hidden="true"></i>
                        </div>
                    </div>

                    <div class="bg-white p-4 sm:p-5 rounded-2xl border border-stone-200/90 shadow-2xs flex items-center justify-between gap-2">
                        <div class="min-w-0">
                            <span class="text-[11px] sm:text-xs text-slate-muted font-medium block">Transaksi Berhasil</span>
                            <span class="text-xl sm:text-2xl font-black font-heading text-emerald-800 mt-1 block tabular-nums">
                                {{ $stats['success_count'] }}
                            </span>
                        </div>
                        <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-pastel-100 text-amber-900 border border-pastel-300 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-file-invoice-dollar text-sm sm:text-base" aria-hidden="true"></i>
                        </div>
                    </div>

                    <div class="bg-white p-4 sm:p-5 rounded-2xl border border-stone-200/90 shadow-2xs flex items-center justify-between gap-2">
                        <div class="min-w-0">
                            <span class="text-[11px] sm:text-xs text-slate-muted font-medium block">Gagal / Ditolak</span>
                            <span class="text-xl sm:text-2xl font-black font-heading {{ ($stats['failed_count'] > 0 || $stats['mismatch_count'] > 0) ? 'text-red-800' : 'text-slate-dark' }} mt-1 block tabular-nums">
                                {{ $stats['failed_count'] }}
                            </span>
                            @if ($stats['mismatch_count'] > 0)
                                <span class="text-[11px] font-bold text-red-800 block mt-0.5">
                                    {{ $stats['mismatch_count'] }} selisih perlu audit
                                </span>
                            @endif
                        </div>
                        <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-red-50 text-red-800 border border-red-200 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-triangle-exclamation text-sm sm:text-base" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-stone-200/90 shadow-2xs p-4 space-y-4">
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-3">
                        <div class="flex items-center gap-1.5 overflow-x-auto pb-1 lg:pb-0">
                            <a href="{{ route('admin.payments.index', ['status' => 'all', 'invoice_type' => $invoiceType, 'search' => $search, 'date_from' => $dateFrom, 'date_to' => $dateTo]) }}"
                                class="min-h-10 px-3.5 py-2 rounded-xl text-xs font-heading font-bold transition whitespace-nowrap flex items-center {{ $status === 'all' ? 'bg-pastel-200 text-slate-dark border border-pastel-300 shadow-xs' : 'text-slate-muted hover:text-slate-dark hover:bg-stone-50' }}">
                                Semua ({{ $statusCounts['all'] }})
                            </a>
                            <a href="{{ route('admin.payments.index', ['status' => 'pending', 'invoice_type' => $invoiceType, 'search' => $search, 'date_from' => $dateFrom, 'date_to' => $dateTo]) }}"
                                class="min-h-10 px-3.5 py-2 rounded-xl text-xs font-heading font-bold transition whitespace-nowrap flex items-center {{ $status === 'pending' ? 'bg-pastel-200 text-slate-dark border border-pastel-300 shadow-xs' : 'text-slate-muted hover:text-slate-dark hover:bg-stone-50' }}">
                                Menunggu ({{ $statusCounts['pending'] }})
                            </a>
                            <a href="{{ route('admin.payments.index', ['status' => 'success', 'invoice_type' => $invoiceType, 'search' => $search, 'date_from' => $dateFrom, 'date_to' => $dateTo]) }}"
                                class="min-h-10 px-3.5 py-2 rounded-xl text-xs font-heading font-bold transition whitespace-nowrap flex items-center {{ $status === 'success' ? 'bg-pastel-200 text-slate-dark border border-pastel-300 shadow-xs' : 'text-slate-muted hover:text-slate-dark hover:bg-stone-50' }}">
                                Berhasil ({{ $statusCounts['success'] }})
                            </a>
                            <a href="{{ route('admin.payments.index', ['status' => 'failed', 'invoice_type' => $invoiceType, 'search' => $search, 'date_from' => $dateFrom, 'date_to' => $dateTo]) }}"
                                class="min-h-10 px-3.5 py-2 rounded-xl text-xs font-heading font-bold transition whitespace-nowrap flex items-center {{ $status === 'failed' ? 'bg-pastel-200 text-slate-dark border border-pastel-300 shadow-xs' : 'text-slate-muted hover:text-slate-dark hover:bg-stone-50' }}">
                                Gagal / Batal ({{ $statusCounts['failed'] }})
                            </a>
                        </div>

                        <form action="{{ route('admin.payments.index') }}" method="GET" class="flex items-center gap-2">
                            <input type="hidden" name="status" value="{{ $status }}">
                            <input type="hidden" name="invoice_type" value="{{ $invoiceType }}">
                            <input type="hidden" name="date_from" value="{{ $dateFrom }}">
                            <input type="hidden" name="date_to" value="{{ $dateTo }}">
                            <label for="payment-search" class="sr-only">Cari invoice, nomor order, referensi transaksi, client, atau artist</label>
                            <div class="relative flex-1 lg:w-72">
                                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-xs text-slate-muted" aria-hidden="true"></i>
                                <input type="text" id="payment-search" name="search" value="{{ $search }}" placeholder="Cari invoice, order, ref, client, artist..."
                                    class="w-full min-h-11 sm:min-h-0 pl-9 pr-3.5 py-2 rounded-xl text-xs bg-bg-light border border-stone-200 focus:outline-none focus:border-amber-500 focus:bg-white transition text-slate-dark placeholder:text-slate-muted">
                            </div>
                            <button type="submit"
                                class="cursor-pointer min-h-11 sm:min-h-0 px-4 py-2 rounded-xl bg-pastel-200 hover:bg-pastel-300 border border-pastel-300 text-slate-dark font-bold text-xs font-heading transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-dark">
                                Cari
                            </button>
                            @if ($search !== '')
                                <a href="{{ route('admin.payments.index', ['status' => $status, 'invoice_type' => $invoiceType, 'date_from' => $dateFrom, 'date_to' => $dateTo]) }}"
                                    aria-label="Reset pencarian"
                                    title="Reset pencarian"
                                    class="min-h-11 min-w-11 sm:min-h-0 sm:min-w-0 px-3 py-2 rounded-xl bg-stone-100 hover:bg-stone-200 text-slate-dark text-xs font-bold font-heading flex items-center justify-center transition">
                                    <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                                </a>
                            @endif
                        </form>
                    </div>

                    <div class="pt-3 border-t border-stone-100 flex flex-col lg:flex-row lg:items-center justify-between gap-3 text-xs">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="text-[11px] font-bold font-heading text-slate-muted uppercase tracking-wider mr-1">Jenis Invoice:</span>
                            <a href="{{ route('admin.payments.index', ['status' => $status, 'invoice_type' => 'all', 'search' => $search, 'date_from' => $dateFrom, 'date_to' => $dateTo]) }}"
                                class="px-3 py-1.5 rounded-lg font-heading font-semibold transition {{ $invoiceType === 'all' ? 'bg-amber-100 text-amber-900 border border-amber-300' : 'bg-stone-100 text-slate-body hover:bg-stone-200' }}">
                                Semua Jenis ({{ $invoiceTypeCounts['all'] }})
                            </a>
                            <a href="{{ route('admin.payments.index', ['status' => $status, 'invoice_type' => 'dp', 'search' => $search, 'date_from' => $dateFrom, 'date_to' => $dateTo]) }}"
                                class="px-3 py-1.5 rounded-lg font-heading font-semibold transition {{ $invoiceType === 'dp' ? 'bg-amber-100 text-amber-900 border border-amber-300' : 'bg-stone-100 text-slate-body hover:bg-stone-200' }}">
                                DP ({{ $invoiceTypeCounts['dp'] }})
                            </a>
                            <a href="{{ route('admin.payments.index', ['status' => $status, 'invoice_type' => 'final', 'search' => $search, 'date_from' => $dateFrom, 'date_to' => $dateTo]) }}"
                                class="px-3 py-1.5 rounded-lg font-heading font-semibold transition {{ $invoiceType === 'final' ? 'bg-amber-100 text-amber-900 border border-amber-300' : 'bg-stone-100 text-slate-body hover:bg-stone-200' }}">
                                Pelunasan ({{ $invoiceTypeCounts['final'] }})
                            </a>
                            <a href="{{ route('admin.payments.index', ['status' => $status, 'invoice_type' => 'dynamic', 'search' => $search, 'date_from' => $dateFrom, 'date_to' => $dateTo]) }}"
                                class="px-3 py-1.5 rounded-lg font-heading font-semibold transition {{ $invoiceType === 'dynamic' ? 'bg-amber-100 text-amber-900 border border-amber-300' : 'bg-stone-100 text-slate-body hover:bg-stone-200' }}">
                                Dynamic Add-on ({{ $invoiceTypeCounts['dynamic'] }})
                            </a>
                        </div>

                        <form action="{{ route('admin.payments.index') }}" method="GET" class="flex flex-wrap items-center gap-2">
                            <input type="hidden" name="status" value="{{ $status }}">
                            <input type="hidden" name="invoice_type" value="{{ $invoiceType }}">
                            <input type="hidden" name="search" value="{{ $search }}">
                            <span class="text-[11px] font-bold font-heading text-slate-muted uppercase tracking-wider">Tanggal:</span>
                            <label for="date-from" class="sr-only">Dari tanggal</label>
                            <input type="date" id="date-from" name="date_from" value="{{ $dateFrom }}"
                                class="min-h-10 sm:min-h-0 px-2.5 py-1.5 rounded-lg text-xs bg-bg-light border border-stone-200 text-slate-dark focus:outline-none focus:border-amber-500">
                            <span class="text-slate-muted">s.d.</span>
                            <label for="date-to" class="sr-only">Sampai tanggal</label>
                            <input type="date" id="date-to" name="date_to" value="{{ $dateTo }}"
                                class="min-h-10 sm:min-h-0 px-2.5 py-1.5 rounded-lg text-xs bg-bg-light border border-stone-200 text-slate-dark focus:outline-none focus:border-amber-500">
                            <button type="submit"
                                class="cursor-pointer min-h-10 sm:min-h-0 px-3 py-1.5 rounded-lg bg-stone-100 hover:bg-stone-200 text-slate-dark font-bold font-heading transition">
                                Terapkan
                            </button>
                            @if ($dateFrom !== '' || $dateTo !== '')
                                <a href="{{ route('admin.payments.index', ['status' => $status, 'invoice_type' => $invoiceType, 'search' => $search]) }}"
                                    class="min-h-10 sm:min-h-0 px-2.5 py-1.5 rounded-lg text-slate-muted hover:text-slate-dark hover:bg-stone-100 font-semibold transition flex items-center">
                                    Reset Tanggal
                                </a>
                            @endif
                        </form>
                    </div>
                </div>

                @if ($payments->isEmpty())
                    <div class="bg-white rounded-2xl border border-stone-200/90 shadow-2xs p-12 text-center space-y-3">
                        <div class="w-14 h-14 rounded-full bg-pastel-100 text-amber-900 flex items-center justify-center mx-auto text-2xl">
                            <i class="fa-solid fa-receipt" aria-hidden="true"></i>
                        </div>
                        <h3 class="font-heading font-bold text-base text-slate-dark">Tidak Ada Transaksi Ditemukan</h3>
                        <p class="text-xs text-slate-muted max-w-md mx-auto leading-relaxed">
                            @if ($search !== '')
                                Tidak ada transaksi yang cocok dengan kata kunci "{{ $search }}".
                            @elseif ($status !== 'all' || $invoiceType !== 'all' || $dateFrom !== '' || $dateTo !== '')
                                Belum ada transaksi yang sesuai dengan kombinasi filter status, jenis invoice, atau rentang tanggal yang dipilih.
                            @else
                                Belum ada rekaman transaksi pembayaran Midtrans di dalam sistem saat ini.
                            @endif
                        </p>
                        @if ($search !== '' || $status !== 'all' || $invoiceType !== 'all' || $dateFrom !== '' || $dateTo !== '')
                            <a href="{{ route('admin.payments.index') }}"
                                class="inline-flex items-center justify-center min-h-11 sm:min-h-0 mt-2 px-4 py-2 rounded-xl bg-pastel-200 hover:bg-pastel-300 border border-pastel-300 text-slate-dark text-xs font-bold font-heading transition">
                                Tampilkan Semua Transaksi
                            </a>
                        @endif
                    </div>
                @else
                    <div class="hidden lg:block bg-white rounded-2xl border border-stone-200/90 shadow-2xs overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b border-stone-200 bg-bg-light text-[11px] font-bold font-heading uppercase tracking-wider text-slate-muted">
                                        <th scope="col" class="py-3.5 px-5">Transaksi &amp; Invoice</th>
                                        <th scope="col" class="py-3.5 px-4">Pesanan &amp; Pihak</th>
                                        <th scope="col" class="py-3.5 px-4">Nominal &amp; Metode</th>
                                        <th scope="col" class="py-3.5 px-4">Status</th>
                                        <th scope="col" class="py-3.5 px-4">Waktu</th>
                                        <th scope="col" class="py-3.5 px-5 text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-stone-100 text-xs">
                                    @foreach ($payments as $payment)
                                        @php
                                            $payload = $service->buildPaymentModalPayload($payment);
                                            $payloadJson = json_encode($payload, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
                                            $statusStyle = match (true) {
                                                in_array($payment->payment_status, ['settlement', 'approved'], true) => ['bg' => 'bg-emerald-50 text-emerald-800 border-emerald-200', 'icon' => 'fa-circle-check'],
                                                $payment->payment_status === 'pending' => ['bg' => 'bg-sky-50 text-sky-800 border-sky-200', 'icon' => 'fa-clock'],
                                                default => ['bg' => 'bg-red-50 text-red-800 border-red-200', 'icon' => 'fa-circle-xmark'],
                                            };
                                        @endphp
                                        <tr class="hover:bg-pastel-50/40 transition">
                                            <td class="py-4 px-5 align-top">
                                                <div class="space-y-1">
                                                    <div class="flex items-center gap-2 flex-wrap">
                                                        <span class="font-heading font-bold text-sm text-slate-dark">
                                                            {{ $payload['invoice']['invoice_number'] ?? '-' }}
                                                        </span>
                                                        @if ($payload['invoice'])
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-pastel-100 text-amber-900 border border-pastel-300 text-[10px] font-bold font-heading">
                                                                {{ $payload['invoice']['type_label'] }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <span class="block font-mono text-[11px] text-slate-muted">
                                                        Ref: {{ $payload['reference_code'] }}
                                                    </span>
                                                </div>
                                            </td>

                                            <td class="py-4 px-4 align-top">
                                                @if ($payload['order'])
                                                    <div class="space-y-0.5">
                                                        <span class="font-heading font-bold text-slate-dark block">
                                                            #{{ $payload['order']['order_number'] }}
                                                        </span>
                                                        <span class="text-slate-body block">
                                                            {{ $payload['order']['client_name'] }} &rarr; {{ $payload['order']['artist_name'] }}
                                                        </span>
                                                    </div>
                                                @else
                                                    <span class="text-slate-muted">Data order tidak tersedia</span>
                                                @endif
                                            </td>

                                            <td class="py-4 px-4 align-top whitespace-nowrap">
                                                <div class="space-y-1">
                                                    <span class="font-heading font-bold text-sm text-slate-dark tabular-nums block">
                                                        {{ $payload['amount_formatted'] }}
                                                    </span>
                                                    <span class="text-slate-muted block">
                                                        {{ $payload['payment_method_label'] }}
                                                    </span>
                                                    @if ($payload['amount_mismatch'])
                                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-red-50 text-red-800 border border-red-200 text-[10px] font-bold font-heading">
                                                            <i class="fa-solid fa-triangle-exclamation text-[9px]" aria-hidden="true"></i>
                                                            <span>Selisih Tagihan</span>
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>

                                            <td class="py-4 px-4 align-top">
                                                <div class="space-y-1">
                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full border {{ $statusStyle['bg'] }} text-[11px] font-bold font-heading">
                                                        <i class="fa-solid {{ $statusStyle['icon'] }} text-[10px]" aria-hidden="true"></i>
                                                        <span>{{ $payload['payment_status_label'] }}</span>
                                                    </span>
                                                    @if ($payload['invoice'])
                                                        <span class="block text-[11px] text-slate-muted">
                                                            Invoice: {{ $payload['invoice']['status_label'] }}
                                                        </span>
                                                    @endif
                                                    @if ($payload['status_mismatch'])
                                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-red-50 text-red-800 border border-red-200 text-[10px] font-bold font-heading">
                                                            <i class="fa-solid fa-triangle-exclamation text-[9px]" aria-hidden="true"></i>
                                                            <span>Status Tidak Sinkron</span>
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>

                                            <td class="py-4 px-4 align-top">
                                                <div class="space-y-0.5 text-slate-muted">
                                                    <span class="text-slate-dark font-medium block whitespace-nowrap">
                                                        {{ $payload['paid_at_formatted'] ?? $payload['created_at_formatted'] ?? '-' }}
                                                    </span>
                                                    @if ($payload['verified_by_admin_name'])
                                                        <span class="text-[11px] block">
                                                            Audit: {{ $payload['verified_by_admin_name'] }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>

                                            <td class="py-4 px-5 text-right whitespace-nowrap align-top">
                                                <div class="inline-flex items-center justify-end gap-1.5">
                                                    <button type="button" data-action="detail" data-payment="{{ $payloadJson }}"
                                                        class="cursor-pointer px-3 py-1.5 rounded-xl bg-pastel-100 hover:bg-pastel-200 text-slate-dark border border-pastel-300 font-bold text-xs font-heading transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-dark">
                                                        Detail
                                                    </button>
                                                    @if ($payload['can_approve'])
                                                        <button type="button" data-action="approve" data-payment="{{ $payloadJson }}"
                                                            class="cursor-pointer px-3 py-1.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-200 font-bold text-xs font-heading transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-dark">
                                                            Setujui
                                                        </button>
                                                    @endif
                                                    @if ($payload['can_reject'])
                                                        <button type="button" data-action="reject" data-payment="{{ $payloadJson }}"
                                                            class="cursor-pointer px-3 py-1.5 rounded-xl bg-red-50 hover:bg-red-100 text-red-800 border border-red-200 font-bold text-xs font-heading transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-dark">
                                                            Tolak
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="lg:hidden grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach ($payments as $payment)
                            @php
                                $payload = $service->buildPaymentModalPayload($payment);
                                $payloadJson = json_encode($payload, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
                                $statusStyle = match (true) {
                                    in_array($payment->payment_status, ['settlement', 'approved'], true) => ['bg' => 'bg-emerald-50 text-emerald-800 border-emerald-200', 'icon' => 'fa-circle-check'],
                                    $payment->payment_status === 'pending' => ['bg' => 'bg-sky-50 text-sky-800 border-sky-200', 'icon' => 'fa-clock'],
                                    default => ['bg' => 'bg-red-50 text-red-800 border-red-200', 'icon' => 'fa-circle-xmark'],
                                };
                            @endphp
                            <div class="bg-white rounded-2xl border border-stone-200/90 shadow-2xs p-4 space-y-3.5">
                                <div class="flex items-start justify-between gap-2">
                                    <div class="min-w-0">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <h3 class="font-heading font-bold text-sm text-slate-dark truncate">
                                                {{ $payload['invoice']['invoice_number'] ?? '-' }}
                                            </h3>
                                            @if ($payload['invoice'])
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-pastel-100 text-amber-900 border border-pastel-300 text-[10px] font-bold font-heading">
                                                    {{ $payload['invoice']['type_label'] }}
                                                </span>
                                            @endif
                                        </div>
                                        <p class="font-mono text-[11px] text-slate-muted mt-0.5 truncate">
                                            Ref: {{ $payload['reference_code'] }}
                                        </p>
                                    </div>

                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full border {{ $statusStyle['bg'] }} text-[10px] font-bold font-heading shrink-0">
                                        <i class="fa-solid {{ $statusStyle['icon'] }} text-[9px]" aria-hidden="true"></i>
                                        <span>{{ $payload['payment_status_label'] }}</span>
                                    </span>
                                </div>

                                <div class="p-3 rounded-xl bg-bg-light border border-stone-100 space-y-1.5 text-xs">
                                    <div class="flex items-center justify-between gap-2">
                                        <span class="font-heading font-black text-sm text-slate-dark tabular-nums">
                                            {{ $payload['amount_formatted'] }}
                                        </span>
                                        <span class="text-slate-muted">{{ $payload['payment_method_label'] }}</span>
                                    </div>
                                    @if ($payload['order'])
                                        <p class="text-slate-body">
                                            #{{ $payload['order']['order_number'] }}: {{ $payload['order']['client_name'] }} &rarr; {{ $payload['order']['artist_name'] }}
                                        </p>
                                    @endif
                                    <div class="flex items-center justify-between gap-2 text-[11px] text-slate-muted pt-1 border-t border-stone-200/70">
                                        <span>{{ $payload['paid_at_formatted'] ?? $payload['created_at_formatted'] ?? '-' }}</span>
                                        @if ($payload['invoice'])
                                            <span>Invoice: {{ $payload['invoice']['status_label'] }}</span>
                                        @endif
                                    </div>
                                </div>

                                @if ($payload['amount_mismatch'] || $payload['status_mismatch'])
                                    <div class="flex flex-wrap gap-1.5">
                                        @if ($payload['amount_mismatch'])
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-red-50 text-red-800 border border-red-200 text-[10px] font-bold font-heading">
                                                <i class="fa-solid fa-triangle-exclamation text-[9px]" aria-hidden="true"></i>
                                                <span>Selisih Tagihan</span>
                                            </span>
                                        @endif
                                        @if ($payload['status_mismatch'])
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-red-50 text-red-800 border border-red-200 text-[10px] font-bold font-heading">
                                                <i class="fa-solid fa-triangle-exclamation text-[9px]" aria-hidden="true"></i>
                                                <span>Status Tidak Sinkron</span>
                                            </span>
                                        @endif
                                    </div>
                                @endif

                                <div class="flex flex-wrap items-center gap-2 pt-2 border-t border-stone-100">
                                    <button type="button" data-action="detail" data-payment="{{ $payloadJson }}"
                                        class="cursor-pointer flex-1 min-h-11 px-3 py-2 rounded-xl bg-pastel-100 hover:bg-pastel-200 text-slate-dark border border-pastel-300 font-bold text-xs font-heading transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-dark">
                                        Detail
                                    </button>
                                    @if ($payload['can_approve'])
                                        <button type="button" data-action="approve" data-payment="{{ $payloadJson }}"
                                            class="cursor-pointer flex-1 min-h-11 px-3 py-2 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-200 font-bold text-xs font-heading transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-dark">
                                            Setujui
                                        </button>
                                    @endif
                                    @if ($payload['can_reject'])
                                        <button type="button" data-action="reject" data-payment="{{ $payloadJson }}"
                                            class="cursor-pointer flex-1 min-h-11 px-3 py-2 rounded-xl bg-red-50 hover:bg-red-100 text-red-800 border border-red-200 font-bold text-xs font-heading transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-dark">
                                            Tolak
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if ($payments->hasPages())
                        <div class="pt-2">
                            {{ $payments->links() }}
                        </div>
                    @endif
                @endif

            </main>
        </div>
    </div>

    <div id="paymentDetailModal" role="dialog" aria-modal="true" aria-labelledby="detail-modal-title"
        class="fixed inset-0 z-50 hidden flex items-center justify-center bg-slate-dark/60 backdrop-blur-xs p-4">
        <div class="bg-white rounded-2xl border border-stone-200 shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto p-6 space-y-5">
            <div class="flex items-center justify-between gap-3 pb-3 border-b border-stone-200">
                <div class="min-w-0">
                    <h3 id="detail-modal-title" class="text-base font-bold font-heading text-slate-dark truncate">
                        Detail Transaksi
                    </h3>
                    <p id="detail-modal-subtitle" class="text-xs text-slate-muted truncate">-</p>
                </div>
                <button type="button" data-close-modal="paymentDetailModal" aria-label="Tutup dialog detail transaksi"
                    class="cursor-pointer w-9 h-9 rounded-full bg-stone-100 hover:bg-stone-200 text-slate-dark flex items-center justify-center font-bold transition shrink-0 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-dark">
                    <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                </button>
            </div>

            <div id="detail-mismatch-box" class="hidden p-4 rounded-xl bg-red-50 border border-red-200 text-xs space-y-1">
                <span class="font-heading font-bold text-red-900 block">Peringatan Ketidaksesuaian Audit</span>
                <p id="detail-mismatch-text" class="text-red-800 leading-relaxed"></p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs">
                <div class="p-3.5 rounded-xl bg-bg-light border border-stone-100 space-y-1">
                    <span class="text-[10px] uppercase font-bold text-slate-muted font-heading block">Nominal Pembayaran</span>
                    <p id="detail-amount" class="text-base font-black font-heading text-slate-dark tabular-nums">-</p>
                    <span id="detail-invoice-amount" class="text-[11px] text-slate-muted block tabular-nums">Tagihan: -</span>
                </div>
                <div class="p-3.5 rounded-xl bg-bg-light border border-stone-100 space-y-1">
                    <span class="text-[10px] uppercase font-bold text-slate-muted font-heading block">Metode &amp; Referensi</span>
                    <p id="detail-method" class="font-bold font-heading text-slate-dark">-</p>
                    <span id="detail-reference" class="font-mono text-[11px] text-slate-muted block break-all">-</span>
                </div>
                <div class="p-3.5 rounded-xl bg-bg-light border border-stone-100 space-y-1">
                    <span class="text-[10px] uppercase font-bold text-slate-muted font-heading block">Status Transaksi</span>
                    <p id="detail-payment-status" class="font-bold font-heading text-slate-dark">-</p>
                    <span id="detail-invoice-status" class="text-[11px] text-slate-muted block">Invoice: -</span>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs">
                <div class="p-3 rounded-xl bg-bg-light border border-stone-100 space-y-0.5">
                    <span class="text-[10px] uppercase font-bold text-slate-muted font-heading block">Dibuat Pada</span>
                    <p id="detail-created-at" class="font-semibold text-slate-dark">-</p>
                </div>
                <div class="p-3 rounded-xl bg-bg-light border border-stone-100 space-y-0.5">
                    <span class="text-[10px] uppercase font-bold text-slate-muted font-heading block">Waktu Dibayar</span>
                    <p id="detail-paid-at" class="font-semibold text-slate-dark">-</p>
                </div>
                <div class="p-3 rounded-xl bg-bg-light border border-stone-100 space-y-0.5">
                    <span class="text-[10px] uppercase font-bold text-slate-muted font-heading block">Jatuh Tempo Invoice</span>
                    <p id="detail-due-date" class="font-semibold text-slate-dark">-</p>
                </div>
            </div>

            <div class="p-4 rounded-xl bg-bg-light border border-stone-100 text-xs space-y-2.5">
                <div class="flex items-center justify-between gap-2 flex-wrap">
                    <span class="font-heading font-bold text-slate-dark" id="detail-order-number">Order -</span>
                    <span class="px-2.5 py-0.5 rounded-full bg-pastel-100 text-amber-900 border border-pastel-300 text-[10px] font-bold font-heading" id="detail-order-status">-</span>
                </div>
                <p id="detail-menu-title" class="text-slate-muted">Menu Komisi: -</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2 border-t border-stone-200/70">
                    <div>
                        <span class="text-[10px] uppercase font-bold text-slate-muted block">Client (Pembeli)</span>
                        <p id="detail-client-name" class="font-bold text-slate-dark mt-0.5">-</p>
                        <p id="detail-client-email" class="text-slate-muted">-</p>
                    </div>
                    <div>
                        <span class="text-[10px] uppercase font-bold text-slate-muted block">Artist (Kreator)</span>
                        <p id="detail-artist-name" class="font-bold text-slate-dark mt-0.5">-</p>
                        <p id="detail-artist-email" class="text-slate-muted">-</p>
                    </div>
                </div>
            </div>

            <div id="detail-items-box" class="hidden p-4 rounded-xl bg-bg-light border border-stone-100 text-xs space-y-2">
                <h4 class="font-heading font-bold text-slate-dark">Rincian Item Tagihan</h4>
                <div id="detail-items-list" class="divide-y divide-stone-200/70"></div>
            </div>

            <div id="detail-proof-audit-grid" class="hidden grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                <div id="detail-proof-box" class="hidden p-4 rounded-xl bg-pastel-50 border border-pastel-300 space-y-2">
                    <span class="text-[10px] uppercase font-bold text-amber-900 font-heading block">Lampiran Referensi Pembayaran</span>
                    <a id="detail-proof-link" href="#" target="_blank" rel="noopener noreferrer"
                        class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-pastel-200 hover:bg-pastel-300 border border-pastel-300 text-slate-dark font-bold text-xs font-heading transition">
                        <i class="fa-solid fa-arrow-up-right-from-square text-[11px]" aria-hidden="true"></i>
                        <span>Buka Lampiran</span>
                    </a>
                </div>

                <div id="detail-audit-box" class="hidden p-4 rounded-xl bg-stone-50 border border-stone-200 space-y-1">
                    <span class="text-[10px] uppercase font-bold text-slate-muted font-heading block">Jejak Audit Admin</span>
                    <p id="detail-audit-admin" class="font-bold text-slate-dark">-</p>
                    <p id="detail-audit-date" class="text-[11px] text-slate-muted">-</p>
                    <p id="detail-audit-note" class="text-slate-body pt-1 hidden"></p>
                </div>
            </div>

            <div id="detail-payload-box" class="hidden p-4 rounded-xl bg-stone-50 border border-stone-200 space-y-2 text-xs">
                <span class="text-[10px] uppercase font-bold text-slate-muted font-heading block">Payload Gateway (Sensitif Disensor)</span>
                <pre id="detail-payload-pre" class="p-3 rounded-lg bg-white border border-stone-200 text-[11px] font-mono text-slate-dark overflow-x-auto max-h-48 whitespace-pre-wrap break-all"></pre>
            </div>

            <div class="flex flex-wrap items-center justify-between gap-2 pt-3 border-t border-stone-100">
                <div id="detail-action-buttons" class="flex flex-wrap items-center gap-2"></div>
                <button type="button" data-close-modal="paymentDetailModal"
                    class="cursor-pointer min-h-11 sm:min-h-0 px-4 py-2 rounded-xl bg-stone-100 hover:bg-stone-200 text-slate-dark text-xs font-bold font-heading transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-dark">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <div id="approvePaymentModal" role="dialog" aria-modal="true" aria-labelledby="approve-modal-title"
        class="fixed inset-0 z-50 hidden flex items-center justify-center bg-slate-dark/60 backdrop-blur-xs p-4">
        <div class="bg-white rounded-2xl border border-stone-200 shadow-2xl w-full max-w-md p-6 space-y-4">
            <div class="flex items-center justify-between gap-3 pb-3 border-b border-stone-200">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-10 h-10 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-center text-base shrink-0">
                        <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
                    </div>
                    <div class="min-w-0">
                        <h3 id="approve-modal-title" class="font-heading font-bold text-base text-slate-dark">Setujui Pembayaran?</h3>
                        <p id="approve-payment-label" class="text-xs text-slate-muted truncate">-</p>
                    </div>
                </div>
                <button type="button" data-close-modal="approvePaymentModal" aria-label="Tutup dialog persetujuan pembayaran"
                    class="cursor-pointer w-9 h-9 rounded-full bg-stone-100 hover:bg-stone-200 text-slate-dark flex items-center justify-center font-bold transition shrink-0">
                    <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                </button>
            </div>

            <div class="p-3.5 rounded-xl bg-emerald-50/70 border border-emerald-200 text-xs text-emerald-900 space-y-1 leading-relaxed">
                <p id="approve-summary-text" class="font-bold">-</p>
                <p>Gunakan aksi ini jika dana sudah terkonfirmasi masuk di dashboard Midtrans namun webhook belum memperbarui status. Menyetujui transaksi akan menandai invoice sebagai lunas, menggerakkan status pesanan ke tahap berikutnya, dan mengirim notifikasi ke Client serta Artist.</p>
            </div>

            <form id="approvePaymentForm" action="" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="approve-notes-input" class="block text-xs font-semibold text-slate-dark mb-1">
                        Catatan Audit (Opsional)
                    </label>
                    <textarea id="approve-notes-input" name="audit_notes" rows="3" maxlength="1000"
                        placeholder="Catatan rekonsiliasi, mis. ID referensi Midtrans atau waktu settlement terkonfirmasi..."
                        class="w-full text-xs p-3 rounded-xl bg-bg-light border border-stone-200 focus:outline-none focus:border-emerald-600 focus:bg-white text-slate-dark placeholder:text-slate-muted"></textarea>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2 border-t border-stone-100">
                    <button type="button" data-close-modal="approvePaymentModal"
                        class="cursor-pointer min-h-11 sm:min-h-0 px-4 py-2 rounded-xl bg-stone-100 hover:bg-stone-200 text-slate-dark text-xs font-bold font-heading transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="cursor-pointer min-h-11 sm:min-h-0 px-4 py-2 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold font-heading shadow-xs transition">
                        Konfirmasi Setujui
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="rejectPaymentModal" role="dialog" aria-modal="true" aria-labelledby="reject-modal-title"
        class="fixed inset-0 z-50 hidden flex items-center justify-center bg-slate-dark/60 backdrop-blur-xs p-4">
        <div class="bg-white rounded-2xl border border-stone-200 shadow-2xl w-full max-w-md p-6 space-y-4">
            <div class="flex items-center justify-between gap-3 pb-3 border-b border-stone-200">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-10 h-10 rounded-full bg-red-50 border border-red-200 text-red-800 flex items-center justify-center text-base shrink-0">
                        <i class="fa-solid fa-circle-xmark" aria-hidden="true"></i>
                    </div>
                    <div class="min-w-0">
                        <h3 id="reject-modal-title" class="font-heading font-bold text-base text-slate-dark">Tolak Pembayaran?</h3>
                        <p id="reject-payment-label" class="text-xs text-slate-muted truncate">-</p>
                    </div>
                </div>
                <button type="button" data-close-modal="rejectPaymentModal" aria-label="Tutup dialog penolakan pembayaran"
                    class="cursor-pointer w-9 h-9 rounded-full bg-stone-100 hover:bg-stone-200 text-slate-dark flex items-center justify-center font-bold transition shrink-0">
                    <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                </button>
            </div>

            <p class="text-xs text-slate-body leading-relaxed">
                Transaksi Midtrans yang masih menunggu ini akan ditandai sebagai ditolak admin. Tagihan invoice tetap terbuka agar Client dapat melakukan pembayaran ulang melalui Midtrans Snap.
            </p>

            <form id="rejectPaymentForm" action="" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="reject-reason-input" class="block text-xs font-semibold text-slate-dark mb-1">
                        Alasan Penolakan <span class="text-red-700">*</span>
                    </label>
                    <textarea id="reject-reason-input" name="rejection_reason" rows="3" required minlength="5" maxlength="1000"
                        placeholder="Contoh: Status di dashboard Midtrans belum dibayar atau transaksi bermasalah..."
                        class="w-full text-xs p-3 rounded-xl bg-bg-light border border-stone-200 focus:outline-none focus:border-red-500 focus:bg-white text-slate-dark placeholder:text-slate-muted"></textarea>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2 border-t border-stone-100">
                    <button type="button" data-close-modal="rejectPaymentModal"
                        class="cursor-pointer min-h-11 sm:min-h-0 px-4 py-2 rounded-xl bg-stone-100 hover:bg-stone-200 text-slate-dark text-xs font-bold font-heading transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="cursor-pointer min-h-11 sm:min-h-0 px-4 py-2 rounded-xl bg-red-700 hover:bg-red-800 text-white text-xs font-bold font-heading shadow-xs transition">
                        Konfirmasi Tolak
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        (function () {
            let activeModalId = null;
            let lastTriggerEl = null;

            function openModal(id, triggerEl) {
                if (activeModalId && activeModalId !== id) {
                    closeModal(activeModalId, false);
                }
                const modal = document.getElementById(id);
                if (!modal) return;
                activeModalId = id;
                lastTriggerEl = triggerEl || document.activeElement;
                modal.classList.remove('hidden');

                const firstFocusable = modal.querySelector('input:not([type="hidden"]):not(:disabled), textarea, select:not(:disabled), button');
                if (firstFocusable) {
                    firstFocusable.focus();
                }
            }

            function closeModal(id, restoreFocus = true) {
                const modal = document.getElementById(id);
                if (!modal) return;
                modal.classList.add('hidden');
                if (activeModalId === id) {
                    activeModalId = null;
                }
                if (restoreFocus && lastTriggerEl && typeof lastTriggerEl.focus === 'function') {
                    lastTriggerEl.focus();
                    lastTriggerEl = null;
                }
            }

            function isSafeProofHref(url) {
                if (typeof url !== 'string' || url.trim() === '') return false;
                return /^https?:\/\//i.test(url) || url.startsWith('/');
            }

            function openDetailModal(data, triggerEl) {
                const invNumber = data.invoice ? data.invoice.invoice_number : '-';
                const ordNumber = data.order ? ('Order #' + data.order.order_number) : 'Order tidak tersedia';

                document.getElementById('detail-modal-title').textContent = 'Detail Transaksi: ' + data.reference_code;
                document.getElementById('detail-modal-subtitle').textContent = invNumber + ' (' + (data.invoice ? data.invoice.type_label : '-') + ') - ' + ordNumber;

                const mismatchBox = document.getElementById('detail-mismatch-box');
                const warnings = [];
                if (data.amount_mismatch) {
                    warnings.push('Nominal pembayaran (' + data.amount_formatted + ') tidak sama dengan tagihan invoice (' + (data.invoice ? data.invoice.amount_formatted : '-') + ').');
                }
                if (data.status_mismatch) {
                    warnings.push('Status transaksi (' + data.payment_status_label + ') belum sinkron dengan status invoice (' + (data.invoice ? data.invoice.status_label : '-') + ').');
                }
                if (data.approve_blocked_reason && data.payment_status === 'pending' && !data.amount_mismatch && !data.status_mismatch) {
                    warnings.push(data.approve_blocked_reason);
                }
                if (warnings.length > 0) {
                    document.getElementById('detail-mismatch-text').textContent = warnings.join(' ');
                    mismatchBox.classList.remove('hidden');
                } else {
                    mismatchBox.classList.add('hidden');
                }

                document.getElementById('detail-amount').textContent = data.amount_formatted;
                document.getElementById('detail-invoice-amount').textContent = 'Tagihan: ' + (data.invoice ? data.invoice.amount_formatted : '-');
                document.getElementById('detail-method').textContent = data.payment_method_label || '-';
                document.getElementById('detail-reference').textContent = data.reference_code;
                document.getElementById('detail-payment-status').textContent = data.payment_status_label;
                document.getElementById('detail-invoice-status').textContent = 'Invoice: ' + (data.invoice ? data.invoice.status_label : '-');
                document.getElementById('detail-created-at').textContent = data.created_at_formatted || '-';
                document.getElementById('detail-paid-at').textContent = data.paid_at_formatted || 'Belum dibayar';
                document.getElementById('detail-due-date').textContent = (data.invoice && data.invoice.due_date) ? data.invoice.due_date : '-';

                if (data.order) {
                    document.getElementById('detail-order-number').textContent = 'Order #' + data.order.order_number + ' (Total: ' + data.order.total_formatted + ')';
                    document.getElementById('detail-order-status').textContent = data.order.status_label;
                    document.getElementById('detail-menu-title').textContent = 'Menu Komisi: ' + data.order.menu_title;
                    document.getElementById('detail-client-name').textContent = data.order.client_name;
                    document.getElementById('detail-client-email').textContent = data.order.client_email;
                    document.getElementById('detail-artist-name').textContent = data.order.artist_name;
                    document.getElementById('detail-artist-email').textContent = data.order.artist_email;
                } else {
                    document.getElementById('detail-order-number').textContent = 'Order tidak tersedia';
                    document.getElementById('detail-order-status').textContent = '-';
                    document.getElementById('detail-menu-title').textContent = 'Menu Komisi: -';
                    document.getElementById('detail-client-name').textContent = '-';
                    document.getElementById('detail-client-email').textContent = '-';
                    document.getElementById('detail-artist-name').textContent = '-';
                    document.getElementById('detail-artist-email').textContent = '-';
                }

                const itemsBox = document.getElementById('detail-items-box');
                const itemsList = document.getElementById('detail-items-list');
                itemsList.replaceChildren();
                if (Array.isArray(data.invoice_items) && data.invoice_items.length > 0) {
                    data.invoice_items.forEach(function (item) {
                        const row = document.createElement('div');
                        row.className = 'py-2 flex items-center justify-between gap-3';

                        const left = document.createElement('span');
                        left.className = 'text-slate-dark font-medium';
                        left.textContent = item.item_name + ' x' + String(item.qty);

                        const right = document.createElement('span');
                        right.className = 'font-heading font-bold text-slate-dark tabular-nums shrink-0';
                        right.textContent = item.subtotal;

                        row.appendChild(left);
                        row.appendChild(right);
                        itemsList.appendChild(row);
                    });
                    itemsBox.classList.remove('hidden');
                } else {
                    itemsBox.classList.add('hidden');
                }

                const proofAuditGrid = document.getElementById('detail-proof-audit-grid');
                const proofBox = document.getElementById('detail-proof-box');
                const proofLink = document.getElementById('detail-proof-link');
                const hasProof = isSafeProofHref(data.proof_url);
                if (hasProof) {
                    proofLink.href = data.proof_url;
                    proofBox.classList.remove('hidden');
                } else {
                    proofLink.href = '#';
                    proofBox.classList.add('hidden');
                }

                const auditBox = document.getElementById('detail-audit-box');
                const auditNoteEl = document.getElementById('detail-audit-note');
                const hasAudit = Boolean(data.verified_by_admin_name || data.verified_at_formatted || data.admin_audit_note);
                if (hasAudit) {
                    document.getElementById('detail-audit-admin').textContent = data.verified_by_admin_name || 'Administrator';
                    document.getElementById('detail-audit-date').textContent = data.verified_at_formatted || '-';
                    if (data.admin_audit_note) {
                        auditNoteEl.textContent = 'Catatan: ' + data.admin_audit_note;
                        auditNoteEl.classList.remove('hidden');
                    } else {
                        auditNoteEl.textContent = '';
                        auditNoteEl.classList.add('hidden');
                    }
                    auditBox.classList.remove('hidden');
                } else {
                    auditBox.classList.add('hidden');
                }

                if (!hasProof && !hasAudit) {
                    proofAuditGrid.className = 'hidden grid grid-cols-1 gap-3 text-xs';
                } else if (hasProof && hasAudit) {
                    proofAuditGrid.className = 'grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs';
                } else {
                    proofAuditGrid.className = 'grid grid-cols-1 gap-3 text-xs';
                }

                const payloadBox = document.getElementById('detail-payload-box');
                const payloadPre = document.getElementById('detail-payload-pre');
                if (data.sanitized_payload_json) {
                    payloadPre.textContent = data.sanitized_payload_json;
                    payloadBox.classList.remove('hidden');
                } else {
                    payloadPre.textContent = '';
                    payloadBox.classList.add('hidden');
                }

                const actionsContainer = document.getElementById('detail-action-buttons');
                actionsContainer.replaceChildren();

                if (data.can_approve) {
                    const approveBtn = document.createElement('button');
                    approveBtn.type = 'button';
                    approveBtn.className = 'cursor-pointer min-h-11 sm:min-h-0 px-4 py-2 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-200 text-xs font-bold font-heading transition';
                    approveBtn.textContent = 'Setujui Pembayaran';
                    approveBtn.addEventListener('click', function () {
                        openApproveModal(data, triggerEl);
                    });
                    actionsContainer.appendChild(approveBtn);
                }

                if (data.can_reject) {
                    const rejectBtn = document.createElement('button');
                    rejectBtn.type = 'button';
                    rejectBtn.className = 'cursor-pointer min-h-11 sm:min-h-0 px-4 py-2 rounded-xl bg-red-50 hover:bg-red-100 text-red-800 border border-red-200 text-xs font-bold font-heading transition';
                    rejectBtn.textContent = 'Tolak Pembayaran';
                    rejectBtn.addEventListener('click', function () {
                        openRejectModal(data, triggerEl);
                    });
                    actionsContainer.appendChild(rejectBtn);
                }

                openModal('paymentDetailModal', triggerEl);
            }

            function openApproveModal(data, triggerEl) {
                const invNumber = data.invoice ? data.invoice.invoice_number : '-';
                const typeLabel = data.invoice ? data.invoice.type_label : '-';
                const clientName = data.order ? data.order.client_name : '-';

                document.getElementById('approvePaymentForm').action = data.approve_url;
                document.getElementById('approve-payment-label').textContent = data.reference_code + ' (' + invNumber + ')';
                document.getElementById('approve-summary-text').textContent = typeLabel + ' sebesar ' + data.amount_formatted + ' dari ' + clientName;
                document.getElementById('approve-notes-input').value = '';
                openModal('approvePaymentModal', triggerEl);
            }

            function openRejectModal(data, triggerEl) {
                const invNumber = data.invoice ? data.invoice.invoice_number : '-';
                document.getElementById('rejectPaymentForm').action = data.reject_url;
                document.getElementById('reject-payment-label').textContent = data.reference_code + ' (' + invNumber + ' - ' + data.amount_formatted + ')';
                document.getElementById('reject-reason-input').value = '';
                openModal('rejectPaymentModal', triggerEl);
            }

            document.addEventListener('click', function (event) {
                const actionBtn = event.target.closest('[data-action]');
                if (actionBtn) {
                    const data = JSON.parse(actionBtn.dataset.payment);
                    const action = actionBtn.dataset.action;

                    if (action === 'detail') openDetailModal(data, actionBtn);
                    else if (action === 'approve') openApproveModal(data, actionBtn);
                    else if (action === 'reject') openRejectModal(data, actionBtn);
                    return;
                }

                const closeBtn = event.target.closest('[data-close-modal]');
                if (closeBtn) {
                    closeModal(closeBtn.dataset.closeModal);
                    return;
                }

                if (activeModalId && event.target.id === activeModalId) {
                    closeModal(activeModalId);
                }
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape' && activeModalId) {
                    closeModal(activeModalId);
                }
            });

            const emptyExportBtn = document.getElementById('empty-export-btn');
            const exportEmptyAlert = document.getElementById('export-empty-alert');
            const closeExportEmptyAlertBtn = document.getElementById('close-export-empty-alert');

            if (emptyExportBtn && exportEmptyAlert) {
                emptyExportBtn.addEventListener('click', function () {
                    exportEmptyAlert.classList.remove('hidden');
                    exportEmptyAlert.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                    exportEmptyAlert.focus();
                });
            }

            if (closeExportEmptyAlertBtn && exportEmptyAlert) {
                closeExportEmptyAlertBtn.addEventListener('click', function () {
                    exportEmptyAlert.classList.add('hidden');
                    if (emptyExportBtn) {
                        emptyExportBtn.focus();
                    }
                });
            }
        })();
    </script>
@endsection
