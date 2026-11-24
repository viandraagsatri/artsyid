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
                <h2 class="text-xl font-bold font-heading text-slate-dark">Upload Portofolio</h2>
                <p class="text-xs text-slate-muted mt-1">Upload karya orisinal anda sebagai portofolio untuk meningkatkan kepercayaan client^^</p>
            </div>

            <!-- form upload portofolio.store -->
            <form action="#" method="POST" enctype="multipart/form-data"
                class="bg-light rounded-2xl border border-stone-200/90 shadow-2xs p-6 space-y-5">
                @csrf

                <!-- judul -->
                <div>
                    <label for="title" class="block text-sm font-semibold text-slate-dark mb-1.5">
                        Judul Karya <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                        id="title"
                        name="title"
                        value="{{ old('title') }}"
                        placeholder="Contoh: Full Body Anime Character - OC Commission"
                        required
                        class="w-full rounded-xl border border-slate-muted/40 bg-light px-4 py-2.5 text-sm text-slate-dark placeholder:text-slate-muted/70 focus:border-slate-dark focus:outline-none transition-colors">
                    @error('title')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- upload gambar -->
                <div>
                    <label for="image_url" class="block text-sm font-semibold text-slate-dark mb-1.5">
                        File Gambar Karya <span class="text-red-500">*</span>
                    </label>
                    <div class="rounded-xl border border-dashed border-slate-muted/50 bg-slate-dark/2 p-4 transition-colors hover:border-slate-dark/60">
                        <input type="file"
                            id="image_url"
                            name="image_url"
                            accept="image/png, image/jpeg, image/jpg, image/webp"
                            required
                            class="block w-full text-sm text-slate-muted
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-lg file:border-0
                                    file:text-xs file:font-semibold
                                    file:bg-primary file:text-slate-dark
                                    hover:file:opacity-90 file:cursor-pointer cursor-pointer">
                        <p class="text-[11px] text-slate-muted mt-2">Format: JPG, JPEG, PNG, atau WEBP (Maks. 2MB)</p>
                    </div>
                    @error('image_url')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- deskripsi Karya -->
                <div>
                    <label for="description" class="block text-sm font-semibold text-slate-dark mb-1.5">
                        Deskripsi Karya <span class="text-xs font-normal text-slate-muted">(Opsional)</span>
                    </label>
                    <textarea id="description"
                            name="description"
                            rows="4"
                            placeholder="Ceritakan sedikit tentang konsep, style, atau software yang digunakan..."
                            class="w-full rounded-xl border border-slate-muted/40 bg-light px-4 py-2.5 text-sm text-slate-dark placeholder:text-slate-muted/70 focus:border-slate-dark focus:outline-none transition-colors">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end gap-3 pt-2">
                    <a href="{{ route('profile.portofolio') }}"
                    class="px-5 py-2.5 rounded-xl text-sm font-semibold text-white bg-red-600 transition-all duration-200 ease-in-out hover:-translate-y-px hover:bg-red-800">
                        Batal
                    </a>
                    <button type="submit" class="btn-primary cursor-pointer">
                        Simpan Portofolio
                    </button>
                </div>
            </form>
        </main>
        </div>
    </div>
@endsection
