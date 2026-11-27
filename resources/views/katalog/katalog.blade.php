@extends('layouts.app', ['title' => 'Katalog Komisi Seni Digital - Artsy ID'])

@section('content')
    @include('layouts.header')

    <main class="bg-bg-light min-h-screen text-slate-body font-sans pb-24">
        <div class="bg-linear-to-b from-pastel-100/60 via-stone-50 to-bg-light border-b border-stone-200/60 pt-6 pb-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <nav class="flex items-center gap-2 text-xs text-slate-muted mb-4" aria-label="Breadcrumb">
                    <a href="{{ route('home') }}" class="hover:text-slate-dark transition flex items-center gap-1">
                        <i class="fa-solid fa-house text-[11px]" aria-hidden="true"></i>
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
                            Temukan ilustrator profesional, modeler Live2D, dan kreator terverifikasi di Indonesia dengan perlindungan Escrow.
                        </p>
                    </div>

                    <div class="w-full md:w-80 lg:w-96 shrink-0">
                        <div class="relative flex items-center bg-white rounded-2xl border border-stone-200 shadow-xs focus-within:border-pastel-400 focus-within:ring-2 focus-within:ring-pastel-200 transition pr-1.5">
                            <i class="fa-solid fa-magnifying-glass text-slate-400 text-sm pl-4" aria-hidden="true"></i>
                            <input
                                type="search"
                                id="catalog-search"
                                name="search"
                                form="catalog-filter-form"
                                value="{{ $filters['search'] }}"
                                placeholder="Cari gaya anime, Live2D, artist..."
                                class="w-full py-3 pl-3 pr-2 text-xs sm:text-sm text-slate-dark placeholder-slate-400 bg-transparent focus:outline-none"
                            />
                            <button type="submit" form="catalog-filter-form"
                                class="min-h-11 sm:min-h-9 px-3.5 py-1.5 rounded-xl bg-pastel-200 hover:bg-pastel-300 text-slate-dark font-bold text-xs font-heading transition cursor-pointer shrink-0">
                                Cari
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-2.5 overflow-x-auto pb-2 pt-6 hide-scrollbar">
                    @foreach ($categories as $cat)
                        <a href="{{ $cat['url'] }}"
                            class="shrink-0 flex items-center gap-2 px-4 py-2 rounded-xl border text-xs font-heading transition {{ $cat['active'] ? 'bg-pastel-200 text-slate-dark border-pastel-300 font-bold shadow-xs hover:bg-pastel-300' : 'bg-white text-slate-body border-stone-200 hover:border-pastel-400 hover:bg-pastel-50 font-medium' }}">
                            <i class="fa-solid {{ match($cat['slug']) { '' => 'fa-fire text-amber-600', 'ilustrasi-karakter' => 'fa-paint-brush text-rose-500', 'avatar-chibi-2d' => 'fa-face-smile-wink text-blue-500', 'model-live2d-vtuber' => 'fa-user-astronaut text-purple-600', 'emote-badge' => 'fa-icons text-emerald-600', default => 'fa-palette text-amber-500' } }} text-xs" aria-hidden="true"></i>
                            <span>{{ $cat['name'] }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

                <aside class="lg:col-span-3 bg-white rounded-2xl border border-stone-200/90 shadow-xs p-5 lg:sticky lg:top-24">
                    <form id="catalog-filter-form" action="{{ route('katalog') }}" method="GET" class="space-y-6">
                        @if ($filters['category'] !== '')
                            <input type="hidden" name="category" value="{{ $filters['category'] }}">
                        @endif

                        <div class="flex items-center justify-between pb-3 border-b border-stone-100">
                            <h2 class="text-sm font-bold font-heading text-slate-dark flex items-center gap-2">
                                <i class="fa-solid fa-filter text-amber-500 text-xs" aria-hidden="true"></i>
                                <span>Filter Pencarian</span>
                            </h2>
                            @if ($hasActiveFilters)
                                <a href="{{ route('katalog') }}" class="text-[11px] font-semibold text-slate-muted hover:text-amber-700 transition">
                                    Atur Ulang
                                </a>
                            @endif
                        </div>

                        <div>
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-dark mb-2.5 font-heading">Status Slot</h3>
                            <label class="flex items-center gap-2.5 cursor-pointer text-xs text-slate-body select-none">
                                <input type="checkbox" id="filter-open-slot" name="open_slot" value="1"
                                    {{ $filters['open_slot'] ? 'checked' : '' }}
                                    class="rounded accent-amber-500 focus:ring-amber-400 cursor-pointer">
                                <span>Hanya yang buka (<strong class="text-emerald-700 font-semibold">Open Slot</strong>)</span>
                            </label>
                        </div>

                        <div>
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-dark mb-2.5 font-heading">Rentang Harga Dasar</h3>
                            <div class="space-y-2 text-xs text-slate-body">
                                <label class="flex items-center gap-2.5 cursor-pointer select-none">
                                    <input type="radio" name="price_range" value="all"
                                        {{ $filters['price_range'] === 'all' ? 'checked' : '' }}
                                        class="accent-amber-500 focus:ring-amber-400 cursor-pointer">
                                    <span>Semua Harga</span>
                                </label>
                                <label class="flex items-center gap-2.5 cursor-pointer select-none">
                                    <input type="radio" name="price_range" value="under_300"
                                        {{ $filters['price_range'] === 'under_300' ? 'checked' : '' }}
                                        class="accent-amber-500 focus:ring-amber-400 cursor-pointer">
                                    <span>Di bawah Rp 300.000</span>
                                </label>
                                <label class="flex items-center gap-2.5 cursor-pointer select-none">
                                    <input type="radio" name="price_range" value="300_700"
                                        {{ $filters['price_range'] === '300_700' ? 'checked' : '' }}
                                        class="accent-amber-500 focus:ring-amber-400 cursor-pointer">
                                    <span>Rp 300.000 - Rp 700.000</span>
                                </label>
                                <label class="flex items-center gap-2.5 cursor-pointer select-none">
                                    <input type="radio" name="price_range" value="above_700"
                                        {{ $filters['price_range'] === 'above_700' ? 'checked' : '' }}
                                        class="accent-amber-500 focus:ring-amber-400 cursor-pointer">
                                    <span>Di atas Rp 700.000</span>
                                </label>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-dark mb-2.5 font-heading">Estimasi Waktu</h3>
                            <div class="space-y-2 text-xs text-slate-body">
                                <label class="flex items-center gap-2.5 cursor-pointer select-none">
                                    <input type="checkbox" name="duration[]" value="fast"
                                        {{ in_array('fast', $filters['durations'], true) ? 'checked' : '' }}
                                        class="rounded accent-amber-500 focus:ring-amber-400 cursor-pointer">
                                    <span>Pengerjaan Cepat (&lt; 3 Hari)</span>
                                </label>
                                <label class="flex items-center gap-2.5 cursor-pointer select-none">
                                    <input type="checkbox" name="duration[]" value="standard"
                                        {{ in_array('standard', $filters['durations'], true) ? 'checked' : '' }}
                                        class="rounded accent-amber-500 focus:ring-amber-400 cursor-pointer">
                                    <span>Standar (3 - 7 Hari)</span>
                                </label>
                                <label class="flex items-center gap-2.5 cursor-pointer select-none">
                                    <input type="checkbox" name="duration[]" value="large"
                                        {{ in_array('large', $filters['durations'], true) ? 'checked' : '' }}
                                        class="rounded accent-amber-500 focus:ring-amber-400 cursor-pointer">
                                    <span>Proyek Besar (&gt; 7 Hari)</span>
                                </label>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-dark mb-2.5 font-heading">Rating Layanan</h3>
                            <div class="space-y-2 text-xs text-slate-body">
                                <label class="flex items-center gap-2.5 cursor-pointer select-none">
                                    <input type="radio" name="rating" value="all"
                                        {{ $filters['rating'] === 'all' ? 'checked' : '' }}
                                        class="accent-amber-500 focus:ring-amber-400 cursor-pointer">
                                    <span>Semua Rating</span>
                                </label>
                                <label class="flex items-center gap-2.5 cursor-pointer select-none">
                                    <input type="radio" name="rating" value="5"
                                        {{ $filters['rating'] === '5' ? 'checked' : '' }}
                                        class="accent-amber-500 focus:ring-amber-400 cursor-pointer">
                                    <span class="flex items-center gap-1">
                                        <i class="fa-solid fa-star text-amber-400 text-xs" aria-hidden="true"></i>
                                        <span>Bintang 5.0 Sempurna</span>
                                    </span>
                                </label>
                                <label class="flex items-center gap-2.5 cursor-pointer select-none">
                                    <input type="radio" name="rating" value="4_8"
                                        {{ $filters['rating'] === '4_8' ? 'checked' : '' }}
                                        class="accent-amber-500 focus:ring-amber-400 cursor-pointer">
                                    <span class="flex items-center gap-1">
                                        <i class="fa-solid fa-star text-amber-400 text-xs" aria-hidden="true"></i>
                                        <span>Bintang 4.8 ke atas</span>
                                    </span>
                                </label>
                            </div>
                        </div>

                        <div class="pt-2 flex flex-col gap-2">
                            <button type="submit" class="btn-primary w-full min-h-11 sm:min-h-0 text-xs cursor-pointer">
                                Terapkan Filter
                            </button>
                        </div>
                    </form>
                </aside>

                <div class="lg:col-span-9 space-y-6">

                    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-stone-200/80 gap-4">
                        <div class="flex items-center gap-2 text-xs text-slate-muted">
                            <span>
                                Menampilkan <strong class="text-slate-dark font-bold font-heading tabular-nums">{{ $pagination['showing_count'] }}</strong> dari
                                <strong class="text-slate-dark font-bold font-heading tabular-nums">{{ $pagination['total'] }}</strong> Layanan Komisi Terverifikasi
                            </span>
                        </div>

                        <div class="flex items-center gap-2.5">
                            <label for="catalog-sort" class="text-xs text-slate-muted font-medium">Urutkan:</label>
                            <select id="catalog-sort" name="sort" form="catalog-filter-form" onchange="this.form.submit()"
                                class="text-xs font-semibold text-slate-dark bg-white border border-stone-200 rounded-xl py-2 px-3 focus:outline-none focus:ring-1 focus:ring-pastel-300 cursor-pointer">
                                @foreach ($sortOptions as $opt)
                                    <option value="{{ $opt['value'] }}" {{ $opt['selected'] ? 'selected' : '' }}>{{ $opt['label'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="catalog-cards-grid">
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
                            <div class="col-span-full bg-white rounded-2xl border border-stone-200/90 p-10 text-center space-y-3">
                                <div class="w-14 h-14 rounded-2xl bg-pastel-100 border border-pastel-300 text-amber-900 flex items-center justify-center mx-auto text-xl">
                                    <i class="fa-solid fa-filter-circle-xmark" aria-hidden="true"></i>
                                </div>
                                <h3 class="text-base font-bold font-heading text-slate-dark">
                                    Tidak Ada Paket Komisi yang Cocok
                                </h3>
                                <p class="text-xs sm:text-sm text-slate-muted max-w-md mx-auto">
                                    Coba ubah kata kunci pencarian, rentang harga, atau filter lainnya untuk menemukan artist yang sesuai.
                                </p>
                                <div class="pt-2">
                                    <a href="{{ route('katalog') }}" class="btn-secondary min-h-11 sm:min-h-0 text-xs cursor-pointer">
                                        Atur Ulang Filter
                                    </a>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    @if ($pagination['has_pages'])
                        <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-stone-200/80">
                            <span class="text-xs text-slate-muted">
                                Halaman <strong class="text-slate-dark tabular-nums">{{ $pagination['current_page'] }}</strong> dari {{ $pagination['last_page'] }}
                            </span>

                            <div class="flex flex-wrap items-center gap-1.5 text-xs font-heading">
                                @if ($pagination['prev_url'])
                                    <a href="{{ $pagination['prev_url'] }}" class="min-h-11 sm:min-h-9 px-3 py-2 rounded-xl bg-white text-slate-body hover:bg-pastel-100 hover:text-slate-dark border border-stone-200 transition font-medium shadow-xs inline-flex items-center gap-1">
                                        <i class="fa-solid fa-chevron-left text-[10px]" aria-hidden="true"></i>
                                        <span>Sebelumnya</span>
                                    </a>
                                @else
                                    <span class="min-h-11 sm:min-h-9 px-3 py-2 rounded-xl bg-stone-100 text-slate-400 cursor-not-allowed inline-flex items-center gap-1">
                                        <i class="fa-solid fa-chevron-left text-[10px]" aria-hidden="true"></i>
                                        <span>Sebelumnya</span>
                                    </span>
                                @endif

                                @foreach ($pagination['pages'] as $pageItem)
                                    @if (($pageItem['type'] ?? 'page') === 'ellipsis')
                                        <span aria-hidden="true" class="min-w-11 min-h-11 sm:min-w-9 sm:min-h-9 inline-flex items-center justify-center text-slate-muted select-none">...</span>
                                    @elseif ($pageItem['active'])
                                        <span aria-current="page" class="min-w-11 min-h-11 sm:min-w-9 sm:min-h-9 rounded-xl bg-pastel-200 text-slate-dark font-bold border border-pastel-300 shadow-xs inline-flex items-center justify-center tabular-nums">{{ $pageItem['number'] }}</span>
                                    @else
                                        <a href="{{ $pageItem['url'] }}" class="min-w-11 min-h-11 sm:min-w-9 sm:min-h-9 rounded-xl bg-white text-slate-body hover:bg-pastel-100 hover:text-slate-dark border border-stone-200 transition font-medium inline-flex items-center justify-center tabular-nums">{{ $pageItem['number'] }}</a>
                                    @endif
                                @endforeach

                                @if ($pagination['next_url'])
                                    <a href="{{ $pagination['next_url'] }}" class="min-h-11 sm:min-h-9 px-3 py-2 rounded-xl bg-white text-slate-body hover:bg-pastel-100 hover:text-slate-dark border border-stone-200 transition font-medium shadow-xs inline-flex items-center gap-1">
                                        <span>Selanjutnya</span>
                                        <i class="fa-solid fa-chevron-right text-[10px]" aria-hidden="true"></i>
                                    </a>
                                @else
                                    <span class="min-h-11 sm:min-h-9 px-3 py-2 rounded-xl bg-stone-100 text-slate-400 cursor-not-allowed inline-flex items-center gap-1">
                                        <span>Selanjutnya</span>
                                        <i class="fa-solid fa-chevron-right text-[10px]" aria-hidden="true"></i>
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif

                </div>

            </div>
        </div>
    </main>

    @include('layouts.footer')
@endsection
