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
            <main class="p-4 sm:p-6 lg:p-8 space-y-6 max-w-7xl w-full mx-auto">
            <div class="bg-light rounded-2xl border border-stone-200/90 shadow-2xs p-6">
                <h2 class="text-xl font-bold font-heading text-slate-dark">Form Tambah Menu Katalog</h2>
                <p class="text-xs text-slate-muted mt-1">Kelola paket layanan komisi Anda untuk ditampilkan pada profil publik dan etalase artist.</p>
            </div>

            <!-- form tambah menu -->
            <form action="" method="POST" class="bg-light rounded-2xl border border-stone-200/90 shadow-2xs p-6 space-y-5">

                <!-- judul sm kategori -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-slate-dark mb-1.5">
                            Nama Paket / Menu <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                            name="title"
                            placeholder="Contoh: Full Body Anime Character"
                            class="w-full rounded-xl border border-slate-muted/40 bg-light px-4 py-2.5 text-sm text-slate-dark placeholder:text-slate-muted/70 focus:border-slate-dark focus:outline-none transition-colors">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-dark mb-1.5">
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <select name="category_id"
                                class="w-full rounded-xl border border-slate-muted/40 bg-light px-4 py-2.5 text-sm text-slate-dark focus:border-slate-dark focus:outline-none transition-colors">
                            <option value="">-- Pilih Kategori --</option>
                            <option value="">Ilustrasi Digital</option>
                            <option value="">Chibi & Emote</option>
                            <option value="">Model 2D VTuber</option>
                        </select>
                    </div>
                </div>

                <!-- base price sm persentase dp -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-slate-dark mb-1.5">
                            Harga Dasar (Rp) <span class="text-red-500">*</span>
                        </label>
                        <input type="number"
                            name="base_price"
                            placeholder="Contoh: 450000"
                            class="w-full rounded-xl border border-slate-muted/40 bg-light px-4 py-2.5 text-sm text-slate-dark placeholder:text-slate-muted/70 focus:border-slate-dark focus:outline-none transition-colors">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-dark mb-1.5">
                            Persentase DP (%) <span class="text-red-500">*</span>
                        </label>
                        <input type="number"
                            name="dp_percentage"
                            placeholder="Contoh: 50"
                            class="w-full rounded-xl border border-slate-muted/40 bg-light px-4 py-2.5 text-sm text-slate-dark placeholder:text-slate-muted/70 focus:border-slate-dark focus:outline-none transition-colors">
                    </div>
                </div>

                <!-- estimasi hari, maks revisi, slot -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-slate-dark mb-1.5">
                            Estimasi Pengerjaan (Hari) <span class="text-red-500">*</span>
                        </label>
                        <input type="number"
                            name="estimated_days"
                            placeholder="Contoh: 7"
                            class="w-full rounded-xl border border-slate-muted/40 bg-light px-4 py-2.5 text-sm text-slate-dark placeholder:text-slate-muted/70 focus:border-slate-dark focus:outline-none transition-colors">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-dark mb-1.5">
                            Maks. Revisi per Tahap <span class="text-red-500">*</span>
                        </label>
                        <input type="number"
                            name="max_revision"
                            placeholder="Contoh: 2"
                            class="w-full rounded-xl border border-slate-muted/40 bg-light px-4 py-2.5 text-sm text-slate-dark placeholder:text-slate-muted/70 focus:border-slate-dark focus:outline-none transition-colors">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-dark mb-1.5">
                            Slot Tersedia <span class="text-red-500">*</span>
                        </label>
                        <input type="number"
                            name="available_slots"
                            placeholder="Contoh: 3"
                            class="w-full rounded-xl border border-slate-muted/40 bg-light px-4 py-2.5 text-sm text-slate-dark placeholder:text-slate-muted/70 focus:border-slate-dark focus:outline-none transition-colors">
                    </div>
                </div>

                <!-- tipe request sm status aktif -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 items-end">
                    <div>
                        <label class="block text-sm font-semibold text-slate-dark mb-1.5">
                            Tipe Pemesanan <span class="text-red-500">*</span>
                        </label>
                        <select name="request_type"
                                class="w-full rounded-xl border border-slate-muted/40 bg-light px-4 py-2.5 text-sm text-slate-dark focus:border-slate-dark focus:outline-none transition-colors">
                            <option value="">-- Pilih Tipe --</option>
                            <option value="custom">Custom</option>
                            <option value="instant">Instant</option>
                        </select>
                    </div>

                    <div class="rounded-xl border border-slate-muted/40 bg-slate-dark/2 px-4 py-2.5 flex items-center justify-between">
                        <div>
                            <label class="text-sm font-semibold text-slate-dark">
                                Tampilkan di Etalase Publik
                            </label>
                            <p class="text-[11px] text-slate-muted">Menu dapat langsung dilihat dan dipesan oleh client</p>
                        </div>
                        <input type="checkbox"
                            name="is_active"
                            checked
                            class="w-4 h-4 accent-slate-dark rounded cursor-pointer">
                    </div>
                </div>

                <!-- deskripsi -->
                <div>
                    <label class="block text-sm font-semibold text-slate-dark mb-1.5">
                        Deskripsi & Ketentuan Paket <span class="text-red-500">*</span>
                    </label>
                    <textarea name="description"
                            rows="4"
                            placeholder="Jelaskan detail yang didapatkan client..."
                            class="w-full rounded-xl border border-slate-muted/40 bg-light px-4 py-2.5 text-sm text-slate-dark placeholder:text-slate-muted/70 focus:border-slate-dark focus:outline-none transition-colors"></textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2">
                    <a href=""
                    class="px-5 py-2.5 rounded-xl text-sm font-semibold text-white bg-red-600 transition-all duration-200 ease-in-out hover:-translate-y-px hover:bg-red-800 hover:shadow-[0_4px_12px_rgba(220,38,38,0.35)]">
                        Batal
                    </a>
                    <button type="submit" class="btn-primary cursor-pointer">
                        Simpan Menu Katalog
                    </button>
                </div>
            </form>
        </main>
        </div>
    </div>
@endsection
