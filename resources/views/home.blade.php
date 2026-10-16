@extends('layouts.app')

@section('content')
    <header class="sticky top-0 z-40 bg-pastel-200/80 backdrop-blur-md border-b border-pastel-300"
        data-purpose="site-navigation">
        <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between gap-4">
            <div class="flex items-center space-x-8">
                <a href="#">
                    <img src="{{ asset('images/logo-artsy.png') }}" class="w-24 h-24">
                </a>
                <nav class="hidden lg:flex items-center space-x-1 font-medium text-sm text-slate-700">
                    <a class="px-3.5 py-2 rounded-xl text-slate-950 font-semibold hover:bg-primary/50 transition-colors"
                        href="#komisi">Komisi</a>
                    <a class="px-3.5 py-2 rounded-xl hover:text-slate-950 hover:bg-primary/50 transition-colors"
                        href="#product">Product</a>
                    <a class="px-3.5 py-2 rounded-xl hover:text-slate-950 hover:bg-primary/50 transition-colors"
                        href="#feature">Features</a>
                </nav>
            </div>
            <div class="flex items-center space-x-2 sm:space-x-3">
                <button
                    class="w-10 h-10 rounded-full flex items-center justify-center text-slate-700 hover:bg-primary/50 hover:text-slate-900 border border-transparent transition relative"
                    title="Keranjang Pesanan">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                        <path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2"></path>
                    </svg>
                </button>
                <button
                    class="w-10 h-10 rounded-full flex items-center justify-center text-slate-700 hover:bg-primary/50 hover:text-slate-900 border border-transparent transition relative"
                    title="Pesan Komisi">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                        <path
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                </button>
                <button
                    class="w-10 h-10 rounded-full flex items-center justify-center text-slate-700 hover:bg-primary/50 hover:text-slate-900 border border-transparent transition relative"
                    title="Notifikasi Progres">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                        <path
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                    <span class="absolute top-2 right-2 w-2 h-2 bg-pastel-500 rounded-full ring-2 ring-white"></span>
                </button>
                <a class="hidden md:inline-flex items-center px-4 py-2 rounded-full text-xs font-bold text-slate-800 bg-pastel-500 hover:bg-pastel-500/70 transition shadow-sm"
                    href="#">
                    Jadi Artist +
                </a>
                <a class="inline-flex items-center px-5 py-2 rounded-full text-xs font-bold bg-pastel-500 hover:bg-pastel-500/70 text-slate-800 shadow-sm transition hover:shadow-md"
                    href="{{ route('register') }}">
                    Daftar
                </a>
                <button
                    class="flex items-center gap-1.5 p-1.5 pl-2.5 rounded-full bg-pastel-500 text-slate-800 hover:shadow-sm transition">
                    <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                        <path d="M4 6h16M4 12h16M4 18h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                        </path>
                    </svg>
                    <div
                        class="w-7 h-7 rounded-full bg-slate-900 text-butter-300 flex items-center justify-center font-bold text-xs">
                        R
                    </div>
                </button>
            </div>
        </div>
    </header>
    <main class="grow pb-24">
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-10 pb-8" data-purpose="hero-search-area">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="max-w-2xl">
                    <h1
                        class="text-3xl sm:text-4xl lg:text-5xl font-black font-heading tracking-tight text-slate-900 leading-[1.15]">
                        Buat Karya Anda Dengan Ahli Seni di Platform Artsy.
                    </h1>
                    <p class="text-sm sm:text-base text-slate-600 mt-2 font-normal">
                        Pesan karya ilustrator, rigger Live2D, dan desainer lokal dengan jaminan DP aman via Escrow.
                    </p>
                </div>
                <div class="w-full md:w-115 lg:w-130 shrink-0">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                                <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2.2"></path>
                            </svg>
                        </div>
                        <input
                            class="w-full pl-11 pr-24 py-3.5 bg-white border border-stone-200 rounded-full text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-butter-400 focus:border-butter-400 shadow-sm transition"
                            placeholder="Cari layanan, gaya anime, Vtuber, atau nama artist..." type="text" />
                        <div class="absolute inset-y-1.5 right-1.5 flex items-center">
                            <button
                                class="h-full px-4 rounded-full bg-slate-900 text-butter-300 text-xs font-bold hover:bg-slate-800 transition">
                                Cari
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-12" data-purpose="featured-showcase-banners">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="relative overflow-hidden rounded-3xl min-h-72.5 p-8 flex flex-col justify-between shadow-xl group border border-pastel-400/40"
                    >
                    <div class="absolute inset-0 bg-linear-to-tr from-pastel-400/95 to-pastel-400/20"></div>
                    <div class="relative z-10 flex items-center justify-between">
                        <span
                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full  text-black text-xs font-bold">
                            <svg class="w-3.5 h-3.5 text-pastel-500" fill="currentColor" viewbox="0 0 20 20">
                                <path clip-rule="evenodd"
                                    d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    fill-rule="evenodd"></path>
                            </svg>
                            Midtrans Escrow Guaranteed
                        </span>
                    </div>
                    <div class="relative z-10 mt-12">
                        <h2 class="text-2xl sm:text-3xl font-extrabold font-heading tracking-tight">
                            Dibuat Khusus Kreator Lokal
                        </h2>
                        <p class="text-slate-800/80 text-sm sm:text-base mt-2 max-w-lg font-normal leading-relaxed">
                            Kebutuhan Vtuber/streaming, musik, novel, komik &amp; OC. Dana DP tersimpan aman di rekening
                            penampung Midtrans hingga draf sketsa disetujui!
                        </p>
                        <div class="mt-6 flex items-center justify-between pt-2 border-t border-white/10">
                            <div
                                class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-black/50 backdrop-blur-md border border-white/15 text-xs text-slate-200">
                                <img alt="Rafly Saputra" class="w-5 h-5 rounded-full object-cover"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuBaZ_2pa-4LLXNR7Meei68S1yxsr9_sv68B5DOwvkBF9q39GHulJxHj2HBxO8ebjrFv8nreQeyx-tf_XFxMicdnywdJ2BORHVnSej_escJBeSe5QnWCSh4XpZpMrzAmTXOtz1Y1AOEmC-cDe7lOulEVHR232Q8xI8Rm3kOART1rUEy50STi0lY7RHJ2J3pghXqWZE65ulGcr3f0NkUKh7hSfNYtNwiJMGov6Dm9CRHYbTEE9BNPSgtN" />
                                <span>Artwork oleh <strong class="text-butter-300">@rafly</strong></span>
                            </div>
                            <a class="text-xs font-bold text-butter-300 hover:text-slate-800/80 flex items-center gap-1" href="#">
                                Jelajahi Showcase
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                                    <path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                    </path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="relative overflow-hidden rounded-3xl min-h-72.5 p-8 flex flex-col justify-between shadow-xl group border border-pastel-400/40">
                    <div class="absolute inset-0 bg-linear-to-tr from-pastel-100/95 to-pastel-400/30">
                    </div>
                    <div class="relative z-10">
                        <span
                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full border border-pastel-500/50 bg-pastel-500/10 text-pastel-500 text-xs font-bold">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                                <path
                                    d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"></path>
                            </svg>
                            100% Karya Manusia
                        </span>
                    </div>
                    <div class="relative z-10 mt-12">
                        <h2 class="text-2xl sm:text-3xl font-extrabold font-heading text-pastel-500! tracking-tight">
                            Anti Generative AI
                        </h2>
                        <p class="text-slate-800/80 text-sm sm:text-base mt-2 max-w-lg font-normal leading-relaxed">
                            Artsy ID mewajibkan verifikasi proses karya. Draf dikirim dengan watermark
                            otomatis &amp; pencairan dana dilakukan bertahap secara transparan.
                        </p>
                        <div class="mt-6 flex items-center justify-start pt-2 border-t border-white/10">
                            <div
                                class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-black/50 backdrop-blur-md border border-white/15 text-xs text-slate-200">
                                <img alt="Rafly" class="w-5 h-5 rounded-full object-cover"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuArVqDTAfI7HYIdMiVui_71xz-GNiRs2rg4nOrdyxCRF3ICE57jdayqwHvs0lqA6kmX-5JWMqM0Zx2MJaS2m9Ebji_tnu_tJtyv2L5JGzwjyGPFyxg6uaCspHd2J-TeIAhl6O-oLBGYljSpkrxyBV3wolH8Vvfdb197B8ReBVvrKLXCZzH8Xq4j8Eg9abLpEC7LICaKwF3q8Zvvth9sNEo4gJQ2uYfz-wT5raf75ybMY0jFNd-3bcU6" />
                                <span>Artwork oleh <strong class="text-pastel-500">@rafly</strong></span>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="komisi" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-10" data-purpose="category-navigation">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl sm:text-2xl font-extrabold font-heading text-slate-900 tracking-tight">
                    38.000+ Layanan Komisi
                </h2>
                <span class="text-xs font-medium text-slate-500 hidden sm:inline">Pilih kategori untuk memfilter
                    portofolio</span>
            </div>
            <div class="flex items-center gap-3 overflow-x-auto pb-2 pt-1 hide-scrollbar">
                <button
                    class="shrink-0 flex items-center gap-3 px-4 py-2.5 rounded-full bg-pastel-500/15 hover:bg-pastel-500/25 border border-pastel-500 shadow-sm transition group">
                    <div
                        class="w-8 h-8 rounded-full bg-linear-to-tr from-rose-500 to-orange-400 flex items-center justify-center text-white shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                            <path
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                        </svg>
                    </div>
                    <span class="text-xs sm:text-sm font-bold text-slate-800">Ilustrasi &amp; OC</span>
                </button>
                <button
                    class="shrink-0 flex items-center gap-3 px-4 py-2.5 rounded-full bg-pastel-500/15 hover:bg-pastel-500/25 border border-pastel-500 shadow-sm transition hover:border-slate-300 group">
                    <div
                        class="w-8 h-8 rounded-full bg-linear-to-tr from-purple-600 to-indigo-500 flex items-center justify-center text-white shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                        </svg>
                    </div>
                    <span class="text-xs sm:text-sm font-bold text-slate-800">Model Live2D &amp; Rigging</span>
                </button>
                <button
                    class="shrink-0 flex items-center gap-3 px-4 py-2.5 rounded-full bg-pastel-500/15 hover:bg-pastel-500/25 border border-pastel-500 shadow-sm transition hover:border-slate-300 group">
                    <div
                        class="w-8 h-8 rounded-full bg-linear-to-tr from-emerald-500 to-teal-400 flex items-center justify-center text-white shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                            <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="2"></path>
                        </svg>
                    </div>
                    <span class="text-xs sm:text-sm font-bold text-slate-800">3D VTuber &amp; VRChat</span>
                </button>
                <button
                    class="shrink-0 flex items-center gap-3 px-4 py-2.5 rounded-full bg-pastel-500/15 hover:bg-pastel-500/25 border border-pastel-500 shadow-sm transition group">
                    <div
                        class="w-8 h-8 rounded-full bg-linear-to-tr from-blue-500 to-cyan-400 flex items-center justify-center text-white shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                            <path d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                        </svg>
                    </div>
                    <span class="text-xs sm:text-sm font-bold text-slate-800">Emotes &amp; Badges</span>
                </button>
                <button
                    class="shrink-0 flex items-center gap-3 px-4 py-2.5 rounded-full bg-pastel-500/15 hover:bg-pastel-500/25 border border-pastel-500 shadow-sm transition group">
                    <div
                        class="w-8 h-8 rounded-full bg-linear-to-tr from-fuchsia-500 to-pink-500 flex items-center justify-center text-white shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                            <path
                                d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                        </svg>
                    </div>
                    <span class="text-xs sm:text-sm font-bold text-slate-800">Asset Streaming &amp; Overlay</span>
                </button>
                <button
                    class="shrink-0 flex items-center gap-3 px-4 py-2.5 rounded-full bg-pastel-500/15 hover:bg-pastel-500/25 border border-pastel-500 shadow-sm transition hover:border-slate-300 group">
                    <div
                        class="w-8 h-8 rounded-full bg-linear-to-tr from-amber-400 to-yellow-500 flex items-center justify-center text-slate-900 shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                            <path
                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                        </svg>
                    </div>
                    <span class="text-xs sm:text-sm font-bold text-slate-800">Cover Musik &amp; Buku</span>
                </button>
                <button
                    class="shrink-0 flex items-center gap-3 px-4 py-2.5 rounded-full bg-pastel-500/15 hover:bg-pastel-500/25 border border-pastel-500 shadow-sm transition group">
                    <div
                        class="w-8 h-8 rounded-full bg-linear-to-tr from-violet-600 to-purple-400 flex items-center justify-center text-white shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                            <path
                                d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                            <path d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2"></path>
                        </svg>
                    </div>
                    <span class="text-xs sm:text-sm font-bold text-slate-800">Animasi PV / MV</span>
                </button>
                <a class="shrink-0 flex items-center gap-2 px-5 py-2.5 rounded-full bg-pastel-500/15 hover:bg-pastel-500/25 border border-pastel-500 text-xs sm:text-sm font-bold shadow-sm transition"
                    href="#">
                    <span>Semua Kategori</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                        <path d="M14 5l7 7m0 0l-7 7m7-7H3" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2.5"></path>
                    </svg>
                </a>
            </div>
        </section>
        <section id="product" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" data-purpose="commission-marketplace-feed">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between pb-6 gap-4">
                <div class="flex items-center space-x-2">
                    <button class="px-4 py-1.5 rounded-full bg-pastel-500 text-butter-300 text-xs font-bold shadow-sm">
                        Rekomendasi
                    </button>
                    <button
                        class="px-4 py-1.5 rounded-full bg-pastel-500/30 hover:bg-pastel-500 text-slate-700 text-xs font-semibold border border-pastel-500 transition">
                        Slot Buka (Open)
                    </button>
                    <button
                        class="px-4 py-1.5 rounded-full bg-pastel-500/30 hover:bg-pastel-500 text-slate-700 text-xs font-semibold border border-pastel-500 transition">
                        Kreator Bintang 5
                    </button>
                    <button
                        class="px-4 py-1.5 rounded-full bg-pastel-500/30 hover:bg-pastel-500 text-slate-700 text-xs font-semibold border border-pastel-500 transition hidden md:inline-block">
                        Pengerjaan Cepat (&lt; 7 Hari)
                    </button>
                </div>
                <div class="flex items-center space-x-3 text-xs text-slate-500 font-medium">
                    <span>Urutkan:</span>
                    <select
                        class="text-xs font-semibold text-slate-800 bg-pastel-500/30 border border-pastel-500 rounded-lg py-1 px-2.5 focus:outline-none focus:ring-1 focus:ring-butter-400">
                        <option>Paling Relevan</option>
                        <option>Rating Tertinggi</option>
                        <option>Harga: Terendah ke Tertinggi</option>
                        <option>Slot Terbaru</option>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <article
                    class="bg-white rounded-2xl overflow-hidden border border-pastel-400/20 shadow-sm card-hover-effect flex flex-col group">
                    <div class="relative aspect-[4/3] bg-stone-100 overflow-hidden">
                        <img alt="Bust-up Anime Karakter Fantasy (Full Render)"
                            class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuDMWrhWHyVZzWIW6Ip317Zju62KnRZUNKChKOktfr3JbY1jRD_Bd42IX-THWsy0y1GcfKdM4UNmdfof4PEfDKvSkRY5Va_Z7RNpf_mDXWrRB-mCNW9osCmVkRuA420t37Bm8yv-WKLAWZh7xeNDZE4pXAOoEmAYH1Za3Sg7im89_qwZRZXIPU5wJBq6in4MyWHEB95toOrDmOaf-ggxJquKj6c7byVILPzy3iZ53qJlIgEjPwI4QJnH" />
                        <span
                            class="absolute top-3 left-3 bg-pastel-400/30 text-pastel-500 font-black text-[11px] px-2.5 py-0.5 rounded-md uppercase tracking-wider shadow-sm">
                            OPEN
                        </span>
                        <button
                            class="absolute top-3 right-3 w-8 h-8 rounded-full bg-pastel-400/30 hover:bg-pastel-500 text-pastel-500 flex items-center justify-center transition shadow-md backdrop-blur-sm"
                            title="Simpan ke Favorit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                                <path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2"></path>
                            </svg>
                        </button>
                        <div
                            class="absolute inset-y-0 left-2 flex items-center opacity-0 group-hover:opacity-100 transition">
                            <button
                                class="w-6 h-6 rounded-full bg-white/80 hover:bg-white text-slate-800 flex items-center justify-center shadow">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                                    <path d="M15 19l-7-7 7-7" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2.5"></path>
                                </svg>
                            </button>
                        </div>
                        <div
                            class="absolute inset-y-0 right-2 flex items-center opacity-0 group-hover:opacity-100 transition">
                            <button
                                class="w-6 h-6 rounded-full bg-white/80 hover:bg-white text-slate-800 flex items-center justify-center shadow">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                                    <path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2.5"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="p-4 flex flex-col grow justify-between bg-card">
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <img alt="Avatar Studio Lunaria"
                                    class="w-6 h-6 rounded-full object-cover ring-1 ring-stone-200"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuC5zHGeuqIuuNNJ_1MOKj1ojpEORbrPoWjGSSOQ8YTI0EjLQ1oNXqgDyU75_JgbzdCPPNwfXkbQSuE2oOtWzxJEjJgyKDggdPYqjN3szCYgfFuXcZKPA1oGghX2VYFsyWv1vfoV7llu1tOLfrMFybQfrINJfClZnBGMOa0kQgm5_-EEgfHKtzisUxcihNL7ck4nnPrpVdk7MQKqhwOG1UJJkyQBZfOU8TAgKw67Zh1GRjVAjNz2UwsN" />
                                <span class="text-xs font-semibold text-slate-700 truncate">RaflyStore</span>
                                <span class="text-amber-500" title="Kreator Terverifikasi">
                                    <svg class="w-3.5 h-3.5 fill-current" viewbox="0 0 20 20">
                                        <path clip-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            fill-rule="evenodd"></path>
                                    </svg>
                                </span>
                            </div>
                            <h3
                                class="text-sm font-bold text-slate-900 group-hover:text-amber-600 line-clamp-2 transition-colors">
                                Bust-up Anime Karakter Fantasy
                            </h3>
                            <div class="flex items-center gap-1.5 mt-2 text-xs text-slate-600">
                                <div class="flex items-center text-amber-400">
                                    <svg class="w-3.5 h-3.5 fill-current" viewbox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                        </path>
                                    </svg>
                                </div>
                                <span class="font-bold text-slate-900">5.0</span>
                                <span>(48 pesanan selesai)</span>
                            </div>
                        </div>
                        <div class="pt-3 mt-3 border-t border-stone-100 flex items-center justify-between">
                            <div>
                                <span class="text-[10px] text-slate-400 block font-medium">Mulai dari</span>
                                <span class="text-sm font-extrabold text-slate-900 font-heading">Rp 450.000</span>
                            </div>
                            <span
                                class="inline-flex items-center gap-1 bg-pastel-400/30 text-slate-600 px-2 py-1 rounded text-[10px] font-semibold"
                                title="DP 50% dijamin Escrow Midtrans">
                                <svg class="w-3 h-3 text-pastel-500" fill="currentColor" viewbox="0 0 20 20">
                                    <path clip-rule="evenodd"
                                        d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                        fill-rule="evenodd"></path>
                                </svg>
                                DP 50% Escrow
                            </span>
                        </div>
                    </div>
                </article>
                 <article
                    class="bg-white rounded-2xl overflow-hidden border border-pastel-400/20 shadow-sm card-hover-effect flex flex-col group">
                    <div class="relative aspect-[4/3] bg-stone-100 overflow-hidden">
                        <img alt="Bust-up Anime Karakter Fantasy (Full Render)"
                            class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuDMWrhWHyVZzWIW6Ip317Zju62KnRZUNKChKOktfr3JbY1jRD_Bd42IX-THWsy0y1GcfKdM4UNmdfof4PEfDKvSkRY5Va_Z7RNpf_mDXWrRB-mCNW9osCmVkRuA420t37Bm8yv-WKLAWZh7xeNDZE4pXAOoEmAYH1Za3Sg7im89_qwZRZXIPU5wJBq6in4MyWHEB95toOrDmOaf-ggxJquKj6c7byVILPzy3iZ53qJlIgEjPwI4QJnH" />
                        <span
                            class="absolute top-3 left-3 bg-pastel-400/30 text-pastel-500 font-black text-[11px] px-2.5 py-0.5 rounded-md uppercase tracking-wider shadow-sm">
                            OPEN
                        </span>
                        <button
                            class="absolute top-3 right-3 w-8 h-8 rounded-full bg-pastel-400/30 hover:bg-pastel-500 text-pastel-500 flex items-center justify-center transition shadow-md backdrop-blur-sm"
                            title="Simpan ke Favorit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                                <path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2"></path>
                            </svg>
                        </button>
                        <div
                            class="absolute inset-y-0 left-2 flex items-center opacity-0 group-hover:opacity-100 transition">
                            <button
                                class="w-6 h-6 rounded-full bg-white/80 hover:bg-white text-slate-800 flex items-center justify-center shadow">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                                    <path d="M15 19l-7-7 7-7" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2.5"></path>
                                </svg>
                            </button>
                        </div>
                        <div
                            class="absolute inset-y-0 right-2 flex items-center opacity-0 group-hover:opacity-100 transition">
                            <button
                                class="w-6 h-6 rounded-full bg-white/80 hover:bg-white text-slate-800 flex items-center justify-center shadow">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                                    <path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2.5"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="p-4 flex flex-col grow justify-between bg-card">
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <img alt="Avatar Studio Lunaria"
                                    class="w-6 h-6 rounded-full object-cover ring-1 ring-stone-200"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuC5zHGeuqIuuNNJ_1MOKj1ojpEORbrPoWjGSSOQ8YTI0EjLQ1oNXqgDyU75_JgbzdCPPNwfXkbQSuE2oOtWzxJEjJgyKDggdPYqjN3szCYgfFuXcZKPA1oGghX2VYFsyWv1vfoV7llu1tOLfrMFybQfrINJfClZnBGMOa0kQgm5_-EEgfHKtzisUxcihNL7ck4nnPrpVdk7MQKqhwOG1UJJkyQBZfOU8TAgKw67Zh1GRjVAjNz2UwsN" />
                                <span class="text-xs font-semibold text-slate-700 truncate">RaflyStore</span>
                                <span class="text-amber-500" title="Kreator Terverifikasi">
                                    <svg class="w-3.5 h-3.5 fill-current" viewbox="0 0 20 20">
                                        <path clip-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            fill-rule="evenodd"></path>
                                    </svg>
                                </span>
                            </div>
                            <h3
                                class="text-sm font-bold text-slate-900 group-hover:text-amber-600 line-clamp-2 transition-colors">
                                Bust-up Anime Karakter Fantasy
                            </h3>
                            <div class="flex items-center gap-1.5 mt-2 text-xs text-slate-600">
                                <div class="flex items-center text-amber-400">
                                    <svg class="w-3.5 h-3.5 fill-current" viewbox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                        </path>
                                    </svg>
                                </div>
                                <span class="font-bold text-slate-900">5.0</span>
                                <span>(48 pesanan selesai)</span>
                            </div>
                        </div>
                        <div class="pt-3 mt-3 border-t border-stone-100 flex items-center justify-between">
                            <div>
                                <span class="text-[10px] text-slate-400 block font-medium">Mulai dari</span>
                                <span class="text-sm font-extrabold text-slate-900 font-heading">Rp 450.000</span>
                            </div>
                            <span
                                class="inline-flex items-center gap-1 bg-pastel-400/30 text-slate-600 px-2 py-1 rounded text-[10px] font-semibold"
                                title="DP 50% dijamin Escrow Midtrans">
                                <svg class="w-3 h-3 text-pastel-500" fill="currentColor" viewbox="0 0 20 20">
                                    <path clip-rule="evenodd"
                                        d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                        fill-rule="evenodd"></path>
                                </svg>
                                DP 50% Escrow
                            </span>
                        </div>
                    </div>
                </article>
                 <article
                    class="bg-white rounded-2xl overflow-hidden border border-pastel-400/20 shadow-sm card-hover-effect flex flex-col group">
                    <div class="relative aspect-[4/3] bg-stone-100 overflow-hidden">
                        <img alt="Bust-up Anime Karakter Fantasy (Full Render)"
                            class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuDMWrhWHyVZzWIW6Ip317Zju62KnRZUNKChKOktfr3JbY1jRD_Bd42IX-THWsy0y1GcfKdM4UNmdfof4PEfDKvSkRY5Va_Z7RNpf_mDXWrRB-mCNW9osCmVkRuA420t37Bm8yv-WKLAWZh7xeNDZE4pXAOoEmAYH1Za3Sg7im89_qwZRZXIPU5wJBq6in4MyWHEB95toOrDmOaf-ggxJquKj6c7byVILPzy3iZ53qJlIgEjPwI4QJnH" />
                        <span
                            class="absolute top-3 left-3 bg-pastel-400/30 text-pastel-500 font-black text-[11px] px-2.5 py-0.5 rounded-md uppercase tracking-wider shadow-sm">
                            OPEN
                        </span>
                        <button
                            class="absolute top-3 right-3 w-8 h-8 rounded-full bg-pastel-400/30 hover:bg-pastel-500 text-pastel-500 flex items-center justify-center transition shadow-md backdrop-blur-sm"
                            title="Simpan ke Favorit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                                <path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2"></path>
                            </svg>
                        </button>
                        <div
                            class="absolute inset-y-0 left-2 flex items-center opacity-0 group-hover:opacity-100 transition">
                            <button
                                class="w-6 h-6 rounded-full bg-white/80 hover:bg-white text-slate-800 flex items-center justify-center shadow">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                                    <path d="M15 19l-7-7 7-7" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2.5"></path>
                                </svg>
                            </button>
                        </div>
                        <div
                            class="absolute inset-y-0 right-2 flex items-center opacity-0 group-hover:opacity-100 transition">
                            <button
                                class="w-6 h-6 rounded-full bg-white/80 hover:bg-white text-slate-800 flex items-center justify-center shadow">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                                    <path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2.5"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="p-4 flex flex-col grow justify-between bg-card">
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <img alt="Avatar Studio Lunaria"
                                    class="w-6 h-6 rounded-full object-cover ring-1 ring-stone-200"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuC5zHGeuqIuuNNJ_1MOKj1ojpEORbrPoWjGSSOQ8YTI0EjLQ1oNXqgDyU75_JgbzdCPPNwfXkbQSuE2oOtWzxJEjJgyKDggdPYqjN3szCYgfFuXcZKPA1oGghX2VYFsyWv1vfoV7llu1tOLfrMFybQfrINJfClZnBGMOa0kQgm5_-EEgfHKtzisUxcihNL7ck4nnPrpVdk7MQKqhwOG1UJJkyQBZfOU8TAgKw67Zh1GRjVAjNz2UwsN" />
                                <span class="text-xs font-semibold text-slate-700 truncate">RaflyStore</span>
                                <span class="text-amber-500" title="Kreator Terverifikasi">
                                    <svg class="w-3.5 h-3.5 fill-current" viewbox="0 0 20 20">
                                        <path clip-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            fill-rule="evenodd"></path>
                                    </svg>
                                </span>
                            </div>
                            <h3
                                class="text-sm font-bold text-slate-900 group-hover:text-amber-600 line-clamp-2 transition-colors">
                                Bust-up Anime Karakter Fantasy
                            </h3>
                            <div class="flex items-center gap-1.5 mt-2 text-xs text-slate-600">
                                <div class="flex items-center text-amber-400">
                                    <svg class="w-3.5 h-3.5 fill-current" viewbox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                        </path>
                                    </svg>
                                </div>
                                <span class="font-bold text-slate-900">5.0</span>
                                <span>(48 pesanan selesai)</span>
                            </div>
                        </div>
                        <div class="pt-3 mt-3 border-t border-stone-100 flex items-center justify-between">
                            <div>
                                <span class="text-[10px] text-slate-400 block font-medium">Mulai dari</span>
                                <span class="text-sm font-extrabold text-slate-900 font-heading">Rp 450.000</span>
                            </div>
                            <span
                                class="inline-flex items-center gap-1 bg-pastel-400/30 text-slate-600 px-2 py-1 rounded text-[10px] font-semibold"
                                title="DP 50% dijamin Escrow Midtrans">
                                <svg class="w-3 h-3 text-pastel-500" fill="currentColor" viewbox="0 0 20 20">
                                    <path clip-rule="evenodd"
                                        d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                        fill-rule="evenodd"></path>
                                </svg>
                                DP 50% Escrow
                            </span>
                        </div>
                    </div>
                </article>
                 <article
                    class="bg-white rounded-2xl overflow-hidden border border-pastel-400/20 shadow-sm card-hover-effect flex flex-col group">
                    <div class="relative aspect-[4/3] bg-stone-100 overflow-hidden">
                        <img alt="Bust-up Anime Karakter Fantasy (Full Render)"
                            class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuDMWrhWHyVZzWIW6Ip317Zju62KnRZUNKChKOktfr3JbY1jRD_Bd42IX-THWsy0y1GcfKdM4UNmdfof4PEfDKvSkRY5Va_Z7RNpf_mDXWrRB-mCNW9osCmVkRuA420t37Bm8yv-WKLAWZh7xeNDZE4pXAOoEmAYH1Za3Sg7im89_qwZRZXIPU5wJBq6in4MyWHEB95toOrDmOaf-ggxJquKj6c7byVILPzy3iZ53qJlIgEjPwI4QJnH" />
                        <span
                            class="absolute top-3 left-3 bg-pastel-400/30 text-pastel-500 font-black text-[11px] px-2.5 py-0.5 rounded-md uppercase tracking-wider shadow-sm">
                            OPEN
                        </span>
                        <button
                            class="absolute top-3 right-3 w-8 h-8 rounded-full bg-pastel-400/30 hover:bg-pastel-500 text-pastel-500 flex items-center justify-center transition shadow-md backdrop-blur-sm"
                            title="Simpan ke Favorit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                                <path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2"></path>
                            </svg>
                        </button>
                        <div
                            class="absolute inset-y-0 left-2 flex items-center opacity-0 group-hover:opacity-100 transition">
                            <button
                                class="w-6 h-6 rounded-full bg-white/80 hover:bg-white text-slate-800 flex items-center justify-center shadow">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                                    <path d="M15 19l-7-7 7-7" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2.5"></path>
                                </svg>
                            </button>
                        </div>
                        <div
                            class="absolute inset-y-0 right-2 flex items-center opacity-0 group-hover:opacity-100 transition">
                            <button
                                class="w-6 h-6 rounded-full bg-white/80 hover:bg-white text-slate-800 flex items-center justify-center shadow">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                                    <path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2.5"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="p-4 flex flex-col grow justify-between bg-card">
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <img alt="Avatar Studio Lunaria"
                                    class="w-6 h-6 rounded-full object-cover ring-1 ring-stone-200"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuC5zHGeuqIuuNNJ_1MOKj1ojpEORbrPoWjGSSOQ8YTI0EjLQ1oNXqgDyU75_JgbzdCPPNwfXkbQSuE2oOtWzxJEjJgyKDggdPYqjN3szCYgfFuXcZKPA1oGghX2VYFsyWv1vfoV7llu1tOLfrMFybQfrINJfClZnBGMOa0kQgm5_-EEgfHKtzisUxcihNL7ck4nnPrpVdk7MQKqhwOG1UJJkyQBZfOU8TAgKw67Zh1GRjVAjNz2UwsN" />
                                <span class="text-xs font-semibold text-slate-700 truncate">RaflyStore</span>
                                <span class="text-amber-500" title="Kreator Terverifikasi">
                                    <svg class="w-3.5 h-3.5 fill-current" viewbox="0 0 20 20">
                                        <path clip-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            fill-rule="evenodd"></path>
                                    </svg>
                                </span>
                            </div>
                            <h3
                                class="text-sm font-bold text-slate-900 group-hover:text-amber-600 line-clamp-2 transition-colors">
                                Bust-up Anime Karakter Fantasy
                            </h3>
                            <div class="flex items-center gap-1.5 mt-2 text-xs text-slate-600">
                                <div class="flex items-center text-amber-400">
                                    <svg class="w-3.5 h-3.5 fill-current" viewbox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                        </path>
                                    </svg>
                                </div>
                                <span class="font-bold text-slate-900">5.0</span>
                                <span>(48 pesanan selesai)</span>
                            </div>
                        </div>
                        <div class="pt-3 mt-3 border-t border-stone-100 flex items-center justify-between">
                            <div>
                                <span class="text-[10px] text-slate-400 block font-medium">Mulai dari</span>
                                <span class="text-sm font-extrabold text-slate-900 font-heading">Rp 450.000</span>
                            </div>
                            <span
                                class="inline-flex items-center gap-1 bg-pastel-400/30 text-slate-600 px-2 py-1 rounded text-[10px] font-semibold"
                                title="DP 50% dijamin Escrow Midtrans">
                                <svg class="w-3 h-3 text-pastel-500" fill="currentColor" viewbox="0 0 20 20">
                                    <path clip-rule="evenodd"
                                        d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                        fill-rule="evenodd"></path>
                                </svg>
                                DP 50% Escrow
                            </span>
                        </div>
                    </div>
                </article>
            </div>
            <div class="mt-12 text-center">
                <button
                    class="inline-flex items-center gap-2 px-8 py-3.5 rounded-full bg-pastel-400 hover:bg-pastel-400/80 border border-pastel-500 font-bold text-sm text-slate-900 shadow-sm transition hover:shadow">
                    <span>Muat Lebih Banyak Layanan</span>
                    <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewbox="0 0 24 24">
                        <path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                </button>
            </div>
        </section>
        <section id="feature" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-20" data-purpose="escrow-process-explanation">
            <div class="bg-pastel-200 shadow rounded-3xl p-8 sm:p-12 text-slate-900 relative overflow-hidden border border-pastel-400/20">
                <div
                    class="absolute -right-20 -bottom-20 w-80 h-80 bg-butter-300/10 rounded-full blur-3xl pointer-events-none">
                </div>
                <div
                    class="absolute -left-20 -top-20 w-80 h-80 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none">
                </div>
                <div class="max-w-2xl">
                    <span
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-pastel-500/20 text-pastel-500 text-xs font-bold border border-pastel-500/30">
                        Sistem Perlindungan 3-Tahap
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold font-heading text-slate-900 mt-3">
                        Komisi Tanpa Ghosting, Tanpa Takut Rugi.
                    </h2>
                    <p class="text-slate-600 text-sm sm:text-base mt-2 leading-relaxed">
                        Artsy ID menghubungkan klien dan artist dengan integrasi payment gateway Midtrans dan perlindungan
                        draf berwatermark resmi.
                    </p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-10">
                    <div class="bg-pastel-500/20 p-6 rounded-2xl backdrop-blur-sm">
                        <div
                            class="w-10 h-10 rounded-xl bg-butter-300 text-slate-900 font-extrabold flex items-center justify-center text-base mb-4">
                            01
                        </div>
                        <h3 class="text-base font-bold text-slate-900 mb-2">DP 50% Aman di Escrow</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Klien membayar DP ke rekening bersama Midtrans. Uang tidak langsung ditransfer ke artist sampai
                            draf sketsa pertama disetujui.
                        </p>
                    </div>
                    <div class="bg-pastel-500/20 p-6 rounded-2xl backdrop-blur-sm">
                        <div
                            class="w-10 h-10 rounded-xl bg-butter-300 text-slate-900 font-extrabold flex items-center justify-center text-base mb-4">
                            02
                        </div>
                        <h3 class="text-base font-bold text-slate-900 mb-2">Draf Ber-Watermark Otomatis</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Artist mengunggah progres karya (WIP)melalui platform. Sistem Artsy ID otomatis menambahkan
                            watermark proteksi.
                        </p>
                    </div>
                    <div class="bg-pastel-500/20 p-6 rounded-2xl backdrop-blur-sm">
                        <div
                            class="w-10 h-10 rounded-xl bg-butter-300 text-slate-900 font-extrabold flex items-center justify-center text-base mb-4">
                            03
                        </div>
                        <h3 class="text-base font-bold text-slate-900 mb-2">Pelunasan &amp; File HD Bersih</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Setelah karya final disetujui, klien melunasi sisa pembayaran. File resolusi penuh langsung
                            dapat diunduh tanpa watermark.
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection