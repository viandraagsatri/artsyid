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
                    <h2 class="text-xl font-bold font-heading text-slate-dark">Paket Menu Komisi</h2>
                    <p class="text-xs text-slate-muted mt-1">Kelola daftar layanan komisi seni, harga dasar, estimasi hari, kuota slot, dan add-ons.</p>
                </div>
                <div class="flex w-full flex-row justify-between items-center">
                    <div class="flex flex-row gap-5 items-center">
                        <span class="text-xl font-bold font-heading text-slate-dark">Daftar Paket Komisi Aktif</span>
                        <div class="bg-status-success-bg rounded-full border border-status-success-border h-fit py-2 px-3 flex items-center justify-center">
                            <span class="text-status-success-text text-xs font-bold">Slot terisi: 4 dari 5 Komisi</span>
                        </div>
                    </div>
                    <a href="{{ route ('artist.menus.form_create_menu') }}" class="btn-primary">+ Tambah Menu Komisi</a>
                </div>
                <div class="flex flex-col gap-7">
                    <!-- foreach -->
                    <div class="flex flex-col gap-5 bg-bg-light border border-slate-muted rounded-4xl py-5 px-7"> 
                        <div class="flex flex-row justify-between">
                            <div class="flex flex-row gap-5 items-center">
                                <span class="font-heading text-slate-dark font-bold">YCH Hug Teddy</span>
                                <div class="flex items-center justify-between bg-slate-muted/5 text-xs rounded-full h-fit py-2 px-5 border border-slate-dark/30">
                                    <span class="text-slate-muted font-bold">Ilustrasi Digital</span>
                                </div>
                            </div>
                            <div class="flex flex-row gap-5 items-center">
                                <div class="flex items-center bg-status-success-bg border border-status-success-border h-fit py-2 px-5 rounded-full">
                                    <span class="text-status-success-text text-xs font-bold">Open Slot</span>
                                </div>
                                <span class="font-bold">Rp 400.000</span>
                            </div>
                        </div>
                        <div class="flex flex-row gap-5">
                            <div class="flex items-center h-fit py-2 px-5 rounded-full bg-pastel-100">
                                <span class="text-teks text-xs font-bold">DP 50%: Rp 200.000</span>
                            </div>
                            <div class="flex items-center h-fit py-2 px-5 rounded-full bg-slate-muted/30">
                                <span class="text-xs font-bold text-slate-dark">Estimasi: 14 hari kerja</span>
                            </div>
                            <div class="flex items-center h-fit py-2 px-5 rounded-full bg-slate-muted/30">
                                <span class="text-slate-dark text-xs font-bold">Maks. 2x revisi</span>
                            </div>
                            <div class="flex items-center h-fit py-2 px-5 rounded-full bg-status-success-bg border border-status-success-border">
                                <span class="text-xs font-bold text-status-success-text">3 dari 5 slot terisi</span>
                            </div>
                        </div>
                        <div class="flex flex-row gap-5 items-center">
                            <span class="font-bold text-md">Add ons tersedia: </span>
                            <div class="flex flex-row gap-5">
                                <!-- foreach -->
                                <div class="flex items-center h-fit py-2 px-5 rounded-full bg-bg-light border border-slate-muted">
                                    <span class="text-xs font-bold text-slate-dark">Detailed Background (+100k)</span>
                                </div>
                                <div class="flex items-center h-fit py-2 px-5 rounded-full bg-bg-light border border-slate-muted">
                                    <span class="text-xs font-bold text-slate-dark">Detailed Background (+100k)</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-row justify-between items-center pt-5">
                            <span class="text-slate-muted text-xs font-medium">Tampil di katalog publik, slot otomatis berkurang saat order dikonfirmasi</span>
                            <div class="flex flex-row gap-3">
                                <a href="#" class="inline-block text-xs font-semibold h-fit py-3 px-5 rounded-xl bg-bg-light border border-slate-dark/50 duration-200 ease-in-out hover:bg-slate-muted/10 hover:-translate-y-px  transition-all">Kelola Add Ons</a>
                                <a href="#" class="inline-block text-xs font-semibold h-fit py-3 px-5 rounded-xl bg-bg-light border border-slate-dark/50 duration-200 ease-in-out hover:bg-slate-muted/10 hover:-translate-y-px  transition-all">Edit Informasi Katalog</a>
                                <a href="#" class="inline-block text-xs font-semibold h-fit py-3 px-5 rounded-xl bg-bg-light border border-slate-dark/50 duration-200 ease-in-out hover:bg-slate-muted/10 hover:-translate-y-px  transition-all">Tutup Slot</a>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection
