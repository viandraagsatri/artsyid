@extends('layouts.app')

@section('content')
    @include('layouts.header')

    <main class="bg-bg-light min-h-screen text-slate-body font-sans pb-24">
        <div class="bg-linear-to-b from-pastel-100/60 via-stone-50 to-bg-light border-b border-stone-200/60 pt-6 pb-10">
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
                <nav class="flex items-center gap-2 text-xs text-slate-muted mb-4" aria-label="Breadcrumb">
                    <a href="{{ route('home') }}" class="hover:text-slate-dark transition flex items-center gap-1">
                        <i class="fa-solid fa-house text-[11px]"></i>
                        <span>Beranda</span>
                    </a>
                    <span class="text-stone-300">/</span>
                    <span class="font-medium text-slate-dark">Daftar Jadi Artist</span>
                </nav>
                <h1 class="text-2xl sm:text-3xl font-black font-heading text-slate-dark tracking-tight">
                    Daftar Jadi Artist
                </h1>
                <p class="mt-2 text-xs sm:text-sm text-slate-body leading-relaxed">
                    Lengkapi data rekening, aturan komisi (ToS), dan portofolio kamu. Admin akan memverifikasi
                    pengajuanmu sebelum akunmu aktif sebagai artist.
                </p>
            </div>
        </div>

        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 space-y-6">
            @if (session('success'))
                <div class="p-4 rounded-xl border text-sm bg-status-success-bg border-status-success-border text-status-success-text shadow-2xs">
                    <i class="fa-solid fa-circle-check mr-1.5"></i>{{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="p-4 rounded-xl border text-sm bg-status-danger-bg border-status-danger-border text-status-danger-text shadow-2xs">
                    <i class="fa-solid fa-circle-xmark mr-1.5"></i>{{ session('error') }}
                </div>
            @endif

            @if ($hasPending)
                <div class="card-artsy p-8 text-center space-y-3">
                    <div class="w-14 h-14 mx-auto rounded-full bg-amber-100 text-amber-800 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-hourglass-half"></i>
                    </div>
                    <span class="inline-block px-3 py-1 rounded-full bg-amber-50 border border-amber-200 text-amber-800 text-[11px] font-bold font-heading uppercase tracking-wider">
                        Sedang Dalam Peninjauan
                    </span>
                    <h2 class="text-lg font-bold font-heading text-slate-dark">Pengajuan Sedang Diverifikasi</h2>
                    <p class="text-sm text-slate-muted leading-relaxed max-w-md mx-auto">
                        Admin sedang meninjau kelengkapan berkas portofolio dan ToS kamu. Setelah disetujui, akunmu akan otomatis diaktifkan sebagai artist.
                    </p>
                    <div class="pt-3">
                        <a href="{{ route('home') }}" class="btn-primary">Kembali ke Beranda</a>
                    </div>
                </div>
            @else
                @if ($lastRejected)
                    <div class="bg-red-50/90 border border-red-200/90 rounded-2xl p-5 sm:p-6 text-red-900 shadow-2xs space-y-4">
                        <div class="flex items-start gap-3.5">
                            <div class="w-10 h-10 rounded-xl bg-red-100 text-red-700 flex items-center justify-center shrink-0 text-lg">
                                <i class="fa-solid fa-circle-xmark"></i>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2">
                                    <span class="px-2 py-0.5 rounded bg-red-200 text-red-900 font-bold text-[10px] font-heading uppercase tracking-wider">
                                        Pengajuan Belum Disetujui
                                    </span>
                                </div>
                                <h2 class="text-base sm:text-lg font-bold font-heading text-red-950 mt-1">
                                    Pengajuan Artist Sebelumnya Ditolak
                                </h2>
                                <p class="text-xs text-red-800/90 mt-0.5">
                                    Ditinjau & Ditolak admin pada: <strong>{{ $lastRejected->updated_at ? $lastRejected->updated_at->timezone('Asia/Jakarta')->translatedFormat('d F Y, H:i') . ' WIB' : '-' }}</strong> ({{ $lastRejected->updated_at ? $lastRejected->updated_at->diffForHumans() : '' }})
                                </p>
                            </div>
                        </div>

                        <div class="p-4 rounded-xl bg-white border border-red-200/90 shadow-2xs space-y-1">
                            <span class="text-xs font-heading font-bold text-red-950 flex items-center gap-1.5">
                                <i class="fa-solid fa-clipboard-question text-red-600"></i> Catatan Evaluasi Admin:
                            </span>
                            <p class="text-xs text-slate-dark leading-relaxed font-sans">
                                {{ $lastRejected->admin_notes ?: 'Tidak ada catatan tambahan dari admin.' }}
                            </p>
                        </div>

                        <p class="text-xs text-red-800 leading-relaxed">
                            Jangan berkecil hati! Memang bukan rezeki anda hehe.
                        </p>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="p-4 rounded-xl border text-sm bg-status-danger-bg border-status-danger-border text-status-danger-text">
                        <i class="fa-solid fa-circle-xmark mr-1.5"></i>Ada isian yang belum benar, cek kembali form di bawah.
                    </div>
                @endif

                <form action="{{ route('register.artist.post') }}" method="POST" class="space-y-6" novalidate>
                    @csrf

                    <section class="card-artsy p-6 space-y-5">
                        <div class="flex items-center justify-between pb-2 border-b border-stone-100">
                            <div>
                                <h2 class="text-base font-bold font-heading text-slate-dark flex items-center gap-2">
                                    <i class="fa-solid fa-building-columns text-amber-500"></i> Rekening Pencairan Dana
                                </h2>
                                <p class="mt-0.5 text-xs text-slate-muted">
                                    Dana komisi dicairkan admin ke rekening ini. Data dapat kamu ubah kapan saja.
                                </p>
                            </div>
                            @if ($previousProfile && $previousProfile->bank_name)
                                <span class="text-[10px] bg-stone-100 text-slate-600 px-2.5 py-1 rounded-md font-medium">
                                    Data Sebelumnya Dimuat
                                </span>
                            @endif
                        </div>

                        <div>
                            <label for="bank_name" class="block text-xs font-bold text-slate-dark font-heading mb-1.5">Nama Bank</label>
                            <input type="text" id="bank_name" name="bank_name" value="{{ old('bank_name', $previousProfile->bank_name ?? '') }}" required
                                placeholder="Contoh: BCA, BRI, Mandiri"
                                class="w-full px-4 py-3 text-sm bg-white rounded-xl border border-stone-200 focus:outline-none focus:border-pastel-400 focus:ring-2 focus:ring-pastel-200 placeholder:text-slate-400 @error('bank_name') border-status-danger-text @enderror">
                            @error('bank_name') <p class="mt-1 text-xs text-status-danger-text">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label for="account_number" class="block text-xs font-bold text-slate-dark font-heading mb-1.5">Nomor Rekening</label>
                                <input type="text" id="account_number" name="account_number" value="{{ old('account_number', $previousProfile->account_number ?? '') }}" required
                                    inputmode="numeric" placeholder="Hanya angka"
                                    class="w-full px-4 py-3 text-sm bg-white rounded-xl border border-stone-200 focus:outline-none focus:border-pastel-400 focus:ring-2 focus:ring-pastel-200 placeholder:text-slate-400 @error('account_number') border-status-danger-text @enderror">
                                @error('account_number') <p class="mt-1 text-xs text-status-danger-text">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="account_holder" class="block text-xs font-bold text-slate-dark font-heading mb-1.5">Nama Pemilik Rekening</label>
                                <input type="text" id="account_holder" name="account_holder" value="{{ old('account_holder', $previousProfile->account_holder ?? '') }}" required
                                    placeholder="Sesuai buku tabungan"
                                    class="w-full px-4 py-3 text-sm bg-white rounded-xl border border-stone-200 focus:outline-none focus:border-pastel-400 focus:ring-2 focus:ring-pastel-200 placeholder:text-slate-400 @error('account_holder') border-status-danger-text @enderror">
                                @error('account_holder') <p class="mt-1 text-xs text-status-danger-text">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </section>

                    @php
                        $tosBisaDefault = (isset($previousProfile->tos['bisa_digambar']) && is_array($previousProfile->tos['bisa_digambar']))
                            ? implode("\n", $previousProfile->tos['bisa_digambar'])
                            : '';
                        $tosTidakDefault = (isset($previousProfile->tos['tidak_menerima']) && is_array($previousProfile->tos['tidak_menerima']))
                            ? implode("\n", $previousProfile->tos['tidak_menerima'])
                            : '';
                    @endphp

                    <section class="card-artsy p-6 space-y-5">
                        <div>
                            <h2 class="text-base font-bold font-heading text-slate-dark flex items-center gap-2">
                                <i class="fa-solid fa-file-contract text-amber-500"></i> Terms of Service (ToS)
                            </h2>
                            <p class="mt-1 text-xs text-slate-muted">
                                Aturan ini tampil di halaman katalogmu dan dibaca client sebelum memesan.
                                Tulis <strong>satu poin per baris</strong>.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="p-4 bg-emerald-50/60 rounded-xl border border-emerald-200/80">
                                <label for="tos_bisa" class="text-xs sm:text-sm font-bold font-heading text-emerald-900 mb-1 flex items-center gap-2">
                                    <i class="fa-solid fa-circle-check text-emerald-600"></i> Bisa Digambar
                                </label>
                                <p class="text-xs text-emerald-800/80 mb-2.5">
                                    Jenis karya yang kamu terima dan sanggup kerjakan.
                                </p>
                                <textarea id="tos_bisa" name="tos_bisa" rows="7" required
                                    placeholder="Karakter Original (OC)&#10;Fanart Anime, Game, dan Novel&#10;Karakter Fantasy&#10;Pasangan / Couple"
                                    class="w-full px-3 py-2.5 text-xs bg-white rounded-xl border border-emerald-200 focus:outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 placeholder:text-slate-400 @error('tos_bisa') border-status-danger-text @enderror">{{ old('tos_bisa', $tosBisaDefault) }}</textarea>
                                @error('tos_bisa') <p class="mt-1 text-xs text-status-danger-text">{{ $message }}</p> @enderror
                            </div>

                            <div class="p-4 bg-rose-50/60 rounded-xl border border-rose-200/80">
                                <label for="tos_tidak" class="text-xs sm:text-sm font-bold font-heading text-rose-900 mb-1 flex items-center gap-2">
                                    <i class="fa-solid fa-circle-xmark text-rose-600"></i> Tidak Menerima
                                </label>
                                <p class="text-xs text-rose-800/80 mb-2.5">
                                    Jenis permintaan yang kamu tolak agar tidak terjadi salah paham.
                                </p>
                                <textarea id="tos_tidak" name="tos_tidak" rows="7" required
                                    placeholder="NSFW berat / R-18 explicit&#10;Mecha / robot ultra-kompleks&#10;Gore / kekerasan ekstrem&#10;Peniruan gaya artis lain secara paksa"
                                    class="w-full px-3 py-2.5 text-xs bg-white rounded-xl border border-rose-200 focus:outline-none focus:border-rose-400 focus:ring-2 focus:ring-rose-100 placeholder:text-slate-400 @error('tos_tidak') border-status-danger-text @enderror">{{ old('tos_tidak', $tosTidakDefault) }}</textarea>
                                @error('tos_tidak') <p class="mt-1 text-xs text-status-danger-text">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </section>

                    @php
                        $linksToFill = !empty($previousLinks) ? $previousLinks : [''];
                    @endphp

                    <section class="card-artsy p-6 space-y-5">
                        <div class="flex items-center justify-between pb-2 border-b border-stone-100">
                            <div>
                                <h2 class="text-base font-bold font-heading text-slate-dark flex items-center gap-2">
                                    <i class="fa-solid fa-link text-amber-500"></i> Tautan Portofolio
                                </h2>
                                <p class="mt-0.5 text-xs text-slate-muted">
                                    Masukkan link media sosial atau galeri karyamu (Instagram, X, Pinterest, ArtStation, dll.). Minimal 1 dan maksimal 5 link.
                                </p>
                            </div>
                        </div>

                        <div id="portfolio-list" class="space-y-3">
                            @foreach (old('portfolio_links', $linksToFill) as $i => $link)
                                <div class="portfolio-row">
                                    <div class="flex items-center gap-2">
                                        <div class="relative grow">
                                            <input type="url" name="portfolio_links[]" value="{{ $link }}" required
                                                placeholder="https://instagram.com/namamu atau https://artstation.com/..."
                                                class="w-full pl-4 pr-4 py-3 text-sm bg-white rounded-xl border border-stone-200 focus:outline-none focus:border-pastel-400 focus:ring-2 focus:ring-pastel-200 placeholder:text-slate-400 @error('portfolio_links.' . $i) border-status-danger-text @enderror">
                                        </div>
                                        <button type="button" class="remove-link shrink-0 w-10 h-10 rounded-xl text-slate-muted hover:text-status-danger-text hover:bg-status-danger-bg transition cursor-pointer" aria-label="Hapus link" title="Hapus tautan ini">
                                            <i class="fa-solid fa-trash-can text-sm"></i>
                                        </button>
                                    </div>
                                    @error('portfolio_links.' . $i) <p class="mt-1 text-xs text-status-danger-text">{{ $message }}</p> @enderror
                                </div>
                            @endforeach
                        </div>
                        @error('portfolio_links') <p class="text-xs text-status-danger-text">{{ $message }}</p> @enderror

                        <button type="button" id="add-link" class="btn-secondary text-xs cursor-pointer">
                            <i class="fa-solid fa-plus mr-1.5"></i> Tambah Link
                        </button>
                    </section>

                    <div class="flex flex-col-reverse sm:flex-row sm:items-center sm:justify-between gap-4">
                        <p class="text-xs text-slate-muted bg-pastel-50/80 px-3 py-2 rounded-xl border border-pastel-300 shadow-2xs">
                            Akunmu akan aktif sebagai artist setelah pengajuan diverifikasi dan disetujui admin.
                        </p>
                        <button type="submit" class="btn-primary px-8 py-3 cursor-pointer shrink-0">
                            {{ $lastRejected ? 'Kirim Ulang Pengajuan' : 'Kirim Pengajuan' }}
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </main>

    <template id="portfolio-template">
        <div class="portfolio-row">
            <div class="flex items-center gap-2">
                <div class="relative grow">
                    <input type="url" name="portfolio_links[]" required placeholder="https://instagram.com/namamu atau https://artstation.com/..."
                        class="w-full pl-4 pr-4 py-3 text-sm bg-white rounded-xl border border-stone-200 focus:outline-none focus:border-pastel-400 focus:ring-2 focus:ring-pastel-200 placeholder:text-slate-400">
                </div>
                <button type="button" class="remove-link shrink-0 w-10 h-10 rounded-xl text-slate-muted hover:text-status-danger-text hover:bg-status-danger-bg transition cursor-pointer" aria-label="Hapus link">
                    <i class="fa-solid fa-trash-can text-sm"></i>
                </button>
            </div>
        </div>
    </template>

    <script>
        (function () {
            var MAX_LINKS = 5;
            var list = document.getElementById('portfolio-list');
            var addBtn = document.getElementById('add-link');
            var tpl = document.getElementById('portfolio-template');
            if (!list || !addBtn) return;

            function refresh() {
                var rows = list.querySelectorAll('.portfolio-row');
                addBtn.classList.toggle('hidden', rows.length >= MAX_LINKS);
                rows.forEach(function (row) {
                    row.querySelector('.remove-link').classList.toggle('invisible', rows.length === 1);
                });
            }

            addBtn.addEventListener('click', function () {
                if (list.querySelectorAll('.portfolio-row').length >= MAX_LINKS) return;
                list.appendChild(tpl.content.cloneNode(true));
                list.querySelector('.portfolio-row:last-child input').focus();
                refresh();
            });

            list.addEventListener('click', function (e) {
                var btn = e.target.closest('.remove-link');
                if (!btn) return;
                btn.closest('.portfolio-row').remove();
                refresh();
            });

            refresh();
        })();
    </script>

    @include('layouts.footer')
@endsection
