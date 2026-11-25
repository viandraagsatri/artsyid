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
                    <h2 class="text-xl font-bold font-heading text-slate-dark">Tagihan &amp; Escrow</h2>
                    <p class="text-xs text-slate-muted mt-1">Daftar tagihan komisi (DP 50%, Pelunasan, &amp; Dynamic Add-ons) yang dibayarkan aman via Midtrans.</p>
                </div>
                
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
                    <div class="rounded-2xl border border-slate-200 bg-white p-5">
                        <p class="text-xs font-medium text-slate-muted">Dana Diamankan di Escrow</p>
                        <h3 class="mt-1 text-2xl font-extrabold text-slate-dark">Rp 450.000</h3>
                        <span class="mt-2 inline-flex rounded-full bg-stone-50 px-3 py-1.5 text-[10px] font-semibold text-slate-body sm:text-xs">
                            2 Pesanan Aktif
                        </span>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-white p-5">
                        <p class="text-xs font-medium text-slate-muted">Tagihan Menunggu Pembayaran</p>
                        <h3 class="mt-1 text-2xl font-extrabold text-slate-dark">Rp 1.250.000</h3>
                        <span class="mt-2 inline-flex rounded-full bg-stone-50 px-3 py-1.5 text-[10px] font-semibold text-slate-body sm:text-xs">
                            1 DP + 2 Pelunasan
                        </span>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-white p-5">
                        <p class="text-xs font-medium text-slate-muted">Total Transaksi Berhasil</p>
                        <h3 class="mt-1 text-2xl font-extrabold text-slate-dark">Rp 5.340.000</h3>
                        <span class="mt-2 inline-flex rounded-full bg-stone-50 px-3 py-1.5 text-[10px] font-semibold text-slate-body sm:text-xs">
                            5 Pesanan Lunas dan Selesai
                        </span>
                    </div>
                </div>

                <div class="flex flex-col justify-between gap-4 xl:flex-row xl:items-center">
                    <div class="flex flex-wrap items-center gap-2">
                        <button type="button" class="rounded-xl border border-slate-dark bg-slate-dark px-3.5 py-2.5 text-xs font-bold text-white sm:text-sm">
                            Semua Invoice (4)
                        </button>
                        <button type="button" class="rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-xs font-medium text-slate-muted sm:text-sm">
                            Menunggu Pembayaran (2)
                        </button>
                        <button type="button" class="rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-xs font-medium text-slate-muted sm:text-sm">
                            Lunas di Escrow (2)
                        </button>
                    </div>

                    <input type="text" placeholder="Cari nomor invoice / pesanan..." aria-label="Cari nomor invoice atau pesanan"
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-xs text-slate-dark outline-none placeholder:text-slate-400 focus:border-amber-400 sm:w-64 sm:text-sm">
                </div>
            </main>
        </div>
    </div>
@endsection
