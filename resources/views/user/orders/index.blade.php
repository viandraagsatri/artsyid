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
<div class="min-h-screen bg-[#fafafa] px-5 py-6 lg:px-8">
    <div class="mb-5 rounded-xl bg-[#fff5b8] px-6 py-5">
        <h1 class="font-heading text-base font-bold text-slate-dark">Pesanan Komisi Saya</h1>
        <p class="mt-1 text-[11px] text-slate-body">Pantau semua pesanan komisi, lihat progres pengerjaan, dan cek status pesanan Anda.</p>
    </div>

    <div class="mb-4 flex flex-wrap items-center gap-2">
        @foreach (['all'=>'Semua (4)','action'=>'Perlu Tindakan (1)','dp'=>'Menunggu DP (1)','working'=>'Sedang Dikerjakan (1)','revision'=>'Menunggu Pelunasan (1)'] as $key=>$label)
            <a href="{{ route('user.orders.index', ['filter'=>$key]) }}" class="rounded-full border px-3 py-2 text-[10px] font-semibold {{ request('filter','all')===$key ? 'border-slate-dark bg-slate-dark text-white' : 'border-stone-200 bg-white text-slate-body hover:bg-pastel-50' }}">{{ $label }}</a>
        @endforeach
        <input type="search" placeholder="Cari nama pesanan atau artist..." class="ml-auto w-56 rounded-full border border-stone-200 bg-white px-4 py-2 text-[10px] outline-none">
    </div>

    @php
    // Data dummy untuk mencocokkan desain. Ganti dengan data dari controller.
    $orders = [
        ['artist'=>'Kuroneko Studio','initial'=>'KN','code'=>'ORD-2026-0051','date'=>'25 Nov 2026','title'=>'Full Body Cyberpunk Samurai Anime (Custom Artwork)','description'=>'Karakter anime dengan konsep cyberpunk dan detail kostum sesuai brief pesanan.','status'=>'TINDAKAN DIPERLUKAN: REVIEW LINE ART','amount'=>'450.000','active_step'=>2,'notice'=>null],
        ['artist'=>'MikaArt','initial'=>'MA','code'=>'ORD-2026-0052','date'=>'24 Nov 2026','title'=>'Custom Character Illustration','description'=>'Ilustrasi karakter sesuai referensi dan permintaan pembeli.','status'=>'Menunggu Pembayaran DP (50%)','amount'=>'100.000','active_step'=>1,'notice'=>'Silakan selesaikan pembayaran DP agar artist dapat mulai mengerjakan pesanan.'],
    ];
    @endphp

    @forelse ($orders as $order)
    <article class="mb-4 rounded-xl border {{ $loop->first ? 'border-amber-300' : 'border-stone-200' }} bg-white p-4 shadow-sm">
        <div class="mb-4 flex flex-wrap items-start justify-between gap-3">
            <div class="flex items-center gap-3">
                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-[#fff0a6] text-xs font-bold text-slate-dark">{{ $order['initial'] }}</div>
                <div><h2 class="text-xs font-bold text-slate-dark">{{ $order['artist'] }}</h2><p class="mt-1 text-[9px] text-slate-400">Pesanan #{{ $order['code'] }} · {{ $order['date'] }}</p></div>
            </div>
            <div class="flex flex-wrap items-center gap-2"><span class="rounded-full bg-[#fff1cf] px-2.5 py-1 text-[9px] font-bold text-amber-800">{{ $order['status'] }}</span><strong class="text-sm text-slate-dark">Rp {{ $order['amount'] }}</strong></div>
        </div>

        <div class="mb-4 rounded-lg bg-stone-50 px-4 py-3"><p class="text-[10px] font-bold text-slate-dark">Paket: {{ $order['title'] }}</p><p class="mt-1 text-[9px] text-slate-500">{{ $order['description'] }}</p></div>
        <p class="mb-2 text-[10px] font-semibold text-slate-dark">Linimasa Progres &amp; Tahapan Pengerjaan</p>

        <div class="mb-4 grid grid-cols-2 gap-2 md:grid-cols-4">
            @foreach ([['Tahap 1: Sketsa','Draft awal disetujui'],['Tahap 2: Line Art','Pembuatan garis akhir'],['Tahap 3: Pewarnaan','Proses pewarnaan'],['Tahap 4: Finishing','Finalisasi karya']] as $i=>$step)
                <div class="rounded-lg border px-3 py-3 {{ $i+1 < $order['active_step'] ? 'border-emerald-200 bg-emerald-50' : ($i+1 == $order['active_step'] ? 'border-amber-400 bg-[#fff8cf]' : 'border-stone-200 bg-stone-50') }}">
                    <p class="text-[9px] font-bold text-slate-dark">{{ $step[0] }}</p><p class="mt-1 text-[9px] text-slate-400">{{ $step[1] }}</p>
                </div>
            @endforeach
        </div>

        @if ($order['notice']) <div class="mb-3 rounded-lg bg-[#fff8c9] px-3 py-2 text-[9px] text-amber-900">{{ $order['notice'] }}</div> @endif
        <div class="flex flex-wrap items-center justify-between gap-3">
            <p class="text-[9px] text-slate-400">Lihat detail pesanan dan informasi pengerjaan.</p>
            <div class="flex gap-2"><a href="#" class="rounded-lg border border-stone-200 px-3 py-2 text-[9px] font-semibold text-slate-600">Detail Pesanan</a><a href="#" class="rounded-lg bg-[#ffe77b] px-3 py-2 text-[9px] font-bold text-slate-dark">Tinjau Draft / Bayar</a></div>
        </div>
    </article>
    @empty
    <div class="rounded-xl border border-stone-200 bg-white p-10 text-center text-xs text-slate-400">Belum ada pesanan.</div>
    @endforelse
</div>
            </main>
        </div>
    </div>
@endsection