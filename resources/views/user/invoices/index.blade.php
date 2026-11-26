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
        <h1 class="font-heading text-base font-bold text-slate-dark">Tagihan &amp; Perlindungan Dana Escrow</h1>
        <p class="mt-1 text-[11px] text-slate-body">Dana pembayaran diamankan melalui sistem escrow Artsy.ID dan dicairkan sesuai tahapan pesanan.</p>
    </div>

    @php
    $summary = [
        ['label'=>'Dana Diamankan di Escrow','amount'=>'Rp 675.000','note'=>'2 Pesanan aktif terlindungi'],
        ['label'=>'Total Tagihan Pembayaran','amount'=>'Rp 450.000','note'=>'1 DP + 1 Pelunasan Akhir'],
        ['label'=>'Total Transaksi Berhasil','amount'=>'Rp 1.850.000','note'=>'6 Pesanan lunas & selesai'],
    ];
    $invoices = [
        ['code'=>'INV-2026-DP-0051','date'=>'25 Nov 2026','type'=>'Uang Muka (DP 50%)','name'=>'Chibi Couple Sketch (2 Karakter)','status'=>'MENUNGGU DP','amount'=>'100.000','tone'=>'amber','pay'=>true],
        ['code'=>'INV-2026-FN-0038','date'=>'24 Nov 2026','type'=>'Pelunasan Akhir','name'=>'VTuber 2D Bust-Up Model Ready to Rig','status'=>'PELUNASAN AKHIR','amount'=>'350.000','tone'=>'purple','pay'=>true],
        ['code'=>'INV-2026-DYN-0042','date'=>'22 Nov 2026','type'=>'Uang Muka (DP 50%)','name'=>'Dynamic Add-on: Background Gedung Tokyo Futuristik','status'=>'LUNAS DI ESCROW','amount'=>'75.000','tone'=>'green','pay'=>false],
        ['code'=>'INV-2026-DP-0042','date'=>'20 Nov 2026','type'=>'Uang Muka (DP 50%)','name'=>'Full Body Cyberpunk Samurai Anime','status'=>'LUNAS DI ESCROW','amount'=>'225.000','tone'=>'green','pay'=>false],
    ];
    @endphp

    <div class="mb-5 grid grid-cols-1 gap-3 md:grid-cols-3">
        @foreach ($summary as $item)
        <div class="rounded-xl border border-stone-200 bg-white p-4"><p class="text-[10px] text-slate-500">{{ $item['label'] }}</p><p class="mt-2 text-xl font-bold text-slate-dark">{{ $item['amount'] }}</p><p class="mt-1 text-[9px] text-slate-400">{{ $item['note'] }}</p></div>
        @endforeach
    </div>

    <div class="mb-4 flex flex-wrap items-center gap-2">
        @foreach (['all'=>'Semua Invoice (4)','pending'=>'Menunggu Pembayaran (2)','escrow'=>'Lunas di Escrow (2)'] as $key=>$label)
        <a href="{{ route('user.invoices.index', ['filter'=>$key]) }}" class="rounded-full border px-3 py-2 text-[10px] font-semibold {{ request('filter','all')===$key ? 'border-slate-dark bg-slate-dark text-white' : 'border-stone-200 bg-white text-slate-body' }}">{{ $label }}</a>
        @endforeach
        <input type="search" placeholder="Cari nomor invoice..." class="ml-auto w-52 rounded-full border border-stone-200 bg-white px-4 py-2 text-[10px] outline-none">
    </div>

    @foreach ($invoices as $invoice)
    <article class="mb-3 rounded-xl border {{ $invoice['pay'] ? 'border-amber-300' : 'border-stone-200' }} bg-white p-4">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="min-w-[220px] flex-1">
                <div class="mb-2 flex flex-wrap items-center gap-2"><h2 class="text-[10px] font-bold text-slate-dark">{{ $invoice['code'] }}</h2><span class="text-[9px] text-slate-400">· {{ $invoice['date'] }}</span><span class="rounded-full bg-stone-100 px-2 py-1 text-[8px] font-semibold text-slate-500">{{ $invoice['type'] }}</span></div>
                <p class="text-[10px] font-semibold text-slate-dark">{{ $invoice['name'] }}</p>
                <span class="mt-2 inline-block rounded-full px-2.5 py-1 text-[8px] font-bold {{ $invoice['tone']==='amber' ? 'bg-amber-100 text-amber-800' : '' }} {{ $invoice['tone']==='purple' ? 'bg-purple-100 text-purple-700' : '' }} {{ $invoice['tone']==='green' ? 'bg-emerald-100 text-emerald-700' : '' }}">{{ $invoice['status'] }}</span>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <strong class="text-sm text-slate-dark">Rp {{ $invoice['amount'] }}</strong>
                <a href="#" class="rounded-lg border border-stone-200 px-3 py-2 text-[9px] font-semibold text-slate-600">Rincian Tagihan</a>
                @if ($invoice['pay'])
                    <a href="#" class="rounded-lg bg-[#ffe77b] px-3 py-2 text-[9px] font-bold text-slate-dark">Bayar {{ $invoice['tone']==='purple' ? 'Pelunasan' : 'via Midtrans' }}</a>
                @else
                    <a href="#" class="rounded-lg border border-stone-200 px-3 py-2 text-[9px] font-semibold text-slate-600">Unduh Kwitansi PDF</a>
                @endif
            </div>
        </div>
    </article>
    @endforeach
</div>
            </main>
        </div>
    </div>
@endsection
