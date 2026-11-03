@extends('layouts.app')

@section('content')
    @include('layouts.header')

    <main class="bg-bg-light min-h-screen text-slate-body font-sans pb-24">
        <div class="bg-linear-to-b from-pastel-100/60 via-stone-50 to-bg-light border-b border-stone-200/60 pt-6 pb-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <nav class="flex items-center gap-2 text-xs text-slate-muted mb-4" aria-label="Breadcrumb">
                    <a href="{{ route('home') }}" class="hover:text-slate-dark transition flex items-center gap-1">
                        <i class="fa-solid fa-house text-[11px]"></i>
                        <span>Beranda</span>
                    </a>
                    <span class="text-stone-300">/</span>
                    <span class="font-medium text-slate-dark">Katalog Komisi</span>
                </nav>

                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                    <div class="max-w-2xl">
                        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black font-heading text-slate-dark tracking-tight">
                            Jelajahi Katalog Komisi Seni Digital
                        </h1>
                        <p class="mt-2 text-xs sm:text-sm text-slate-body leading-relaxed">
                            Temukan ratusan ilustrator profesional, modeler Live2D, dan kreator 3D terverifikasi di Indonesia.
                        </p>
                    </div>

                    <div class="w-full md:w-80 lg:w-96 shrink-0">
                        <div class="relative flex items-center bg-white rounded-2xl border border-stone-200 shadow-xs focus-within:border-pastel-400 focus-within:ring-2 focus-within:ring-pastel-200 transition">
                            <i class="fa-solid fa-magnifying-glass text-slate-400 text-sm pl-4"></i>
                            <input 
                                type="text" 
                                id="catalog-search"
                                placeholder="Cari gaya anime, Live2D, artis..." 
                                class="w-full py-3 pl-3 pr-4 text-xs sm:text-sm text-slate-dark placeholder-slate-400 bg-transparent focus:outline-none"
                            />
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-2.5 overflow-x-auto pb-2 pt-6 hide-scrollbar">
                    <button type="button" class="category-pill shrink-0 flex items-center gap-2 px-4 py-2 rounded-xl bg-pastel-200 text-slate-dark border border-pastel-300 font-bold text-xs font-heading shadow-xs transition hover:bg-pastel-300">
                        <i class="fa-solid fa-fire text-amber-600 text-xs"></i>
                        <span>Semua Kategori</span>
                    </button>
                    <button type="button" class="category-pill shrink-0 flex items-center gap-2 px-4 py-2 rounded-xl bg-white text-slate-body border border-stone-200 hover:border-pastel-400 hover:bg-pastel-50 font-medium text-xs font-heading transition">
                        <i class="fa-solid fa-paint-brush text-rose-500 text-xs"></i>
                        <span>Ilustrasi &amp; OC</span>
                    </button>
                    <button type="button" class="category-pill shrink-0 flex items-center gap-2 px-4 py-2 rounded-xl bg-white text-slate-body border border-stone-200 hover:border-pastel-400 hover:bg-pastel-50 font-medium text-xs font-heading transition">
                        <i class="fa-solid fa-user-astronaut text-purple-600 text-xs"></i>
                        <span>Model Live2D Vtuber</span>
                    </button>
                    <button type="button" class="category-pill shrink-0 flex items-center gap-2 px-4 py-2 rounded-xl bg-white text-slate-body border border-stone-200 hover:border-pastel-400 hover:bg-pastel-50 font-medium text-xs font-heading transition">
                        <i class="fa-solid fa-cube text-emerald-600 text-xs"></i>
                        <span>3D Avatar &amp; VRChat</span>
                    </button>
                    <button type="button" class="category-pill shrink-0 flex items-center gap-2 px-4 py-2 rounded-xl bg-white text-slate-body border border-stone-200 hover:border-pastel-400 hover:bg-pastel-50 font-medium text-xs font-heading transition">
                        <i class="fa-solid fa-face-smile-wink text-blue-500 text-xs"></i>
                        <span>Emotes &amp; Badges</span>
                    </button>
                    <button type="button" class="category-pill shrink-0 flex items-center gap-2 px-4 py-2 rounded-xl bg-white text-slate-body border border-stone-200 hover:border-pastel-400 hover:bg-pastel-50 font-medium text-xs font-heading transition">
                        <i class="fa-solid fa-display text-fuchsia-500 text-xs"></i>
                        <span>Overlay Streaming</span>
                    </button>
                    <button type="button" class="category-pill shrink-0 flex items-center gap-2 px-4 py-2 rounded-xl bg-white text-slate-body border border-stone-200 hover:border-pastel-400 hover:bg-pastel-50 font-medium text-xs font-heading transition">
                        <i class="fa-solid fa-book-open text-amber-500 text-xs"></i>
                        <span>Cover Musik &amp; Buku</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <aside class="lg:col-span-3 bg-white rounded-2xl border border-stone-200/90 shadow-xs p-5 lg:sticky lg:top-24 space-y-6">
                    <div class="flex items-center justify-between pb-3 border-b border-stone-100">
                        <h3 class="text-sm font-bold font-heading text-slate-dark flex items-center gap-2">
                            <i class="fa-solid fa-filter text-amber-500 text-xs"></i>
                            <span>Filter Pencarian</span>
                        </h3>
                        <button type="button" onclick="resetFilters()" class="text-[11px] font-semibold text-slate-muted hover:text-amber-700 transition">
                            Atur Ulang
                        </button>
                    </div>

                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-dark mb-2.5 font-heading">Status Slot</h4>
                        <label class="flex items-center gap-2.5 cursor-pointer text-xs text-slate-body select-none">
                            <input type="checkbox" id="filter-open-slot" checked class="rounded text-amber-500 focus:ring-amber-400">
                            <span>Hanya yang buka (<strong class="text-emerald-700 font-semibold">Open Slot</strong>)</span>
                        </label>
                    </div>

                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-dark mb-2.5 font-heading">Rentang Harga Dasar</h4>
                        <div class="space-y-2 text-xs text-slate-body">
                            <label class="flex items-center gap-2.5 cursor-pointer select-none">
                                <input type="radio" name="price_range" value="all" checked class="text-amber-500 focus:ring-amber-400">
                                <span>Semua Harga</span>
                            </label>
                            <label class="flex items-center gap-2.5 cursor-pointer select-none">
                                <input type="radio" name="price_range" value="under_300" class="text-amber-500 focus:ring-amber-400">
                                <span>Di bawah Rp 300.000</span>
                            </label>
                            <label class="flex items-center gap-2.5 cursor-pointer select-none">
                                <input type="radio" name="price_range" value="300_700" class="text-amber-500 focus:ring-amber-400">
                                <span>Rp 300.000 - Rp 700.000</span>
                            </label>
                            <label class="flex items-center gap-2.5 cursor-pointer select-none">
                                <input type="radio" name="price_range" value="above_700" class="text-amber-500 focus:ring-amber-400">
                                <span>Di atas Rp 700.000</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-dark mb-2.5 font-heading">Estimasi Waktu</h4>
                        <div class="space-y-2 text-xs text-slate-body">
                            <label class="flex items-center gap-2.5 cursor-pointer select-none">
                                <input type="checkbox" class="rounded text-amber-500 focus:ring-amber-400">
                                <span>Pengerjaan Cepat (&lt; 3 Hari)</span>
                            </label>
                            <label class="flex items-center gap-2.5 cursor-pointer select-none">
                                <input type="checkbox" class="rounded text-amber-500 focus:ring-amber-400">
                                <span>Standar (3 - 7 Hari)</span>
                            </label>
                            <label class="flex items-center gap-2.5 cursor-pointer select-none">
                                <input type="checkbox" class="rounded text-amber-500 focus:ring-amber-400">
                                <span>Proyek Besar (&gt; 7 Hari)</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-dark mb-2.5 font-heading">Rating Seniman</h4>
                        <div class="space-y-2 text-xs text-slate-body">
                            <label class="flex items-center gap-2.5 cursor-pointer select-none">
                                <input type="checkbox" class="rounded text-amber-500 focus:ring-amber-400">
                                <span class="flex items-center gap-1">
                                    <i class="fa-solid fa-star text-amber-400 text-xs"></i>
                                    <span>Bintang 5.0 Sempurna</span>
                                </span>
                            </label>
                            <label class="flex items-center gap-2.5 cursor-pointer select-none">
                                <input type="checkbox" class="rounded text-amber-500 focus:ring-amber-400">
                                <span class="flex items-center gap-1">
                                    <i class="fa-solid fa-star text-amber-400 text-xs"></i>
                                    <span>Bintang 4.8 ke atas</span>
                                </span>
                            </label>
                        </div>
                    </div>
                </aside>

                <div class="lg:col-span-9 space-y-6">
                    
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-stone-200/80 gap-4">
                        <div class="flex items-center gap-2 text-xs text-slate-muted">
                            <span>Menampilkan <strong class="text-slate-dark font-bold font-heading">12</strong> dari 96 Layanan Komisi Terverifikasi</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="catalog-cards-grid">
                        
                        <article class="bg-white rounded-2xl overflow-hidden border border-stone-200/90 shadow-xs hover:shadow-md transition-all duration-200 flex flex-col group">
                            <a href="{{ route('katalog.detail', ['id' => 1]) }}" class="relative aspect-4/3 bg-stone-100 overflow-hidden block">
                                <img 
                                    src="https://images.unsplash.com/photo-1578632767115-351597cf2477?w=600&auto=format&fit=crop&q=80" 
                                    alt="Bust-up Anime Karakter Fantasy" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                />
                                <span class="absolute top-3 left-3 bg-emerald-600/90 text-white font-bold text-[10px] px-2.5 py-0.5 rounded-full uppercase tracking-wider backdrop-blur-xs font-heading">
                                    Buka Slot
                                </span>
                                <span class="absolute bottom-2 right-2 px-2 py-0.5 rounded bg-black/60 text-white/90 text-[10px] font-sans backdrop-blur-xs">
                                    <i class="fa-solid fa-clock text-[9px] mr-1"></i>5 Hari
                                </span>
                            </a>

                            <div class="p-4 flex flex-col grow justify-between bg-white">
                                <div>
                                    <div class="flex items-center gap-2 mb-2">
                                        <div class="w-6 h-6 rounded-full bg-pastel-300 text-slate-dark font-bold text-[10px] flex items-center justify-center font-heading">
                                            R
                                        </div>
                                        <span class="text-xs font-semibold text-slate-dark truncate">@rafly.art</span>
                                        <i class="fa-solid fa-circle-check text-amber-500 text-[11px]" title="Artis Terverifikasi"></i>
                                    </div>

                                    <h3 class="text-sm font-bold text-slate-dark group-hover:text-amber-700 line-clamp-2 transition-colors font-heading">
                                        <a href="{{ route('katalog.detail', ['id' => 1]) }}">Bust-Up Anime Karakter Fantasy</a>
                                    </h3>

                                    <div class="flex items-center gap-1.5 mt-2 text-xs text-slate-body">
                                        <i class="fa-solid fa-star text-amber-400 text-xs"></i>
                                        <span class="font-bold text-slate-dark">5.0</span>
                                        <span class="text-slate-muted text-[11px]">(52 ulasan)</span>
                                    </div>
                                </div>

                                <div class="pt-3 mt-3 border-t border-stone-100 flex items-center justify-between">
                                    <div>
                                        <span class="text-[10px] text-slate-muted block">Mulai dari</span>
                                        <span class="text-sm font-extrabold text-slate-dark font-heading">Rp 350.000</span>
                                    </div>
                                    <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-800 border border-emerald-200/80 px-2 py-0.5 rounded text-[10px] font-bold">
                                        <i class="fa-solid fa-shield-halved text-[9px]"></i>
                                        DP Rp 175rb
                                    </span>
                                </div>
                            </div>
                        </article>

                        <article class="bg-white rounded-2xl overflow-hidden border border-stone-200/90 shadow-xs hover:shadow-md transition-all duration-200 flex flex-col group">
                            <a href="{{ route('katalog.detail', ['id' => 2]) }}" class="relative aspect-4/3 bg-stone-100 overflow-hidden block">
                                <img 
                                    src="https://images.unsplash.com/photo-1534447677768-be436bb09401?w=600&auto=format&fit=crop&q=80" 
                                    alt="Model Live2D Ready-to-Rig Vtuber" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                />
                                <span class="absolute top-3 left-3 bg-emerald-600/90 text-white font-bold text-[10px] px-2.5 py-0.5 rounded-full uppercase tracking-wider backdrop-blur-xs font-heading">
                                    Buka Slot
                                </span>
                                <span class="absolute bottom-2 right-2 px-2 py-0.5 rounded bg-black/60 text-white/90 text-[10px] font-sans backdrop-blur-xs">
                                    <i class="fa-solid fa-clock text-[9px] mr-1"></i>14 Hari
                                </span>
                            </a>

                            <div class="p-4 flex flex-col grow justify-between bg-white">
                                <div>
                                    <div class="flex items-center gap-2 mb-2">
                                        <div class="w-6 h-6 rounded-full bg-indigo-200 text-indigo-900 font-bold text-[10px] flex items-center justify-center font-heading">
                                            R
                                        </div>
                                        <span class="text-xs font-semibold text-slate-dark truncate">@rafly.art</span>
                                        <i class="fa-solid fa-circle-check text-amber-500 text-[11px]" title="Artis Terverifikasi"></i>
                                    </div>

                                    <h3 class="text-sm font-bold text-slate-dark group-hover:text-amber-700 line-clamp-2 transition-colors font-heading">
                                        <a href="{{ route('katalog.detail', ['id' => 2]) }}">Model Live2D Vtuber</a>
                                    </h3>

                                    <div class="flex items-center gap-1.5 mt-2 text-xs text-slate-body">
                                        <i class="fa-solid fa-star text-amber-400 text-xs"></i>
                                        <span class="font-bold text-slate-dark">4.9</span>
                                        <span class="text-slate-muted text-[11px]">(28 ulasan)</span>
                                    </div>
                                </div>

                                <div class="pt-3 mt-3 border-t border-stone-100 flex items-center justify-between">
                                    <div>
                                        <span class="text-[10px] text-slate-muted block">Mulai dari</span>
                                        <span class="text-sm font-extrabold text-slate-dark font-heading">Rp 1.750.000</span>
                                    </div>
                                    <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-800 border border-emerald-200/80 px-2 py-0.5 rounded text-[10px] font-bold">
                                        <i class="fa-solid fa-shield-halved text-[9px]"></i>
                                        DP Rp 875rb
                                    </span>
                                </div>
                            </div>
                        </article>

                        <article class="bg-white rounded-2xl overflow-hidden border border-stone-200/90 shadow-xs hover:shadow-md transition-all duration-200 flex flex-col group">
                            <a href="{{ route('katalog.detail', ['id' => 3]) }}" class="relative aspect-4/3 bg-stone-100 overflow-hidden block">
                                <img 
                                    src="https://images.unsplash.com/photo-1563089145-599997674d42?w=600&auto=format&fit=crop&q=80" 
                                    alt="Paket Emote Chibi Twitch" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                />
                                <span class="absolute top-3 left-3 bg-emerald-600/90 text-white font-bold text-[10px] px-2.5 py-0.5 rounded-full uppercase tracking-wider backdrop-blur-xs font-heading">
                                    Buka Slot
                                </span>
                                <span class="absolute bottom-2 right-2 px-2 py-0.5 rounded bg-black/60 text-white/90 text-[10px] font-sans backdrop-blur-xs">
                                    <i class="fa-solid fa-clock text-[9px] mr-1"></i>3 Hari
                                </span>
                            </a>

                            <div class="p-4 flex flex-col grow justify-between bg-white">
                                <div>
                                    <div class="flex items-center gap-2 mb-2">
                                        <div class="w-6 h-6 rounded-full bg-rose-200 text-rose-900 font-bold text-[10px] flex items-center justify-center font-heading">
                                            A
                                        </div>
                                        <span class="text-xs font-semibold text-slate-dark truncate">@annisa.art</span>
                                        <i class="fa-solid fa-circle-check text-amber-500 text-[11px]" title="Artis Terverifikasi"></i>
                                    </div>

                                    <h3 class="text-sm font-bold text-slate-dark group-hover:text-amber-700 line-clamp-2 transition-colors font-heading">
                                        <a href="{{ route('katalog.detail', ['id' => 3]) }}">Paket 5 Emote Chibi Lucu Twitch</a>
                                    </h3>

                                    <div class="flex items-center gap-1.5 mt-2 text-xs text-slate-body">
                                        <i class="fa-solid fa-star text-amber-400 text-xs"></i>
                                        <span class="font-bold text-slate-dark">5.0</span>
                                        <span class="text-slate-muted text-[11px]">(84 ulasan)</span>
                                    </div>
                                </div>

                                <div class="pt-3 mt-3 border-t border-stone-100 flex items-center justify-between">
                                    <div>
                                        <span class="text-[10px] text-slate-muted block">Mulai dari</span>
                                        <span class="text-sm font-extrabold text-slate-dark font-heading">Rp 250.000</span>
                                    </div>
                                    <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-800 border border-emerald-200/80 px-2 py-0.5 rounded text-[10px] font-bold">
                                        <i class="fa-solid fa-shield-halved text-[9px]"></i>
                                        DP Rp 125rb
                                    </span>
                                </div>
                            </div>
                        </article>
                        <article class="bg-white rounded-2xl overflow-hidden border border-stone-200/90 shadow-xs hover:shadow-md transition-all duration-200 flex flex-col group">
                            <a href="{{ route('katalog.detail', ['id' => 3]) }}" class="relative aspect-4/3 bg-stone-100 overflow-hidden block">
                                <img 
                                    src="https://images.unsplash.com/photo-1563089145-599997674d42?w=600&auto=format&fit=crop&q=80" 
                                    alt="Paket Emote Chibi Twitch" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                />
                                <span class="absolute top-3 left-3 bg-emerald-600/90 text-white font-bold text-[10px] px-2.5 py-0.5 rounded-full uppercase tracking-wider backdrop-blur-xs font-heading">
                                    Buka Slot
                                </span>
                                <span class="absolute bottom-2 right-2 px-2 py-0.5 rounded bg-black/60 text-white/90 text-[10px] font-sans backdrop-blur-xs">
                                    <i class="fa-solid fa-clock text-[9px] mr-1"></i>3 Hari
                                </span>
                            </a>

                            <div class="p-4 flex flex-col grow justify-between bg-white">
                                <div>
                                    <div class="flex items-center gap-2 mb-2">
                                        <div class="w-6 h-6 rounded-full bg-rose-200 text-rose-900 font-bold text-[10px] flex items-center justify-center font-heading">
                                            A
                                        </div>
                                        <span class="text-xs font-semibold text-slate-dark truncate">@annisa.art</span>
                                        <i class="fa-solid fa-circle-check text-amber-500 text-[11px]" title="Artis Terverifikasi"></i>
                                    </div>

                                    <h3 class="text-sm font-bold text-slate-dark group-hover:text-amber-700 line-clamp-2 transition-colors font-heading">
                                        <a href="{{ route('katalog.detail', ['id' => 3]) }}">Paket 5 Emote Chibi Lucu Twitch</a>
                                    </h3>

                                    <div class="flex items-center gap-1.5 mt-2 text-xs text-slate-body">
                                        <i class="fa-solid fa-star text-amber-400 text-xs"></i>
                                        <span class="font-bold text-slate-dark">5.0</span>
                                        <span class="text-slate-muted text-[11px]">(84 ulasan)</span>
                                    </div>
                                </div>

                                <div class="pt-3 mt-3 border-t border-stone-100 flex items-center justify-between">
                                    <div>
                                        <span class="text-[10px] text-slate-muted block">Mulai dari</span>
                                        <span class="text-sm font-extrabold text-slate-dark font-heading">Rp 250.000</span>
                                    </div>
                                    <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-800 border border-emerald-200/80 px-2 py-0.5 rounded text-[10px] font-bold">
                                        <i class="fa-solid fa-shield-halved text-[9px]"></i>
                                        DP Rp 125rb
                                    </span>
                                </div>
                            </div>
                        </article>
                        <article class="bg-white rounded-2xl overflow-hidden border border-stone-200/90 shadow-xs hover:shadow-md transition-all duration-200 flex flex-col group">
                            <a href="{{ route('katalog.detail', ['id' => 3]) }}" class="relative aspect-4/3 bg-stone-100 overflow-hidden block">
                                <img 
                                    src="https://images.unsplash.com/photo-1563089145-599997674d42?w=600&auto=format&fit=crop&q=80" 
                                    alt="Paket Emote Chibi Twitch" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                />
                                <span class="absolute top-3 left-3 bg-emerald-600/90 text-white font-bold text-[10px] px-2.5 py-0.5 rounded-full uppercase tracking-wider backdrop-blur-xs font-heading">
                                    Buka Slot
                                </span>
                                <span class="absolute bottom-2 right-2 px-2 py-0.5 rounded bg-black/60 text-white/90 text-[10px] font-sans backdrop-blur-xs">
                                    <i class="fa-solid fa-clock text-[9px] mr-1"></i>3 Hari
                                </span>
                            </a>

                            <div class="p-4 flex flex-col grow justify-between bg-white">
                                <div>
                                    <div class="flex items-center gap-2 mb-2">
                                        <div class="w-6 h-6 rounded-full bg-rose-200 text-rose-900 font-bold text-[10px] flex items-center justify-center font-heading">
                                            A
                                        </div>
                                        <span class="text-xs font-semibold text-slate-dark truncate">@annisa.art</span>
                                        <i class="fa-solid fa-circle-check text-amber-500 text-[11px]" title="Artis Terverifikasi"></i>
                                    </div>

                                    <h3 class="text-sm font-bold text-slate-dark group-hover:text-amber-700 line-clamp-2 transition-colors font-heading">
                                        <a href="{{ route('katalog.detail', ['id' => 3]) }}">Paket 5 Emote Chibi Lucu Twitch</a>
                                    </h3>

                                    <div class="flex items-center gap-1.5 mt-2 text-xs text-slate-body">
                                        <i class="fa-solid fa-star text-amber-400 text-xs"></i>
                                        <span class="font-bold text-slate-dark">5.0</span>
                                        <span class="text-slate-muted text-[11px]">(84 ulasan)</span>
                                    </div>
                                </div>

                                <div class="pt-3 mt-3 border-t border-stone-100 flex items-center justify-between">
                                    <div>
                                        <span class="text-[10px] text-slate-muted block">Mulai dari</span>
                                        <span class="text-sm font-extrabold text-slate-dark font-heading">Rp 250.000</span>
                                    </div>
                                    <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-800 border border-emerald-200/80 px-2 py-0.5 rounded text-[10px] font-bold">
                                        <i class="fa-solid fa-shield-halved text-[9px]"></i>
                                        DP Rp 125rb
                                    </span>
                                </div>
                            </div>
                        </article>
                        <article class="bg-white rounded-2xl overflow-hidden border border-stone-200/90 shadow-xs hover:shadow-md transition-all duration-200 flex flex-col group">
                            <a href="{{ route('katalog.detail', ['id' => 3]) }}" class="relative aspect-4/3 bg-stone-100 overflow-hidden block">
                                <img 
                                    src="https://images.unsplash.com/photo-1563089145-599997674d42?w=600&auto=format&fit=crop&q=80" 
                                    alt="Paket Emote Chibi Twitch" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                />
                                <span class="absolute top-3 left-3 bg-emerald-600/90 text-white font-bold text-[10px] px-2.5 py-0.5 rounded-full uppercase tracking-wider backdrop-blur-xs font-heading">
                                    Buka Slot
                                </span>
                                <span class="absolute bottom-2 right-2 px-2 py-0.5 rounded bg-black/60 text-white/90 text-[10px] font-sans backdrop-blur-xs">
                                    <i class="fa-solid fa-clock text-[9px] mr-1"></i>3 Hari
                                </span>
                            </a>

                            <div class="p-4 flex flex-col grow justify-between bg-white">
                                <div>
                                    <div class="flex items-center gap-2 mb-2">
                                        <div class="w-6 h-6 rounded-full bg-rose-200 text-rose-900 font-bold text-[10px] flex items-center justify-center font-heading">
                                            A
                                        </div>
                                        <span class="text-xs font-semibold text-slate-dark truncate">@annisa.art</span>
                                        <i class="fa-solid fa-circle-check text-amber-500 text-[11px]" title="Artis Terverifikasi"></i>
                                    </div>

                                    <h3 class="text-sm font-bold text-slate-dark group-hover:text-amber-700 line-clamp-2 transition-colors font-heading">
                                        <a href="{{ route('katalog.detail', ['id' => 3]) }}">Paket 5 Emote Chibi Lucu Twitch</a>
                                    </h3>

                                    <div class="flex items-center gap-1.5 mt-2 text-xs text-slate-body">
                                        <i class="fa-solid fa-star text-amber-400 text-xs"></i>
                                        <span class="font-bold text-slate-dark">5.0</span>
                                        <span class="text-slate-muted text-[11px]">(84 ulasan)</span>
                                    </div>
                                </div>

                                <div class="pt-3 mt-3 border-t border-stone-100 flex items-center justify-between">
                                    <div>
                                        <span class="text-[10px] text-slate-muted block">Mulai dari</span>
                                        <span class="text-sm font-extrabold text-slate-dark font-heading">Rp 250.000</span>
                                    </div>
                                    <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-800 border border-emerald-200/80 px-2 py-0.5 rounded text-[10px] font-bold">
                                        <i class="fa-solid fa-shield-halved text-[9px]"></i>
                                        DP Rp 125rb
                                    </span>
                                </div>
                            </div>
                        </article>
                        <article class="bg-white rounded-2xl overflow-hidden border border-stone-200/90 shadow-xs hover:shadow-md transition-all duration-200 flex flex-col group">
                            <a href="{{ route('katalog.detail', ['id' => 3]) }}" class="relative aspect-4/3 bg-stone-100 overflow-hidden block">
                                <img 
                                    src="https://images.unsplash.com/photo-1563089145-599997674d42?w=600&auto=format&fit=crop&q=80" 
                                    alt="Paket Emote Chibi Twitch" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                />
                                <span class="absolute top-3 left-3 bg-emerald-600/90 text-white font-bold text-[10px] px-2.5 py-0.5 rounded-full uppercase tracking-wider backdrop-blur-xs font-heading">
                                    Buka Slot
                                </span>
                                <span class="absolute bottom-2 right-2 px-2 py-0.5 rounded bg-black/60 text-white/90 text-[10px] font-sans backdrop-blur-xs">
                                    <i class="fa-solid fa-clock text-[9px] mr-1"></i>3 Hari
                                </span>
                            </a>

                            <div class="p-4 flex flex-col grow justify-between bg-white">
                                <div>
                                    <div class="flex items-center gap-2 mb-2">
                                        <div class="w-6 h-6 rounded-full bg-rose-200 text-rose-900 font-bold text-[10px] flex items-center justify-center font-heading">
                                            A
                                        </div>
                                        <span class="text-xs font-semibold text-slate-dark truncate">@annisa.art</span>
                                        <i class="fa-solid fa-circle-check text-amber-500 text-[11px]" title="Artis Terverifikasi"></i>
                                    </div>

                                    <h3 class="text-sm font-bold text-slate-dark group-hover:text-amber-700 line-clamp-2 transition-colors font-heading">
                                        <a href="{{ route('katalog.detail', ['id' => 3]) }}">Paket 5 Emote Chibi Lucu Twitch</a>
                                    </h3>

                                    <div class="flex items-center gap-1.5 mt-2 text-xs text-slate-body">
                                        <i class="fa-solid fa-star text-amber-400 text-xs"></i>
                                        <span class="font-bold text-slate-dark">5.0</span>
                                        <span class="text-slate-muted text-[11px]">(84 ulasan)</span>
                                    </div>
                                </div>

                                <div class="pt-3 mt-3 border-t border-stone-100 flex items-center justify-between">
                                    <div>
                                        <span class="text-[10px] text-slate-muted block">Mulai dari</span>
                                        <span class="text-sm font-extrabold text-slate-dark font-heading">Rp 250.000</span>
                                    </div>
                                    <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-800 border border-emerald-200/80 px-2 py-0.5 rounded text-[10px] font-bold">
                                        <i class="fa-solid fa-shield-halved text-[9px]"></i>
                                        DP Rp 125rb
                                    </span>
                                </div>
                            </div>
                        </article>
                        <article class="bg-white rounded-2xl overflow-hidden border border-stone-200/90 shadow-xs hover:shadow-md transition-all duration-200 flex flex-col group">
                            <a href="{{ route('katalog.detail', ['id' => 3]) }}" class="relative aspect-4/3 bg-stone-100 overflow-hidden block">
                                <img 
                                    src="https://images.unsplash.com/photo-1563089145-599997674d42?w=600&auto=format&fit=crop&q=80" 
                                    alt="Paket Emote Chibi Twitch" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                />
                                <span class="absolute top-3 left-3 bg-emerald-600/90 text-white font-bold text-[10px] px-2.5 py-0.5 rounded-full uppercase tracking-wider backdrop-blur-xs font-heading">
                                    Buka Slot
                                </span>
                                <span class="absolute bottom-2 right-2 px-2 py-0.5 rounded bg-black/60 text-white/90 text-[10px] font-sans backdrop-blur-xs">
                                    <i class="fa-solid fa-clock text-[9px] mr-1"></i>3 Hari
                                </span>
                            </a>

                            <div class="p-4 flex flex-col grow justify-between bg-white">
                                <div>
                                    <div class="flex items-center gap-2 mb-2">
                                        <div class="w-6 h-6 rounded-full bg-rose-200 text-rose-900 font-bold text-[10px] flex items-center justify-center font-heading">
                                            A
                                        </div>
                                        <span class="text-xs font-semibold text-slate-dark truncate">@annisa.art</span>
                                        <i class="fa-solid fa-circle-check text-amber-500 text-[11px]" title="Artis Terverifikasi"></i>
                                    </div>

                                    <h3 class="text-sm font-bold text-slate-dark group-hover:text-amber-700 line-clamp-2 transition-colors font-heading">
                                        <a href="{{ route('katalog.detail', ['id' => 3]) }}">Paket 5 Emote Chibi Lucu Twitch</a>
                                    </h3>

                                    <div class="flex items-center gap-1.5 mt-2 text-xs text-slate-body">
                                        <i class="fa-solid fa-star text-amber-400 text-xs"></i>
                                        <span class="font-bold text-slate-dark">5.0</span>
                                        <span class="text-slate-muted text-[11px]">(84 ulasan)</span>
                                    </div>
                                </div>

                                <div class="pt-3 mt-3 border-t border-stone-100 flex items-center justify-between">
                                    <div>
                                        <span class="text-[10px] text-slate-muted block">Mulai dari</span>
                                        <span class="text-sm font-extrabold text-slate-dark font-heading">Rp 250.000</span>
                                    </div>
                                    <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-800 border border-emerald-200/80 px-2 py-0.5 rounded text-[10px] font-bold">
                                        <i class="fa-solid fa-shield-halved text-[9px]"></i>
                                        DP Rp 125rb
                                    </span>
                                </div>
                            </div>
                        </article>
                        <article class="bg-white rounded-2xl overflow-hidden border border-stone-200/90 shadow-xs hover:shadow-md transition-all duration-200 flex flex-col group">
                            <a href="{{ route('katalog.detail', ['id' => 3]) }}" class="relative aspect-4/3 bg-stone-100 overflow-hidden block">
                                <img 
                                    src="https://images.unsplash.com/photo-1563089145-599997674d42?w=600&auto=format&fit=crop&q=80" 
                                    alt="Paket Emote Chibi Twitch" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                />
                                <span class="absolute top-3 left-3 bg-emerald-600/90 text-white font-bold text-[10px] px-2.5 py-0.5 rounded-full uppercase tracking-wider backdrop-blur-xs font-heading">
                                    Buka Slot
                                </span>
                                <span class="absolute bottom-2 right-2 px-2 py-0.5 rounded bg-black/60 text-white/90 text-[10px] font-sans backdrop-blur-xs">
                                    <i class="fa-solid fa-clock text-[9px] mr-1"></i>3 Hari
                                </span>
                            </a>

                            <div class="p-4 flex flex-col grow justify-between bg-white">
                                <div>
                                    <div class="flex items-center gap-2 mb-2">
                                        <div class="w-6 h-6 rounded-full bg-rose-200 text-rose-900 font-bold text-[10px] flex items-center justify-center font-heading">
                                            A
                                        </div>
                                        <span class="text-xs font-semibold text-slate-dark truncate">@annisa.art</span>
                                        <i class="fa-solid fa-circle-check text-amber-500 text-[11px]" title="Artis Terverifikasi"></i>
                                    </div>

                                    <h3 class="text-sm font-bold text-slate-dark group-hover:text-amber-700 line-clamp-2 transition-colors font-heading">
                                        <a href="{{ route('katalog.detail', ['id' => 3]) }}">Paket 5 Emote Chibi Lucu Twitch</a>
                                    </h3>

                                    <div class="flex items-center gap-1.5 mt-2 text-xs text-slate-body">
                                        <i class="fa-solid fa-star text-amber-400 text-xs"></i>
                                        <span class="font-bold text-slate-dark">5.0</span>
                                        <span class="text-slate-muted text-[11px]">(84 ulasan)</span>
                                    </div>
                                </div>

                                <div class="pt-3 mt-3 border-t border-stone-100 flex items-center justify-between">
                                    <div>
                                        <span class="text-[10px] text-slate-muted block">Mulai dari</span>
                                        <span class="text-sm font-extrabold text-slate-dark font-heading">Rp 250.000</span>
                                    </div>
                                    <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-800 border border-emerald-200/80 px-2 py-0.5 rounded text-[10px] font-bold">
                                        <i class="fa-solid fa-shield-halved text-[9px]"></i>
                                        DP Rp 125rb
                                    </span>
                                </div>
                            </div>
                        </article>
                        <article class="bg-white rounded-2xl overflow-hidden border border-stone-200/90 shadow-xs hover:shadow-md transition-all duration-200 flex flex-col group">
                            <a href="{{ route('katalog.detail', ['id' => 3]) }}" class="relative aspect-4/3 bg-stone-100 overflow-hidden block">
                                <img 
                                    src="https://images.unsplash.com/photo-1563089145-599997674d42?w=600&auto=format&fit=crop&q=80" 
                                    alt="Paket Emote Chibi Twitch" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                />
                                <span class="absolute top-3 left-3 bg-emerald-600/90 text-white font-bold text-[10px] px-2.5 py-0.5 rounded-full uppercase tracking-wider backdrop-blur-xs font-heading">
                                    Buka Slot
                                </span>
                                <span class="absolute bottom-2 right-2 px-2 py-0.5 rounded bg-black/60 text-white/90 text-[10px] font-sans backdrop-blur-xs">
                                    <i class="fa-solid fa-clock text-[9px] mr-1"></i>3 Hari
                                </span>
                            </a>

                            <div class="p-4 flex flex-col grow justify-between bg-white">
                                <div>
                                    <div class="flex items-center gap-2 mb-2">
                                        <div class="w-6 h-6 rounded-full bg-rose-200 text-rose-900 font-bold text-[10px] flex items-center justify-center font-heading">
                                            A
                                        </div>
                                        <span class="text-xs font-semibold text-slate-dark truncate">@annisa.art</span>
                                        <i class="fa-solid fa-circle-check text-amber-500 text-[11px]" title="Artis Terverifikasi"></i>
                                    </div>

                                    <h3 class="text-sm font-bold text-slate-dark group-hover:text-amber-700 line-clamp-2 transition-colors font-heading">
                                        <a href="{{ route('katalog.detail', ['id' => 3]) }}">Paket 5 Emote Chibi Lucu Twitch</a>
                                    </h3>

                                    <div class="flex items-center gap-1.5 mt-2 text-xs text-slate-body">
                                        <i class="fa-solid fa-star text-amber-400 text-xs"></i>
                                        <span class="font-bold text-slate-dark">5.0</span>
                                        <span class="text-slate-muted text-[11px]">(84 ulasan)</span>
                                    </div>
                                </div>

                                <div class="pt-3 mt-3 border-t border-stone-100 flex items-center justify-between">
                                    <div>
                                        <span class="text-[10px] text-slate-muted block">Mulai dari</span>
                                        <span class="text-sm font-extrabold text-slate-dark font-heading">Rp 250.000</span>
                                    </div>
                                    <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-800 border border-emerald-200/80 px-2 py-0.5 rounded text-[10px] font-bold">
                                        <i class="fa-solid fa-shield-halved text-[9px]"></i>
                                        DP Rp 125rb
                                    </span>
                                </div>
                            </div>
                        </article>
                        <article class="bg-white rounded-2xl overflow-hidden border border-stone-200/90 shadow-xs hover:shadow-md transition-all duration-200 flex flex-col group">
                            <a href="{{ route('katalog.detail', ['id' => 3]) }}" class="relative aspect-4/3 bg-stone-100 overflow-hidden block">
                                <img 
                                    src="https://images.unsplash.com/photo-1563089145-599997674d42?w=600&auto=format&fit=crop&q=80" 
                                    alt="Paket Emote Chibi Twitch" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                />
                                <span class="absolute top-3 left-3 bg-emerald-600/90 text-white font-bold text-[10px] px-2.5 py-0.5 rounded-full uppercase tracking-wider backdrop-blur-xs font-heading">
                                    Buka Slot
                                </span>
                                <span class="absolute bottom-2 right-2 px-2 py-0.5 rounded bg-black/60 text-white/90 text-[10px] font-sans backdrop-blur-xs">
                                    <i class="fa-solid fa-clock text-[9px] mr-1"></i>3 Hari
                                </span>
                            </a>

                            <div class="p-4 flex flex-col grow justify-between bg-white">
                                <div>
                                    <div class="flex items-center gap-2 mb-2">
                                        <div class="w-6 h-6 rounded-full bg-rose-200 text-rose-900 font-bold text-[10px] flex items-center justify-center font-heading">
                                            A
                                        </div>
                                        <span class="text-xs font-semibold text-slate-dark truncate">@annisa.art</span>
                                        <i class="fa-solid fa-circle-check text-amber-500 text-[11px]" title="Artis Terverifikasi"></i>
                                    </div>

                                    <h3 class="text-sm font-bold text-slate-dark group-hover:text-amber-700 line-clamp-2 transition-colors font-heading">
                                        <a href="{{ route('katalog.detail', ['id' => 3]) }}">Paket 5 Emote Chibi Lucu Twitch</a>
                                    </h3>

                                    <div class="flex items-center gap-1.5 mt-2 text-xs text-slate-body">
                                        <i class="fa-solid fa-star text-amber-400 text-xs"></i>
                                        <span class="font-bold text-slate-dark">5.0</span>
                                        <span class="text-slate-muted text-[11px]">(84 ulasan)</span>
                                    </div>
                                </div>

                                <div class="pt-3 mt-3 border-t border-stone-100 flex items-center justify-between">
                                    <div>
                                        <span class="text-[10px] text-slate-muted block">Mulai dari</span>
                                        <span class="text-sm font-extrabold text-slate-dark font-heading">Rp 250.000</span>
                                    </div>
                                    <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-800 border border-emerald-200/80 px-2 py-0.5 rounded text-[10px] font-bold">
                                        <i class="fa-solid fa-shield-halved text-[9px]"></i>
                                        DP Rp 125rb
                                    </span>
                                </div>
                            </div>
                        </article>
                        <article class="bg-white rounded-2xl overflow-hidden border border-stone-200/90 shadow-xs hover:shadow-md transition-all duration-200 flex flex-col group">
                            <a href="{{ route('katalog.detail', ['id' => 3]) }}" class="relative aspect-4/3 bg-stone-100 overflow-hidden block">
                                <img 
                                    src="https://images.unsplash.com/photo-1563089145-599997674d42?w=600&auto=format&fit=crop&q=80" 
                                    alt="Paket Emote Chibi Twitch" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                />
                                <span class="absolute top-3 left-3 bg-emerald-600/90 text-white font-bold text-[10px] px-2.5 py-0.5 rounded-full uppercase tracking-wider backdrop-blur-xs font-heading">
                                    Buka Slot
                                </span>
                                <span class="absolute bottom-2 right-2 px-2 py-0.5 rounded bg-black/60 text-white/90 text-[10px] font-sans backdrop-blur-xs">
                                    <i class="fa-solid fa-clock text-[9px] mr-1"></i>3 Hari
                                </span>
                            </a>

                            <div class="p-4 flex flex-col grow justify-between bg-white">
                                <div>
                                    <div class="flex items-center gap-2 mb-2">
                                        <div class="w-6 h-6 rounded-full bg-rose-200 text-rose-900 font-bold text-[10px] flex items-center justify-center font-heading">
                                            A
                                        </div>
                                        <span class="text-xs font-semibold text-slate-dark truncate">@annisa.art</span>
                                        <i class="fa-solid fa-circle-check text-amber-500 text-[11px]" title="Artis Terverifikasi"></i>
                                    </div>

                                    <h3 class="text-sm font-bold text-slate-dark group-hover:text-amber-700 line-clamp-2 transition-colors font-heading">
                                        <a href="{{ route('katalog.detail', ['id' => 3]) }}">Paket 5 Emote Chibi Lucu Twitch</a>
                                    </h3>

                                    <div class="flex items-center gap-1.5 mt-2 text-xs text-slate-body">
                                        <i class="fa-solid fa-star text-amber-400 text-xs"></i>
                                        <span class="font-bold text-slate-dark">5.0</span>
                                        <span class="text-slate-muted text-[11px]">(84 ulasan)</span>
                                    </div>
                                </div>

                                <div class="pt-3 mt-3 border-t border-stone-100 flex items-center justify-between">
                                    <div>
                                        <span class="text-[10px] text-slate-muted block">Mulai dari</span>
                                        <span class="text-sm font-extrabold text-slate-dark font-heading">Rp 250.000</span>
                                    </div>
                                    <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-800 border border-emerald-200/80 px-2 py-0.5 rounded text-[10px] font-bold">
                                        <i class="fa-solid fa-shield-halved text-[9px]"></i>
                                        DP Rp 125rb
                                    </span>
                                </div>
                            </div>
                        </article>
                        <article class="bg-white rounded-2xl overflow-hidden border border-stone-200/90 shadow-xs hover:shadow-md transition-all duration-200 flex flex-col group">
                            <a href="{{ route('katalog.detail', ['id' => 3]) }}" class="relative aspect-4/3 bg-stone-100 overflow-hidden block">
                                <img 
                                    src="https://images.unsplash.com/photo-1563089145-599997674d42?w=600&auto=format&fit=crop&q=80" 
                                    alt="Paket Emote Chibi Twitch" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                />
                                <span class="absolute top-3 left-3 bg-emerald-600/90 text-white font-bold text-[10px] px-2.5 py-0.5 rounded-full uppercase tracking-wider backdrop-blur-xs font-heading">
                                    Buka Slot
                                </span>
                                <span class="absolute bottom-2 right-2 px-2 py-0.5 rounded bg-black/60 text-white/90 text-[10px] font-sans backdrop-blur-xs">
                                    <i class="fa-solid fa-clock text-[9px] mr-1"></i>3 Hari
                                </span>
                            </a>

                            <div class="p-4 flex flex-col grow justify-between bg-white">
                                <div>
                                    <div class="flex items-center gap-2 mb-2">
                                        <div class="w-6 h-6 rounded-full bg-rose-200 text-rose-900 font-bold text-[10px] flex items-center justify-center font-heading">
                                            A
                                        </div>
                                        <span class="text-xs font-semibold text-slate-dark truncate">@annisa.art</span>
                                        <i class="fa-solid fa-circle-check text-amber-500 text-[11px]" title="Artis Terverifikasi"></i>
                                    </div>

                                    <h3 class="text-sm font-bold text-slate-dark group-hover:text-amber-700 line-clamp-2 transition-colors font-heading">
                                        <a href="{{ route('katalog.detail', ['id' => 3]) }}">Paket 5 Emote Chibi Lucu Twitch</a>
                                    </h3>

                                    <div class="flex items-center gap-1.5 mt-2 text-xs text-slate-body">
                                        <i class="fa-solid fa-star text-amber-400 text-xs"></i>
                                        <span class="font-bold text-slate-dark">5.0</span>
                                        <span class="text-slate-muted text-[11px]">(84 ulasan)</span>
                                    </div>
                                </div>

                                <div class="pt-3 mt-3 border-t border-stone-100 flex items-center justify-between">
                                    <div>
                                        <span class="text-[10px] text-slate-muted block">Mulai dari</span>
                                        <span class="text-sm font-extrabold text-slate-dark font-heading">Rp 250.000</span>
                                    </div>
                                    <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-800 border border-emerald-200/80 px-2 py-0.5 rounded text-[10px] font-bold">
                                        <i class="fa-solid fa-shield-halved text-[9px]"></i>
                                        DP Rp 125rb
                                    </span>
                                </div>
                            </div>
                        </article>
                        <article class="bg-white rounded-2xl overflow-hidden border border-stone-200/90 shadow-xs hover:shadow-md transition-all duration-200 flex flex-col group">
                            <a href="{{ route('katalog.detail', ['id' => 3]) }}" class="relative aspect-4/3 bg-stone-100 overflow-hidden block">
                                <img 
                                    src="https://images.unsplash.com/photo-1563089145-599997674d42?w=600&auto=format&fit=crop&q=80" 
                                    alt="Paket Emote Chibi Twitch" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                />
                                <span class="absolute top-3 left-3 bg-emerald-600/90 text-white font-bold text-[10px] px-2.5 py-0.5 rounded-full uppercase tracking-wider backdrop-blur-xs font-heading">
                                    Buka Slot
                                </span>
                                <span class="absolute bottom-2 right-2 px-2 py-0.5 rounded bg-black/60 text-white/90 text-[10px] font-sans backdrop-blur-xs">
                                    <i class="fa-solid fa-clock text-[9px] mr-1"></i>3 Hari
                                </span>
                            </a>

                            <div class="p-4 flex flex-col grow justify-between bg-white">
                                <div>
                                    <div class="flex items-center gap-2 mb-2">
                                        <div class="w-6 h-6 rounded-full bg-rose-200 text-rose-900 font-bold text-[10px] flex items-center justify-center font-heading">
                                            A
                                        </div>
                                        <span class="text-xs font-semibold text-slate-dark truncate">@annisa.art</span>
                                        <i class="fa-solid fa-circle-check text-amber-500 text-[11px]" title="Artis Terverifikasi"></i>
                                    </div>

                                    <h3 class="text-sm font-bold text-slate-dark group-hover:text-amber-700 line-clamp-2 transition-colors font-heading">
                                        <a href="{{ route('katalog.detail', ['id' => 3]) }}">Paket 5 Emote Chibi Lucu Twitch</a>
                                    </h3>

                                    <div class="flex items-center gap-1.5 mt-2 text-xs text-slate-body">
                                        <i class="fa-solid fa-star text-amber-400 text-xs"></i>
                                        <span class="font-bold text-slate-dark">5.0</span>
                                        <span class="text-slate-muted text-[11px]">(84 ulasan)</span>
                                    </div>
                                </div>

                                <div class="pt-3 mt-3 border-t border-stone-100 flex items-center justify-between">
                                    <div>
                                        <span class="text-[10px] text-slate-muted block">Mulai dari</span>
                                        <span class="text-sm font-extrabold text-slate-dark font-heading">Rp 250.000</span>
                                    </div>
                                    <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-800 border border-emerald-200/80 px-2 py-0.5 rounded text-[10px] font-bold">
                                        <i class="fa-solid fa-shield-halved text-[9px]"></i>
                                        DP Rp 125rb
                                    </span>
                                </div>
                            </div>
                        </article>
                        <article class="bg-white rounded-2xl overflow-hidden border border-stone-200/90 shadow-xs hover:shadow-md transition-all duration-200 flex flex-col group">
                            <a href="{{ route('katalog.detail', ['id' => 3]) }}" class="relative aspect-4/3 bg-stone-100 overflow-hidden block">
                                <img 
                                    src="https://images.unsplash.com/photo-1563089145-599997674d42?w=600&auto=format&fit=crop&q=80" 
                                    alt="Paket Emote Chibi Twitch" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                />
                                <span class="absolute top-3 left-3 bg-emerald-600/90 text-white font-bold text-[10px] px-2.5 py-0.5 rounded-full uppercase tracking-wider backdrop-blur-xs font-heading">
                                    Buka Slot
                                </span>
                                <span class="absolute bottom-2 right-2 px-2 py-0.5 rounded bg-black/60 text-white/90 text-[10px] font-sans backdrop-blur-xs">
                                    <i class="fa-solid fa-clock text-[9px] mr-1"></i>3 Hari
                                </span>
                            </a>

                            <div class="p-4 flex flex-col grow justify-between bg-white">
                                <div>
                                    <div class="flex items-center gap-2 mb-2">
                                        <div class="w-6 h-6 rounded-full bg-rose-200 text-rose-900 font-bold text-[10px] flex items-center justify-center font-heading">
                                            V
                                        </div>
                                        <span class="text-xs font-semibold text-slate-dark truncate">@viandra.art</span>
                                        <i class="fa-solid fa-circle-check text-amber-500 text-[11px]" title="Artis Terverifikasi"></i>
                                    </div>

                                    <h3 class="text-sm font-bold text-slate-dark group-hover:text-amber-700 line-clamp-2 transition-colors font-heading">
                                        <a href="{{ route('katalog.detail', ['id' => 3]) }}">3D Avatar & VrChat</a>
                                    </h3>

                                    <div class="flex items-center gap-1.5 mt-2 text-xs text-slate-body">
                                        <i class="fa-solid fa-star text-amber-400 text-xs"></i>
                                        <span class="font-bold text-slate-dark">5.0</span>
                                        <span class="text-slate-muted text-[11px]">(12 ulasan)</span>
                                    </div>
                                </div>

                                <div class="pt-3 mt-3 border-t border-stone-100 flex items-center justify-between">
                                    <div>
                                        <span class="text-[10px] text-slate-muted block">Mulai dari</span>
                                        <span class="text-sm font-extrabold text-slate-dark font-heading">Rp 550.000</span>
                                    </div>
                                    <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-800 border border-emerald-200/80 px-2 py-0.5 rounded text-[10px] font-bold">
                                        <i class="fa-solid fa-shield-halved text-[9px]"></i>
                                        DP Rp 270rb
                                    </span>
                                </div>
                            </div>
                        </article>
                    </div>

                    <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-stone-200/80">
                        <span class="text-xs text-slate-muted">Halaman <strong class="text-slate-dark">1</strong> dari 8</span>

                        <div class="flex items-center gap-1.5 text-xs font-heading">
                            <button type="button" disabled class="px-3 py-2 rounded-xl bg-stone-100 text-slate-400 cursor-not-allowed">
                                <i class="fa-solid fa-chevron-left text-[10px] mr-1"></i>
                                <span>Sebelumnya</span>
                            </button>
                            <button type="button" class="w-9 h-9 rounded-xl bg-pastel-200 text-slate-dark font-bold border border-pastel-300 shadow-xs">1</button>
                            <button type="button" class="w-9 h-9 rounded-xl bg-white text-slate-body hover:bg-pastel-100 hover:text-slate-dark border border-stone-200 transition font-medium">2</button>
                            <button type="button" class="w-9 h-9 rounded-xl bg-white text-slate-body hover:bg-pastel-100 hover:text-slate-dark border border-stone-200 transition font-medium">3</button>
                            <span class="px-1 text-slate-400">...</span>
                            <button type="button" class="w-9 h-9 rounded-xl bg-white text-slate-body hover:bg-pastel-100 hover:text-slate-dark border border-stone-200 transition font-medium">8</button>
                            <button type="button" class="px-3 py-2 rounded-xl bg-white text-slate-body hover:bg-pastel-100 hover:text-slate-dark border border-stone-200 transition font-medium shadow-xs">
                                <span>Selanjutnya</span>
                                <i class="fa-solid fa-chevron-right text-[10px] ml-1"></i>
                            </button>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </main>

    <script>
        function resetFilters() {
            const searchInput = document.getElementById('catalog-search');
            if (searchInput) searchInput.value = '';

            const openSlotCheckbox = document.getElementById('filter-open-slot');
            if (openSlotCheckbox) openSlotCheckbox.checked = true;

            const radioAll = document.querySelector('input[name="price_range"][value="all"]');
            if (radioAll) radioAll.checked = true;

            document.querySelectorAll('aside input[type="checkbox"]').forEach(cb => {
                if (cb.id !== 'filter-open-slot') cb.checked = false;
            });
        }

        document.querySelectorAll('.category-pill').forEach(pill => {
            pill.addEventListener('click', function() {
                document.querySelectorAll('.category-pill').forEach(p => {
                    p.classList.remove('bg-pastel-200', 'text-slate-dark', 'border-pastel-300', 'font-bold', 'shadow-xs');
                    p.classList.add('bg-white', 'text-slate-body', 'border-stone-200', 'font-medium');
                });
                this.classList.remove('bg-white', 'text-slate-body', 'border-stone-200', 'font-medium');
                this.classList.add('bg-pastel-200', 'text-slate-dark', 'border-pastel-300', 'font-bold', 'shadow-xs');
            });
        });
    </script>
@endsection

