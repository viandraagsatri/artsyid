@extends('layouts.app', ['title' => $detail['title'] . ' - Katalog Artsy ID'])

@section('content')
    @include('layouts.header')

    <main class="bg-bg-light min-h-screen text-slate-body font-sans pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 pb-4">
            <nav class="flex items-center gap-2 text-xs text-slate-muted flex-wrap" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-slate-dark transition flex items-center gap-1">
                    <i class="fa-solid fa-house text-[11px]" aria-hidden="true"></i>
                    <span>Beranda</span>
                </a>
                <span class="text-stone-300">/</span>
                <a href="{{ route('katalog') }}" class="hover:text-slate-dark transition">Katalog Komisi</a>
                <span class="text-stone-300">/</span>
                <a href="{{ $detail['category_url'] }}" class="hover:text-slate-dark transition">{{ $detail['category_name'] }}</a>
                <span class="text-stone-300">/</span>
                <span class="font-medium text-slate-dark truncate max-w-56 sm:max-w-xs">{{ $detail['title'] }}</span>
            </nav>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                <div class="lg:col-span-8 flex flex-col gap-8">
                    <!-- Galeri Sampel -->
                    <div class="bg-white rounded-2xl border border-stone-200/90 shadow-xs p-4 sm:p-6 overflow-hidden">
                        <div class="relative aspect-16/10 sm:aspect-video bg-stone-100 rounded-xl overflow-hidden border border-stone-100 flex items-center justify-center">
                            @if (count($samples) > 0)
                                <img id="main-preview-img"
                                    src="{{ $samples[0]['url'] }}"
                                    alt="{{ $detail['title'] }}"
                                    class="w-full h-full object-cover transition-all duration-300" />
                            @else
                                <div class="text-center p-6 space-y-2 text-slate-muted">
                                    <i class="fa-regular fa-image text-3xl" aria-hidden="true"></i>
                                    <p class="text-xs font-medium">Artist belum menambahkan gambar sampel untuk paket ini.</p>
                                </div>
                            @endif

                            <div class="absolute top-3 left-3 flex flex-wrap gap-2">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-dark/85 backdrop-blur-xs text-white text-[11px] font-bold">
                                    <i class="fa-solid fa-palette text-amber-400" aria-hidden="true"></i>
                                    {{ $detail['category_name'] }}
                                </span>
                            </div>

                            <div class="absolute bottom-3 right-3">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-dark/75 backdrop-blur-xs text-stone-100 text-[11px]">
                                    <i class="fa-solid fa-shield-halved text-amber-400" aria-hidden="true"></i>
                                    Escrow &amp; Watermark Protected
                                </span>
                            </div>
                        </div>

                        @if (count($samples) > 1)
                            <div class="flex items-center gap-3 mt-4 overflow-x-auto pb-2 pt-1 hide-scrollbar">
                                @foreach ($samples as $sample)
                                    <button type="button"
                                        data-image-url="{{ $sample['url'] }}"
                                        class="thumb-btn shrink-0 w-20 h-16 rounded-lg overflow-hidden transition cursor-pointer {{ $sample['is_first'] ? 'border-2 border-amber-500 ring-2 ring-amber-500/20 opacity-100' : 'border border-stone-200 hover:border-amber-400 opacity-70 hover:opacity-100' }}">
                                        <img src="{{ $sample['url'] }}"
                                            class="w-full h-full object-cover" alt="{{ $sample['alt'] }}">
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Informasi Judul & Profil Artist -->
                    <div class="bg-white rounded-2xl border border-stone-200/90 shadow-xs p-6">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-stone-100">
                            <div>
                                <h1 class="text-xl sm:text-2xl font-black font-heading text-slate-dark tracking-tight">
                                    {{ $detail['title'] }}
                                </h1>
                                <div class="flex flex-wrap items-center gap-3 mt-2 text-xs text-slate-muted">
                                    <div class="flex items-center gap-1 text-slate-dark font-medium">
                                        @if ($detail['avg_rating_formatted'] !== null)
                                            <i class="fa-solid fa-star text-amber-400 text-xs" aria-hidden="true"></i>
                                            <span class="font-bold text-slate-dark">{{ $detail['avg_rating_formatted'] }}</span>
                                            <span>({{ $detail['reviews_count'] }} ulasan pembeli)</span>
                                        @else
                                            <i class="fa-regular fa-star text-slate-400 text-xs" aria-hidden="true"></i>
                                            <span>Belum ada ulasan</span>
                                        @endif
                                    </div>
                                    <span class="text-stone-300">•</span>
                                    <span>Kategori: <strong class="text-slate-dark">{{ $detail['category_name'] }}</strong></span>
                                    <span class="text-stone-300">•</span>
                                    <span>Tipe: <strong class="text-slate-dark">{{ $detail['request_type_label'] }}</strong></span>
                                </div>
                            </div>
                        </div>

                        <div class="pt-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div class="flex items-center gap-3.5 min-w-0">
                                <div class="relative shrink-0">
                                    @if ($detail['artist_avatar_url'])
                                        <img src="{{ $detail['artist_avatar_url'] }}" alt="{{ $detail['artist_name'] }}"
                                            class="w-12 h-12 rounded-full object-cover border-2 border-white shadow-xs ring-2 ring-pastel-200">
                                    @else
                                        <div class="w-12 h-12 rounded-full bg-pastel-300 text-slate-dark font-bold text-base flex items-center justify-center font-heading border-2 border-white shadow-xs">
                                            {{ $detail['artist_initial'] }}
                                        </div>
                                    @endif
                                    <i class="fa-solid fa-circle-check text-amber-500 text-sm absolute -bottom-0.5 -right-0.5 bg-white rounded-full ring-2 ring-white"
                                        title="Kreator Terverifikasi"></i>
                                </div>
                                <div class="min-w-0">
                                    <div class="flex items-center gap-2">
                                        <h2 class="text-sm font-bold font-heading text-slate-dark truncate">{{ $detail['artist_name'] }}</h2>
                                    </div>
                                    <p class="text-xs text-slate-muted line-clamp-2 mt-0.5">
                                        {{ $detail['artist_bio'] }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 shrink-0">
                                <div class="sm:text-right sm:border-l sm:border-stone-100 sm:pl-4">
                                    <span class="text-[10px] text-slate-muted uppercase font-heading block">Slot Paket</span>
                                    <span class="text-xs font-bold {{ $detail['is_open_slot'] ? 'text-status-success-text' : 'text-amber-800' }}">
                                        {{ $detail['is_open_slot'] ? $detail['available_slots'] . ' Tersedia' : 'Penuh (0)' }}
                                    </span>
                                </div>
                                <div class="sm:text-right border-l border-stone-100 pl-4">
                                    <span class="text-[10px] text-slate-muted uppercase font-heading block">Pesanan Selesai</span>
                                    <span class="text-xs font-bold text-slate-dark tabular-nums">{{ $detail['artist_completed_orders'] }} Selesai</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 4 Kartu Spesifikasi Paket -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        <div class="bg-white p-4 rounded-xl border border-stone-200/90 shadow-xs flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-clock text-sm" aria-hidden="true"></i>
                            </div>
                            <div>
                                <span class="text-[10px] text-slate-muted uppercase font-heading block">Estimasi</span>
                                <span class="text-xs font-bold text-slate-dark font-heading">{{ $detail['estimated_days'] }} Hari Kerja</span>
                            </div>
                        </div>

                        <div class="bg-white p-4 rounded-xl border border-stone-200/90 shadow-xs flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-arrows-rotate text-sm" aria-hidden="true"></i>
                            </div>
                            <div>
                                <span class="text-[10px] text-slate-muted uppercase font-heading block">Batas Revisi</span>
                                <span class="text-xs font-bold text-slate-dark font-heading">{{ $detail['max_revision'] }}x Total</span>
                            </div>
                        </div>

                        <div class="bg-white p-4 rounded-xl border border-stone-200/90 shadow-xs flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-sky-100 text-sky-800 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-ticket text-sm" aria-hidden="true"></i>
                            </div>
                            <div>
                                <span class="text-[10px] text-slate-muted uppercase font-heading block">Kapasitas</span>
                                <span class="text-xs font-bold text-slate-dark font-heading">{{ $detail['is_open_slot'] ? $detail['available_slots'] . ' Slot Buka' : 'Slot Penuh' }}</span>
                            </div>
                        </div>

                        <div class="bg-white p-4 rounded-xl border border-stone-200/90 shadow-xs flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-800 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-shield-halved text-sm" aria-hidden="true"></i>
                            </div>
                            <div>
                                <span class="text-[10px] text-slate-muted uppercase font-heading block">Skema DP</span>
                                <span class="text-xs font-bold text-slate-dark font-heading">{{ $detail['dp_percentage'] }}% Escrow</span>
                            </div>
                        </div>
                    </div>

                    <!-- Tab Deskripsi, ToS & Ulasan -->
                    <div class="bg-white rounded-2xl border border-stone-200/90 shadow-xs overflow-hidden">
                        <div role="tablist" aria-label="Informasi Detail Layanan" class="flex flex-wrap border-b border-stone-200 bg-stone-50/60 text-xs sm:text-sm font-heading">
                            <button type="button" id="tab-deskripsi-btn" data-tab-target="deskripsi"
                                role="tab" aria-selected="true" aria-controls="tab-deskripsi"
                                class="tab-btn min-h-11 px-5 sm:px-6 py-3.5 font-bold border-b-2 border-slate-dark text-slate-dark bg-white transition cursor-pointer">
                                Deskripsi Layanan
                            </button>
                            <button type="button" id="tab-tos-btn" data-tab-target="tos"
                                role="tab" aria-selected="false" aria-controls="tab-tos"
                                class="tab-btn min-h-11 px-5 sm:px-6 py-3.5 font-medium border-b-2 border-transparent text-slate-muted hover:text-slate-dark transition cursor-pointer">
                                Syarat &amp; Ketentuan (ToS)
                            </button>
                            <button type="button" id="tab-ulasan-btn" data-tab-target="ulasan"
                                role="tab" aria-selected="false" aria-controls="tab-ulasan"
                                class="tab-btn min-h-11 px-5 sm:px-6 py-3.5 font-medium border-b-2 border-transparent text-slate-muted hover:text-slate-dark transition cursor-pointer">
                                Ulasan Pembeli ({{ $detail['reviews_count'] }})
                            </button>
                        </div>

                        <div id="tab-deskripsi" role="tabpanel" aria-labelledby="tab-deskripsi-btn" class="p-6 space-y-5">
                            <div>
                                <h3 class="text-sm font-bold font-heading text-slate-dark mb-2">Detail &amp; Ketentuan Paket:</h3>
                                <p class="text-xs sm:text-sm text-slate-body leading-relaxed whitespace-pre-line">{{ $detail['description'] }}</p>
                            </div>

                            <div class="pt-4 border-t border-stone-100">
                                <h3 class="text-sm font-bold font-heading text-slate-dark mb-2">Linimasa Pengerjaan 4 Tahap:</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                                    <div class="p-3 bg-stone-50 rounded-xl border border-stone-200/80">
                                        <span class="font-bold text-slate-dark block font-heading mb-1">1. Tahap Sketsa</span>
                                        <p class="text-slate-muted">Penyusunan pose, ekspresi wajah, dan proporsi dasar karakter sesuai brief Anda.</p>
                                    </div>
                                    <div class="p-3 bg-stone-50 rounded-xl border border-stone-200/80">
                                        <span class="font-bold text-slate-dark block font-heading mb-1">2. Tahap Line Art</span>
                                        <p class="text-slate-muted">Penegasan garis akhir ber-watermark sebelum masuk ke tahap pewarnaan.</p>
                                    </div>
                                    <div class="p-3 bg-stone-50 rounded-xl border border-stone-200/80">
                                        <span class="font-bold text-slate-dark block font-heading mb-1">3. Tahap Pewarnaan</span>
                                        <p class="text-slate-muted">Penentuan palet warna dasar dan bayangan awal sesuai referensi karakter.</p>
                                    </div>
                                    <div class="p-3 bg-stone-50 rounded-xl border border-stone-200/80">
                                        <span class="font-bold text-slate-dark block font-heading mb-1">4. Rendering &amp; Pelunasan</span>
                                        <p class="text-slate-muted">Detail pencahayaan akhir. Setelah disetujui &amp; dilunasi, file bersih terbuka untuk diunduh.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="tab-tos" role="tabpanel" aria-labelledby="tab-tos-btn" class="p-6 space-y-5 hidden">
                            @if (count($tos['can_draw']) > 0 || count($tos['cannot_draw']) > 0)
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <div class="p-4 bg-emerald-50/60 rounded-xl border border-emerald-200/80">
                                        <h3 class="text-xs sm:text-sm font-bold font-heading text-emerald-900 mb-2.5 flex items-center gap-2">
                                            <i class="fa-solid fa-circle-check text-emerald-600" aria-hidden="true"></i>
                                            Bisa Digambar:
                                        </h3>
                                        @if (count($tos['can_draw']) > 0)
                                            <ul class="space-y-1.5 text-xs text-emerald-800">
                                                @foreach ($tos['can_draw'] as $item)
                                                    <li>• {{ $item }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p class="text-xs text-emerald-800">Belum ada rincian spesifik dari artist.</p>
                                        @endif
                                    </div>

                                    <div class="p-4 bg-rose-50/60 rounded-xl border border-rose-200/80">
                                        <h3 class="text-xs sm:text-sm font-bold font-heading text-rose-900 mb-2.5 flex items-center gap-2">
                                            <i class="fa-solid fa-circle-xmark text-rose-600" aria-hidden="true"></i>
                                            Tidak Menerima:
                                        </h3>
                                        @if (count($tos['cannot_draw']) > 0)
                                            <ul class="space-y-1.5 text-xs text-rose-800">
                                                @foreach ($tos['cannot_draw'] as $item)
                                                    <li>• {{ $item }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p class="text-xs text-rose-800">Belum ada pantangan khusus yang dicantumkan artist.</p>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="p-6 text-center bg-stone-50 rounded-xl border border-stone-200/80 text-xs text-slate-muted">
                                    Artist belum mencantumkan daftar Terms of Service (ToS) terstruktur. Silakan baca deskripsi layanan dengan saksama sebelum memesan.
                                </div>
                            @endif
                        </div>

                        <div id="tab-ulasan" role="tabpanel" aria-labelledby="tab-ulasan-btn" class="p-6 space-y-4 hidden">
                            @if ($detail['reviews_count'] > 0 && $detail['avg_rating_formatted'] !== null)
                                <div class="flex items-center gap-6 p-4 bg-stone-50 rounded-xl border border-stone-200/80 mb-6">
                                    <div class="text-center shrink-0">
                                        <span class="text-3xl font-extrabold font-heading text-slate-dark block tabular-nums">{{ $detail['avg_rating_formatted'] }}</span>
                                        <div class="flex items-center justify-center text-amber-400 text-xs mt-1" aria-label="Rating rata-rata {{ $detail['avg_rating_formatted'] }} dari 5">
                                            @foreach ($detail['avg_rating_stars'] as $starState)
                                                @if ($starState === 'full')
                                                    <i class="fa-solid fa-star" aria-hidden="true"></i>
                                                @elseif ($starState === 'half')
                                                    <i class="fa-solid fa-star-half-stroke" aria-hidden="true"></i>
                                                @else
                                                    <i class="fa-regular fa-star text-stone-300" aria-hidden="true"></i>
                                                @endif
                                            @endforeach
                                        </div>
                                        <span class="text-[10px] text-slate-muted mt-1 block tabular-nums">{{ $detail['reviews_count'] }} Ulasan</span>
                                    </div>
                                    <div class="border-l border-stone-200 pl-6 grow text-xs text-slate-muted space-y-1">
                                        <p>• Penilaian terverifikasi dari pembeli yang telah menyelesaikan pelunasan paket ini.</p>
                                        <p>• Total <strong class="text-slate-dark">{{ $detail['completed_orders_count'] }} pesanan</strong> paket ini telah diselesaikan.</p>
                                    </div>
                                </div>

                                @foreach ($reviews as $review)
                                    <div class="pb-4 border-b border-stone-100 last:border-none">
                                        <div class="flex items-center justify-between gap-2 mb-1.5">
                                            <div class="flex items-center gap-2 min-w-0">
                                                @if ($review['client_avatar_url'])
                                                    <img src="{{ $review['client_avatar_url'] }}" alt="{{ $review['client_name'] }}" class="w-7 h-7 rounded-full object-cover shrink-0">
                                                @else
                                                    <div class="w-7 h-7 rounded-full bg-pastel-200 text-slate-dark font-bold text-xs flex items-center justify-center font-heading shrink-0">
                                                        {{ $review['client_initial'] }}
                                                    </div>
                                                @endif
                                                <span class="text-xs font-bold text-slate-dark truncate">{{ $review['client_name'] }}</span>
                                                <span class="text-[10px] text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200 shrink-0">Pembeli Terverifikasi</span>
                                            </div>
                                            <span class="text-[11px] text-slate-muted shrink-0">{{ $review['created_at_label'] }}</span>
                                        </div>
                                        <div class="flex items-center gap-2 mb-1.5">
                                            <div class="flex items-center text-amber-400 text-[11px]" aria-label="Rating {{ $review['rating'] }} dari 5">
                                                @for ($star = 1; $star <= 5; $star++)
                                                    <i class="{{ $star <= $review['rating'] ? 'fa-solid' : 'fa-regular text-stone-300' }} fa-star" aria-hidden="true"></i>
                                                @endfor
                                            </div>
                                            @if ($review['tip_amount'] > 0)
                                                <span class="text-[10px] font-bold text-amber-900 bg-pastel-100 border border-pastel-300 px-2 py-0.5 rounded-full">
                                                    + Tip Rp {{ number_format($review['tip_amount'], 0, ',', '.') }}
                                                </span>
                                            @endif
                                        </div>
                                        @if ($review['comment'] !== '')
                                            <p class="text-xs text-slate-body leading-relaxed">{{ $review['comment'] }}</p>
                                        @endif
                                    </div>
                                @endforeach
                                @if ($detail['has_more_reviews'])
                                    <p class="pt-2 text-center text-[11px] text-slate-muted">
                                        Menampilkan {{ $detail['reviews_shown_count'] }} ulasan terbaru dari total {{ $detail['reviews_count'] }} ulasan pembeli.
                                    </p>
                                @endif
                            @else
                                <div class="p-8 text-center bg-stone-50 rounded-xl border border-stone-200/80 space-y-2">
                                    <i class="fa-regular fa-comment-dots text-2xl text-slate-muted" aria-hidden="true"></i>
                                    <h3 class="text-sm font-bold font-heading text-slate-dark">Belum Ada Ulasan Pembeli</h3>
                                    <p class="text-xs text-slate-muted max-w-md mx-auto">
                                        Ulasan akan tampil secara otomatis setelah pembeli menyelesaikan pesanan pada paket komisi ini.
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar Kanan: Kalkulator Harga & CTA Pemesanan -->
                <div class="lg:col-span-4 sticky top-24 space-y-6">
                    <div class="bg-white rounded-2xl border border-stone-200/90 shadow-sm p-6 flex flex-col justify-between">
                        <div>
                            <div class="flex items-start justify-between pb-4 border-b border-stone-100">
                                <div>
                                    <span class="text-xs text-slate-muted block font-medium">Harga Dasar Layanan</span>
                                    <div class="flex items-baseline gap-1 mt-1">
                                        <span class="text-2xl font-black font-heading text-slate-dark tracking-tight tabular-nums">
                                            Rp {{ number_format($detail['base_price'], 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 p-3 bg-emerald-50/70 rounded-xl border border-emerald-200/80 text-xs text-emerald-900 flex items-start gap-2.5">
                                <i class="fa-solid fa-shield-halved text-emerald-700 text-sm mt-0.5 shrink-0" aria-hidden="true"></i>
                                <div>
                                    <span class="font-bold block font-heading">Escrow Payment (DP {{ $detail['dp_percentage'] }}%)</span>
                                    <span class="text-[11px] text-emerald-800/90">
                                        Anda membayar <strong>DP {{ $detail['dp_percentage'] }}%</strong> saat order diterima. Sisa tagihan dibayar setelah karya akhir disetujui.
                                    </span>
                                </div>
                            </div>

                            <div class="mt-6">
                                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-dark mb-3 font-heading flex items-center justify-between">
                                    <span>Pilih Add-ons Opsional</span>
                                    <span class="text-[10px] font-normal text-slate-muted">Simulasi biaya</span>
                                </h3>

                                @if (count($addons) > 0)
                                    <div class="space-y-2.5" id="addons-container">
                                        @foreach ($addons as $addon)
                                            <label class="addon-item flex items-start gap-3 p-3 rounded-xl border border-stone-200 hover:border-pastel-400 hover:bg-pastel-50/50 cursor-pointer transition select-none">
                                                <input type="checkbox"
                                                    class="addon-checkbox mt-1 rounded accent-amber-500 focus:ring-amber-400 cursor-pointer"
                                                    data-price="{{ $addon['price'] }}">
                                                <div class="grow min-w-0">
                                                    <div class="flex items-center justify-between gap-2">
                                                        <span class="text-xs font-bold text-slate-dark font-heading">{{ $addon['title'] }}</span>
                                                        <span class="text-xs font-bold text-slate-dark font-heading tabular-nums shrink-0">+Rp {{ number_format($addon['price'], 0, ',', '.') }}</span>
                                                    </div>
                                                    @if ($addon['description'] !== '')
                                                        <p class="text-[11px] text-slate-muted mt-0.5">{{ $addon['description'] }}</p>
                                                    @endif
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-xs text-slate-muted p-3 rounded-xl border border-dashed border-stone-200 bg-stone-50">
                                        Paket ini tidak memiliki add-ons opsional tambahan.
                                    </p>
                                @endif
                            </div>

                            <div class="mt-6 pt-5 border-t border-stone-100 space-y-2.5 text-xs">
                                <div class="flex items-center justify-between text-slate-muted">
                                    <span>Harga Dasar Layanan</span>
                                    <span class="font-medium text-slate-dark tabular-nums">Rp {{ number_format($detail['base_price'], 0, ',', '.') }}</span>
                                </div>
                                <div class="flex items-center justify-between text-slate-muted">
                                    <span>Tambahan Add-ons</span>
                                    <span class="font-medium text-slate-dark tabular-nums" id="calc-addons">Rp 0</span>
                                </div>
                                <div class="flex items-center justify-between pt-2 border-t border-dashed border-stone-200 text-sm">
                                    <span class="font-bold text-slate-dark font-heading">Total Biaya Komisi</span>
                                    <span class="font-extrabold text-slate-dark font-heading tabular-nums" id="calc-total">Rp {{ number_format($detail['base_price'], 0, ',', '.') }}</span>
                                </div>

                                <div class="p-3 bg-pastel-100 rounded-xl border border-pastel-300 mt-3 flex items-center justify-between gap-2">
                                    <div>
                                        <span class="text-[10px] uppercase font-bold text-amber-900 font-heading block">
                                            Tagihan DP {{ $detail['dp_percentage'] }}% di Awal
                                        </span>
                                    </div>
                                    <span class="text-base font-black font-heading text-slate-dark tabular-nums" id="calc-dp">
                                        Rp {{ number_format($detail['initial_dp_amount'], 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t border-stone-100 flex flex-col gap-2.5">
                            @if ($cta['mode'] === 'link')
                                <a href="{{ $cta['url'] }}"
                                    class="w-full min-h-11 py-3.5 px-4 rounded-xl bg-pastel-200 hover:bg-pastel-300 border border-pastel-300 text-slate-dark font-bold text-xs sm:text-sm font-heading shadow-xs hover:shadow-sm transition flex items-center justify-center gap-2 text-center">
                                    <i class="fa-solid fa-paper-plane text-xs" aria-hidden="true"></i>
                                    <span>{{ $cta['label'] }}</span>
                                </a>
                            @else
                                <button type="button" disabled
                                    class="w-full min-h-11 py-3.5 px-4 rounded-xl bg-stone-100 border border-stone-200 text-slate-muted font-bold text-xs sm:text-sm font-heading cursor-not-allowed flex items-center justify-center gap-2 text-center opacity-75">
                                    <i class="fa-solid fa-lock text-xs" aria-hidden="true"></i>
                                    <span>{{ $cta['label'] }}</span>
                                </button>
                            @endif

                            <p class="text-[11px] text-center text-slate-muted">
                                {{ $cta['hint'] }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('layouts.footer')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const calculatorConfig = @json($calculatorConfig, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
            const mainImg = document.getElementById('main-preview-img');
            const thumbButtons = document.querySelectorAll('.thumb-btn');
            const tabButtons = document.querySelectorAll('.tab-btn');
            const addonCheckboxes = document.querySelectorAll('.addon-checkbox');
            const calcAddonsEl = document.getElementById('calc-addons');
            const calcTotalEl = document.getElementById('calc-total');
            const calcDpEl = document.getElementById('calc-dp');

            function formatRupiah(amount) {
                return 'Rp ' + Math.round(amount).toLocaleString('id-ID');
            }

            thumbButtons.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const url = btn.getAttribute('data-image-url');
                    if (mainImg && url) {
                        mainImg.src = url;
                    }

                    thumbButtons.forEach(function (other) {
                        other.classList.remove('border-2', 'border-amber-500', 'ring-2', 'ring-amber-500/20', 'opacity-100');
                        other.classList.add('border', 'border-stone-200', 'opacity-70');
                    });

                    btn.classList.remove('border', 'border-stone-200', 'opacity-70');
                    btn.classList.add('border-2', 'border-amber-500', 'ring-2', 'ring-amber-500/20', 'opacity-100');
                });
            });

            tabButtons.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const activeTab = btn.getAttribute('data-tab-target');
                    ['deskripsi', 'tos', 'ulasan'].forEach(function (tabName) {
                        const content = document.getElementById('tab-' + tabName);
                        const targetBtn = document.getElementById('tab-' + tabName + '-btn');
                        if (!content || !targetBtn) return;

                        if (tabName === activeTab) {
                            content.classList.remove('hidden');
                            targetBtn.setAttribute('aria-selected', 'true');
                            targetBtn.classList.remove('border-transparent', 'text-slate-muted', 'font-medium');
                            targetBtn.classList.add('border-slate-dark', 'text-slate-dark', 'bg-white', 'font-bold');
                        } else {
                            content.classList.add('hidden');
                            targetBtn.setAttribute('aria-selected', 'false');
                            targetBtn.classList.remove('border-slate-dark', 'text-slate-dark', 'bg-white', 'font-bold');
                            targetBtn.classList.add('border-transparent', 'text-slate-muted', 'font-medium');
                        }
                    });
                });
            });

            function calculateTotal() {
                const basePrice = Number(calculatorConfig.basePrice || 0);
                const dpPercentage = calculatorConfig.dpPercentage !== undefined && calculatorConfig.dpPercentage !== null
                    ? Number(calculatorConfig.dpPercentage)
                    : 50;
                let addonsTotal = 0;

                addonCheckboxes.forEach(function (cb) {
                    if (cb.checked) {
                        addonsTotal += parseInt(cb.getAttribute('data-price') || '0', 10);
                    }
                });

                const grandTotal = basePrice + addonsTotal;
                const dpAmount = Math.round((grandTotal * dpPercentage) / 100);

                if (calcAddonsEl) calcAddonsEl.textContent = formatRupiah(addonsTotal);
                if (calcTotalEl) calcTotalEl.textContent = formatRupiah(grandTotal);
                if (calcDpEl) calcDpEl.textContent = formatRupiah(dpAmount);
            }

            addonCheckboxes.forEach(function (cb) {
                cb.addEventListener('change', calculateTotal);
            });

            calculateTotal();
            window.addEventListener('pageshow', calculateTotal);
        });
    </script>
@endsection
