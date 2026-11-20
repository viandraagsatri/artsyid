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

                <div class="bg-linear-to-r from-pastel-100 via-pastel-200/90 to-pastel-100 rounded-2xl p-5 sm:p-6 border border-pastel-300 shadow-2xs">
                    <div class="flex items-start gap-4">
                        <div
                            class="w-14 h-14 rounded-2xl bg-white text-slate-dark font-black font-heading flex items-center justify-center shrink-0 shadow-2xs text-xl border border-pastel-300">
                            {{ strtoupper(substr($artist->name, 0, 2)) }}
                        </div>
                        <div>
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200 text-[10px] font-bold font-heading inline-flex items-center gap-1">
                                    <i class="fa-solid fa-circle-check text-emerald-600 text-[10px]"></i>
                                    Artist Terverifikasi
                                </span>
                            </div>
                            <h1 class="text-xl sm:text-2xl font-black font-heading text-slate-dark mt-1">
                                Halo, {{ $artist->name }}!
                            </h1>
                            <p class="text-xs text-slate-body mt-1 leading-relaxed max-w-2xl">
                                Kelola paket komisi seni Anda, tinjau pesanan masuk, dan unggah draf karya bertahap dengan proteksi watermark otomatis.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                    {{-- Pesanan Aktif --}}
                    <div
                        class="bg-white p-5 rounded-2xl border border-stone-200/90 shadow-2xs flex items-center justify-between">
                        <div>
                            <span class="text-xs text-slate-muted font-medium block">Pesanan Sedang Dikerjakan</span>
                            <div class="flex items-baseline gap-2 mt-1">
                                <span class="text-2xl font-black font-heading text-slate-dark">
                                    {{ $metrics['activeOrdersCount'] }}
                                </span>
                                @if ($metrics['pendingReviewCount'] > 0)
                                    <span class="text-[10px] font-bold text-amber-700 bg-amber-50 px-2 py-0.5 rounded-full border border-amber-200">
                                        +{{ $metrics['pendingReviewCount'] }} Baru
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div
                            class="w-11 h-11 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-paintbrush text-base"></i>
                        </div>
                    </div>

                    {{-- Total Pendapatan --}}
                    <div
                        class="bg-white p-5 rounded-2xl border border-stone-200/90 shadow-2xs flex items-center justify-between">
                        <div>
                            <span class="text-xs text-slate-muted font-medium block">Total Dana Dicairkan</span>
                            <div class="flex items-baseline gap-2 mt-1">
                                <span class="text-2xl font-black font-heading text-slate-dark">
                                    Rp. {{ number_format($metrics['totalEarnings'], 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                        <div
                            class="w-11 h-11 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-wallet text-base"></i>
                        </div>
                    </div>

                    {{-- Saldo Menunggu Pencairan --}}
                    <div
                        class="bg-white p-5 rounded-2xl border border-stone-200/90 shadow-2xs flex items-center justify-between">
                        <div>
                            <span class="text-xs text-slate-muted font-medium block">Menunggu Transfer Admin</span>
                            <div class="flex items-baseline gap-2 mt-1">
                                <span class="text-2xl font-black font-heading {{ $metrics['pendingPayouts'] > 0 ? 'text-sky-700' : 'text-slate-dark' }}">
                                    Rp. {{ number_format($metrics['pendingPayouts'], 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                        <div
                            class="w-11 h-11 rounded-xl bg-sky-100 text-sky-800 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-hourglass-half text-base"></i>
                        </div>
                    </div>

                    {{-- Pesanan Selesai --}}
                    <div
                        class="bg-white p-5 rounded-2xl border border-stone-200/90 shadow-2xs flex items-center justify-between">
                        <div>
                            <span class="text-xs text-slate-muted font-medium block">Komisi Selesai</span>
                            <div class="flex items-baseline gap-2 mt-1">
                                <span class="text-2xl font-black font-heading text-slate-dark">
                                    {{ $metrics['completedOrdersCount'] }}
                                </span>
                            </div>
                        </div>
                        <div
                            class="w-11 h-11 rounded-xl bg-indigo-100 text-indigo-800 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-circle-check text-base"></i>
                        </div>
                    </div>

                </div>

                <section class="space-y-4">
                    <div class="flex items-center justify-between pb-2 border-b border-stone-200">
                        <div>
                            <h3 class="text-base sm:text-lg font-black flex items-center gap-2 font-heading text-slate-dark">
                                <span>Permintaan Komisi Baru</span>
                                @if ($pendingReviews->count() > 0)
                                    <span class="w-7 h-7 rounded-full bg-amber-200 text-amber-900 text-xs font-bold font-heading inline-flex justify-center items-center">
                                        {{ $pendingReviews->count() }}
                                    </span>
                                @endif
                            </h3>
                            <p class="text-xs text-slate-muted">
                                Konfirmasi atau tolak pesanan komisi yang diajukan oleh client.
                            </p>
                        </div>
                        <a href="{{ route('artist.orders.index') }}"
                            class="text-xs font-bold text-slate-dark hover:text-amber-700 transition font-heading flex items-center gap-1">
                            <span>Buka Semua Pesanan</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>

                    @if ($pendingReviews->isEmpty())
                        <div class="bg-white rounded-2xl border border-stone-200/90 shadow-2xs p-8 text-center space-y-3">
                            <div class="w-12 h-12 rounded-full bg-pastel-100 text-amber-700 flex items-center justify-center mx-auto text-xl">
                                <i class="fa-solid fa-inbox"></i>
                            </div>
                            <h4 class="font-heading font-bold text-sm text-slate-dark">Tidak Ada Permintaan Komisi Baru</h4>
                            <p class="text-xs text-slate-muted max-w-sm mx-auto">
                                Saat ada client yang memesan dari katalog komisi Anda, permintaannya akan tampil di sini untuk Anda tinjau.
                            </p>
                        </div>
                    @else
                        <div class="space-y-3">
                            @foreach ($pendingReviews as $req)
                                <div class="bg-white rounded-2xl border border-stone-200/90 shadow-2xs p-4 sm:p-5 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                                    <div class="flex items-center gap-3.5">
                                        <div class="w-11 h-11 rounded-xl bg-pastel-200 text-slate-dark font-black font-heading flex items-center justify-center shrink-0">
                                            {{ strtoupper(substr($req->client?->name ?? 'C', 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2 flex-wrap">
                                                <h4 class="text-sm font-bold font-heading text-slate-dark">
                                                    {{ $req->commissionMenu?->title ?? 'Custom Artwork' }}
                                                </h4>
                                                <span class="text-xs font-semibold text-slate-muted">#{{ $req->order_number }}</span>
                                            </div>
                                            <p class="text-xs text-slate-muted mt-0.5">
                                                Dari Client: <strong class="text-slate-dark">{{ $req->client?->name ?? 'Client' }}</strong> •
                                                Diajukan: {{ $req->created_at ? $req->created_at->diffForHumans() : '-' }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-3 w-full md:w-auto justify-between md:justify-end">
                                        <div class="text-right">
                                            <span class="text-[10px] text-slate-muted uppercase font-bold block">Total Komisi</span>
                                            <span class="text-sm font-extrabold font-heading text-slate-dark">
                                                Rp {{ number_format($req->total_amount, 0, ',', '.') }}
                                            </span>
                                        </div>
                                        <a href="{{ route('artist.orders.index') }}"
                                            class="px-4 py-2 rounded-xl bg-pastel-200 hover:bg-pastel-300 text-slate-dark font-bold text-xs font-heading shadow-2xs transition">
                                            Tinjau Request
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </section>

                <section class="space-y-4">
                    <div class="flex items-center justify-between pb-2 border-b border-stone-200">
                        <div>
                            <h3 class="text-base sm:text-lg font-black flex items-center gap-2 font-heading text-slate-dark">
                                <span>Linimasa Komisi Sedang Dikerjakan</span>
                                <span class="w-7 h-7 rounded-full bg-pastel-200 text-slate-dark text-xs font-bold font-heading inline-flex justify-center items-center">
                                    {{ $activeOrders->count() }}
                                </span>
                            </h3>
                            <p class="text-xs text-slate-muted">
                                Unggah draf per tahapan (Sketsa, Line Art, Pewarnaan, Rendering) untuk persetujuan client.
                            </p>
                        </div>
                        <a href="{{ route('artist.tracker.index') }}"
                            class="text-xs font-bold text-slate-dark hover:text-amber-700 transition font-heading flex items-center gap-1">
                            <span>Buka Tracker</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>

                    @if ($activeOrders->isEmpty())
                        <div class="bg-white rounded-2xl border border-stone-200/90 shadow-2xs p-8 text-center space-y-3">
                            <div class="w-12 h-12 rounded-full bg-pastel-100 text-amber-700 flex items-center justify-center mx-auto text-xl">
                                <i class="fa-solid fa-paintbrush"></i>
                            </div>
                            <h4 class="font-heading font-bold text-sm text-slate-dark">Belum Ada Komisi yang Berjalan</h4>
                            <p class="text-xs text-slate-muted max-w-sm mx-auto">
                                Pesanan yang Anda terima dan telah dibayar DP-nya oleh client akan muncul di sini untuk digarap.
                            </p>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach ($activeOrders as $order)
                                @php
                                    $tracks = $order->tracks->sortBy('step_order');
                                    $stageNames = [1 => 'Sketsa', 2 => 'Line Art', 3 => 'Coloring', 4 => 'Rendering'];
                                @endphp
                                <div class="bg-white rounded-2xl border border-stone-200/90 shadow-2xs p-5 sm:p-6 space-y-5">
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-stone-100">
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <h4 class="text-sm font-bold font-heading text-slate-dark">
                                                    {{ $order->commissionMenu?->title ?? 'Komisi Seni Digital' }}
                                                </h4>
                                                <span class="text-xs font-semibold text-slate-muted">#{{ $order->order_number }}</span>
                                            </div>
                                            <p class="text-xs text-slate-muted mt-0.5">
                                                Client: <strong class="text-slate-dark">{{ $order->client?->name ?? 'Client' }}</strong> •
                                                Deadline: <span class="font-medium text-slate-dark">{{ $order->deadline_at ? $order->deadline_at->timezone('Asia/Jakarta')->translatedFormat('d F Y') : '-' }}</span>
                                            </p>
                                        </div>

                                        <div class="flex items-center gap-2">
                                            <span class="text-xs font-extrabold font-heading text-slate-dark bg-stone-100 px-3 py-1 rounded-full border border-stone-200">
                                                Nilai: Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                            </span>
                                            <a href="{{ route('artist.tracker.index') }}" class="px-3.5 py-1.5 rounded-xl bg-pastel-200 hover:bg-pastel-300 text-slate-dark font-bold text-xs font-heading transition">
                                                Update Draf WIP
                                            </a>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-4 gap-2 sm:gap-4 text-center">
                                        @for ($step = 1; $step <= 4; $step++)
                                            @php
                                                $track = $tracks->firstWhere('step_order', $step);
                                                $stepName = $track?->stage_name ?? $stageNames[$step];
                                                $isApproved = $track && $track->status === 'approved';
                                                $isReview = $track && $track->status === 'review';
                                            @endphp
                                            <div class="flex flex-col items-center {{ !$isApproved && !$isReview ? 'opacity-40' : '' }}">
                                                @if ($isApproved)
                                                    <div class="w-8 h-8 rounded-full bg-emerald-500 text-white flex items-center justify-center font-bold text-xs shadow-xs mb-1.5">
                                                        <i class="fa-solid fa-check"></i>
                                                    </div>
                                                    <span class="text-xs font-bold text-slate-dark font-heading">{{ $step }}. {{ $stepName }}</span>
                                                    <span class="text-[10px] text-emerald-700 font-medium">Selesai</span>
                                                @elseif ($isReview)
                                                    <div class="w-8 h-8 rounded-full bg-pastel-300 border-2 border-amber-500 text-slate-dark flex items-center justify-center font-bold text-xs shadow-xs mb-1.5 animate-pulse">
                                                        {{ $step }}
                                                    </div>
                                                    <span class="text-xs font-bold text-amber-800 font-heading">{{ $step }}. {{ $stepName }}</span>
                                                    <span class="text-[10px] text-amber-700 font-bold">Review Client</span>
                                                @else
                                                    <div class="w-8 h-8 rounded-full bg-stone-100 border border-stone-300 text-slate-500 flex items-center justify-center font-bold text-xs mb-1.5">
                                                        {{ $step }}
                                                    </div>
                                                    <span class="text-xs font-medium text-slate-body font-heading">{{ $step }}. {{ $stepName }}</span>
                                                    <span class="text-[10px] text-slate-400">Antre</span>
                                                @endif
                                            </div>
                                        @endfor
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </section>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                    <div class="bg-white rounded-2xl border border-stone-200/90 shadow-2xs p-5 sm:p-6 space-y-4 max-h-87.5 overflow-y-auto">
                        <div class="flex items-center justify-between pb-3 border-b border-stone-100">
                            <div>
                                <h3 class="font-heading font-bold text-sm sm:text-base text-slate-dark">
                                    Paket Menu Komisi ({{ $menus->count() }})
                                </h3>
                                <p class="text-xs text-slate-muted">Daftar paket harga yang tampil di etalase Anda.</p>
                            </div>
                            <a href="{{ route('artist.menus.index') }}" class="text-xs font-bold font-heading text-slate-dark hover:text-amber-700 transition">
                                Kelola <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>

                        @if ($menus->isEmpty())
                            <div class="p-6 text-center text-xs text-slate-muted space-y-2">
                                <p>Belum ada paket komisi yang dibuat.</p>
                                <a href="{{ route('artist.menus.index') }}" class="inline-block px-3.5 py-1.5 rounded-xl bg-pastel-200 hover:bg-pastel-300 text-slate-dark font-bold font-heading">
                                    Tambah Paket Pertama
                                </a>
                            </div>
                        @else
                            <div class="space-y-2.5">
                                @foreach ($menus as $menu)
                                    <div class="p-3 rounded-xl bg-bg-light border border-stone-100 flex items-center justify-between gap-3">
                                        <div>
                                            <h4 class="text-xs font-bold font-heading text-slate-dark">{{ $menu->title }}</h4>
                                            <p class="text-[11px] text-slate-muted">
                                                Estimasi: {{ $menu->estimated_days }} hari • Slot: {{ $menu->available_slots }}
                                            </p>
                                        </div>
                                        <span class="text-xs font-black font-heading text-slate-dark shrink-0">
                                            Rp. {{ number_format($menu->base_price, 0, ',', '.') }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="bg-white rounded-2xl border border-stone-200/90 shadow-2xs p-5 sm:p-6 space-y-4 max-h-87.5 overflow-y-auto">
                        <div class="flex items-center justify-between pb-3 border-b border-stone-100">
                            <div>
                                <h3 class="font-heading font-bold text-sm sm:text-base text-slate-dark">
                                    Portofolio Karya ({{ $portfolios->count() }})
                                </h3>
                                <p class="text-xs text-slate-muted">Sampel karya untuk menarik minat calon client.</p>
                            </div>
                            <a href="{{ route('artist.portfolios.index') }}" class="text-xs font-bold font-heading text-slate-dark hover:text-amber-700 transition">
                                Galeri <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>

                        @if ($portfolios->isEmpty())
                            <div class="p-6 text-center text-xs text-slate-muted space-y-2">
                                <p>Belum ada portofolio yang diunggah.</p>
                                <a href="{{ route('artist.portfolios.index') }}" class="inline-block px-3.5 py-1.5 rounded-xl bg-pastel-200 hover:bg-pastel-300 text-slate-dark font-bold font-heading">
                                    Unggah Gambar Karya
                                </a>
                            </div>
                        @else
                            <div class="grid grid-cols-3 gap-2.5">
                                @foreach ($portfolios as $work)
                                    <div class="aspect-square rounded-xl overflow-hidden border border-stone-200/90 bg-stone-100 group relative">
                                        <img src="{{ $work->image_url }}" alt="{{ $work->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-200">
                                        <span class="absolute inset-x-0 bottom-0 bg-linear-to-t from-black/60 to-transparent p-1.5 text-[10px] text-white truncate font-medium">
                                            {{ $work->title }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                </div>

            </main>
        </div>
    </div>
@endsection
