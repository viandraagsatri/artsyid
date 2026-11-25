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
                    <h2 class="text-xl font-bold font-heading text-slate-dark">Pencairan Dana Artist</h2>
                    <p class="text-xs text-slate-muted mt-1">Pantau saldo komisi di escrow dan riwayat pencairan dana oleh admin ke rekening bank Anda.</p>
                </div>
                
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
                    <div class="rounded-2xl border border-slate-200 bg-white p-5">
                        <p class="text-xs font-medium text-slate-muted">Saldo Menunggu Transfer Admin</p>
                        <h3 class="mt-1 text-2xl font-extrabold text-slate-dark">Rp 450.000</h3>
                        <span class="mt-2 inline-flex rounded-full bg-stone-50 px-3 py-1.5 text-[10px] font-semibold text-slate-body sm:text-xs">
                            1 DP + 1 Pelunasan Menunggu
                        </span>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-white p-5">
                        <p class="text-xs font-medium text-slate-muted">Total Dana Berhasil Dicairkan</p>
                        <h3 class="mt-1 text-2xl font-extrabold text-slate-dark">Rp 3.250.000</h3>
                        <span class="mt-2 inline-flex rounded-full bg-stone-50 px-3 py-1.5 text-[10px] font-semibold text-slate-body sm:text-xs">
                            8 Kali Payout Selesai
                        </span>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-white p-5">
                        <p class="text-xs font-medium text-slate-muted">Rekening Bank Pencairan</p>
                        <h3 class="mt-1 text-2xl font-extrabold text-slate-dark">Bank BCA</h3>
                        <span class="mt-2 inline-flex rounded-full bg-stone-50 px-3 py-1.5 text-[10px] font-semibold text-slate-body sm:text-xs">
                            1234567890 a.n Viandra Agsatri
                        </span>
                    </div>
                </div>

                <div class="flex flex-col justify-between gap-4 xl:flex-row xl:items-center">
                    <div class="flex flex-wrap items-center gap-2">
                        <button type="button" class="rounded-xl border border-slate-dark bg-slate-dark px-3.5 py-2.5 text-xs font-bold text-white sm:text-sm">
                            Semua Payout (4)
                        </button>
                        <button type="button" class="rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-xs font-medium text-slate-muted sm:text-sm">
                            Menunggu Transfer (2)
                        </button>
                        <button type="button" class="rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-xs font-medium text-slate-muted sm:text-sm">
                            Selesai Ditransfer (2)
                        </button>
                    </div>

                    <input type="text" placeholder="Cari nomor payout / pesanan..." aria-label="Cari nomor payout atau pesanan"
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-xs text-slate-dark outline-none placeholder:text-slate-400 focus:border-amber-400 sm:w-64 sm:text-sm">
                </div>

                <article class="rounded-[20px] border-2 border-amber-500 bg-white p-5 sm:p-6">
                    <div class="flex flex-col justify-between gap-4 xl:flex-row xl:items-start">
                        <div class="min-w-0 flex-1">
                            <div class="flex flex-wrap items-center gap-2 text-xs sm:text-sm">
                                <h3 class="font-extrabold text-slate-dark">PO-2026-DP-0042</h3>
                                <span class="text-slate-muted">• Pesanan #ORD-2026-0042</span>
                                <span class="rounded-full bg-stone-50 px-3 py-1.5 text-[10px] font-semibold text-slate-body sm:text-xs">Pencairan Tahap 1: DP (50%)</span>
                            </div>
                            <p class="mt-4 text-xs font-bold text-slate-dark sm:text-sm">Client: M. Rafly Saputra</p>
                            <p class="mt-1 text-xs text-slate-muted">Keterangan: Line Art Disetujui Client (18 Nov 2026)</p>
                        </div>
                        <div class="flex flex-wrap items-center gap-3 xl:justify-end">
                            <span class="rounded-full border border-amber-300 bg-amber-100 px-3 py-1.5 text-[10px] font-bold uppercase text-amber-800 sm:text-xs">Menunggu Transfer Admin</span>
                            <p class="text-base font-extrabold text-slate-dark">Rp 225.000</p>
                        </div>
                    </div>
                    <div class="mt-3 flex justify-end">
                        <button type="button" class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-xs font-semibold text-slate-dark sm:text-sm">Detail Pesanan</button>
                    </div>
                </article>

                <article class="rounded-[20px] border-2 border-amber-500 bg-white p-5 sm:p-6">
                    <div class="flex flex-col justify-between gap-4 xl:flex-row xl:items-start">
                        <div class="min-w-0 flex-1">
                            <div class="flex flex-wrap items-center gap-2 text-xs sm:text-sm">
                                <h3 class="font-extrabold text-slate-dark">PO-2026-FN-0035</h3>
                                <span class="text-slate-muted">• Pesanan #ORD-2026-0035</span>
                                <span class="rounded-full bg-stone-50 px-3 py-1.5 text-[10px] font-semibold text-slate-body sm:text-xs">Pencairan Tahap 2: Pelunasan Final</span>
                            </div>
                            <p class="mt-4 text-xs font-bold text-slate-dark sm:text-sm">Client: Annisa Azzahra</p>
                            <p class="mt-1 text-xs text-slate-muted">Keterangan: Karya Akhir Diterima &amp; Disetujui (18 Nov 2026)</p>
                        </div>
                        <div class="flex flex-wrap items-center gap-3 xl:justify-end">
                            <span class="rounded-full border border-amber-300 bg-amber-100 px-3 py-1.5 text-[10px] font-bold uppercase text-amber-800 sm:text-xs">Menunggu Transfer Admin</span>
                            <p class="text-base font-extrabold text-slate-dark">Rp 225.000</p>
                        </div>
                    </div>
                    <div class="mt-3 flex justify-end">
                        <button type="button" class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-xs font-semibold text-slate-dark sm:text-sm">Detail Pesanan</button>
                    </div>
                </article>

                <article class="rounded-[20px] border border-slate-200 bg-white p-5 sm:p-6">
                    <div class="flex flex-col justify-between gap-4 xl:flex-row xl:items-start">
                        <div class="min-w-0 flex-1">
                            <div class="flex flex-wrap items-center gap-2 text-xs sm:text-sm">
                                <h3 class="font-extrabold text-slate-dark">PO-2026-FN-0029</h3>
                                <span class="text-slate-muted">• Pesanan #ORD-2026-0029</span>
                                <span class="rounded-full bg-stone-50 px-3 py-1.5 text-[10px] font-semibold text-slate-body sm:text-xs">Pencairan Tahap 2: Pelunasan Final</span>
                            </div>
                            <p class="mt-4 text-xs font-bold text-slate-dark sm:text-sm">Client: M. Surya Gymnastyar</p>
                            <p class="mt-1 text-xs text-slate-muted">Keterangan: Ditransfer oleh Admin via BCA • 14 Nov 2026</p>
                        </div>
                        <div class="flex flex-wrap items-center gap-3 xl:justify-end">
                            <span class="rounded-full border border-emerald-300 bg-emerald-50 px-3 py-1.5 text-[10px] font-bold uppercase text-emerald-700 sm:text-xs">Berhasil Ditransfer</span>
                            <p class="text-base font-extrabold text-slate-dark">Rp 350.000</p>
                        </div>
                    </div>
                    <div class="mt-3 flex flex-wrap justify-end gap-2">
                        <button type="button" class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-xs font-semibold text-slate-dark sm:text-sm">Lihat Bukti Transfer Bank</button>
                        <button type="button" class="rounded-xl border border-yellow-400 bg-[#FFF2A8] px-4 py-2.5 text-xs font-extrabold text-slate-dark sm:text-sm">Kuitansi Pencairan</button>
                    </div>
                </article>

                <article class="rounded-[20px] border border-slate-200 bg-white p-5 sm:p-6">
                    <div class="flex flex-col justify-between gap-4 xl:flex-row xl:items-start">
                        <div class="min-w-0 flex-1">
                            <div class="flex flex-wrap items-center gap-2 text-xs sm:text-sm">
                                <h3 class="font-extrabold text-slate-dark">PO-2026-DP-0029</h3>
                                <span class="text-slate-muted">• Pesanan #ORD-2026-0029</span>
                                <span class="rounded-full bg-stone-50 px-3 py-1.5 text-[10px] font-semibold text-slate-body sm:text-xs">Pencairan Tahap 1: DP (50%)</span>
                            </div>
                            <p class="mt-4 text-xs font-bold text-slate-dark sm:text-sm">Client: Nur Ramadhani</p>
                            <p class="mt-1 text-xs text-slate-muted">Keterangan: Ditransfer oleh Admin via BCA • 08 Nov 2026</p>
                        </div>
                        <div class="flex flex-wrap items-center gap-3 xl:justify-end">
                            <span class="rounded-full border border-emerald-300 bg-emerald-50 px-3 py-1.5 text-[10px] font-bold uppercase text-emerald-700 sm:text-xs">Berhasil Ditransfer</span>
                            <p class="text-base font-extrabold text-slate-dark">Rp 350.000</p>
                        </div>
                    </div>
                    <div class="mt-3 flex flex-wrap justify-end gap-2">
                        <button type="button" class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-xs font-semibold text-slate-dark sm:text-sm">Lihat Bukti Transfer Bank</button>
                        <button type="button" class="rounded-xl border border-yellow-400 bg-[#FFF2A8] px-4 py-2.5 text-xs font-extrabold text-slate-dark sm:text-sm">Kuitansi Pencairan</button>
                    </div>
                </article>
            </main>
        </div>
    </div>
@endsection
