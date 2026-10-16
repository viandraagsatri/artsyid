@extends('layouts.app')

@section('content')
<div class="body relative flex bg-background min-h-screen w-full justify-center items-center overflow-hidden">
    <div class="w-100 h-100 bg-pink-500 absolute -top-50 -right-50 rounded-full blur-3xl opacity-10"></div>
    <div class="w-100 h-100 bg-pink-500 absolute -bottom-50 -left-50 rounded-full blur-3xl opacity-10"></div>
    <div class="flex bg-card w-fit h-fit justify-center items-center flex-col p-10 rounded-4xl gap-10 shadow-md">
        <div class="flex flex-col gap-4 justify-center items-center">
            <h1 class="text-teks font-semibold text-xl">Daftar ke Artsy Id</h1>
            <img src="{{ asset('images/logo.png') }}" alt="" class="object-cover w-20 h-20 rounded-full">
        </div>
        <form action="{{ route('register.post') }}" method="POST" class="flex flex-col gap-5">
            @csrf
            <div class="flex flex-col gap-5">
                {{-- Nama lengkap --}}
                <div>
                    <div class="relative w-full">
                        <div class="absolute inset-y-2 left-0 flex items-center pl-5 pointer-events-none">
                            <i class="fa-solid fa-user text-md text-teks"></i>
                        </div>
                        <input type="text" name="name" value="{{ old('name') }}" required autocomplete="name"
                            class="pl-12 bg-amber-50 w-90 py-3 px-3 rounded-2xl border border-teks focus:outline-none focus:border-teks placeholder:font-heading placeholder:text-sm placeholder:text-teks placeholder:opacity-50 placeholder:font-medium"
                            placeholder="Masukkan nama lengkap">
                    </div>
                    @error('name')
                        <p class="text-xs text-red-600 mt-1 pl-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <div class="relative w-full">
                        <div class="absolute inset-y-2 left-0 flex items-center pl-5 pointer-events-none">
                            <i class="fa-solid fa-envelope text-md text-teks"></i>
                        </div>
                        <input type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                            class="pl-12 bg-amber-50 w-90 py-3 px-3 rounded-2xl border border-teks focus:outline-none focus:border-teks placeholder:font-heading placeholder:text-sm placeholder:text-teks placeholder:opacity-50 placeholder:font-medium"
                            placeholder="Masukkan email">
                    </div>
                    @error('email')
                        <p class="text-xs text-red-600 mt-1 pl-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <div class="relative w-full">
                        <div class="absolute inset-y-2 left-0 flex items-center pl-5 pointer-events-none">
                            <i class="fa-solid fa-lock text-md text-teks"></i>
                        </div>
                        <input type="password" name="password" id="password" required autocomplete="new-password"
                            class="pl-12 pr-12 bg-amber-50 w-90 py-3 px-3 rounded-2xl border border-teks focus:outline-none focus:border-teks placeholder:font-heading placeholder:text-sm placeholder:text-teks placeholder:opacity-50 placeholder:font-medium"
                            placeholder="Buat password">
                        <button type="button" data-toggle="password" aria-label="Tampilkan password"
                            class="absolute inset-y-2 right-4 flex items-center cursor-pointer">
                            <i class="fa-solid fa-eye text-md text-teks"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-xs text-red-600 mt-1 pl-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Konfirmasi password --}}
                <div>
                    <div class="relative w-full">
                        <div class="absolute inset-y-2 left-0 flex items-center pl-5 pointer-events-none">
                            <i class="fa-solid fa-lock text-md text-teks"></i>
                        </div>
                        <input type="password" name="password_confirmation" id="password_confirmation" required autocomplete="new-password"
                            class="pl-12 pr-12 bg-amber-50 w-90 py-3 px-3 rounded-2xl border border-teks focus:outline-none focus:border-teks placeholder:font-heading placeholder:text-sm placeholder:text-teks placeholder:opacity-50 placeholder:font-medium"
                            placeholder="Konfirmasi password">
                        <button type="button" data-toggle="password_confirmation" aria-label="Tampilkan konfirmasi password"
                            class="absolute inset-y-2 right-4 flex items-center cursor-pointer">
                            <i class="fa-solid fa-eye text-md text-teks"></i>
                        </button>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-primary">Daftar</button>

            <div class="flex w-full gap-1 justify-center">
                <span class="text-sm teks-isi">Sudah punya akun? </span>
                <a href="{{ url('/login') }}" class="text-sm font-medium teks-isi">Masuk</a>
            </div>
        </form>
    </div>
</div>

<script>
    document.querySelectorAll('[data-toggle]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var input = document.getElementById(btn.dataset.toggle);
            var icon = btn.querySelector('i');
            var show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            icon.classList.toggle('fa-eye', !show);
            icon.classList.toggle('fa-eye-slash', show);
        });
    });
</script>
@endsection