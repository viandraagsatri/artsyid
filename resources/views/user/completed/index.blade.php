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
        <h1 class="font-heading text-base font-bold text-slate-dark">Galeri Karya Selesai &amp; Berkas Master Asli</h1>
        <p class="mt-1 text-[11px] text-slate-body">Semua karya komisi yang telah selesai. Unduh file master dan konten lisensi karya Anda.</p>
    </div>

    @php
    $works = [
        ['title'=>'Cyberpunk Samurai Ronin Girl','license'=>'Lisensi Komersial Terbatas','date'=>'24 Nov 2026','rating'=>'4.9','tip'=>'Rp 150.000','image'=>'https://placehold.co/260x170/171526/ffffff?text=Cyberpunk+Samurai','master_url'=>'#','license_url'=>'#'],
        ['title'=>'Fantasy Celestial Mage Illustration','license'=>'Penggunaan Personal','date'=>'20 Nov 2026','rating'=>'5.0','tip'=>'Rp 300.000','image'=>'https://placehold.co/260x170/24203b/ffffff?text=Fantasy+Mage','master_url'=>'#','license_url'=>'#'],
        ['title'=>'Twitch & Discord Chibi Emote Pack (8 Pcs)','license'=>'Stream Emote License','date'=>'18 Nov 2026','rating'=>'4.8','tip'=>'Rp 120.000','image'=>'https://placehold.co/260x170/fce7f3/333333?text=Chibi+Emote','master_url'=>'#','license_url'=>'#'],
    ];
    @endphp

    <div class="mb-4 flex flex-wrap items-center gap-2">
        @foreach (['all'=>'Semua Karya (3)','downloaded'=>'Berhasil Diunduh (2)','master'=>'Emas & Master (1)'] as $key=>$label)
        <a href="{{ route('user.completed.index', ['filter'=>$key]) }}" class="rounded-full border px-3 py-2 text-[10px] font-semibold {{ request('filter','all')===$key ? 'border-slate-dark bg-slate-dark text-white' : 'border-stone-200 bg-white text-slate-body' }}">{{ $label }}</a>
        @endforeach
        <input type="search" placeholder="Cari judul karya atau artist..." class="ml-auto w-56 rounded-full border border-stone-200 bg-white px-4 py-2 text-[10px] outline-none">
    </div>

    <div class="space-y-3">
        @forelse ($works as $work)
        <article class="flex flex-col gap-4 rounded-xl border border-stone-200 bg-white p-4 md:flex-row md:items-center">
            <div class="relative shrink-0">
                <img src="{{ $work['image'] }}" alt="{{ $work['title'] }}" class="h-32 w-full rounded-xl object-cover md:w-48">
                <span class="absolute left-2 top-2 rounded-full border border-emerald-300 bg-white/95 px-2 py-1 text-[8px] font-bold text-emerald-700">BEBAS WATERMARK</span>
            </div>
            <div class="min-w-0 flex-1">
                <div class="mb-2 flex flex-wrap items-center gap-2"><h2 class="text-xs font-bold text-slate-dark">{{ $work['title'] }}</h2><span class="rounded-full bg-purple-50 px-2 py-1 text-[8px] font-semibold text-purple-700">{{ $work['license'] }}</span></div>
                <p class="text-[9px] text-slate-400">Selesai pada {{ $work['date'] }}</p>
                <p class="mt-2 text-[10px] font-semibold text-amber-600">★★★★★ <span class="text-slate-600">{{ $work['rating'] }}</span></p>
                <span class="mt-2 inline-block rounded-full bg-[#fff5c7] px-2.5 py-1 text-[8px] font-bold text-amber-800">Tip Sukarela: {{ $work['tip'] }}</span>
            </div>
            <div class="flex shrink-0 flex-col gap-2 sm:flex-row md:flex-col">
                <a href="{{ $work['master_url'] }}" class="rounded-lg bg-[#ffe77b] px-3 py-2.5 text-center text-[9px] font-bold text-slate-dark">Unduh File Art (Master ZIP)</a>
                <a href="{{ $work['license_url'] }}" class="rounded-lg border border-stone-200 px-3 py-2.5 text-center text-[9px] font-semibold text-slate-600">Unduh Konten Lisensi</a>
            </div>
        </article>
        @empty
        <div class="rounded-xl border border-stone-200 bg-white p-10 text-center text-xs text-slate-400">Belum ada karya yang selesai.</div>
        @endforelse
    </div>
</div>
            </main>
        </div>
    </div>
@endsection
