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
                <div
                    class="bg-linear-to-r from-pastel-100 via-pastel-200/90 to-pastel-100 rounded-2xl p-5 sm:p-6 border border-pastel-300 shadow-2xs flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                    <div class="flex items-start gap-4">
                        <div
                            class="w-12 h-12 rounded-xl bg-white text-amber-600 flex items-center justify-center shrink-0 shadow-2xs text-xl">
                            <i class="fa-solid fa-bell-concierge"></i>
                        </div>
                        <div>
                            <span class="text-[10px] uppercase font-bold text-amber-900 font-heading tracking-wider block">
                                Tindakan Memerlukan Respon Anda
                            </span>
                            <h2 class="text-base sm:text-lg font-black font-heading text-slate-dark mt-0.5">
                                Draf Line Art Pesanan #ORD-2026-089 Siap Ditinjau!
                            </h2>
                            <p class="text-xs text-slate-body mt-1 leading-relaxed max-w-2xl">
                                Artist <strong>@rafly.art</strong> telah mengunggah draf Line Art sementara. Segera di
                                periksa.
                            </p>
                        </div>
                    </div>
                    <div class="shrink-0 flex items-center gap-2.5 w-full md:w-auto">
                        <a href="#active-orders"
                            class="w-full md:w-auto px-4 py-2.5 rounded-xl bg-pastel-500 hover:bg-pastel-400 text-slate-dark font-bold text-xs font-heading shadow-xs transition text-center">
                            Lihat
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                    <div
                        class="bg-white p-5 rounded-2xl border border-stone-200/90 shadow-2xs flex items-center justify-between">
                        <div>
                            <span class="text-xs text-slate-muted font-medium block">Pesanan Aktif</span>
                            <div class="flex items-baseline gap-2 mt-1">
                                <span class="text-2xl font-black font-heading text-slate-dark">2</span>
                            </div>
                        </div>
                        <div
                            class="w-11 h-11 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-paintbrush text-base"></i>
                        </div>
                    </div>

                    <div
                        class="bg-white p-5 rounded-2xl border border-stone-200/90 shadow-2xs flex items-center justify-between">
                        <div>
                            <span class="text-xs text-slate-muted font-medium block">Dana di Escrow</span>
                            <div class="flex items-baseline gap-2 mt-1">
                                <span class="text-2xl font-black font-heading text-slate-dark">Rp. 525 K</span>
                            </div>
                        </div>
                        <div
                            class="w-11 h-11 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-lock text-base"></i>
                        </div>
                    </div>

                    <div
                        class="bg-white p-5 rounded-2xl border border-stone-200/90 shadow-2xs flex items-center justify-between">
                        <div>
                            <span class="text-xs text-slate-muted font-medium block">Menunggu Persetujuan</span>
                            <div class="flex items-baseline gap-2 mt-1">
                                <span class="text-2xl font-black font-heading text-amber-600">1</span>
                            </div>
                        </div>
                        <div class="w-11 h-11 rounded-xl bg-sky-100 text-sky-800 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-list-check text-base"></i>
                        </div>
                    </div>

                    <div
                        class="bg-white p-5 rounded-2xl border border-stone-200/90 shadow-2xs flex items-center justify-between">
                        <div>
                            <span class="text-xs text-slate-muted font-medium block">Pesanan Selesai</span>
                            <div class="flex items-baseline gap-2 mt-1">
                                <span class="text-2xl font-black font-heading text-slate-dark">4</span>
                            </div>
                        </div>
                        <div
                            class="w-11 h-11 rounded-xl bg-indigo-100 text-indigo-800 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-check text-base"></i>
                        </div>
                    </div>

                </div>

                <section id="active-orders" class="space-y-4">
                    <div class="flex items-center justify-between pb-2 border-b border-stone-200">
                        <div>
                            <h3 class="text-base sm:text-lg font-black flex items-center gap-2 font-heading text-slate-dark">
                                Linimasa Komisi Sedang Berjalan
                                <span class="w-8 h-8 rounded-full bg-pastel-200 text-xs inline-flex justify-center items-center">
                                    1
                                </span>
                            </h3>
                            <p class="text-xs text-slate-muted">
                                3 progres komisi akan ditampilkan disini.
                            </p>
                        </div>
                        <a href="{{ route('katalog') }}"
                            class="text-xs font-bold text-slate-dark hover:text-amber-700 transition font-heading hidden sm:flex items-center gap-1">
                            <span>Lihat Detail Pesanan</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>

                    <div class="space-y-4">
                        <div class="bg-white rounded-2xl border border-stone-200/90 shadow-xs p-5 sm:p-6 space-y-6">

                            <div
                                class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-stone-100">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-full bg-pastel-300 text-slate-dark font-bold text-sm flex items-center justify-center font-heading">
                                        R
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <h4 class="text-sm font-bold font-heading text-slate-dark">
                                                Bust-Up Anime Karakter Fantasy
                                            </h4>
                                            <span class="text-xs font-semibold text-slate-muted">#ORD-2026-089</span>
                                        </div>
                                        <p class="text-xs text-slate-muted mt-0.5">
                                            Artist: <strong class="text-slate-dark">@rafly.art</strong> • Deadline: <span
                                                class="font-medium text-slate-dark">09 November 2026</span>
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2.5">
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-50 text-amber-800 border border-amber-200 text-xs font-bold font-heading">
                                        <i class="fa-solid fa-clock-rotate-left text-[11px]"></i>
                                        Perlu Review Line Art
                                    </span>
                                    <span
                                        class="text-xs font-extrabold font-heading text-slate-dark bg-stone-100 px-3 py-1 rounded-full border border-stone-200">
                                        Total: Rp 350.000
                                    </span>
                                </div>
                            </div>

                            <div>
                                <div class="grid grid-cols-4 gap-2 sm:gap-4 relative text-center">

                                    <div class="flex flex-col items-center">
                                        <div
                                            class="w-9 h-9 rounded-full bg-emerald-500 text-white flex items-center justify-center font-bold text-xs shadow-xs mb-2">
                                            <i class="fa-solid fa-check"></i>
                                        </div>
                                        <span class="text-xs font-bold text-slate-dark font-heading">1. Sketsa</span>
                                        <span class="text-[10px] text-emerald-700 font-medium">Disetujui</span>
                                    </div>

                                    <div class="flex flex-col items-center">
                                        <div
                                            class="w-9 h-9 rounded-full bg-pastel-300 border-2 border-amber-500 text-slate-dark flex items-center justify-center font-bold text-xs shadow-xs mb-2 animate-pulse">
                                            2
                                        </div>
                                        <span class="text-xs font-bold text-amber-800 font-heading">2. Line Art</span>
                                        <span class="text-[10px] text-amber-700 font-bold">Menunggu Review</span>
                                    </div>

                                    <div class="flex flex-col items-center opacity-40">
                                        <div
                                            class="w-9 h-9 rounded-full bg-stone-100 border border-stone-300 text-slate-500 flex items-center justify-center font-bold text-xs mb-2">
                                            3
                                        </div>
                                        <span class="text-xs font-medium text-slate-body font-heading">3. Coloring</span>
                                        <span class="text-[10px] text-slate-400">Menunggu</span>
                                    </div>

                                    <div class="flex flex-col items-center opacity-40">
                                        <div
                                            class="w-9 h-9 rounded-full bg-stone-100 border border-stone-300 text-slate-500 flex items-center justify-center font-bold text-xs mb-2">
                                            4
                                        </div>
                                        <span class="text-xs font-medium text-slate-body font-heading">4. Rendering</span>
                                        <span class="text-[10px] text-slate-400">Pelunasan</span>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="p-4 rounded-xl bg-stone-50 border border-stone-200/90 flex flex-col sm:flex-row items-center justify-between gap-4">
                                <div class="flex items-center gap-3.5 w-full sm:w-auto">
                                    <div
                                        class="relative w-16 h-16 rounded-lg overflow-hidden border border-stone-200 bg-stone-200 shrink-0">
                                        <img src="https://images.unsplash.com/photo-1578632767115-351597cf2477?w=200&auto=format&fit=crop&q=80"
                                            alt="Preview Line Art" class="w-full h-full object-cover">
                                        <span
                                            class="absolute inset-0 bg-black/40 flex items-center justify-center text-[8px] font-black text-white/90 uppercase tracking-tighter text-center p-1">
                                            ARTSY WATERMARK
                                        </span>
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs font-bold text-slate-dark font-heading">Draf Line Art
                                                Diunggah</span>
                                        </div>
                                        <p class="text-xs text-slate-muted mt-0.5">
                                            "Catatan artisnya disini..."
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2.5 w-full sm:w-auto shrink-0 justify-end">
                                    <a href="{{ route('katalog') }}"
                                        class="px-4 py-2 rounded-xl text-xs font-bold font-heading text-slate-dark bg-pastel-200 hover:bg-pastel-300 border border-pastel-300 shadow-2xs transition">
                                        Tinjau Sekarang
                                        <i class="fa-solid fa-arrow-right text-[11px] mr-1"></i>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                </section>
            </main>
        </div>
    </div>
@endsection