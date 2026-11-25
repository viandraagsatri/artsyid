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
                <div class="bg-white rounded-2xl border border-stone-200/90 shadow-2xs p-6">
                    <h2 class="text-xl font-bold font-heading text-slate-dark">Pesanan Masuk</h2>
                    <p class="text-xs text-slate-muted mt-1">Tinjau request komisi custom (terima/tolak), dan pantau daftar pesanan yang sedang berjalan.</p>
                </div>
                
                <div class="flex flex-col justify-between gap-4 xl:flex-row xl:items-center">
                    <div class="flex flex-wrap items-center gap-2">
                        <button type="button" class="rounded-xl border border-slate-dark bg-slate-dark px-3.5 py-2.5 text-xs font-bold text-white sm:text-sm">
                            Perlu Konfirmasi (2)
                        </button>
                        <button type="button" class="rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-xs font-medium text-slate-muted sm:text-sm">
                            Sedang Dikerjakan (2)
                        </button>
                        <button type="button" class="rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-xs font-medium text-slate-muted sm:text-sm">
                            Menunggu Pelunasan (1)
                        </button>
                        <button type="button" class="rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-xs font-medium text-slate-muted sm:text-sm">
                            Selesai (8)
                        </button>
                    </div>

                    <input 
                        type="text" 
                        placeholder="Cari client atau nomor pesanan..." aria-label="Cari client atau nomor pesanan" 
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-xs text-slate-dark outline-none placeholder:text-slate-400 focus:border-amber-400 sm:w-64 sm:text-sm"
                    />
                </div>
                
                <article class="rounded-[20px] border-2 border-amber-500 bg-white p-5 sm:p-6">
                    <div class="flex flex-col justify-between gap-4 lg:flex-row lg:items-center">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-sky-50 text-sm font-bold text-sky-700">
                                BP
                            </div>
                            <div>
                                <h3 class="text-sm font-extrabold text-slate-dark sm:text-base">Budi Pembeli • Request Baru</h3>
                                <p class="mt-1 text-xs text-slate-muted">Nomor: #ORD-2026-0051 • Diajukan: 25 Menit yang lalu</p>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-3">
                            <span class="rounded-full border border-amber-300 bg-amber-100 px-3 py-1.5 text-[10px] font-bold uppercase text-amber-800 sm:text-xs">
                                Status: Menunggu Persetujuan Anda
                            </span>
                            <p class="text-base font-extrabold text-slate-dark">Total: Rp 200.000</p>
                        </div>
                    </div>

                    <div class="mt-4 rounded-2xl bg-[#F8F8F8] p-4">
                        <h4 class="text-sm font-bold text-slate-dark">Paket Dipesan: Chibi Couple Emote Set (6 Karakter)</h4>
                        <p class="mt-2 text-xs leading-relaxed text-slate-body sm:text-sm">
                            Deskripsi Konsep: 'Dua karakter chibi anime perempuan dan laki-laki berpelukan dengan ekspresi ceria dan telinga kucing kawaii.'
                        </p>
                        <div class="mt-3 flex flex-wrap items-center gap-2">
                            <span class="rounded-full bg-white px-3 py-1.5 text-[10px] font-semibold text-slate-body sm:text-xs">Vibes: Ceria Pastel</span>
                            <span class="rounded-full bg-white px-3 py-1.5 text-[10px] font-semibold text-slate-body sm:text-xs">Background: Transparan</span>
                            <span class="rounded-full bg-white px-3 py-1.5 text-[10px] font-semibold text-slate-body sm:text-xs">Karakter: 2 Orang</span>
                            <span class="rounded-full bg-yellow-100 px-3 py-1.5 text-[10px] font-bold text-amber-800 sm:text-xs">Add-on: Lisensi Stream Twitch (+Rp 50.000)</span>
                            <span class="rounded-full bg-sky-50 px-3 py-1.5 text-[10px] font-bold text-sky-700 sm:text-xs">2 Berkas Referensi Terlampir (PNG)</span>
                        </div>
                    </div>

                    <div class="mt-4 flex flex-col justify-between gap-4 xl:flex-row xl:items-center">
                        <p class="text-xs text-slate-muted sm:text-sm">DP 50% Otomatis: Rp 100.000 • Estimasi: 3 Hari Kerja</p>
                        <div class="flex flex-wrap items-center gap-2">
                            <button type="button" class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-xs font-semibold text-slate-dark sm:text-sm">Chat Client</button>
                            <button type="button" class="rounded-xl border border-red-200 bg-red-50 px-4 py-2.5 text-xs font-bold text-red-700 sm:text-sm">Tolak Pesanan</button>
                            <button type="button" class="rounded-xl border border-yellow-400 bg-[#FFF2A8] px-4 py-2.5 text-xs font-extrabold text-slate-dark sm:text-sm">Terima Pesanan (Terbitkan Invoice DP)</button>
                        </div>
                    </div>
                </article>

                <article class="rounded-[20px] border border-slate-200 bg-white p-5 sm:p-6">
                    <div class="flex flex-col justify-between gap-3 lg:flex-row lg:items-center">
                        <div class="flex flex-wrap items-center gap-3">
                            <h3 class="text-sm font-extrabold text-slate-dark sm:text-base">Siti Pembeli • #ORD-2026-0042</h3>
                            <span class="rounded-full bg-sky-50 px-3 py-1.5 text-[10px] font-bold text-sky-700 sm:text-xs">
                                SEDANG DIKERJAKAN: TAHAP 2 (LINE ART)
                            </span>
                        </div>
                        <p class="text-sm font-extrabold text-slate-dark sm:text-base">Nilai Komisi: Rp 450.000 (DP Lunas)</p>
                    </div>

                    <p class="mt-4 text-xs leading-relaxed text-slate-body sm:text-sm">
                        Paket: Full Body Cyberpunk Samurai Anime • Draft Line Art sedang ditinjau client • Sisa waktu 4 hari
                    </p>

                    <div class="mt-4 flex flex-col justify-between gap-4 xl:flex-row xl:items-center">
                        <p class="text-xs font-medium text-emerald-700 sm:text-sm">
                            Status Dana: DP Rp 225.000 di Escrow (Cair pasca Line Art disetujui)
                        </p>
                        <div class="flex flex-wrap items-center gap-2">
                            <button type="button" class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-xs font-semibold text-slate-dark sm:text-sm">Chat Client</button>
                            <button type="button" class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-xs font-semibold text-slate-dark sm:text-sm">Terbitkan Dynamic Invoice</button>
                            <button type="button" class="rounded-xl border border-yellow-400 bg-[#FFF2A8] px-4 py-2.5 text-xs font-extrabold text-slate-dark sm:text-sm">Update Draft di Tracker</button>
                        </div>
                    </div>
                </article>
            </main>
        </div>
    </div>
@endsection
