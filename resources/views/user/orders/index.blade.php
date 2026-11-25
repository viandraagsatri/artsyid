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
                    <h2 class="text-xl font-bold font-heading text-slate-dark">Pesanan Saya</h2>
                    <p class="text-xs text-slate-muted mt-1">Pantau linimasa progres 4 tahap pesanan Anda, review draf ber-watermark, dan chat dengan artist.</p>
                </div>
                
                <div class="flex flex-col justify-between gap-4 xl:flex-row xl:items-center">
                    <div class="flex flex-wrap items-center gap-2">
                        <button type="button" class="rounded-xl border border-slate-dark bg-slate-dark px-3.5 py-2.5 text-xs font-bold text-white sm:text-sm">
                            Semua (2)
                        </button>
                        <button type="button" class="rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-xs font-medium text-slate-muted sm:text-sm">
                            Perlu Tindakan (1)
                        </button>
                        <button type="button" class="rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-xs font-medium text-slate-muted sm:text-sm">
                            Menunggu DP (8)
                        </button>
                        <button type="button" class="rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-xs font-medium text-slate-muted sm:text-sm">
                            Sedang Dikerjakan (8)
                        </button>
                        <button type="button" class="rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-xs font-medium text-slate-muted sm:text-sm">
                            Menunggu Pelunasan (8)
                        </button>
                    </div>

                    <input 
                        type="text" 
                        placeholder="Cari nomor pesanan atau artist..." aria-label="Cari artist atau nomor pesanan" 
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-xs text-slate-dark outline-none placeholder:text-slate-400 focus:border-amber-400 sm:w-64 sm:text-sm"
                    />
            </main>
        </div>
    </div>
@endsection
