@extends('layouts.app', ['title' => 'Edit Paket Menu Komisi - Artist Artsy ID'])

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

            <main class="p-4 sm:p-6 lg:p-8 space-y-6 max-w-5xl w-full mx-auto">

                <div>
                    <a href="{{ route('artist.menus.index') }}"
                        class="inline-flex items-center gap-2 text-xs font-bold font-heading text-slate-muted hover:text-slate-dark transition min-h-11 sm:min-h-0">
                        <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
                        <span>Kembali ke Daftar Paket Menu Komisi</span>
                    </a>
                </div>

                @if (session('success'))
                    <div role="status" class="p-4 rounded-2xl bg-status-success-bg border border-status-success-border text-status-success-text text-xs sm:text-sm font-semibold flex items-center justify-between gap-3 shadow-2xs">
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-circle-check text-base shrink-0" aria-hidden="true"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                        <button type="button" onclick="this.parentElement.remove()" aria-label="Tutup notifikasi"
                            class="cursor-pointer min-w-11 min-h-11 sm:min-w-8 sm:min-h-8 rounded-lg hover:bg-emerald-100 flex items-center justify-center transition shrink-0">
                            <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                        </button>
                    </div>
                @endif

                @if ($errors->any())
                    <div role="alert" class="p-4 rounded-2xl bg-status-danger-bg border border-status-danger-border text-status-danger-text text-xs sm:text-sm font-semibold flex items-start justify-between gap-3 shadow-2xs">
                        <div class="flex items-start gap-2.5">
                            <i class="fa-solid fa-triangle-exclamation text-base shrink-0 mt-0.5" aria-hidden="true"></i>
                            <div>
                                <p class="font-bold">Gagal memperbarui paket menu komisi:</p>
                                <p class="mt-0.5 font-medium">{{ $errors->first() }}</p>
                            </div>
                        </div>
                        <button type="button" onclick="this.parentElement.remove()" aria-label="Tutup peringatan"
                            class="cursor-pointer min-w-11 min-h-11 sm:min-w-8 sm:min-h-8 rounded-lg hover:bg-red-100 flex items-center justify-center transition shrink-0">
                            <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                        </button>
                    </div>
                @endif

                <div class="bg-white rounded-2xl border border-stone-200/90 shadow-2xs p-5 sm:p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="min-w-0">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-pastel-100 border border-pastel-300 text-[11px] font-bold font-heading text-amber-900 mb-2">
                            <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i>
                            <span>Edit Paket Komisi</span>
                        </span>
                        <h1 class="text-xl sm:text-2xl font-black font-heading text-slate-dark truncate">
                            {{ $menu->title }}
                        </h1>
                        <p class="text-xs sm:text-sm text-slate-muted mt-1">
                            Perbarui harga, slot, ketentuan revisi, atau sampel gambar untuk paket komisi ini.
                        </p>
                    </div>

                    <div class="flex flex-wrap items-center gap-2 shrink-0">
                        <span class="px-3 py-1.5 rounded-full bg-stone-100 border border-stone-200 text-xs font-bold text-slate-dark tabular-nums">
                            {{ $menu->orders_count }} total pesanan
                        </span>
                        <span class="px-3 py-1.5 rounded-full {{ $menu->is_active ? 'bg-status-success-bg border-status-success-border text-status-success-text' : 'bg-stone-100 border-stone-200 text-slate-body' }} border text-xs font-bold">
                            {{ $menu->is_active ? 'Aktif di Etalase' : 'Ditutup' }}
                        </span>
                    </div>
                </div>

                <form action="{{ route('artist.menus.update', $menu) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @include('artist.menus._form_fields', ['form' => $form, 'categories' => $categories])
                </form>

            </main>
        </div>
    </div>
@endsection
