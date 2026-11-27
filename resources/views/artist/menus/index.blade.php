@extends('layouts.app', ['title' => 'Paket Menu Komisi - Artist Artsy ID'])

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

            <main class="p-4 sm:p-6 lg:p-8 space-y-6 max-w-7xl w-full mx-auto">

                @if (session('success'))
                    <div role="status" class="p-4 rounded-2xl bg-status-success-bg border border-status-success-border text-status-success-text text-xs sm:text-sm font-semibold flex items-center justify-between gap-3 shadow-2xs">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <i class="fa-solid fa-circle-check text-base shrink-0" aria-hidden="true"></i>
                            <span class="wrap-break-word">{{ session('success') }}</span>
                        </div>
                        <button type="button" onclick="this.parentElement.remove()" aria-label="Tutup notifikasi"
                            class="cursor-pointer min-w-11 min-h-11 sm:min-w-8 sm:min-h-8 rounded-lg hover:bg-emerald-100 font-bold flex items-center justify-center transition shrink-0">
                            <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                        </button>
                    </div>
                @endif

                @if ($errors->getBag('default')->any())
                    <div role="alert" class="p-4 rounded-2xl bg-status-danger-bg border border-status-danger-border text-status-danger-text text-xs sm:text-sm font-semibold flex items-center justify-between gap-3 shadow-2xs">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <i class="fa-solid fa-triangle-exclamation text-base shrink-0" aria-hidden="true"></i>
                            <span class="wrap-break-word">{{ $errors->getBag('default')->first() }}</span>
                        </div>
                        <button type="button" onclick="this.parentElement.remove()" aria-label="Tutup peringatan"
                            class="cursor-pointer min-w-11 min-h-11 sm:min-w-8 sm:min-h-8 rounded-lg hover:bg-red-100 font-bold flex items-center justify-center transition shrink-0">
                            <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                        </button>
                    </div>
                @endif

                <!-- Header -->
                <div class="bg-white rounded-2xl border border-stone-200/90 shadow-2xs p-5 sm:p-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-xl sm:text-2xl font-black font-heading text-slate-dark">
                            Paket Menu Komisi
                        </h1>
                        <p class="text-xs sm:text-sm text-slate-muted mt-1">
                            Kelola daftar layanan komisi seni, harga dasar, persentase DP Escrow, kuota slot, sampel gambar, dan add-ons.
                        </p>
                    </div>
                    <div class="shrink-0">
                        <a href="{{ route('artist.menus.form_create_menu') }}"
                            class="btn-primary min-h-11 sm:min-h-0 gap-2 w-full sm:w-auto cursor-pointer">
                            <i class="fa-solid fa-plus" aria-hidden="true"></i>
                            <span>Tambah Menu Komisi</span>
                        </a>
                    </div>
                </div>

                <!-- Ringkasan KPI -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                    <div class="bg-white p-4 sm:p-5 rounded-2xl border border-stone-200/90 shadow-2xs flex items-center justify-between gap-3">
                        <div class="min-w-0">
                            <span class="text-[11px] sm:text-xs text-slate-muted font-medium block">Total Paket</span>
                            <span class="text-xl sm:text-2xl font-black font-heading text-slate-dark mt-1 block tabular-nums">
                                {{ $stats['total_menus'] }}
                            </span>
                            <span class="text-[11px] text-slate-muted block mt-0.5 tabular-nums">
                                {{ $stats['total_addons'] }} add-on tersedia
                            </span>
                        </div>
                        <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-stone-100 text-slate-dark flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-layer-group text-sm sm:text-base" aria-hidden="true"></i>
                        </div>
                    </div>

                    <div class="bg-white p-4 sm:p-5 rounded-2xl border border-stone-200/90 shadow-2xs flex items-center justify-between gap-3">
                        <div class="min-w-0">
                            <span class="text-[11px] sm:text-xs text-slate-muted font-medium block">Paket Aktif</span>
                            <span class="text-xl sm:text-2xl font-black font-heading text-status-success-text mt-1 block tabular-nums">
                                {{ $stats['active_menus'] }}
                            </span>
                            <span class="text-[11px] text-slate-muted block mt-0.5 tabular-nums">
                                {{ $stats['inactive_menus'] }} paket ditutup
                            </span>
                        </div>
                        <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-status-success-bg border border-status-success-border text-status-success-text flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-store text-sm sm:text-base" aria-hidden="true"></i>
                        </div>
                    </div>

                    <div class="bg-white p-4 sm:p-5 rounded-2xl border border-stone-200/90 shadow-2xs flex items-center justify-between gap-3">
                        <div class="min-w-0">
                            <span class="text-[11px] sm:text-xs text-slate-muted font-medium block">Total Slot Terbuka</span>
                            <span class="text-xl sm:text-2xl font-black font-heading text-slate-dark mt-1 block tabular-nums">
                                {{ $stats['open_slots_total'] }}
                            </span>
                        </div>
                        <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-pastel-100 border border-pastel-300 text-amber-900 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-ticket text-sm sm:text-base" aria-hidden="true"></i>
                        </div>
                    </div>

                    <div class="bg-white p-4 sm:p-5 rounded-2xl border border-stone-200/90 shadow-2xs flex items-center justify-between gap-3">
                        <div class="min-w-0">
                            <span class="text-[11px] sm:text-xs text-slate-muted font-medium block">Pesanan Berjalan</span>
                            <span class="text-xl sm:text-2xl font-black font-heading text-status-info-text mt-1 block tabular-nums">
                                {{ $stats['active_orders_total'] }}
                            </span>
                            <span class="text-[11px] text-slate-muted block mt-0.5">
                                Antrean &amp; progres WIP
                            </span>
                        </div>
                        <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-status-info-bg border border-status-info-border text-status-info-text flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-paintbrush text-sm sm:text-base" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>

                <!-- Tab Status & Filter Pencarian -->
                <div class="bg-white rounded-2xl border border-stone-200/90 shadow-2xs p-4 sm:p-5 space-y-4">
                    <div class="flex flex-wrap items-center gap-2 border-b border-stone-100 pb-3">
                        @foreach ($statusTabs as $tab)
                            <a href="{{ $tab['url'] }}"
                                class="min-h-11 sm:min-h-0 px-3.5 py-2 rounded-xl text-xs font-bold font-heading inline-flex items-center gap-2 transition {{ $tab['active'] ? 'bg-pastel-200 text-slate-dark border border-pastel-300 shadow-2xs' : 'bg-stone-100 text-slate-body hover:bg-stone-200 border border-transparent' }}">
                                <span>{{ $tab['label'] }}</span>
                                <span class="px-1.5 py-0.5 rounded-full text-[10px] font-extrabold tabular-nums {{ $tab['active'] ? 'bg-white text-slate-dark' : 'bg-white/80 text-slate-muted' }}">
                                    {{ $tab['count'] }}
                                </span>
                            </a>
                        @endforeach
                    </div>

                    <form action="{{ route('artist.menus.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-12 gap-3 items-end">
                        @if (($filters['status'] ?? 'all') !== 'all')
                            <input type="hidden" name="status" value="{{ $filters['status'] }}">
                        @endif

                        <div class="sm:col-span-2 xl:col-span-4">
                            <label for="filter-search" class="block text-xs font-semibold font-heading text-slate-dark mb-1">
                                Cari Paket atau Add-on
                            </label>
                            <div class="relative">
                                <i class="fa-solid fa-magnifying-glass text-xs text-slate-muted absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" aria-hidden="true"></i>
                                <input
                                    type="search"
                                    id="filter-search"
                                    name="search"
                                    value="{{ $filters['search'] ?? '' }}"
                                    placeholder="Nama paket, kategori, atau add-on..."
                                    class="w-full min-h-11 sm:min-h-10 rounded-xl border border-stone-300 bg-bg-light pl-9 pr-3.5 py-2 text-xs sm:text-sm text-slate-dark placeholder:text-slate-muted/80 focus:border-slate-dark focus:ring-2 focus:ring-pastel-300/70 focus:outline-none transition"
                                >
                            </div>
                        </div>

                        <div class="sm:col-span-1 xl:col-span-3">
                            <label for="filter-category" class="block text-xs font-semibold font-heading text-slate-dark mb-1">
                                Kategori
                            </label>
                            <select
                                id="filter-category"
                                name="category_id"
                                class="w-full min-h-11 sm:min-h-10 rounded-xl border border-stone-300 bg-bg-light px-3 py-2 text-xs sm:text-sm text-slate-dark focus:border-slate-dark focus:ring-2 focus:ring-pastel-300/70 focus:outline-none transition cursor-pointer"
                            >
                                <option value="">Semua Kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ (int) ($filters['category_id'] ?? 0) === (int) $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="sm:col-span-1 xl:col-span-2">
                            <label for="filter-request-type" class="block text-xs font-semibold font-heading text-slate-dark mb-1">
                                Tipe Order
                            </label>
                            <select
                                id="filter-request-type"
                                name="request_type"
                                class="w-full min-h-11 sm:min-h-10 rounded-xl border border-stone-300 bg-bg-light px-3 py-2 text-xs sm:text-sm text-slate-dark focus:border-slate-dark focus:ring-2 focus:ring-pastel-300/70 focus:outline-none transition cursor-pointer"
                            >
                                <option value="all" {{ ($filters['request_type'] ?? 'all') === 'all' ? 'selected' : '' }}>Semua Tipe</option>
                                <option value="custom" {{ ($filters['request_type'] ?? 'all') === 'custom' ? 'selected' : '' }}>Custom</option>
                                <option value="instant" {{ ($filters['request_type'] ?? 'all') === 'instant' ? 'selected' : '' }}>Instant</option>
                            </select>
                        </div>

                        <div class="sm:col-span-2 xl:col-span-3 flex items-center gap-2">
                            <button type="submit"
                                class="btn-primary min-h-11 sm:min-h-10 flex-1 px-4 py-2 text-xs cursor-pointer">
                                Terapkan
                            </button>
                            @if ($hasActiveFilters)
                                <a href="{{ route('artist.menus.index') }}"
                                    class="btn-secondary min-h-11 sm:min-h-10 px-3.5 py-2 text-xs cursor-pointer shrink-0"
                                    title="Reset semua filter">
                                    Reset
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                <!-- Daftar Paket Menu Komisi -->
                @if ($menus->isEmpty())
                    <div class="bg-white rounded-2xl border border-stone-200/90 shadow-2xs p-8 sm:p-10 text-center space-y-3">
                        <div class="w-14 h-14 rounded-2xl bg-pastel-100 border border-pastel-300 text-amber-900 flex items-center justify-center mx-auto text-xl">
                            <i class="fa-solid {{ $hasActiveFilters ? 'fa-filter-circle-xmark' : 'fa-palette' }}" aria-hidden="true"></i>
                        </div>
                        @if ($hasActiveFilters)
                            <h2 class="text-base sm:text-lg font-bold font-heading text-slate-dark">
                                Tidak Ada Paket yang Cocok dengan Filter
                            </h2>
                            <p class="text-xs sm:text-sm text-slate-muted max-w-md mx-auto">
                                Coba ubah kata kunci pencarian, kategori, atau status untuk melihat paket komisi Anda yang lain.
                            </p>
                            <div class="pt-2">
                                <a href="{{ route('artist.menus.index') }}" class="btn-secondary min-h-11 sm:min-h-0 text-xs cursor-pointer">
                                    Tampilkan Semua Paket
                                </a>
                            </div>
                        @else
                            <h2 class="text-base sm:text-lg font-bold font-heading text-slate-dark">
                                Belum Ada Paket Menu Komisi
                            </h2>
                            <p class="text-xs sm:text-sm text-slate-muted max-w-md mx-auto">
                                Buat paket komisi pertama Anda lengkap dengan harga, DP Escrow, estimasi pengerjaan, dan sampel karya agar client dapat langsung memesan.
                            </p>
                            <div class="pt-2">
                                <a href="{{ route('artist.menus.form_create_menu') }}" class="btn-primary min-h-11 sm:min-h-0 text-xs cursor-pointer gap-2">
                                    <i class="fa-solid fa-plus" aria-hidden="true"></i>
                                    <span>Buat Paket Pertama</span>
                                </a>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach ($menuCards as $card)
                            <article class="bg-white rounded-2xl border border-stone-200/90 shadow-2xs p-4 sm:p-6 transition hover:shadow-md">
                                <div class="flex flex-col lg:flex-row gap-5">
                                    <!-- Kolom Sampel Gambar -->
                                    <div class="w-full lg:w-64 shrink-0 space-y-2">
                                        <div class="aspect-4/3 w-full rounded-xl overflow-hidden bg-stone-100 border border-stone-200 flex items-center justify-center">
                                            @if ($card['primary_sample_url'])
                                                <img src="{{ $card['primary_sample_url'] }}"
                                                    alt="Sampel {{ $card['model']->title }}"
                                                    class="w-full h-full object-cover">
                                            @else
                                                <div class="text-center p-4 space-y-1.5">
                                                    <i class="fa-regular fa-image text-2xl text-slate-muted" aria-hidden="true"></i>
                                                    <span class="block text-[11px] font-medium text-slate-muted">Belum ada sampel</span>
                                                </div>
                                            @endif
                                        </div>

                                        @if (count($card['extra_sample_urls']) > 0)
                                            <div class="grid grid-cols-4 gap-1.5">
                                                @foreach ($card['extra_sample_urls'] as $extraUrl)
                                                    <div class="aspect-4/3 rounded-lg overflow-hidden bg-stone-100 border border-stone-200 flex items-center justify-center">
                                                        @if ($extraUrl)
                                                            <img src="{{ $extraUrl }}" alt="Sampel tambahan {{ $card['model']->title }}" class="w-full h-full object-cover">
                                                        @else
                                                            <i class="fa-regular fa-image text-xs text-slate-muted" aria-hidden="true"></i>
                                                        @endif
                                                    </div>
                                                @endforeach
                                                @if ($card['remaining_samples_count'] > 0)
                                                    <div class="aspect-4/3 rounded-lg bg-pastel-100 border border-pastel-300 flex items-center justify-center text-[11px] font-bold text-slate-dark">
                                                        +{{ $card['remaining_samples_count'] }}
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Kolom Informasi & Kontrol -->
                                    <div class="flex-1 min-w-0 flex flex-col justify-between gap-4">
                                        <div class="space-y-3.5">
                                            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-3">
                                                <div class="min-w-0 space-y-2">
                                                    <h2 class="text-base sm:text-lg font-extrabold font-heading text-slate-dark wrap-break-word">
                                                        {{ $card['model']->title }}
                                                    </h2>
                                                    <div class="flex flex-wrap items-center gap-2">
                                                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-stone-100 border border-stone-200 text-[11px] font-bold text-slate-dark">
                                                            {{ $card['model']->category?->name ?? 'Tanpa Kategori' }}
                                                        </span>
                                                        <span class="inline-flex items-center px-3 py-1 rounded-full border text-[11px] font-bold {{ $card['model']->request_type === 'instant' ? 'bg-pastel-100 border-pastel-300 text-amber-900' : 'bg-status-info-bg border-status-info-border text-status-info-text' }}">
                                                            {{ $card['model']->request_type === 'instant' ? 'Order Instant' : 'Order Custom' }}
                                                        </span>
                                                        <span class="inline-flex items-center px-3 py-1 rounded-full border text-[11px] font-bold {{ match($card['slot_status']) { 'closed' => 'bg-stone-100 border-stone-200 text-slate-body', 'full' => 'bg-amber-50 border-amber-200 text-amber-900', default => 'bg-status-success-bg border-status-success-border text-status-success-text' } }}">
                                                            {{ $card['slot_badge_label'] }}
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="sm:text-right shrink-0">
                                                    <span class="text-[11px] font-semibold text-slate-muted uppercase tracking-wide block">
                                                        Harga Dasar
                                                    </span>
                                                    <span class="text-lg sm:text-xl font-black font-heading text-slate-dark tabular-nums block">
                                                        Rp {{ number_format((float) $card['model']->base_price, 0, ',', '.') }}
                                                    </span>
                                                    <span class="inline-flex items-center mt-1 px-2.5 py-0.5 rounded-full bg-pastel-100 border border-pastel-300 text-[11px] font-bold text-amber-900 tabular-nums">
                                                        DP {{ $card['dp_percentage_int'] }}%: Rp {{ number_format($card['dp_amount'], 0, ',', '.') }}
                                                    </span>
                                                </div>
                                            </div>

                                            <!-- Deskripsi -->
                                            <p class="text-xs sm:text-sm text-slate-body line-clamp-2">
                                                {{ $card['model']->description }}
                                            </p>

                                            <!-- Spesifikasi Paket -->
                                            <div class="flex flex-wrap items-center gap-2">
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-stone-100 text-xs font-semibold text-slate-dark">
                                                    <i class="fa-regular fa-clock text-slate-muted" aria-hidden="true"></i>
                                                    <span>Estimasi: {{ $card['model']->estimated_days }} hari</span>
                                                </span>
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-stone-100 text-xs font-semibold text-slate-dark">
                                                    <i class="fa-solid fa-rotate-left text-slate-muted" aria-hidden="true"></i>
                                                    <span>Maks. {{ $card['model']->max_revision }}x revisi total</span>
                                                </span>
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-stone-100 text-xs font-semibold text-slate-dark tabular-nums">
                                                    <i class="fa-solid fa-ticket text-slate-muted" aria-hidden="true"></i>
                                                    <span>Slot tersisa: {{ $card['model']->available_slots }}</span>
                                                </span>
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-status-info-bg border border-status-info-border text-xs font-semibold text-status-info-text tabular-nums">
                                                    <i class="fa-solid fa-briefcase" aria-hidden="true"></i>
                                                    <span>{{ $card['model']->active_orders_count }} pesanan berjalan</span>
                                                </span>
                                            </div>

                                            <!-- Daftar Add-ons Ringkas -->
                                            <div class="pt-1 flex flex-wrap items-center gap-2">
                                                <span class="text-xs font-bold font-heading text-slate-dark">
                                                    Add-ons ({{ $card['model']->addons_count }}):
                                                </span>
                                                @if ($card['model']->addons->isEmpty())
                                                    <span class="text-xs text-slate-muted">
                                                        Belum ada add-on tambahan.
                                                    </span>
                                                @else
                                                    @foreach ($card['preview_addons'] as $addon)
                                                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-bg-light border border-stone-200 text-xs font-semibold text-slate-dark tabular-nums">
                                                            {{ $addon->title }} (+Rp {{ number_format((float) $addon->price, 0, ',', '.') }})
                                                        </span>
                                                    @endforeach
                                                    @if ($card['remaining_addons_count'] > 0)
                                                        <span class="text-xs font-semibold text-slate-muted">
                                                            +{{ $card['remaining_addons_count'] }} lainnya
                                                        </span>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Footer Aksi -->
                                        <div class="pt-3.5 border-t border-stone-100">
                                            <div class="flex flex-wrap items-center gap-2">
                                                <button type="button"
                                                    data-open-addons="{{ $card['model']->id }}"
                                                    class="btn-primary min-h-11 sm:min-h-0 px-3.5 py-2 text-xs cursor-pointer gap-1.5">
                                                    <i class="fa-solid fa-puzzle-piece" aria-hidden="true"></i>
                                                    <span>Kelola Add-ons ({{ $card['model']->addons_count }})</span>
                                                </button>

                                                <a href="{{ route('artist.menus.edit', $card['model']) }}"
                                                    class="btn-secondary min-h-11 sm:min-h-0 px-3.5 py-2 text-xs cursor-pointer gap-1.5">
                                                    <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i>
                                                    <span>Edit Paket</span>
                                                </a>

                                                <form action="{{ route('artist.menus.toggle', $card['model']) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                        class="min-h-11 sm:min-h-0 px-3.5 py-2 rounded-xl border text-xs font-bold font-heading transition cursor-pointer inline-flex items-center gap-1.5 {{ $card['model']->is_active ? 'bg-stone-100 hover:bg-stone-200 border-stone-200 text-slate-dark' : 'bg-status-success-bg hover:bg-emerald-100 border-status-success-border text-status-success-text' }}">
                                                        <i class="fa-solid {{ $card['model']->is_active ? 'fa-lock' : 'fa-lock-open' }}" aria-hidden="true"></i>
                                                        <span>{{ $card['model']->is_active ? 'Tutup Slot' : 'Buka Slot' }}</span>
                                                    </button>
                                                </form>

                                                @if ($card['model']->orders_count === 0)
                                                    <button type="button"
                                                        data-open-delete="{{ $card['model']->id }}"
                                                        class="min-h-11 sm:min-h-0 px-3.5 py-2 rounded-xl bg-status-danger-bg hover:bg-red-100 border border-status-danger-border text-status-danger-text text-xs font-bold font-heading transition cursor-pointer inline-flex items-center gap-1.5">
                                                        <i class="fa-solid fa-trash-can" aria-hidden="true"></i>
                                                        <span>Hapus</span>
                                                    </button>
                                                @else
                                                    <button type="button"
                                                        disabled
                                                        title="Paket memiliki {{ $card['model']->orders_count }} riwayat pesanan sehingga tidak dapat dihapus. Gunakan tombol Tutup Slot."
                                                        class="min-h-11 sm:min-h-0 px-3.5 py-2 rounded-xl bg-stone-100 border border-stone-200 text-slate-muted text-xs font-bold font-heading opacity-65 cursor-not-allowed inline-flex items-center gap-1.5">
                                                        <i class="fa-solid fa-trash-can" aria-hidden="true"></i>
                                                        <span>Terkunci Order</span>
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    @if ($menus->hasPages())
                        <div class="pt-2">
                            {{ $menus->links() }}
                        </div>
                    @endif
                @endif

            </main>
        </div>
    </div>

    <!-- Modal Kelola Add-ons -->
    <div id="addons-modal"
        role="dialog"
        aria-modal="true"
        aria-labelledby="addons-modal-title"
        class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-slate-dark/60 backdrop-blur-xs">
        <div class="bg-white rounded-2xl border border-stone-200 shadow-xl w-full max-w-2xl max-h-[90vh] flex flex-col overflow-hidden">
            <div class="px-5 py-4 border-b border-stone-100 flex items-center justify-between gap-3 shrink-0">
                <div class="min-w-0">
                    <h2 id="addons-modal-title" class="text-base sm:text-lg font-black font-heading text-slate-dark">
                        Kelola Add-ons Paket
                    </h2>
                    <p id="addons-modal-menu-title" class="text-xs text-slate-muted truncate mt-0.5"></p>
                </div>
                <button type="button" data-close-modal="addons-modal" aria-label="Tutup modal kelola add-ons"
                    class="cursor-pointer min-w-11 min-h-11 sm:min-w-9 sm:min-h-9 rounded-xl bg-stone-100 hover:bg-stone-200 text-slate-dark flex items-center justify-center transition shrink-0">
                    <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                </button>
            </div>

            <div class="p-5 overflow-y-auto space-y-5 flex-1">
                @if (session('addon_success'))
                    <div role="status" data-addon-modal-alert class="p-3.5 rounded-xl bg-status-success-bg border border-status-success-border text-status-success-text text-xs font-semibold flex items-center gap-2">
                        <i class="fa-solid fa-circle-check shrink-0" aria-hidden="true"></i>
                        <span>{{ session('addon_success') }}</span>
                    </div>
                @endif

                @if ($modalState['has_addon_errors'])
                    <div role="alert" data-addon-modal-alert class="p-3.5 rounded-xl bg-status-danger-bg border border-status-danger-border text-status-danger-text text-xs font-semibold flex items-center gap-2">
                        <i class="fa-solid fa-triangle-exclamation shrink-0" aria-hidden="true"></i>
                        <span>
                            {{ $modalState['has_addon_store_errors'] ? $errors->getBag('addonStore')->first() : $errors->getBag('addonUpdate')->first() }}
                        </span>
                    </div>
                @endif

                <!-- Daftar Add-ons Saat Ini -->
                <div class="space-y-2.5">
                    <h3 class="text-xs font-bold font-heading uppercase tracking-wider text-slate-muted">
                        Daftar Add-ons Tersedia
                    </h3>
                    <div id="addons-list-container" class="space-y-2.5"></div>
                </div>

                <!-- Form Tambah / Edit Add-on -->
                <form id="addon-form" action="" method="POST" class="rounded-2xl border border-stone-200 bg-bg-light p-4 space-y-4">
                    @csrf
                    <input type="hidden" id="addon-method-field" name="_method" value="PUT" disabled>
                    <input type="hidden" id="addon-menu-id-input" name="addon_menu_id" value="">
                    <input type="hidden" id="addon-edit-id-input" name="addon_edit_id" value="">

                    <div class="flex items-center justify-between gap-2">
                        <span id="addon-form-heading" class="text-sm font-bold font-heading text-slate-dark">
                            Tambah Add-on Baru
                        </span>
                        <button type="button" id="addon-cancel-edit-btn"
                            class="hidden min-h-11 sm:min-h-0 items-center text-xs font-bold text-slate-muted hover:text-slate-dark underline cursor-pointer">
                            Batal Edit
                        </button>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <div>
                            <label for="addon_title" class="block text-xs font-semibold font-heading text-slate-dark mb-1">
                                Nama Add-on <span class="text-red-600" aria-hidden="true">*</span>
                            </label>
                            <input
                                type="text"
                                id="addon_title"
                                name="title"
                                required
                                maxlength="120"
                                placeholder="Contoh: Background Detail"
                                class="w-full min-h-11 sm:min-h-10 rounded-xl border border-stone-300 bg-white px-3.5 py-2 text-xs sm:text-sm text-slate-dark focus:border-slate-dark focus:ring-2 focus:ring-pastel-300/70 focus:outline-none transition"
                            >
                        </div>

                        <div>
                            <label for="addon_price" class="block text-xs font-semibold font-heading text-slate-dark mb-1">
                                Harga Tambahan (Rp) <span class="text-red-600" aria-hidden="true">*</span>
                            </label>
                            <input
                                type="number"
                                id="addon_price"
                                name="price"
                                required
                                min="1000"
                                step="1"
                                placeholder="Contoh: 75000"
                                class="w-full min-h-11 sm:min-h-10 rounded-xl border border-stone-300 bg-white px-3.5 py-2 text-xs sm:text-sm text-slate-dark tabular-nums focus:border-slate-dark focus:ring-2 focus:ring-pastel-300/70 focus:outline-none transition"
                            >
                        </div>
                    </div>

                    <div>
                        <label for="addon_description" class="block text-xs font-semibold font-heading text-slate-dark mb-1">
                            Keterangan Singkat (Opsional)
                        </label>
                        <textarea
                            id="addon_description"
                            name="description"
                            rows="2"
                            maxlength="500"
                            placeholder="Jelaskan detail tambahan yang didapat client..."
                            class="w-full rounded-xl border border-stone-300 bg-white px-3.5 py-2 text-xs sm:text-sm text-slate-dark focus:border-slate-dark focus:ring-2 focus:ring-pastel-300/70 focus:outline-none transition"
                        ></textarea>
                    </div>

                    <div class="flex items-center justify-end gap-2">
                        <button type="submit" id="addon-submit-btn" class="btn-primary min-h-11 sm:min-h-0 text-xs cursor-pointer gap-1.5">
                            <i class="fa-solid fa-plus" aria-hidden="true"></i>
                            <span id="addon-submit-label">Simpan Add-on</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus Paket -->
    <div id="delete-menu-modal"
        role="dialog"
        aria-modal="true"
        aria-labelledby="delete-menu-modal-title"
        class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-slate-dark/60 backdrop-blur-xs">
        <div class="bg-white rounded-2xl border border-stone-200 shadow-xl w-full max-w-md p-5 sm:p-6 space-y-4">
            <div class="flex items-start justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-status-danger-bg border border-status-danger-border text-status-danger-text flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-trash-can" aria-hidden="true"></i>
                    </div>
                    <div>
                        <h2 id="delete-menu-modal-title" class="text-base font-black font-heading text-slate-dark">
                            Hapus Paket Komisi?
                        </h2>
                        <p class="text-xs text-slate-muted">Tindakan ini tidak dapat dibatalkan.</p>
                    </div>
                </div>
                <button type="button" data-close-modal="delete-menu-modal" aria-label="Tutup modal konfirmasi hapus"
                    class="cursor-pointer min-w-11 min-h-11 sm:min-w-8 sm:min-h-8 rounded-lg hover:bg-stone-100 text-slate-muted flex items-center justify-center transition">
                    <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                </button>
            </div>

            <p class="text-xs sm:text-sm text-slate-body">
                Anda akan menghapus paket <strong id="delete-menu-name" class="text-slate-dark"></strong> beserta seluruh sampel gambar dan add-ons di dalamnya.
            </p>

            <form id="delete-menu-form" action="" method="POST" class="flex flex-col-reverse sm:flex-row sm:items-center justify-end gap-2.5 pt-2">
                @csrf
                @method('DELETE')
                <button type="button" data-close-modal="delete-menu-modal"
                    class="btn-secondary min-h-11 sm:min-h-0 text-xs cursor-pointer">
                    Batal
                </button>
                <button type="submit"
                    class="min-h-11 sm:min-h-0 px-4 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white text-xs font-bold font-heading transition cursor-pointer">
                    Ya, Hapus Paket
                </button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const addonsByMenu = @json($addonsPayload, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
            const menusMeta = @json($menusMetaPayload, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
            const initialModalState = @json($modalState['initial_modal_state'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

            const addonsModal = document.getElementById('addons-modal');
            const addonsModalMenuTitle = document.getElementById('addons-modal-menu-title');
            const addonsListContainer = document.getElementById('addons-list-container');
            const addonForm = document.getElementById('addon-form');
            const addonMethodField = document.getElementById('addon-method-field');
            const addonMenuIdInput = document.getElementById('addon-menu-id-input');
            const addonEditIdInput = document.getElementById('addon-edit-id-input');
            const addonFormHeading = document.getElementById('addon-form-heading');
            const addonCancelEditBtn = document.getElementById('addon-cancel-edit-btn');
            const addonTitleInput = document.getElementById('addon_title');
            const addonPriceInput = document.getElementById('addon_price');
            const addonDescInput = document.getElementById('addon_description');
            const addonSubmitLabel = document.getElementById('addon-submit-label');

            const deleteMenuModal = document.getElementById('delete-menu-modal');
            const deleteMenuName = document.getElementById('delete-menu-name');
            const deleteMenuForm = document.getElementById('delete-menu-form');

            let activeMenuId = null;
            let lastFocusedElement = null;

            function openModal(modal) {
                if (!modal) return;
                if (document.activeElement instanceof HTMLElement) {
                    lastFocusedElement = document.activeElement;
                }
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                const focusTarget = modal.querySelector('[data-close-modal]');
                if (focusTarget instanceof HTMLElement) {
                    focusTarget.focus();
                }
            }

            function closeModal(modal) {
                if (!modal || modal.classList.contains('hidden')) return;
                modal.classList.remove('flex');
                modal.classList.add('hidden');
                if (lastFocusedElement instanceof HTMLElement) {
                    lastFocusedElement.focus();
                    lastFocusedElement = null;
                }
            }

            function formatRupiah(amount) {
                return 'Rp ' + Number(amount || 0).toLocaleString('id-ID');
            }

            function setAddonCreateMode(menuId, clearFields) {
                const meta = menusMeta[menuId];
                if (!meta || !addonForm) return;
                addonForm.action = meta.storeAddonUrl;
                addonMethodField.disabled = true;
                addonMenuIdInput.value = String(menuId);
                addonEditIdInput.value = '';
                addonFormHeading.textContent = 'Tambah Add-on Baru';
                addonSubmitLabel.textContent = 'Simpan Add-on';
                addonCancelEditBtn.classList.remove('inline-flex');
                addonCancelEditBtn.classList.add('hidden');
                if (clearFields) {
                    addonTitleInput.value = '';
                    addonPriceInput.value = '';
                    addonDescInput.value = '';
                }
            }

            function setAddonEditMode(menuId, addon, populateFields) {
                if (!addon || !addonForm) return;
                addonForm.action = addon.updateUrl;
                addonMethodField.disabled = false;
                addonMenuIdInput.value = String(menuId);
                addonEditIdInput.value = String(addon.id);
                addonFormHeading.textContent = 'Edit Add-on: ' + addon.title;
                addonSubmitLabel.textContent = 'Simpan Perubahan Add-on';
                addonCancelEditBtn.classList.remove('hidden');
                addonCancelEditBtn.classList.add('inline-flex');
                if (populateFields) {
                    addonTitleInput.value = addon.title;
                    addonPriceInput.value = String(addon.price);
                    addonDescInput.value = addon.description || '';
                }
            }

            function renderAddonsList(menuId) {
                while (addonsListContainer.firstChild) {
                    addonsListContainer.removeChild(addonsListContainer.firstChild);
                }

                const items = addonsByMenu[menuId] || [];

                if (items.length === 0) {
                    const emptyBox = document.createElement('div');
                    emptyBox.className = 'rounded-xl border border-dashed border-stone-300 bg-bg-light p-4 text-center text-xs text-slate-muted';
                    emptyBox.textContent = 'Paket ini belum memiliki add-on tambahan. Gunakan formulir di bawah untuk menambahkan.';
                    addonsListContainer.appendChild(emptyBox);
                    return;
                }

                items.forEach(function (addon) {
                    const row = document.createElement('div');
                    row.className = 'rounded-xl border border-stone-200 bg-white p-3.5 flex flex-col sm:flex-row sm:items-center justify-between gap-3';

                    const info = document.createElement('div');
                    info.className = 'min-w-0 space-y-0.5';

                    const titleRow = document.createElement('div');
                    titleRow.className = 'flex flex-wrap items-center gap-2';

                    const titleEl = document.createElement('span');
                    titleEl.className = 'text-xs sm:text-sm font-bold font-heading text-slate-dark';
                    titleEl.textContent = addon.title;

                    const priceEl = document.createElement('span');
                    priceEl.className = 'px-2.5 py-0.5 rounded-full bg-pastel-100 border border-pastel-300 text-[11px] font-bold text-amber-900 tabular-nums';
                    priceEl.textContent = '+ ' + formatRupiah(addon.price);

                    titleRow.appendChild(titleEl);
                    titleRow.appendChild(priceEl);
                    info.appendChild(titleRow);

                    if (addon.description) {
                        const descEl = document.createElement('p');
                        descEl.className = 'text-xs text-slate-muted wrap-break-word';
                        descEl.textContent = addon.description;
                        info.appendChild(descEl);
                    }

                    const actions = document.createElement('div');
                    actions.className = 'flex flex-wrap items-center gap-2 shrink-0';

                    const editBtn = document.createElement('button');
                    editBtn.type = 'button';
                    editBtn.className = 'min-h-11 sm:min-h-0 px-3 py-1.5 rounded-lg border border-stone-200 bg-stone-100 hover:bg-stone-200 text-xs font-bold text-slate-dark transition cursor-pointer';
                    editBtn.textContent = 'Edit';
                    editBtn.addEventListener('click', function () {
                        setAddonEditMode(menuId, addon, true);
                        addonTitleInput.focus();
                    });

                    const deleteInitBtn = document.createElement('button');
                    deleteInitBtn.type = 'button';
                    deleteInitBtn.className = 'min-h-11 sm:min-h-0 px-3 py-1.5 rounded-lg border border-status-danger-border bg-status-danger-bg hover:bg-red-100 text-xs font-bold text-status-danger-text transition cursor-pointer';
                    deleteInitBtn.textContent = 'Hapus';

                    const confirmForm = document.createElement('form');
                    confirmForm.method = 'POST';
                    confirmForm.action = addon.deleteUrl;
                    confirmForm.className = 'hidden items-center gap-1.5';

                    const tokenInput = document.createElement('input');
                    tokenInput.type = 'hidden';
                    tokenInput.name = '_token';
                    tokenInput.value = csrfToken;

                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'DELETE';

                    const confirmYesBtn = document.createElement('button');
                    confirmYesBtn.type = 'submit';
                    confirmYesBtn.className = 'min-h-11 sm:min-h-0 px-3 py-1.5 rounded-lg bg-red-600 hover:bg-red-700 text-white text-xs font-bold transition cursor-pointer';
                    confirmYesBtn.textContent = 'Yakin Hapus?';

                    const confirmNoBtn = document.createElement('button');
                    confirmNoBtn.type = 'button';
                    confirmNoBtn.className = 'min-h-11 sm:min-h-0 px-2.5 py-1.5 rounded-lg border border-stone-200 bg-stone-100 hover:bg-stone-200 text-xs font-bold text-slate-dark transition cursor-pointer';
                    confirmNoBtn.textContent = 'Batal';

                    confirmForm.appendChild(tokenInput);
                    confirmForm.appendChild(methodInput);
                    confirmForm.appendChild(confirmYesBtn);
                    confirmForm.appendChild(confirmNoBtn);

                    deleteInitBtn.addEventListener('click', function () {
                        deleteInitBtn.classList.add('hidden');
                        confirmForm.classList.remove('hidden');
                        confirmForm.classList.add('flex');
                    });

                    confirmNoBtn.addEventListener('click', function () {
                        confirmForm.classList.remove('flex');
                        confirmForm.classList.add('hidden');
                        deleteInitBtn.classList.remove('hidden');
                    });

                    actions.appendChild(editBtn);
                    actions.appendChild(deleteInitBtn);
                    actions.appendChild(confirmForm);

                    row.appendChild(info);
                    row.appendChild(actions);
                    addonsListContainer.appendChild(row);
                });
            }

            function openAddonsModalFor(menuId, restoreEditId, oldInput, keepServerAlerts = false) {
                const meta = menusMeta[menuId];
                if (!meta) return;
                activeMenuId = menuId;

                document.querySelectorAll('[data-addon-modal-alert]').forEach(function (alertEl) {
                    if (keepServerAlerts) {
                        alertEl.classList.remove('hidden');
                        alertEl.classList.add('flex');
                    } else {
                        alertEl.classList.remove('flex');
                        alertEl.classList.add('hidden');
                    }
                });

                addonsModalMenuTitle.textContent = 'Paket: ' + meta.title;
                renderAddonsList(menuId);

                const items = addonsByMenu[menuId] || [];
                const targetEdit = restoreEditId ? items.find(function (a) { return Number(a.id) === Number(restoreEditId); }) : null;

                if (targetEdit) {
                    setAddonEditMode(menuId, targetEdit, !oldInput);
                } else {
                    setAddonCreateMode(menuId, !oldInput);
                }

                if (oldInput) {
                    addonTitleInput.value = oldInput.title || '';
                    addonPriceInput.value = oldInput.price || '';
                    addonDescInput.value = oldInput.description || '';
                }

                openModal(addonsModal);
            }

            document.querySelectorAll('[data-open-addons]').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const menuId = Number(btn.getAttribute('data-open-addons'));
                    openAddonsModalFor(menuId, null, null, false);
                });
            });

            if (addonCancelEditBtn) {
                addonCancelEditBtn.addEventListener('click', function () {
                    if (activeMenuId !== null) {
                        setAddonCreateMode(activeMenuId, true);
                    }
                });
            }

            document.querySelectorAll('[data-open-delete]').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const menuId = Number(btn.getAttribute('data-open-delete'));
                    const meta = menusMeta[menuId];
                    if (!meta) return;
                    deleteMenuName.textContent = '"' + meta.title + '"';
                    deleteMenuForm.action = meta.deleteMenuUrl;
                    openModal(deleteMenuModal);
                });
            });

            document.querySelectorAll('[data-close-modal]').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const targetId = btn.getAttribute('data-close-modal');
                    closeModal(document.getElementById(targetId));
                });
            });

            [addonsModal, deleteMenuModal].forEach(function (modal) {
                if (!modal) return;
                modal.addEventListener('click', function (e) {
                    if (e.target === modal) {
                        closeModal(modal);
                    }
                });
            });

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') {
                    closeModal(addonsModal);
                    closeModal(deleteMenuModal);
                }
            });

            if (initialModalState && initialModalState.openMenuId && menusMeta[initialModalState.openMenuId]) {
                openAddonsModalFor(
                    initialModalState.openMenuId,
                    initialModalState.editAddonId,
                    initialModalState.oldInput,
                    true
                );
            }
        });
    </script>
@endsection
