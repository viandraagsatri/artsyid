<footer class="bg-stone-100 border-t border-stone-200 text-slate-body pt-14 pb-10" data-purpose="site-footer">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 pb-12 border-b border-stone-200">
            <div class="lg:col-span-2 flex flex-col gap-4">
                <a class="flex items-center gap-2.5 group w-fit" href="{{ route('home') }}">
                    <img src="{{ asset('images/logo-artsy.png') }}" alt="Artsy ID Logo"
                        class="h-10 w-auto object-contain transition-transform group-hover:scale-105" />
                    <span
                        class="text-xl font-extrabold font-heading text-slate-dark tracking-tight leading-none">Artsy<span
                            class="text-amber-500">.ID</span></span>
                </a>
                <p class="text-xs text-slate-muted max-w-sm leading-relaxed">
                    Platform marketplace komisi seni digital di Indonesia. Menghadirkan transaksi bebas penipuan (<em
                        class="not-italic text-slate-dark font-medium">anti-scam</em>) melalui sistem pembayaran
                    bertahap (Escrow) dan pelacakan progres dengan proteksi watermark otomatis.
                </p>

                <div class="flex flex-wrap items-center gap-2.5 pt-2">
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-emerald-50 border border-emerald-200/80 text-[11px] font-bold text-emerald-800">
                        <i class="fa-solid fa-shield-halved text-emerald-600"></i>
                        Midtrans Escrow 2-Stage
                    </span>
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-amber-50 border border-amber-200/80 text-[11px] font-bold text-amber-800">
                        <i class="fa-solid fa-stamp text-amber-600"></i>
                        Proteksi Watermark Otomatis
                    </span>
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-indigo-50 border border-indigo-200/80 text-[11px] font-bold text-indigo-800">
                        <i class="fa-solid fa-hand-holding-heart text-indigo-600"></i>
                        100% Karya Manusia
                    </span>
                </div>
            </div>

            <div>
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-dark mb-3.5 font-heading">Eksplorasi
                    Seni</h4>
                <ul class="space-y-2.5 text-xs text-slate-muted font-sans">
                    <li><a class="hover:text-slate-dark hover:underline transition" href="#katalog">Katalog Komisi</a>
                    </li>
                    <li><a class="hover:text-slate-dark hover:underline transition" href="#kategori">Ilustrasi &amp;
                            Karakter OC</a></li>
                    <li><a class="hover:text-slate-dark hover:underline transition" href="#kategori">Model Live2D
                            Vtuber</a></li>
                    <li><a class="hover:text-slate-dark hover:underline transition" href="#kategori">3D Avatar &amp;
                            VRChat</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-dark mb-3.5 font-heading">Untuk Artist
                </h4>
                <ul class="space-y-2.5 text-xs text-slate-muted font-sans">
                    <li><a class="hover:text-slate-dark hover:underline transition"
                            href="{{ route('register') }}">Pendaftaran Akun Artist</a></li>
                    <li><a class="hover:text-slate-dark hover:underline transition" href="#cara-kerja">Pencairan
                            Dana</a></li>
                    <li><a class="hover:text-slate-dark hover:underline transition" href="#keunggulan">Fitur Dynamic
                            Invoice</a></li>
                    <li><a class="hover:text-slate-dark hover:underline transition" href="#keunggulan">Proteksi
                            Watermark</a></li>
                    <li><a class="hover:text-slate-dark hover:underline transition" href="#cara-kerja">Batas Revisi</a>
                    </li>
                </ul>
            </div>

            <div>
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-dark mb-3.5 font-heading">Keamanan
                    &amp; Bantuan</h4>
                <ul class="space-y-2.5 text-xs text-slate-muted font-sans">
                    <li><a class="hover:text-slate-dark hover:underline transition" href="#cara-kerja">Mekanisme
                            Rekening Escrow</a></li>
                    <li><a class="hover:text-slate-dark hover:underline transition" href="#keunggulan">Kebijakan
                            Larangan Generative AI</a></li>
                    <li><a class="hover:text-slate-dark hover:underline transition" href="{{ route('login') }}">Pusat
                            Bantuan &amp; Laporan</a></li>
                    <li><a class="hover:text-slate-dark hover:underline transition" href="#">Syarat &amp; Ketentuan
                            Layanan</a></li>
                    <li><a class="hover:text-slate-dark hover:underline transition" href="#">Kebijakan Privasi Data</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-muted gap-4">
            <p>© {{ date('Y') }} Artsy ID. Platform Komisi Seni Digital Terintegrasi Payment Gateway. Seluruh hak cipta
                dilindungi.</p>
            <div class="flex items-center space-x-6 text-xs text-slate-muted">
                <a class="hover:text-slate-dark transition" href="#">Privasi</a>
                <a class="hover:text-slate-dark transition" href="#">Ketentuan</a>
                <a class="hover:text-slate-dark transition" href="#">Pedoman Etika Kreator</a>
            </div>
        </div>
    </div>
</footer>