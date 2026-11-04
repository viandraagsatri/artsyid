@extends('layouts.app')

@section('content')
    @include('layouts.header')

    <main class="bg-bg-light min-h-screen text-slate-body font-sans pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 pb-4">
            <nav class="flex items-center gap-2 text-xs text-slate-muted" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-slate-dark transition flex items-center gap-1">
                    <i class="fa-solid fa-house text-[11px]"></i>
                    <span>Beranda</span>
                </a>
                <span class="text-stone-300">/</span>
                <a href="{{ route('home') }}#katalog" class="hover:text-slate-dark transition">Katalog Seni</a>
                <span class="text-stone-300">/</span>
                <span class="text-slate-muted">Ilustrasi &amp; OC</span>
                <span class="text-stone-300">/</span>
                <span class="font-medium text-slate-dark truncate max-w-50 sm:max-w-xs">Bust-Up Anime Karakter Fantasy (Full
                    Render)</span>
            </nav>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                <div class="lg:col-span-8 flex flex-col gap-8">
                    <div class="bg-white rounded-2xl border border-stone-200/90 shadow-xs p-4 sm:p-6 overflow-hidden">
                        <div
                            class="relative aspect-16/10 sm:aspect-video bg-stone-100 rounded-xl overflow-hidden border border-stone-100">
                            <img id="main-preview-img"
                                src="https://images.unsplash.com/photo-1578632767115-351597cf2477?w=1200&auto=format&fit=crop&q=80"
                                alt="Bust-up Anime Karakter Fantasy"
                                class="w-full h-full object-cover transition-all duration-300" />

                            <div class="absolute top-3 left-3 flex flex-wrap gap-2">
                                <span
                                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-black/80 backdrop-blur-xs text-white text-[11px] font-bold">
                                    <i class="fa-solid fa-palette text-amber-400"></i>
                                    Ilustrasi &amp; OC
                                </span>
                            </div>

                            <div class="absolute bottom-3 right-3">
                                <span
                                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-black/60 backdrop-blur-xs text-stone-200 text-[11px]">
                                    <i class="fa-solid fa-shield-halved text-amber-400"></i>
                                    Watermark Protected
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 mt-4 overflow-x-auto pb-2 pt-1 hide-scrollbar">
                            <button type="button"
                                onclick="changeMainImage('https://images.unsplash.com/photo-1578632767115-351597cf2477?w=1200&auto=format&fit=crop&q=80', this)"
                                class="thumb-btn shrink-0 w-20 h-16 rounded-lg overflow-hidden border-2 border-amber-500 ring-2 ring-amber-500/20 transition">
                                <img src="https://images.unsplash.com/photo-1578632767115-351597cf2477?w=200&auto=format&fit=crop&q=80"
                                    class="w-full h-full object-cover" alt="Sample 1">
                            </button>

                            <button type="button"
                                onclick="changeMainImage('https://images.unsplash.com/photo-1534447677768-be436bb09401?w=1200&auto=format&fit=crop&q=80', this)"
                                class="thumb-btn shrink-0 w-20 h-16 rounded-lg overflow-hidden border border-stone-200 hover:border-amber-400 opacity-70 hover:opacity-100 transition">
                                <img src="https://images.unsplash.com/photo-1534447677768-be436bb09401?w=200&auto=format&fit=crop&q=80"
                                    class="w-full h-full object-cover" alt="Sample 2">
                            </button>

                            <button type="button"
                                onclick="changeMainImage('https://images.unsplash.com/photo-1541701494587-cb58502866ab?w=1200&auto=format&fit=crop&q=80', this)"
                                class="thumb-btn shrink-0 w-20 h-16 rounded-lg overflow-hidden border border-stone-200 hover:border-amber-400 opacity-70 hover:opacity-100 transition">
                                <img src="https://images.unsplash.com/photo-1541701494587-cb58502866ab?w=200&auto=format&fit=crop&q=80"
                                    class="w-full h-full object-cover" alt="Sample 3">
                            </button>

                            <button type="button"
                                onclick="changeMainImage('https://images.unsplash.com/photo-1579783900882-c0d3dad7b119?w=1200&auto=format&fit=crop&q=80', this)"
                                class="thumb-btn shrink-0 w-20 h-16 rounded-lg overflow-hidden border border-stone-200 hover:border-amber-400 opacity-70 hover:opacity-100 transition">
                                <img src="https://images.unsplash.com/photo-1579783900882-c0d3dad7b119?w=200&auto=format&fit=crop&q=80"
                                    class="w-full h-full object-cover" alt="Sample 4">
                            </button>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl border border-stone-200/90 shadow-xs p-6">
                        <div
                            class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-stone-100">
                            <div>
                                <h1 class="text-xl sm:text-2xl font-black font-heading text-slate-dark tracking-tight">
                                    Bust-Up Anime Karakter Fantasy
                                </h1>
                                <div class="flex flex-wrap items-center gap-3 mt-2 text-xs text-slate-muted">
                                    <div class="flex items-center gap-1 text-slate-dark font-medium">
                                        <i class="fa-solid fa-star text-amber-400 text-xs"></i>
                                        <span class="font-bold text-slate-dark">5.0</span>
                                        <span>(52 ulasan pembeli)</span>
                                    </div>
                                    <span class="text-stone-300">•</span>
                                    <span>Kategori: <strong class="text-slate-dark">Ilustrasi &amp; OC</strong></span>
                                    <span class="text-stone-300">•</span>
                                    <span>Tipe: <strong class="text-slate-dark">Custom Request</strong></span>
                                </div>
                            </div>
                        </div>

                        <div class="pt-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div class="flex items-center gap-3.5">
                                <div class="relative">
                                    <div
                                        class="w-12 h-12 rounded-full bg-pastel-300 text-slate-dark font-bold text-base flex items-center justify-center font-heading border-2 border-white shadow-xs">
                                        R
                                    </div>
                                    <i class="fa-solid fa-circle-check text-amber-500 text-sm absolute -bottom-0.5 -right-0.5 bg-white rounded-full ring-2 ring-white"
                                        title="Kreator Terverifikasi"></i>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <h3 class="text-sm font-bold font-heading text-slate-dark">Rafly Studio</h3>
                                        <span class="text-xs text-slate-muted">(@rafly.art)</span>
                                    </div>
                                    <p class="text-xs text-slate-muted line-clamp-1 mt-0.5">
                                        Ilustrator karakter fantasi &amp; Vtuber enthusiast sejak 2026.
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 shrink-0">
                                <div class="text-right sm:border-l sm:border-stone-100 sm:pl-4">
                                    <span class="text-[10px] text-slate-muted uppercase font-heading block">Waktu
                                        Respon</span>
                                    <span class="text-xs font-bold text-slate-dark">&plusmn; 2 Jam</span>
                                </div>
                                <div class="text-right border-l border-stone-100 pl-4">
                                    <span class="text-[10px] text-slate-muted uppercase font-heading block">Pesanan
                                        Berhasil</span>
                                    <span class="text-xs font-bold text-slate-dark">98% Selesai</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        <div class="bg-white p-4 rounded-xl border border-stone-200/90 shadow-xs flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-clock text-sm"></i>
                            </div>
                            <div>
                                <span class="text-[10px] text-slate-muted uppercase font-heading block">Estimasi</span>
                                <span class="text-xs font-bold text-slate-dark font-heading">5 Hari Kerja</span>
                            </div>
                        </div>

                        <div class="bg-white p-4 rounded-xl border border-stone-200/90 shadow-xs flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-arrows-rotate text-sm"></i>
                            </div>
                            <div>
                                <span class="text-[10px] text-slate-muted uppercase font-heading block">Batas Revisi</span>
                                <span class="text-xs font-bold text-slate-dark font-heading">2x Gratis</span>
                            </div>
                        </div>

                        <div class="bg-white p-4 rounded-xl border border-stone-200/90 shadow-xs flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-xl bg-sky-100 text-sky-800 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-file-image text-sm"></i>
                            </div>
                            <div>
                                <span class="text-[10px] text-slate-muted uppercase font-heading block">Format File</span>
                                <span class="text-xs font-bold text-slate-dark font-heading">PNG HD &amp; PSD</span>
                            </div>
                        </div>

                        <div class="bg-white p-4 rounded-xl border border-stone-200/90 shadow-xs flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-800 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-expand text-sm"></i>
                            </div>
                            <div>
                                <span class="text-[10px] text-slate-muted uppercase font-heading block">Resolusi</span>
                                <span class="text-xs font-bold text-slate-dark font-heading">A4 350 DPI</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl border border-stone-200/90 shadow-xs overflow-hidden"
                        x-data="{ tab: 'deskripsi' }">
                        <div class="flex border-b border-stone-200 bg-stone-50/60 text-xs sm:text-sm font-heading">
                            <button type="button" id="tab-deskripsi-btn" onclick="switchTab('deskripsi')"
                                class="tab-btn px-6 py-4 font-bold border-b-2 border-slate-dark text-slate-dark bg-white transition">
                                Deskripsi Layanan
                            </button>
                            <button type="button" id="tab-tos-btn" onclick="switchTab('tos')"
                                class="tab-btn px-6 py-4 font-medium border-b-2 border-transparent text-slate-muted hover:text-slate-dark transition">
                                Syarat &amp; Ketentuan (ToS)
                            </button>
                            <button type="button" id="tab-ulasan-btn" onclick="switchTab('ulasan')"
                                class="tab-btn px-6 py-4 font-medium border-b-2 border-transparent text-slate-muted hover:text-slate-dark transition">
                                Ulasan Pembeli (52)
                            </button>
                        </div>

                        <div id="tab-deskripsi" class="p-6 space-y-5">
                            <div>
                                <h4 class="text-sm font-bold font-heading text-slate-dark mb-2">Yang Anda Dapatkan:</h4>
                                <ul class="space-y-2 text-xs sm:text-sm text-slate-body">
                                    <li class="flex items-start gap-2.5">
                                        <i class="fa-solid fa-check text-emerald-600 mt-1"></i>
                                        <span>Ilustrasi karakter dari kepala hingga dada dengan pewarnaan penuh.</span>
                                    </li>
                                    <li class="flex items-start gap-2.5">
                                        <i class="fa-solid fa-check text-emerald-600 mt-1"></i>
                                        <span>File resolusi tinggi: Format PNG Transparan dan PNG Full Illustration resolusi
                                            cetak (300-350 DPI).</span>
                                    </li>
                                    <li class="flex items-start gap-2.5">
                                        <i class="fa-solid fa-check text-emerald-600 mt-1"></i>
                                        <span>Simpel background berupa gradasi lembut / elemen grafis minimalis
                                            (Gratis).</span>
                                    </li>
                                    <li class="flex items-start gap-2.5">
                                        <i class="fa-solid fa-check text-emerald-600 mt-1"></i>
                                        <span>2x kesempatan revisi gratis pada fase Sketsa Kasar &amp; Line Art.</span>
                                    </li>
                                </ul>
                            </div>

                            <div class="pt-4 border-t border-stone-100">
                                <h4 class="text-sm font-bold font-heading text-slate-dark mb-2">Linimasa Pengerjaan 4 Tahap:
                                </h4>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                                    <div class="p-3 bg-stone-50 rounded-xl border border-stone-200/80">
                                        <span class="font-bold text-slate-dark block font-heading mb-1">1. Tahap
                                            Sketsa</span>
                                        <p class="text-slate-muted">Penyusunan pose, ekspresi wajah, dan proporsi dasar
                                            karakter. Anda dapat meminta revisi pose di tahap ini.</p>
                                    </div>
                                    <div class="p-3 bg-stone-50 rounded-xl border border-stone-200/80">
                                        <span class="font-bold text-slate-dark block font-heading mb-1">2. Tahap Line
                                            Art</span>
                                        <p class="text-slate-muted">Garis gambar.</p>
                                    </div>
                                    <div class="p-3 bg-stone-50 rounded-xl border border-stone-200/80">
                                        <span class="font-bold text-slate-dark block font-heading mb-1">3. Tahap
                                            Pewarnaan</span>
                                        <p class="text-slate-muted">Penentuan palet warna dasar dan bayangan awal sebelum
                                            masuk proses rendering.</p>
                                    </div>
                                    <div class="p-3 bg-stone-50 rounded-xl border border-stone-200/80">
                                        <span class="font-bold text-slate-dark block font-heading mb-1">4. Rendering &amp;
                                            Pelunasan</span>
                                        <p class="text-slate-muted">Detail pencahayaan akhir. Setelah disetujui &amp;
                                            dilunasi, akses unduh berkas file terbuka.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="tab-tos" class="p-6 space-y-5 hidden">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div class="p-4 bg-emerald-50/60 rounded-xl border border-emerald-200/80">
                                    <h4
                                        class="text-xs sm:text-sm font-bold font-heading text-emerald-900 mb-2.5 flex items-center gap-2">
                                        <i class="fa-solid fa-circle-check text-emerald-600"></i>
                                        Bisa Digambar:
                                    </h4>
                                    <ul class="space-y-1.5 text-xs text-emerald-800">
                                        <li>• Karakter Original (OC) Laki-laki / Perempuan</li>
                                        <li>• Fanart Anime, Game, dan Novel</li>
                                        <li>• Karakter Fantasy</li>
                                        <li>• Pasangan / Couple</li>
                                        <li>• Armor ringan &amp; aksesoris sihir</li>
                                    </ul>
                                </div>


                                <div class="p-4 bg-rose-50/60 rounded-xl border border-rose-200/80">
                                    <h4
                                        class="text-xs sm:text-sm font-bold font-heading text-rose-900 mb-2.5 flex items-center gap-2">
                                        <i class="fa-solid fa-circle-xmark text-rose-600"></i>
                                        Tidak Menerima:
                                    </h4>
                                    <ul class="space-y-1.5 text-xs text-rose-800">
                                        <li>• NSFW Berat / R-18 explicit</li>
                                        <li>• Mecha / Robot ultra-kompleks</li>
                                        <li>• Gore / Kekerasan ekstrem</li>
                                        <li>• Peniruan gaya artis lain secara paksa</li>
                                    </ul>
                                </div>
                            </div>

                            <div
                                class="p-4 bg-stone-50 rounded-xl border border-stone-200/80 text-xs text-slate-body leading-relaxed">
                                <h4 class="font-bold text-slate-dark font-heading mb-1.5">Hak Cipta &amp; Lisensi:</h4>
                                <p class="text-slate-muted">
                                    Karya ini secara bawaan berlisensi untuk <strong>Penggunaan Pribadi</strong> seperti
                                    foto profil, avatar media sosial, atau cetak koleksi pribadi. Jika ingin menggunakan
                                    karya ini untuk keperluan komersil (VTuber, merchandise komersial, promosi berbayar,
                                    YouTube monetized), silakan pilih opsi add-on <em>Lisensi Komersial</em> di bawah.
                                </p>
                            </div>
                        </div>

                        <div id="tab-ulasan" class="p-6 space-y-4 hidden">
                            <div class="flex items-center gap-6 p-4 bg-stone-50 rounded-xl border border-stone-200/80 mb-6">
                                <div class="text-center">
                                    <span class="text-3xl font-extrabold font-heading text-slate-dark block">5.0</span>
                                    <div class="flex items-center justify-center text-amber-400 text-xs mt-1">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                    <span class="text-[10px] text-slate-muted mt-1 block">52 Ulasan</span>
                                </div>
                                <div class="border-l border-stone-200 pl-6 grow text-xs text-slate-muted space-y-1">
                                    <p>• <strong>100%</strong> pembeli puas dengan komunikasi dan ketepatan deadline.</p>
                                    <p>• Rata-rata pengerjaan selesai dalam <strong>4 hari</strong> (lebih cepat dari
                                        estimasi).</p>
                                </div>
                            </div>

                            <div class="pb-4 border-b border-stone-100 last:border-none">
                                <div class="flex items-center justify-between mb-1.5">
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="w-7 h-7 rounded-full bg-indigo-100 text-indigo-900 font-bold text-xs flex items-center justify-center font-heading">
                                            P
                                        </div>
                                        <span class="text-xs font-bold text-slate-dark">Prabowo Subianto</span>
                                        <span
                                            class="text-[10px] text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200">Pembeli
                                            Terverifikasi</span>
                                    </div>
                                    <span class="text-[11px] text-slate-muted">3 hari yang lalu</span>
                                </div>
                                <div class="flex items-center text-amber-400 text-[11px] mb-1.5">
                                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                        class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                        class="fa-solid fa-star"></i>
                                </div>
                                <p class="text-xs text-slate-body leading-relaxed">
                                    Hasilnya melebihi ekspektasi! Shading warnanya sangat halus dan draf sketsa dikirim
                                    tepat waktu sesuai tracker. Saya langsung bayar lebih 1 triliuin.
                                </p>
                            </div>

                            <div class="pb-4 border-b border-stone-100 last:border-none">
                                <div class="flex items-center justify-between mb-1.5">
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="w-7 h-7 rounded-full bg-rose-100 text-rose-900 font-bold text-xs flex items-center justify-center font-heading">
                                            M
                                        </div>
                                        <span class="text-xs font-bold text-slate-dark">Megawati</span>
                                        <span
                                            class="text-[10px] text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200">Pembeli
                                            Terverifikasi</span>
                                    </div>
                                    <span class="text-[11px] text-slate-muted">1 minggu yang lalu</span>
                                </div>
                                <div class="flex items-center text-amber-400 text-[11px] mb-1.5">
                                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                        class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                        class="fa-solid fa-star"></i>
                                </div>
                                <p class="text-xs text-slate-body leading-relaxed">
                                    hasilnya bagus artsy.id memang terbaik
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-4 sticky top-24 space-y-6">
                    <div
                        class="bg-white rounded-2xl border border-stone-200/90 shadow-sm p-6 flex flex-col justify-between">
                        <div>
                            <div class="flex items-start justify-between pb-4 border-b border-stone-100">
                                <div>
                                    <span class="text-xs text-slate-muted block font-medium">Harga Dasar Layanan</span>
                                    <div class="flex items-baseline gap-1 mt-1">
                                        <span class="text-2xl font-black font-heading text-slate-dark tracking-tight">Rp
                                            350.000</span>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="mt-4 p-3 bg-emerald-50/70 rounded-xl border border-emerald-200/80 text-xs text-emerald-900 flex items-start gap-2.5">
                                <i class="fa-solid fa-shield-halved text-emerald-700 text-sm mt-0.5"></i>
                                <div>
                                    <span class="font-bold block font-heading">Escrow Payment (DP 50%)</span>
                                    <span class="text-[11px] text-emerald-800/90">
                                        Anda hanya membayar <strong>DP 50%</strong> saat order diterima. Pelunasan sisa 50%
                                        dibayar setelah karya selesai disetujui.
                                    </span>
                                </div>
                            </div>

                            <div class="mt-6">
                                <h4
                                    class="text-xs font-bold uppercase tracking-wider text-slate-dark mb-3 font-heading flex items-center justify-between">
                                    <span>Pilih Add-ons Opsional</span>
                                    <span class="text-[10px] font-normal text-slate-muted">Disesuaikan otomatis</span>
                                </h4>

                                <div class="space-y-2.5" id="addons-container">
                                    <label
                                        class="addon-item flex items-start gap-3 p-3 rounded-xl border border-stone-200 hover:border-pastel-400 hover:bg-pastel-50/50 cursor-pointer transition select-none">
                                        <input type="checkbox"
                                            class="addon-checkbox mt-1 rounded text-amber-500 focus:ring-amber-400"
                                            data-price="150000" onchange="calculateTotal()">
                                        <div class="grow">
                                            <div class="flex items-center justify-between">
                                                <span class="text-xs font-bold text-slate-dark font-heading">Background
                                                    Detail</span>
                                                <span class="text-xs font-bold text-slate-dark font-heading">+Rp
                                                    150.000</span>
                                            </div>
                                            <p class="text-[11px] text-slate-muted mt-0.5">Latar pemandangan / kamar tidur
                                                detail</p>
                                        </div>
                                    </label>

                                    <label
                                        class="addon-item flex items-start gap-3 p-3 rounded-xl border border-stone-200 hover:border-pastel-400 hover:bg-pastel-50/50 cursor-pointer transition select-none">
                                        <input type="checkbox"
                                            class="addon-checkbox mt-1 rounded text-amber-500 focus:ring-amber-400"
                                            data-price="200000" onchange="calculateTotal()">
                                        <div class="grow">
                                            <div class="flex items-center justify-between">
                                                <span class="text-xs font-bold text-slate-dark font-heading">Karakter
                                                    Tambahan (+1)</span>
                                                <span class="text-xs font-bold text-slate-dark font-heading">+Rp
                                                    200.000</span>
                                            </div>
                                            <p class="text-[11px] text-slate-muted mt-0.5">Karakter kedua dalam satu kanvas
                                            </p>
                                        </div>
                                    </label>

                                    <label
                                        class="addon-item flex items-start gap-3 p-3 rounded-xl border border-stone-200 hover:border-pastel-400 hover:bg-pastel-50/50 cursor-pointer transition select-none">
                                        <input type="checkbox"
                                            class="addon-checkbox mt-1 rounded text-amber-500 focus:ring-amber-400"
                                            data-price="250000" onchange="calculateTotal()">
                                        <div class="grow">
                                            <div class="flex items-center justify-between">
                                                <span class="text-xs font-bold text-slate-dark font-heading">Lisensi
                                                    Komersial</span>
                                                <span class="text-xs font-bold text-slate-dark font-heading">+Rp
                                                    250.000</span>
                                            </div>
                                            <p class="text-[11px] text-slate-muted mt-0.5">Untuk Vtuber / Merchandise /
                                                YouTube</p>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div class="mt-6 pt-5 border-t border-stone-100 space-y-2.5 text-xs">
                                <div class="flex items-center justify-between text-slate-muted">
                                    <span>Harga Dasar Layanan</span>
                                    <span class="font-medium text-slate-dark">Rp 350.000</span>
                                </div>
                                <div class="flex items-center justify-between text-slate-muted">
                                    <span>Tambahan Add-ons</span>
                                    <span class="font-medium text-slate-dark" id="calc-addons">Rp 0</span>
                                </div>
                                <div
                                    class="flex items-center justify-between pt-2 border-t border-dashed border-stone-200 text-sm">
                                    <span class="font-bold text-slate-dark font-heading">Total Biaya Komisi</span>
                                    <span class="font-extrabold text-slate-dark font-heading" id="calc-total">Rp
                                        350.000</span>
                                </div>

                                <div
                                    class="p-3 bg-pastel-100 rounded-xl border border-pastel-300 mt-3 flex items-center justify-between">
                                    <div>
                                        <span
                                            class="text-[10px] uppercase font-bold text-amber-900 font-heading block">Tagihan
                                            DP 50% di Awal</span>
                                        <span class="text-[11px] text-slate-body">Dibayar via Payment Gateway</span>
                                    </div>
                                    <span class="text-base font-black font-heading text-slate-dark" id="calc-dp">Rp
                                        175.000</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t border-stone-100 flex flex-col gap-2.5">
                            <a href="{{ route('register') }}"
                                class="w-full py-3.5 px-4 rounded-xl bg-pastel-200 hover:bg-pastel-300 border border-pastel-300 text-slate-dark font-bold text-xs sm:text-sm font-heading shadow-xs hover:shadow-sm transition flex items-center justify-center gap-2 text-center">
                                <i class="fa-solid fa-paper-plane text-xs"></i>
                                <span>Lanjut ke Formulir Pemesanan</span>
                            </a>

                            <p class="text-[11px] text-center text-slate-muted">
                                Bebas pembatalan sebelum draf sketsa pertama dikerjakan.
                            </p>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl border border-stone-200/80 p-5 shadow-xs space-y-3">
                        <h4
                            class="text-xs font-bold uppercase tracking-wider text-slate-dark font-heading flex items-center gap-2">
                            <i class="fa-solid fa-lock text-amber-500"></i>
                            Standar Keamanan Artsy ID
                        </h4>
                        <ul class="space-y-2 text-xs text-slate-muted">
                            <li class="flex items-start gap-2">
                                <i class="fa-solid fa-check text-emerald-600 mt-0.5"></i>
                                <span>Pencairan dana diawasi manual oleh Admin Platform.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fa-solid fa-check text-emerald-600 mt-0.5"></i>
                                <span>Proteksi draf ber-watermark diagonal resolusi penuh.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fa-solid fa-check text-emerald-600 mt-0.5"></i>
                                <span>Sistem laporan sengketa &amp; garansi refund bila terjadi kecurangan.</span>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <script>
        function changeMainImage(url, element) {
            const mainImg = document.getElementById('main-preview-img');
            if (mainImg) {
                mainImg.src = url;
            }

            document.querySelectorAll('.thumb-btn').forEach(btn => {
                btn.classList.remove('border-amber-500', 'ring-2', 'ring-amber-500/20', 'opacity-100');
                btn.classList.add('border-stone-200', 'opacity-70');
            });

            element.classList.remove('border-stone-200', 'opacity-70');
            element.classList.add('border-amber-500', 'ring-2', 'ring-amber-500/20', 'opacity-100');
        }

        function switchTab(activeTab) {
            const tabs = ['deskripsi', 'tos', 'ulasan'];

            tabs.forEach(tabName => {
                const content = document.getElementById('tab-' + tabName);
                const btn = document.getElementById('tab-' + tabName + '-btn');

                if (tabName === activeTab) {
                    content.classList.remove('hidden');
                    btn.classList.remove('border-transparent', 'text-slate-muted');
                    btn.classList.add('border-slate-dark', 'text-slate-dark', 'bg-white', 'font-bold');
                } else {
                    content.classList.add('hidden');
                    btn.classList.remove('border-slate-dark', 'text-slate-dark', 'bg-white', 'font-bold');
                    btn.classList.add('border-transparent', 'text-slate-muted');
                }
            });
        }

        function calculateTotal() {
            const basePrice = 350000;
            let addonsTotal = 0;

            const checkboxes = document.querySelectorAll('.addon-checkbox:checked');
            checkboxes.forEach(cb => {
                addonsTotal += parseInt(cb.getAttribute('data-price') || '0', 10);
            });

            const grandTotal = basePrice + addonsTotal;
            const dpAmount = Math.round(grandTotal * 0.5);

            const formatter = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            });

            document.getElementById('calc-addons').textContent = formatter.format(addonsTotal).replace('IDR', 'Rp');
            document.getElementById('calc-total').textContent = formatter.format(grandTotal).replace('IDR', 'Rp');
            document.getElementById('calc-dp').textContent = formatter.format(dpAmount).replace('IDR', 'Rp');
        }
    </script>
@endsection