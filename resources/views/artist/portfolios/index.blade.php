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
                    <h2 class="text-xl font-bold font-heading text-slate-dark">Galeri Portofolio</h2>
                    <p class="text-xs text-slate-muted mt-1">Kelola galeri karya portofolio Anda untuk ditampilkan pada profil publik dan etalase artist.</p>
                </div>
                <div class="flex w-full flex-row justify-between items-center">
                    <div class="flex flex-row gap-5 items-center">
                        <span class="text-xl font-bold font-heading text-slate-dark">Daftar Portofolio</span>
                        <div class="bg-status-success-bg rounded-full border border-status-success-border h-fit py-2 px-3 flex items-center justify-center">
                            <span class="text-status-success-text text-xs font-bold">12 karya telah diupload</span>
                        </div>
                    </div>
                    <a href="{{ route('artist.portfolios.form_create_portofolio') }}" class="btn-primary">+ Unggah Portofolio Baru</a>
                </div>
                <div class="flex flex-col gap-6">
                    <!-- chips kategori -->
                    <div>
                        <div class="flex items-center h-fit py-2 px-5 rounded-full bg-slate-muted/30">
                            <span class="text-xs font-bold text-slate-dark">Semua</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        <!-- forelse ($portofolios as $karya) -->
                            <div class="flex flex-col bg-bg-light h-fit rounded-2xl border border-slate-muted p-3 gap-3">
                                <img src="{{ asset('images/logo.png') }}" alt="" class="h-36 object-cover rounded-2xl">
                                <div class="flex flex-col ">
                                    <span class="font-heading text-md font-bold text-slate-dark">YCH Hug Teddy</span>
                                    <span class="text-xs font-bold text-slate-muted">Diupload: xx november 2026</span>
                                </div>
                                <div class="flex flex-row gap-3">
                                    <button class="w-fit bg-red-700 text-bg-light text-xs font-semibold h-fit py-3 px-4 rounded-xl duration-200 ease-in-out hover:bg-red-900 hover:-translate-y-px  transition-all">Hapus</button>
                                    <button class="w-full bg-pastel-100 text-teks border border-pastel-500 text-xs font-bold h-fit py-3 px-2 rounded-xl duration-200 ease-in-out hover:bg-pastel-300 hover:-translate-y-px  transition-all">Lihat Detail</button>
                                </div>
                            </div>
                        <!-- empty
                            <span>Kamu belum upload portofolio apapun</span>
                        endforelse -->
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection
