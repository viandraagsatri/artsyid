@extends('layouts.app')

@section('content')
    @include('layouts.header')
    <main class="bg-bg-light min-h-screen text-slate-body font-sans">
        <section class="relative overflow-hidden bg-linear-to-b from-pastel-100/70 via-stone-50 to-bg-light border-b border-stone-200/60 pt-12 pb-16 lg:pt-16 lg:pb-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="max-w-3xl mx-auto text-center">
                
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black font-heading text-slate-dark tracking-tight leading-[1.2]">
                        Pesan Komisi Karya Seni Digital Bersama Artsy<span class="text-amber-500">.ID</span>
                    </h1>

                    <p class="mt-4 text-sm sm:text-base text-slate-body leading-relaxed max-w-2xl mx-auto">
                        Hubungkan ide kreatifmu langsung dengan artist profesional, modeler Live2D, dan kreator 3D lokal. Dana DP dan pelunasan aman tertampung di sistem sampai setiap tahap karya kamu setujui.
                    </p>

                    <div class="mt-8 max-w-2xl mx-auto">
                        <form action="{{ route('katalog') }}" method="GET" class="relative flex flex-col sm:flex-row items-stretch p-2 bg-white rounded-2xl sm:rounded-full border border-stone-200 shadow-sm hover:border-pastel-400 focus-within:border-pastel-400 focus-within:ring-2 focus-within:ring-pastel-200 transition-all gap-2">
                            <div class="flex items-center grow pl-3 gap-3">
                                <i class="fa-solid fa-magnifying-glass text-slate-400 text-sm" aria-hidden="true"></i>
                                <input 
                                    type="text" 
                                    id="search-input"
                                    name="search" 
                                    placeholder="Cari gaya anime, Live2D, Vtuber, atau nama artist..." 
                                    class="w-full py-2.5 text-xs sm:text-sm text-slate-dark placeholder-slate-400 bg-transparent focus:outline-none"
                                />
                            </div>
                            <button type="submit" class="px-6 py-3 rounded-xl sm:rounded-full bg-pastel-200 hover:bg-pastel-300 text-slate-dark font-bold text-xs sm:text-sm font-heading shadow-xs transition hover:shadow-sm shrink-0 cursor-pointer">
                                Cari Komisi
                            </button>
                        </form>

                        @if (count($popularCategories) > 0)
                            <div class="mt-4 flex flex-wrap items-center justify-center gap-2 text-xs text-slate-muted">
                                <span class="font-medium text-slate-dark font-heading">Populer:</span>
                                @foreach ($popularCategories as $popCat)
                                    <a href="{{ $popCat['katalog_url'] }}" class="px-2.5 py-1 rounded-lg bg-white border border-stone-200 hover:border-pastel-400 hover:bg-pastel-50 transition">{{ $popCat['name'] }}</a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <div class="mt-12 max-w-5xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-white/90 p-4 rounded-xl border border-stone-200/80 shadow-xs flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-100/80 text-emerald-700 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-shield-halved text-base"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-dark font-heading">Escrow 2-Tahap</h4>
                            <p class="text-[11px] text-slate-muted">DP 50% &amp; Pelunasan</p>
                        </div>
                    </div>

                    <div class="bg-white/90 p-4 rounded-xl border border-stone-200/80 shadow-xs flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-100/80 text-amber-700 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-stamp text-base"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-dark font-heading">Watermark</h4>
                            <p class="text-[11px] text-slate-muted">Draf aman dari pencurian</p>
                        </div>
                    </div>

                    <div class="bg-white/90 p-4 rounded-xl border border-stone-200/80 shadow-xs flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-sky-100/80 text-sky-700 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-list-check text-base"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-dark font-heading">4-Stage Tracker</h4>
                            <p class="text-[11px] text-slate-muted">Sketsa s.d Hasil</p>
                        </div>
                    </div>

                    <div class="bg-white/90 p-4 rounded-xl border border-stone-200/80 shadow-xs flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-indigo-100/80 text-indigo-700 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-hand-holding-heart text-base"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-dark font-heading">Anti AI</h4>
                            <p class="text-[11px] text-slate-muted">100% seniman manusia asli</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="cara-kerja" class="py-16 bg-white border-b border-stone-200/70" data-purpose="escrow-process-explanation">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-2xl mx-auto text-center mb-12">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-pastel-100 text-amber-900 border border-pastel-300 text-xs font-bold font-heading">
                        Sistem Escrow Terpercaya
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold font-heading text-slate-dark mt-3">
                        Cara Kerja Komisi Transparan di Artsy <span class="text-amber-500">.ID</span>
                    </h2>
                    <p class="text-slate-muted text-xs sm:text-sm mt-2 leading-relaxed">
                        Perlindungan adil untuk Pembeli dan Seniman melalui 4 tahapan pengerjaan bertahap:
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="relative bg-stone-50 p-6 rounded-2xl border border-stone-200 flex flex-col justify-between group hover:border-pastel-400 hover:shadow-xs transition">
                        <div>
                            <div class="w-10 h-10 rounded-xl bg-pastel-200 text-slate-dark font-black font-heading flex items-center justify-center text-sm mb-4">
                                01
                            </div>
                            <h3 class="text-sm font-bold text-slate-dark mb-2 font-heading">Request &amp; DP 50% di Escrow</h3>
                            <p class="text-xs text-slate-muted leading-relaxed">
                                Klien mengisi formulir request dan membayar invoice DP (50%) melalui Payment Gateway. Dana ditahan di dalam sistem sebelum artis mulai menggambar.
                            </p>
                        </div>
                        <div class="mt-4 pt-3 border-t border-stone-200 text-[11px] font-semibold text-emerald-700 flex items-center gap-1.5">
                            <i class="fa-solid fa-lock text-xs"></i>
                            Dana Tertahan di Rekening Bersama
                        </div>
                    </div>

                    <div class="relative bg-stone-50 p-6 rounded-2xl border border-stone-200 flex flex-col justify-between group hover:border-pastel-400 hover:shadow-xs transition">
                        <div>
                            <div class="w-10 h-10 rounded-xl bg-pastel-200 text-slate-dark font-black font-heading flex items-center justify-center text-sm mb-4">
                                02
                            </div>
                            <h3 class="text-sm font-bold text-slate-dark mb-2 font-heading">Sketsa &amp; Line Art Ber-Watermark</h3>
                            <p class="text-xs text-slate-muted leading-relaxed">
                                Artis mengunggah update berkas. Sistem secara otomatis menambahkan watermark pelindung. Klien dapat mereview draf tanpa risiko pembajakan.
                            </p>
                        </div>
                        <div class="mt-4 pt-3 border-t border-stone-200 text-[11px] font-semibold text-amber-700 flex items-center gap-1.5">
                            <i class="fa-solid fa-stamp text-xs"></i>
                            Otomatis Diberi Watermark Resmi
                        </div>
                    </div>

                    <div class="relative bg-stone-50 p-6 rounded-2xl border border-stone-200 flex flex-col justify-between group hover:border-pastel-400 hover:shadow-xs transition">
                        <div>
                            <div class="w-10 h-10 rounded-xl bg-pastel-200 text-slate-dark font-black font-heading flex items-center justify-center text-sm mb-4">
                                03
                            </div>
                            <h3 class="text-sm font-bold text-slate-dark mb-2 font-heading">Persetujuan Line Art</h3>
                            <p class="text-xs text-slate-muted leading-relaxed">
                                Saat klien menyetujui tahap Line Art, pengerjaan lanjut ke pewarnaan sementara dana DP tetap aman di escrow. Jika ada permintaan tambahan, artist dapat menerbitkan dynamic invoice.
                            </p>
                        </div>
                        <div class="mt-4 pt-3 border-t border-stone-200 text-[11px] font-semibold text-sky-700 flex items-center gap-1.5">
                            <i class="fa-solid fa-money-bill-transfer text-xs"></i>
                            Tahap Lanjut Atau Penambahan Item
                        </div>
                    </div>

                    <div class="relative bg-stone-50 p-6 rounded-2xl border border-stone-200 flex flex-col justify-between group hover:border-pastel-400 hover:shadow-xs transition">
                        <div>
                            <div class="w-10 h-10 rounded-xl bg-pastel-200 text-slate-dark font-black font-heading flex items-center justify-center text-sm mb-4">
                                04
                            </div>
                            <h3 class="text-sm font-bold text-slate-dark mb-2 font-heading">Pelunasan &amp; Unduh File Bersih</h3>
                            <p class="text-xs text-slate-muted leading-relaxed">
                                Artis menyelesaikan pewarnaan &amp; rendering. Setelah disetujui dan klien melunasi sisa tagihan, akses berkas tanpa watermark terbuka serta dana komisi penuh dicairkan ke artist.
                            </p>
                        </div>
                        <div class="mt-4 pt-3 border-t border-stone-200 text-[11px] font-semibold text-indigo-700 flex items-center gap-1.5">
                            <i class="fa-solid fa-cloud-arrow-down text-xs"></i>
                            Akses File Tanpa Watermark
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="kategori" class="py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" data-purpose="category-navigation">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div>
                    <h2 class="text-xl sm:text-2xl font-extrabold font-heading text-slate-dark tracking-tight">
                        Eksplorasi Kategori Seni
                    </h2>
                    <p class="text-xs text-slate-muted mt-1">Pilih kategori spesifik yang sesuai dengan kebutuhan anda</p>
                </div>
                <a href="{{ route('katalog') }}" class="text-xs font-bold text-slate-dark hover:text-amber-600 flex items-center gap-1.5 transition font-heading">
                    <span>Lihat Semua Layanan</span>
                    <i class="fa-solid fa-arrow-right text-[11px]"></i>
                </a>
            </div>

            <div class="flex items-center gap-3 overflow-x-auto pb-3 pt-1 hide-scrollbar">
                @foreach ($categories as $cat)
                    <a href="{{ $cat['home_url'] }}"
                        class="shrink-0 flex items-center gap-2.5 px-4 py-2.5 rounded-xl border text-xs sm:text-sm font-heading transition {{ $cat['active'] ? 'bg-pastel-200 text-slate-dark border-pastel-300 font-bold shadow-xs hover:bg-pastel-300' : 'bg-white text-slate-body border-stone-200 hover:border-pastel-400 hover:bg-pastel-50 font-medium' }}">
                        <i class="fa-solid {{ match($cat['slug']) { '' => 'fa-fire text-amber-600', 'ilustrasi-karakter' => 'fa-paint-brush text-rose-500', 'avatar-chibi-2d' => 'fa-face-smile-wink text-blue-500', 'model-live2d-vtuber' => 'fa-user-astronaut text-purple-600', 'emote-badge' => 'fa-icons text-emerald-600', default => 'fa-palette text-amber-500' } }} text-sm" aria-hidden="true"></i>
                        <span>{{ $cat['name'] }}</span>
                    </a>
                @endforeach
            </div>
        </section>

        <section id="katalog" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" data-purpose="commission-marketplace-feed">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between pb-6 border-b border-stone-200/80 gap-4">
                <div>
                    <h2 class="text-xl sm:text-2xl font-extrabold font-heading text-slate-dark">
                        Katalog Komisi Terverifikasi
                    </h2>
                    <p class="text-xs text-slate-muted mt-0.5">Semua layanan dilindungi oleh Escrow &amp; Watermark Progres</p>
                </div>

                <form action="{{ route('home') }}#katalog" method="GET" class="flex items-center gap-3">
                    @if ($activeCategory !== '')
                        <input type="hidden" name="category" value="{{ $activeCategory }}">
                    @endif
                    <label for="home-sort-select" class="text-xs text-slate-muted font-medium hidden sm:inline">Urutkan:</label>
                    <select id="home-sort-select" name="sort" onchange="this.form.submit()" class="text-xs font-semibold text-slate-dark bg-white border border-stone-200 rounded-xl py-2 px-3 focus:outline-none focus:ring-1 focus:ring-pastel-300 cursor-pointer">
                        @foreach ($sortOptions as $opt)
                            <option value="{{ $opt['value'] }}" {{ $opt['selected'] ? 'selected' : '' }}>{{ $opt['label'] }}</option>
                        @endforeach
                    </select>
                </form>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-6">
                @forelse ($menuCards as $card)
                    <article class="bg-white rounded-2xl overflow-hidden border border-stone-200/90 shadow-xs hover:shadow-md transition-all duration-200 flex flex-col group">
                        <a href="{{ $card['detail_url'] }}" class="relative aspect-4/3 bg-stone-100 overflow-hidden block">
                            @if ($card['thumbnail_url'])
                                <img
                                    src="{{ $card['thumbnail_url'] }}"
                                    alt="{{ $card['title'] }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                />
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-slate-muted gap-1.5">
                                    <i class="fa-regular fa-image text-2xl" aria-hidden="true"></i>
                                    <span class="text-[11px] font-medium">Sampel belum tersedia</span>
                                </div>
                            @endif
                            <span class="absolute top-3 left-3 {{ $card['is_open_slot'] ? 'bg-emerald-600/90' : 'bg-amber-600/90' }} text-white font-bold text-[10px] px-2.5 py-0.5 rounded-full uppercase tracking-wider backdrop-blur-xs font-heading">
                                {{ $card['is_open_slot'] ? 'Buka Slot' : 'Slot Penuh' }}
                            </span>
                            <span class="absolute bottom-2 right-2 px-2 py-0.5 rounded bg-slate-dark/80 text-white text-[10px] font-sans backdrop-blur-xs">
                                <i class="fa-solid fa-clock text-[9px] mr-1" aria-hidden="true"></i>{{ $card['estimated_days'] }} Hari
                            </span>
                        </a>

                        <div class="p-4 flex flex-col grow justify-between bg-white">
                            <div>
                                <div class="flex items-center gap-2 mb-2">
                                    @if ($card['artist_avatar_url'])
                                        <img src="{{ $card['artist_avatar_url'] }}" alt="{{ $card['artist_name'] }}" class="w-6 h-6 rounded-full object-cover ring-1 ring-pastel-300 shrink-0">
                                    @else
                                        <div class="w-6 h-6 rounded-full bg-pastel-300 text-slate-dark font-bold text-[10px] flex items-center justify-center font-heading shrink-0">
                                            {{ $card['artist_initial'] }}
                                        </div>
                                    @endif
                                    <span class="text-xs font-semibold text-slate-dark truncate">{{ $card['artist_name'] }}</span>
                                    <i class="fa-solid fa-circle-check text-amber-500 text-[11px] shrink-0" title="Artis Terverifikasi"></i>
                                </div>

                                <h3 class="text-sm font-bold text-slate-dark group-hover:text-amber-700 line-clamp-2 transition-colors font-heading">
                                    <a href="{{ $card['detail_url'] }}">{{ $card['title'] }}</a>
                                </h3>

                                <div class="flex items-center gap-1.5 mt-2 text-xs text-slate-body">
                                    @if ($card['avg_rating_formatted'] !== null)
                                        <i class="fa-solid fa-star text-amber-400 text-xs" aria-hidden="true"></i>
                                        <span class="font-bold text-slate-dark">{{ $card['avg_rating_formatted'] }}</span>
                                        <span class="text-slate-muted text-[11px]">({{ $card['reviews_count'] }} ulasan)</span>
                                    @else
                                        <i class="fa-regular fa-star text-slate-400 text-xs" aria-hidden="true"></i>
                                        <span class="text-slate-muted text-[11px]">Belum ada ulasan</span>
                                        @if ($card['completed_orders_count'] > 0)
                                            <span class="text-slate-muted text-[11px]">• {{ $card['completed_orders_count'] }} pesanan</span>
                                        @endif
                                    @endif
                                </div>
                            </div>

                            <div class="pt-3 mt-3 border-t border-stone-100 flex items-center justify-between gap-2">
                                <div>
                                    <span class="text-[10px] text-slate-muted block">Mulai dari</span>
                                    <span class="text-sm font-extrabold text-slate-dark font-heading tabular-nums">Rp {{ number_format($card['base_price'], 0, ',', '.') }}</span>
                                </div>
                                <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-800 border border-emerald-200/80 px-2 py-0.5 rounded text-[10px] font-bold shrink-0">
                                    <i class="fa-solid fa-shield-halved text-[9px]" aria-hidden="true"></i>
                                    {{ $card['dp_short_label'] }}
                                </span>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full bg-white rounded-2xl border border-stone-200/90 p-8 text-center space-y-3">
                        <div class="w-12 h-12 rounded-2xl bg-pastel-100 border border-pastel-300 text-amber-900 flex items-center justify-center mx-auto text-lg">
                            <i class="fa-solid fa-palette" aria-hidden="true"></i>
                        </div>
                        <h3 class="text-sm sm:text-base font-bold font-heading text-slate-dark">
                            Belum Ada Paket Komisi pada Kategori Ini
                        </h3>
                        <p class="text-xs text-slate-muted max-w-md mx-auto">
                            Pilih kategori lain atau lihat seluruh katalog layanan yang tersedia di Artsy ID.
                        </p>
                        @if ($activeCategory !== '')
                            <a href="{{ route('home') }}#katalog" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-pastel-200 hover:bg-pastel-300 text-slate-dark font-bold text-xs font-heading transition">
                                Tampilkan Semua Kategori
                            </a>
                        @endif
                    </div>
                @endforelse
            </div>

            <div class="mt-12 text-center">
                <a href="{{ route('katalog') }}" class="inline-flex items-center gap-2 px-8 py-3.5 rounded-full bg-white hover:bg-pastel-100 text-slate-dark border border-stone-300 font-bold text-xs sm:text-sm font-heading shadow-xs transition hover:shadow-sm">
                    <span>Jelajahi Semua Layanan ({{ $totalPublicMenus }} Paket)</span>
                    <i class="fa-solid fa-arrow-right text-xs" aria-hidden="true"></i>
                </a>
            </div>
        </section>

        <section id="keunggulan" class="py-16 bg-white border-t border-stone-200/80" data-purpose="platform-benefits">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-2xl mx-auto text-center mb-12">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-stone-100 text-slate-dark border border-stone-300 text-xs font-bold font-heading">
                        Kenapa Artsy ID?
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold font-heading text-slate-dark mt-3">
                        Transaksi aman dan terpercaya
                    </h2>
                    <p class="text-slate-muted text-xs sm:text-sm mt-2 leading-relaxed">
                        Platform Artsy ID menjembatani kedua pihak secara adil dan transparan.
                    </p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="bg-linear-to-br from-stone-50 to-white p-8 rounded-2xl border border-stone-200 shadow-xs flex flex-col justify-between">
                        <div>
                            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold font-heading mb-4">
                                <i class="fa-solid fa-user-shield"></i>
                                Untuk Klien (Pembeli)
                            </div>
                            <h3 class="text-xl font-bold font-heading text-slate-dark mb-4">
                                Pesan Tanpa Cemas Uang Melayang
                            </h3>
                            <ul class="space-y-3.5 text-xs sm:text-sm text-slate-body">
                                <li class="flex items-start gap-3">
                                    <div class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 mt-0.5">
                                        <i class="fa-solid fa-check text-[11px]"></i>
                                    </div>
                                    <span><strong>Dana Terlindungi Escrow:</strong> DP 50% dan pelunasan aman tertampung di sistem sampai karya akhir selesai kamu setujui.</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <div class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 mt-0.5">
                                        <i class="fa-solid fa-check text-[11px]"></i>
                                    </div>
                                    <span><strong>Progress Tracker Jelas:</strong> Pantau pengerjaan bertahap (Sketsa, Line Art, Coloring, Rendering) secara real-time.</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <div class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 mt-0.5">
                                        <i class="fa-solid fa-check text-[11px]"></i>
                                    </div>
                                    <span><strong>Anti Generative AI:</strong> Seluruh karya diverifikasi bertahap dari sketsa mentah buatan tangan manusia asli.</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <div class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 mt-0.5">
                                        <i class="fa-solid fa-check text-[11px]"></i>
                                    </div>
                                    <span><strong>Sistem Laporan &amp; Rating:</strong> Komunitas aman dengan audit laporan yang ditangani langsung oleh Admin.</span>
                                </li>
                            </ul>
                        </div>
                        <div class="mt-8 pt-4 border-t border-stone-200">
                            <a href="{{ route('register') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-dark hover:text-amber-700 font-heading">
                                <span>Mulai Pesan Komisi Pertama</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>

                    <div class="bg-linear-to-br from-pastel-50 to-white p-8 rounded-2xl border border-pastel-200 shadow-xs flex flex-col justify-between">
                        <div>
                            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-100 text-amber-900 text-xs font-bold font-heading mb-4">
                                <i class="fa-solid fa-palette"></i>
                                Untuk Artist (Kreator)
                            </div>
                            <h3 class="text-xl font-bold font-heading text-slate-dark mb-4">
                                Berkarya Tanpa Khawatir, Bayaran Terjamin
                            </h3>
                            <ul class="space-y-3.5 text-xs sm:text-sm text-slate-body">
                                <li class="flex items-start gap-3">
                                    <div class="w-5 h-5 rounded-full bg-amber-200 text-amber-800 flex items-center justify-center shrink-0 mt-0.5">
                                        <i class="fa-solid fa-check text-[11px]"></i>
                                    </div>
                                    <span><strong>Pencairan Dana Penuh di Akhir:</strong> Seluruh dana komisi (DP, pelunasan, dan add-on) dicairkan penuh oleh admin ke rekeningmu setelah klien menyelesaikan pelunasan.</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <div class="w-5 h-5 rounded-full bg-amber-200 text-amber-800 flex items-center justify-center shrink-0 mt-0.5">
                                        <i class="fa-solid fa-check text-[11px]"></i>
                                    </div>
                                    <span><strong>Proteksi Watermark Otomatis:</strong> Gambar draf otomatis dilindungi watermark sistem agar tidak bisa dicuri.</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <div class="w-5 h-5 rounded-full bg-amber-200 text-amber-800 flex items-center justify-center shrink-0 mt-0.5">
                                        <i class="fa-solid fa-check text-[11px]"></i>
                                    </div>
                                    <span><strong>Anti Scope Creep (Dynamic Invoice):</strong> Klien minta tambah elemen di tengah jalan? Terbitkan tagihan tambahan resmi dengan satu klik.</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <div class="w-5 h-5 rounded-full bg-amber-200 text-amber-800 flex items-center justify-center shrink-0 mt-0.5">
                                        <i class="fa-solid fa-check text-[11px]"></i>
                                    </div>
                                    <span><strong>Pencairan Langsung ke Bank Lokal:</strong> Payout dapat ditarik ke BCA, Mandiri, BRI, BNI atau E-Wallet.</span>
                                </li>
                            </ul>
                        </div>
                        <div class="mt-8 pt-4 border-t border-pastel-200">
                            <a href="{{ route('register') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-dark hover:text-amber-700 font-heading">
                                <span>Daftar Menjadi Kreator Artsy ID</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="faq" class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16" data-purpose="faq-section">
            <div class="text-center mb-10">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-pastel-100 text-amber-900 border border-pastel-300 text-xs font-bold font-heading">
                    Pertanyaan Umum
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold font-heading text-slate-dark mt-3 tracking-tight">
                    Hal yang Sering Ditanyakan
                </h2>
                <p class="text-slate-muted text-xs sm:text-sm mt-2 max-w-xl mx-auto leading-relaxed">
                    Jawaban seputar sistem pembayaran bertahap (Escrow), linimasa progres ber-watermark, dan perlindungan hak cipta di Artsy ID.
                </p>
            </div>

            <div class="space-y-4">
                <details class="group bg-white rounded-2xl border border-stone-200/90 shadow-xs hover:border-pastel-400 transition-all duration-200 overflow-hidden" open>
                    <summary class="flex items-center justify-between gap-4 p-5 sm:p-6 cursor-pointer list-none [&::-webkit-details-marker]:hidden font-heading font-bold text-slate-dark text-sm sm:text-base focus:outline-none">
                        <span>Bagaimana cara kerja sistem pembayaran Escrow Midtrans di Artsy ID?</span>
                        <div class="w-8 h-8 rounded-full bg-stone-100 group-open:bg-pastel-200 text-slate-600 group-open:text-slate-dark flex items-center justify-center shrink-0 transition-transform duration-200 group-open:rotate-180">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </summary>
                    <div class="px-5 sm:px-6 pb-5 sm:pb-6 pt-2 text-xs sm:text-sm text-slate-muted leading-relaxed font-sans border-t border-stone-100">
                        Sistem pembayaran Artsy ID terbagi menjadi 2 tahap melalui Payment Gateway. Saat artist menyetujui pesanan Anda, sistem menerbitkan invoice DP (50%). Dana tersebut ditampung secara aman di sistem bersama dan <strong>tidak langsung dikirim ke artist</strong>. Invoice pelunasan (sisa 50%) baru diterbitkan setelah seluruh pengerjaan selesai dan Anda menyetujui hasil rendering akhir.
                    </div>
                </details>

                <details class="group bg-white rounded-2xl border border-stone-200/90 shadow-xs hover:border-pastel-400 transition-all duration-200 overflow-hidden">
                    <summary class="flex items-center justify-between gap-4 p-5 sm:p-6 cursor-pointer list-none [&::-webkit-details-marker]:hidden font-heading font-bold text-slate-dark text-sm sm:text-base focus:outline-none">
                        <span>Kapan artist menerima pencairan dana komisi?</span>
                        <div class="w-8 h-8 rounded-full bg-stone-100 group-open:bg-pastel-200 text-slate-600 group-open:text-slate-dark flex items-center justify-center shrink-0 transition-transform duration-200 group-open:rotate-180">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </summary>
                    <div class="px-5 sm:px-6 pb-5 sm:pb-6 pt-2 text-xs sm:text-sm text-slate-muted leading-relaxed font-sans border-t border-stone-100">
                        Seluruh dana komisi (DP 50%, pelunasan 50%, serta dynamic add-on yang disetujui) ditahan aman di rekening escrow selama proses pengerjaan dan dicairkan secara <strong>penuh 1 kali di akhir</strong> oleh Admin ke rekening bank artist setelah karya akhir disetujui dan klien menyelesaikan pelunasan.
                    </div>
                </details>

                <details class="group bg-white rounded-2xl border border-stone-200/90 shadow-xs hover:border-pastel-400 transition-all duration-200 overflow-hidden">
                    <summary class="flex items-center justify-between gap-4 p-5 sm:p-6 cursor-pointer list-none [&::-webkit-details-marker]:hidden font-heading font-bold text-slate-dark text-sm sm:text-base focus:outline-none">
                        <span>Bagaimana sistem melindungi karya dari pencurian selama proses pengerjaan?</span>
                        <div class="w-8 h-8 rounded-full bg-stone-100 group-open:bg-pastel-200 text-slate-600 group-open:text-slate-dark flex items-center justify-center shrink-0 transition-transform duration-200 group-open:rotate-180">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </summary>
                    <div class="px-5 sm:px-6 pb-5 sm:pb-6 pt-2 text-xs sm:text-sm text-slate-muted leading-relaxed font-sans border-t border-stone-100">
                        Setiap kali artist mengunggah gambar draf (Sketsa, Line Art, Coloring, dan Rendering), sistem Artsy ID secara otomatis menambahkan watermark diagonal <em>"ARTSY ID - PREVIEW ONLY"</em> melalui proses background queue. Klien hanya dapat melihat gambar pratinjau ber-watermark tersebut. Berkas file asli tanpa watermark hanya dapat diunduh setelah status pembayaran lunas terverifikasi.
                    </div>
                </details>

                <details class="group bg-white rounded-2xl border border-stone-200/90 shadow-xs hover:border-pastel-400 transition-all duration-200 overflow-hidden">
                    <summary class="flex items-center justify-between gap-4 p-5 sm:p-6 cursor-pointer list-none [&::-webkit-details-marker]:hidden font-heading font-bold text-slate-dark text-sm sm:text-base focus:outline-none">
                        <span>Bagaimana jika klien meminta tambahan di tengah jalan?</span>
                        <div class="w-8 h-8 rounded-full bg-stone-100 group-open:bg-pastel-200 text-slate-600 group-open:text-slate-dark flex items-center justify-center shrink-0 transition-transform duration-200 group-open:rotate-180">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </summary>
                    <div class="px-5 sm:px-6 pb-5 sm:pb-6 pt-2 text-xs sm:text-sm text-slate-muted leading-relaxed font-sans border-t border-stone-100">
                        Artsy ID memiliki fitur <strong>Dynamic Invoice</strong>. Jika di ruang chat klien meminta elemen tambahan (misal: aksesoris rumit, karakter tambahan, atau variasi warna ekstra), artist dapat menerbitkan tagihan dinamis baru. Setelah klien mengonfirmasi rincian biaya tersebut, nominalnya akan otomatis ditambahkan ke total invoice pelunasan akhir.
                    </div>
                </details>

                <details class="group bg-white rounded-2xl border border-stone-200/90 shadow-xs hover:border-pastel-400 transition-all duration-200 overflow-hidden">
                    <summary class="flex items-center justify-between gap-4 p-5 sm:p-6 cursor-pointer list-none [&::-webkit-details-marker]:hidden font-heading font-bold text-slate-dark text-sm sm:text-base focus:outline-none">
                        <span>Apakah Artsy ID mengizinkan karya yang dibuat dengan Generative AI?</span>
                        <div class="w-8 h-8 rounded-full bg-stone-100 group-open:bg-pastel-200 text-slate-600 group-open:text-slate-dark flex items-center justify-center shrink-0 transition-transform duration-200 group-open:rotate-180">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </summary>
                    <div class="px-5 sm:px-6 pb-5 sm:pb-6 pt-2 text-xs sm:text-sm text-slate-muted leading-relaxed font-sans border-t border-stone-100">
                        <strong>Sama sekali tidak.</strong> Artsy ID mewajibkan seluruh karya seni adalah 100% orisinal buatan tangan seniman manusia. Hal ini diverifikasi secara sistematis melalui kewajiban pengunggahan tahapan linimasa dari sketsa mentah hingga rendering akhir. Akun yang terbukti menggunakan Generative AI akan langsung diblokir secara permanen oleh Admin.
                    </div>
                </details>

                <details class="group bg-white rounded-2xl border border-stone-200/90 shadow-xs hover:border-pastel-400 transition-all duration-200 overflow-hidden">
                    <summary class="flex items-center justify-between gap-4 p-5 sm:p-6 cursor-pointer list-none [&::-webkit-details-marker]:hidden font-heading font-bold text-slate-dark text-sm sm:text-base focus:outline-none">
                        <span>Bagaimana jika terjadi sengketa atau pesanan bermasalah?</span>
                        <div class="w-8 h-8 rounded-full bg-stone-100 group-open:bg-pastel-200 text-slate-600 group-open:text-slate-dark flex items-center justify-center shrink-0 transition-transform duration-200 group-open:rotate-180">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </summary>
                    <div class="px-5 sm:px-6 pb-5 sm:pb-6 pt-2 text-xs sm:text-sm text-slate-muted leading-relaxed font-sans border-t border-stone-100">
                        Klien dapat menggunakan fitur pelaporan resmi (<em>Artist Report</em>) dengan menyertakan bukti kendala atau pelanggaran. Karena dana ditahan di rekening penampung escrow sistem, Admin platform dapat mengaudit catatan chat dan linimasa pesanan, serta berwenang mengembalikan dana (refund) kepada klien jika artist terbukti melanggar kesepakatan.
                    </div>
                </details>
            </div>

            <div class="mt-8 text-center p-6 bg-stone-50 rounded-2xl border border-stone-200/80">
                <p class="text-xs sm:text-sm text-slate-dark font-medium">
                    Masih punya pertanyaan lain seputar sistem komisi atau pendaftaran artist?
                </p>
                <div class="mt-3 flex items-center justify-center gap-3">
                    <a href="mailto:966raflisaputra@gmail.com" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-pastel-200 hover:bg-pastel-300 text-slate-dark font-bold text-xs font-heading shadow-xs transition">
                        <span>Hubungi Admin</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                   
                </div>
            </div>
        </section>
    </main>
    @include('layouts.footer')
@endsection