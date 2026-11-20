@extends('layouts.app')

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

            <main class="p-4 sm:p-6 lg:p-8 space-y-8 max-w-7xl w-full mx-auto">

                <div class="bg-white rounded-2xl border border-stone-200/90 shadow-2xs p-5 sm:p-6 ">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="px-2.5 py-1 rounded-md bg-pastel-200 text-amber-900 font-bold text-[10px] font-heading uppercase tracking-wider">
                                Administrator Portal
                            </span>
                            <span class="text-xs text-slate-muted">
                                • {{ now()->timezone('Asia/Jakarta')->translatedFormat('l, d F Y') }} WIB
                            </span>
                        </div>
                        <h1 class="text-xl sm:text-2xl font-black font-heading text-slate-dark mt-1">
                            Ringkasan Platform dan Operasional
                        </h1>
                        <p class="text-xs sm:text-sm text-slate-muted mt-0.5">
                            Audit transaksi escrow, proses pencairan dana artist, dan verifikasi berkas pendaftar baru.
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                    {{-- Menunggu Verifikasi --}}
                    <div class="bg-white p-5 rounded-2xl border border-stone-200/90 shadow-2xs flex items-center justify-between">
                        <div>
                            <span class="text-xs text-slate-muted font-medium block">Pengajuan Artist Menunggu</span>
                            <div class="flex items-baseline gap-2 mt-1">
                                <span class="text-2xl font-black font-heading {{ $metrics['pendingApplicationsCount'] > 0 ? 'text-amber-600' : 'text-slate-dark' }}">
                                    {{ $metrics['pendingApplicationsCount'] }}
                                </span>
                                @if ($metrics['pendingApplicationsCount'] > 0)
                                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                                @endif
                            </div>
                        </div>
                        <div class="w-11 h-11 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-id-card-clip text-base"></i>
                        </div>
                    </div>

                    {{-- Antrean Payout Escrow --}}
                    <div class="bg-white p-5 rounded-2xl border border-stone-200/90 shadow-2xs flex items-center justify-between">
                        <div>
                            <span class="text-xs text-slate-muted font-medium block">Antrean Payout Artist</span>
                            <div class="flex items-baseline gap-2 mt-1">
                                <span class="text-2xl font-black font-heading {{ $metrics['pendingPayoutsCount'] > 0 ? 'text-sky-700' : 'text-slate-dark' }}">
                                    {{ $metrics['pendingPayoutsCount'] }}
                                </span>
                                <span class="text-xs text-slate-muted font-medium truncate">
                                    (Rp {{ number_format($metrics['pendingPayoutsAmount'], 0, ',', '.') }})
                                </span>
                            </div>
                        </div>
                        <div class="w-11 h-11 rounded-xl bg-sky-100 text-sky-800 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-money-bill-transfer text-base"></i>
                        </div>
                    </div>

                    {{-- Total Escrow Terbayar --}}
                    <div class="bg-white p-5 rounded-2xl border border-stone-200/90 shadow-2xs flex items-center justify-between">
                        <div>
                            <span class="text-xs text-slate-muted font-medium block">Total Transaksi Escrow</span>
                            <div class="flex items-baseline gap-2 mt-1">
                                <span class="text-xl sm:text-2xl font-black font-heading text-slate-dark">
                                    Rp {{ number_format($metrics['totalEscrowTransacted'], 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                        <div class="w-11 h-11 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-shield-halved text-base"></i>
                        </div>
                    </div>

                    {{-- Laporan Sengketa --}}
                    <div class="bg-white p-5 rounded-2xl border border-stone-200/90 shadow-2xs flex items-center justify-between">
                        <div>
                            <span class="text-xs text-slate-muted font-medium block">Laporan Sengketa</span>
                            <div class="flex items-baseline gap-2 mt-1">
                                <span class="text-2xl font-black font-heading {{ $metrics['pendingReportsCount'] > 0 ? 'text-rose-600' : 'text-slate-dark' }}">
                                    {{ $metrics['pendingReportsCount'] }}
                                </span>
                                @if ($metrics['pendingReportsCount'] > 0)
                                    <span class="text-[10px] font-bold text-rose-700 bg-rose-50 px-2 py-0.5 rounded-full border border-rose-200">
                                        Perlu Ditinjau
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="w-11 h-11 rounded-xl bg-rose-100 text-rose-800 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-triangle-exclamation text-base"></i>
                        </div>
                    </div>

                </div>

                @if (!empty($actionItems))
                <section class="space-y-3">
                    <h3 class="text-sm font-bold font-heading text-slate-dark flex items-center gap-2">
                        <i class="fa-solid fa-bell text-amber-600"></i>
                        <span>Tindakan Memerlukan Respon Admin</span>
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                        @foreach ($actionItems as $item)
                                <div class="bg-white rounded-2xl border border-stone-200/90 shadow-2xs p-4 flex flex-col justify-between space-y-3">
                                    <div class="flex items-start gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-{{ $item['color'] }}-100 text-{{ $item['color'] }}-800 flex items-center justify-center shrink-0 text-base">
                                            <i class="{{ $item['icon'] }}"></i>
                                        </div>
                                        <div>
                                            <span class="px-2 py-0.5 rounded-full bg-{{ $item['color'] }}-50 text-{{ $item['color'] }}-800 border border-{{ $item['color'] }}-200 text-[10px] font-bold font-heading">
                                                {{ $item['badge'] }}
                                            </span>
                                            <h4 class="font-heading font-bold text-xs sm:text-sm text-slate-dark mt-1">
                                                {{ $item['title'] }}
                                            </h4>
                                            <p class="text-[11px] text-slate-muted mt-0.5 leading-relaxed">
                                                {{ $item['description'] }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="pt-2 border-t border-stone-100 flex justify-end">
                                        <a href="{{ $item['link'] }}" class="px-3.5 py-1.5 rounded-xl bg-pastel-200 hover:bg-pastel-300 text-slate-dark text-xs font-bold font-heading transition">
                                            Proses Sekarang &rarr;
                                        </a>
                                    </div>
                                </div>
                        @endforeach
                    </div>
                </section>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    <div class="bg-white rounded-2xl border border-stone-200/90 shadow-2xs p-5 sm:p-6 space-y-4">
                        <div class="pb-3 border-b border-stone-100">
                            <h3 class="font-heading font-bold text-sm sm:text-base text-slate-dark">
                                Pengguna Artsy.ID
                            </h3>
                            <p class="text-xs text-slate-muted">Total entitas aktif di database platform.</p>
                        </div>

                        <div class="space-y-3 text-xs">
                            <div class="p-3.5 rounded-xl bg-bg-light border border-stone-100 flex items-center justify-between">
                                <div class="flex items-center gap-2.5">
                                    <i class="fa-solid fa-user text-amber-700"></i>
                                    <span class="font-medium text-slate-dark">Client / User</span>
                                </div>
                                <span class="font-black font-heading text-sm text-slate-dark">{{ $metrics['totalUsersCount'] }}</span>
                            </div>

                            <div class="p-3.5 rounded-xl bg-bg-light border border-stone-100 flex items-center justify-between">
                                <div class="flex items-center gap-2.5">
                                    <i class="fa-solid fa-palette text-amber-700"></i>
                                    <span class="font-medium text-slate-dark">Artist</span>
                                </div>
                                <span class="font-black font-heading text-sm text-slate-dark">{{ $metrics['totalArtistsCount'] }}</span>
                            </div>

                            <div class="p-3.5 rounded-xl bg-bg-light border border-stone-100 flex items-center justify-between">
                                <div class="flex items-center gap-2.5">
                                    <i class="fa-solid fa-boxes-stacked text-amber-700"></i>
                                    <span class="font-medium text-slate-dark">Pesanan Aktif</span>
                                </div>
                                <span class="font-black font-heading text-sm text-slate-dark">{{ $metrics['activeOrdersCount'] }}</span>
                            </div>

                            <div class="p-3.5 rounded-xl bg-bg-light border border-stone-100 flex items-center justify-between">
                                <div class="flex items-center gap-2.5">
                                    <i class="fa-solid fa-circle-check text-emerald-600"></i>
                                    <span class="font-medium text-slate-dark">Komisi Berhasil Selesai</span>
                                </div>
                                <span class="font-black font-heading text-sm text-emerald-700">{{ $metrics['completedOrdersCount'] }}</span>
                            </div>
                        </div>

                        <div class="pt-2">
                            <a href="{{ route('admin.users.index') }}" class="w-full py-2 rounded-xl bg-stone-100 hover:bg-stone-200 text-slate-dark text-xs font-bold font-heading transition text-center block">
                                Kelola Pengguna Platform
                            </a>
                        </div>
                    </div>

                    <div class="lg:col-span-2 bg-white rounded-2xl border border-stone-200/90 shadow-2xs p-5 sm:p-6 space-y-4 max-h-105 overflow-y-auto">
                        <div class="flex items-center justify-between pb-3 border-b border-stone-100">
                            <div>
                                <h3 class="font-heading font-bold text-sm sm:text-base text-slate-dark">
                                    Pengajuan Pendaftaran Artist Terbaru
                                </h3>
                                <p class="text-xs text-slate-muted">Pendaftar terbaru yang mengajukan berkas portofolio &amp; ToS.</p>
                            </div>
                            <a href="{{ route('admin.applications.index') }}" class="text-xs font-bold font-heading text-slate-dark hover:text-amber-700 transition">
                                Lihat Semua <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>

                        @if ($recentApplications->isEmpty())
                            <div class="p-8 text-center text-xs text-slate-muted">
                                Belum ada pengajuan pendaftaran artist.
                            </div>
                        @else
                            <div class="space-y-2.5">
                                @foreach ($recentApplications as $app)
                                    <div class="p-3.5 rounded-xl bg-bg-light border border-stone-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-full bg-pastel-300 text-slate-dark font-black text-xs flex items-center justify-center font-heading shrink-0">
                                                {{ strtoupper(substr($app->user?->name ?? 'A', 0, 2)) }}
                                            </div>
                                            <div>
                                                <h4 class="font-bold font-heading text-slate-dark">{{ $app->user?->name ?? 'Pemohon' }}</h4>
                                                <p class="text-[11px] text-slate-muted">{{ $app->user?->email }} • Diajukan: {{ $app->created_at ? $app->created_at->diffForHumans() : '-' }}</p>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-2.5 justify-between sm:justify-end">
                                            @if ($app->status === 'pending')
                                                <span class="px-2.5 py-0.5 rounded-full bg-amber-50 text-amber-800 border border-amber-200 text-[10px] font-bold font-heading">
                                                    Menunggu
                                                </span>
                                            @elseif ($app->status === 'approved')
                                                <span class="px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200 text-[10px] font-bold font-heading">
                                                    Disetujui
                                                </span>
                                            @elseif ($app->status === 'rejected')
                                                <span class="px-2.5 py-0.5 rounded-full bg-red-50 text-red-800 border border-red-200 text-[10px] font-bold font-heading">
                                                    Ditolak
                                                </span>
                                            @endif
                                            <a href="{{ route('admin.applications.index') }}" class="text-[11px] font-bold text-amber-800 hover:underline">
                                                Tinjau Berkas
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                </div>

                <section class="space-y-4">
                    <div class="flex items-center justify-between pb-2 border-b border-stone-200">
                        <div>
                            <h3 class="text-base sm:text-lg font-black font-heading text-slate-dark">
                                Pesanan Komisi Terbaru di Platform
                            </h3>
                            <p class="text-xs text-slate-muted">Log transaksi pesanan terkini antara Client dan Artist.</p>
                        </div>
                        <a href="{{ route('admin.orders.index') }}" class="text-xs font-bold text-slate-dark hover:text-amber-700 transition font-heading flex items-center gap-1">
                            <span>Buka Manajemen Pesanan</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>

                    @if ($recentOrders->isEmpty())
                        <div class="bg-white rounded-2xl border border-stone-200/90 shadow-2xs p-8 text-center space-y-2">
                            <div class="w-12 h-12 rounded-full bg-pastel-100 text-amber-700 flex items-center justify-center mx-auto text-xl">
                                <i class="fa-solid fa-boxes-stacked"></i>
                            </div>
                            <h4 class="font-heading font-bold text-sm text-slate-dark">Belum Ada Transaksi Pesanan</h4>
                            <p class="text-xs text-slate-muted max-w-sm mx-auto">
                                Pesanan komisi yang dibuat oleh client akan tercatat di sini.
                            </p>
                        </div>
                    @else
                        <div class="space-y-3">
                            @foreach ($recentOrders as $order)
                                <div class="bg-white rounded-2xl border border-stone-200/90 shadow-2xs p-4 sm:p-5 flex flex-col md:flex-row items-start md:items-center justify-between gap-4 text-xs">
                                    <div class="flex items-center gap-3.5">
                                        <div class="w-10 h-10 rounded-xl bg-pastel-200 text-slate-dark font-black font-heading flex items-center justify-center shrink-0">
                                            #
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2 flex-wrap">
                                                <h4 class="font-bold font-heading text-slate-dark text-sm">
                                                    {{ $order->commissionMenu?->title ?? 'Custom Artwork' }}
                                                </h4>
                                                <span class="text-slate-muted font-mono font-semibold">#{{ $order->order_number }}</span>
                                            </div>
                                            <p class="text-slate-muted mt-0.5">
                                                Client: <strong class="text-slate-dark">{{ $order->client?->name ?? 'Client' }}</strong> &bull;
                                                Artist: <strong class="text-slate-dark">{{ $order->artist?->name ?? 'Artist' }}</strong> &bull;
                                                {{ $order->created_at ? $order->created_at->timezone('Asia/Jakarta')->translatedFormat('d M Y, H:i') : '-' }} WIB
                                            </p>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-3 w-full md:w-auto justify-between md:justify-end">
                                        <div class="text-right">
                                            <span class="text-[10px] text-slate-muted uppercase font-bold block">Nilai Escrow</span>
                                            <span class="text-xs sm:text-sm font-black font-heading text-slate-dark">
                                                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                            </span>
                                        </div>
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold font-heading capitalize
                                            {{ $order->status === 'completed' ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : 'bg-amber-50 text-amber-800 border border-amber-200' }}">
                                            {{ str_replace('_', ' ', $order->status) }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </section>

            </main>
        </div>
    </div>
@endsection
