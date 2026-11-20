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
                @if ($actionOrder)
                    @php
                        $reviewTrack = $actionOrder->tracks->where('status', 'review')->first();
                    @endphp
                    <div
                        class="bg-linear-to-r from-pastel-100 via-pastel-200/90 to-pastel-100 rounded-2xl p-5 sm:p-6 border border-pastel-300 shadow-2xs flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                        <div class="flex items-start gap-4">
                            <div
                                class="w-12 h-12 rounded-xl bg-white text-amber-600 flex items-center justify-center shrink-0 shadow-2xs text-xl">
                                <i class="fa-solid fa-bell-concierge"></i>
                            </div>
                            <div>
                                <span class="text-[10px] uppercase font-bold text-amber-900 font-heading tracking-wider block">
                                    Tindakan Memerlukan Respon Anda
                                </span>
                                <h2 class="text-base sm:text-lg font-black font-heading text-slate-dark mt-0.5">
                                    @if ($actionOrder->status === 'review')
                                        Draf {{ $reviewTrack ? $reviewTrack->stage_name : 'Progres' }} Pesanan #{{ $actionOrder->order_number }} Siap Ditinjau!
                                    @elseif ($actionOrder->status === 'awaiting_dp')
                                        Invoice DP Pesanan #{{ $actionOrder->order_number }} Menunggu Pembayaran
                                    @elseif ($actionOrder->status === 'awaiting_final_payment')
                                        Karya Siap! Pelunasan Pesanan #{{ $actionOrder->order_number }} Menunggu Pembayaran
                                    @else
                                        Pesanan #{{ $actionOrder->order_number }} Memerlukan Perhatian Anda
                                    @endif
                                </h2>
                                <p class="text-xs text-slate-body mt-1 leading-relaxed max-w-2xl">
                                    Artist <strong>{{ $actionOrder->artist?->name ?? 'Artist' }}</strong> sedang menunggu respon Anda untuk melanjutkan proses komisi.
                                </p>
                            </div>
                        </div>
                        <div class="shrink-0 flex items-center gap-2.5 w-full md:w-auto">
                            <a href="#active-orders"
                                class="w-full md:w-auto px-5 py-2.5 rounded-xl bg-pastel-400 hover:bg-pastel-300 text-slate-dark font-bold text-xs font-heading shadow-xs transition text-center flex items-center justify-center gap-2">
                                <span>Tinjau Sekarang</span>
                                <i class="fa-solid fa-arrow-down text-xs"></i>
                            </a>
                        </div>
                    </div>
                @else
                    <div class="bg-linear-to-r from-pastel-100 via-pastel-200/90 to-pastel-100 rounded-2xl p-5 sm:p-6 border border-pastel-300 shadow-2xs">
                        <div class="flex items-start gap-4">
                            <div
                                class="w-12 h-12 rounded-xl bg-white text-amber-600 flex items-center justify-center shrink-0 shadow-2xs text-xl">
                                <i class="fa-solid fa-wand-magic-sparkles"></i>
                            </div>
                            <div>
                                <span class="text-[10px] uppercase font-bold text-amber-900 font-heading tracking-wider block">
                                    Portal Pelanggan Artsy ID
                                </span>
                                <h2 class="text-base sm:text-lg font-black font-heading text-slate-dark mt-0.5">
                                    Selamat Datang, {{ auth()->user()->name }}!
                                </h2>
                                <p class="text-xs text-slate-body mt-1 leading-relaxed max-w-2xl">
                                    Pantau linimasa pengerjaan komisi Anda, audit dana escrow, dan unduh karya hasil pesanan anda.
                                </p>
                            </div>
                        </div>
    
                    </div>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                    <div
                        class="bg-white p-5 rounded-2xl border border-stone-200/90 shadow-2xs flex items-center justify-between">
                        <div>
                            <span class="text-xs text-slate-muted font-medium block">Pesanan Aktif</span>
                            <div class="flex items-baseline gap-2 mt-1">
                                <span class="text-2xl font-black font-heading text-slate-dark">{{ $metrics['activeOrdersCount'] }}</span>
                            </div>
                        </div>
                        <div
                            class="w-11 h-11 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-paintbrush text-base"></i>
                        </div>
                    </div>

                    <div
                        class="bg-white p-5 rounded-2xl border border-stone-200/90 shadow-2xs flex items-center justify-between">
                        <div>
                            <span class="text-xs text-slate-muted font-medium block">Dana di Escrow</span>
                            <div class="flex items-baseline gap-2 mt-1">
                                <span class="text-2xl font-black font-heading text-slate-dark">
                                    Rp. {{ number_format($metrics['escrowBalance'], 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                        <div
                            class="w-11 h-11 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-lock text-base"></i>
                        </div>
                    </div>

                    <div
                        class="bg-white p-5 rounded-2xl border border-stone-200/90 shadow-2xs flex items-center justify-between">
                        <div>
                            <span class="text-xs text-slate-muted font-medium block">Menunggu Persetujuan</span>
                            <div class="flex items-baseline gap-2 mt-1">
                                <span class="text-2xl font-black font-heading {{ $metrics['waitingApprovalCount'] > 0 ? 'text-amber-600' : 'text-slate-dark' }}">
                                    {{ $metrics['waitingApprovalCount'] }}
                                </span>
                            </div>
                        </div>
                        <div class="w-11 h-11 rounded-xl bg-sky-100 text-sky-800 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-list-check text-base"></i>
                        </div>
                    </div>

                    <div
                        class="bg-white p-5 rounded-2xl border border-stone-200/90 shadow-2xs flex items-center justify-between">
                        <div>
                            <span class="text-xs text-slate-muted font-medium block">Pesanan Selesai</span>
                            <div class="flex items-baseline gap-2 mt-1">
                                <span class="text-2xl font-black font-heading text-slate-dark">{{ $metrics['completedOrdersCount'] }}</span>
                            </div>
                        </div>
                        <div
                            class="w-11 h-11 rounded-xl bg-indigo-100 text-indigo-800 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-check text-base"></i>
                        </div>
                    </div>

                </div>

                <section id="active-orders" class="space-y-4">
                    <div class="flex items-center justify-between pb-2 border-b border-stone-200">
                        <div>
                            <h3 class="text-base sm:text-lg font-black flex items-center gap-2 font-heading text-slate-dark">
                                <span>Linimasa Komisi Sedang Berjalan</span>
                                <span class="w-7 h-7 rounded-full bg-pastel-200 text-slate-dark text-xs font-bold font-heading inline-flex justify-center items-center">
                                    {{ $activeOrders->count() }}
                                </span>
                            </h3>
                            <p class="text-xs text-slate-muted">
                                Pantau progres berkas, tinjau draf pesanan, dan setujui tahapan pengerjaan.
                            </p>
                        </div>
                        <a href="{{ route('katalog') }}"
                            class="text-xs font-bold text-slate-dark hover:text-amber-700 transition font-heading hidden sm:flex items-center gap-1">
                            <span>Jelajahi Katalog Seni</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>

                    @if ($activeOrders->isEmpty())
                        <div class="bg-white rounded-2xl border border-stone-200/90 shadow-2xs p-10 sm:p-14 text-center space-y-4">
                            <div class="w-16 h-16 rounded-full bg-pastel-100 text-amber-700 flex items-center justify-center mx-auto text-2xl shadow-2xs">
                                <i class="fa-solid fa-palette"></i>
                            </div>
                            <div class="space-y-1">
                                <h4 class="font-heading font-bold text-base text-slate-dark">Belum Ada Komisi yang Sedang Berjalan</h4>
                                <p class="text-xs text-slate-muted max-w-md mx-auto leading-relaxed">
                                    Ayo Wujudkan Karakter Impian Anda Bersama Artist Berbakat di Artsy ID!
                                </p>
                            </div>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach ($activeOrders as $order)
                                @php
                                    $tracks = $order->tracks->sortBy('step_order');
                                    $latestTrack = $tracks->where('status', 'review')->first() ?? $tracks->where('status', 'pending')->first() ?? $tracks->last();
                                    $stageNames = [1 => 'Sketsa', 2 => 'Line Art', 3 => 'Coloring', 4 => 'Rendering'];
                                @endphp
                                <div class="bg-white rounded-2xl border border-stone-200/90 shadow-2xs p-5 sm:p-6 space-y-6">

                                    <div
                                        class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-stone-100">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 rounded-full bg-pastel-300 text-slate-dark font-black text-sm flex items-center justify-center font-heading shrink-0 shadow-2xs">
                                                {{ strtoupper(substr($order->artist?->name ?? 'A', 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="flex items-center gap-2 flex-wrap">
                                                    <h4 class="text-sm font-bold font-heading text-slate-dark">
                                                        {{ $order->commissionMenu?->title ?? 'Komisi Seni Digital' }}
                                                    </h4>
                                                    <span class="text-xs font-semibold text-slate-muted">#{{ $order->order_number }}</span>
                                                </div>
                                                <p class="text-xs text-slate-muted mt-0.5">
                                                    Artist: <strong class="text-slate-dark">{{ $order->artist?->name ?? 'Artist' }}</strong> • Deadline: <span
                                                        class="font-medium text-slate-dark">{{ $order->deadline_at ? $order->deadline_at->timezone('Asia/Jakarta')->translatedFormat('d F Y') : '-' }}</span>
                                                </p>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-2.5 flex-wrap">
                                            @if ($order->status === 'review')
                                                <span
                                                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-50 text-amber-800 border border-amber-200 text-xs font-bold font-heading">
                                                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                                                    Perlu Review Draf
                                                </span>
                                            @elseif ($order->status === 'on_progress')
                                                <span
                                                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-sky-50 text-sky-800 border border-sky-200 text-xs font-bold font-heading">
                                                    <i class="fa-solid fa-paintbrush text-[11px]"></i>
                                                    Sedang Dikerjakan
                                                </span>
                                            @elseif ($order->status === 'awaiting_dp')
                                                <span
                                                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-50 text-amber-800 border border-amber-200 text-xs font-bold font-heading">
                                                    <i class="fa-solid fa-wallet text-[11px]"></i>
                                                    Menunggu DP
                                                </span>
                                            @elseif ($order->status === 'awaiting_final_payment')
                                                <span
                                                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-purple-50 text-purple-800 border border-purple-200 text-xs font-bold font-heading">
                                                    <i class="fa-solid fa-receipt text-[11px]"></i>
                                                    Menunggu Pelunasan
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-stone-100 text-slate-700 border border-stone-200 text-xs font-bold font-heading capitalize">
                                                    {{ str_replace('_', ' ', $order->status) }}
                                                </span>
                                            @endif
                                            <span
                                                class="text-xs font-extrabold font-heading text-slate-dark bg-stone-100 px-3 py-1 rounded-full border border-stone-200">
                                                Total: Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>

                                    <div>
                                        <div class="grid grid-cols-4 gap-2 sm:gap-4 relative text-center">
                                            @for ($step = 1; $step <= 4; $step++)
                                                @php
                                                    $track = $tracks->firstWhere('step_order', $step);
                                                    $stepName = $track?->stage_name ?? $stageNames[$step];
                                                    $isApproved = $track && $track->status === 'approved';
                                                    $isReview = $track && $track->status === 'review';
                                                @endphp
                                                <div class="flex flex-col items-center {{ !$isApproved && !$isReview ? 'opacity-40' : '' }}">
                                                    @if ($isApproved)
                                                        <div
                                                            class="w-9 h-9 rounded-full bg-emerald-500 text-white flex items-center justify-center font-bold text-xs shadow-xs mb-2">
                                                            <i class="fa-solid fa-check"></i>
                                                        </div>
                                                        <span class="text-xs font-bold text-slate-dark font-heading">{{ $step }}. {{ $stepName }}</span>
                                                        <span class="text-[10px] text-emerald-700 font-medium">Disetujui</span>
                                                    @elseif ($isReview)
                                                        <div
                                                            class="w-9 h-9 rounded-full bg-pastel-300 border-2 border-amber-500 text-slate-dark flex items-center justify-center font-bold text-xs shadow-xs mb-2 animate-pulse">
                                                            {{ $step }}
                                                        </div>
                                                        <span class="text-xs font-bold text-amber-800 font-heading">{{ $step }}. {{ $stepName }}</span>
                                                        <span class="text-[10px] text-amber-700 font-bold">Menunggu Review</span>
                                                    @else
                                                        <div
                                                            class="w-9 h-9 rounded-full bg-stone-100 border border-stone-300 text-slate-500 flex items-center justify-center font-bold text-xs mb-2">
                                                            {{ $step }}
                                                        </div>
                                                        <span class="text-xs font-medium text-slate-body font-heading">{{ $step }}. {{ $stepName }}</span>
                                                        <span class="text-[10px] text-slate-400">Menunggu</span>
                                                    @endif
                                                </div>
                                            @endfor
                                        </div>
                                    </div>

                                    @if ($latestTrack && $latestTrack->watermarked_image_url)
                                        <div
                                            class="p-4 rounded-xl bg-stone-50 border border-stone-200/90 flex flex-col sm:flex-row items-center justify-between gap-4">
                                            <div class="flex items-center gap-3.5 w-full sm:w-auto">
                                                <div
                                                    class="relative w-16 h-16 rounded-lg overflow-hidden border border-stone-200 bg-stone-200 shrink-0">
                                                    <img src="{{ $latestTrack->watermarked_image_url }}"
                                                        alt="Preview {{ $latestTrack->stage_name }}" class="w-full h-full object-cover">
                                                    <span
                                                        class="absolute inset-0 bg-black/40 flex items-center justify-center text-[7px] font-black text-white/90 uppercase tracking-tighter text-center p-1">
                                                        PREVIEW ONLY
                                                    </span>
                                                </div>
                                                <div>
                                                    <div class="flex items-center gap-2">
                                                        <span class="text-xs font-bold text-slate-dark font-heading">
                                                            Draf {{ $latestTrack->stage_name }} Diunggah
                                                        </span>
                                                    </div>
                                                    <p class="text-xs text-slate-muted mt-0.5 italic">
                                                        "{{ $latestTrack->notes ?: 'Draf pengerjaan terbaru dari artist.' }}"
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="flex items-center gap-2.5 w-full sm:w-auto shrink-0 justify-end">
                                                <a href="{{ route('katalog') }}"
                                                    class="px-4 py-2 rounded-xl text-xs font-bold font-heading text-slate-dark bg-pastel-200 hover:bg-pastel-300 border border-pastel-300 shadow-2xs transition flex items-center gap-1.5">
                                                    <span>Tinjau Karya</span>
                                                    <i class="fa-solid fa-arrow-right text-[11px]"></i>
                                                </a>
                                            </div>
                                        </div>
                                    @endif

                                </div>
                            @endforeach
                        </div>
                    @endif
                </section>
            </main>
        </div>
    </div>
@endsection
