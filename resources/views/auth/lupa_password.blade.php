@extends('layouts.app')

@section('content')
<div class="body relative flex bg-background min-h-screen w-full justify-center items-center overflow-hidden">
    <!-- Dekorasi Background -->
    <div class="w-100 h-100 bg-pink-500 absolute -top-50 -right-50 rounded-full blur-3xl opacity-10"></div>
    <div class="w-100 h-100 bg-pink-500 absolute -bottom-50 -left-50 rounded-full blur-3xl opacity-10"></div>
    
    <div class="flex bg-card w-fit h-fit justify-center items-center flex-col p-10 rounded-4xl gap-10 shadow-md">
        <!-- INPUT EMAIL & KODE VERIFIKASI      -->
        <div id="form-verifikasi" class="flex flex-col w-full gap-6">
            <div class="flex flex-col gap-2 justify-center items-center mb-2">
                <h1 class="text-teks font-semibold text-xl">Lupa Password</h1>
                <p class="text-sm text-center font-medium teks-isi opacity-70">
                    Masukkan email dan kirim permintaan kode verifikasi.
                </p>
            </div>
            
            <form action="#" method="POST" class="flex flex-col gap-5">
                @csrf
                <div class="flex flex-col gap-5">
                    <!-- Input Email -->
                    <div class="flex gap-3 w-full">
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-5 pointer-events-none">
                                <i class="fa-solid fa-envelope text-md text-teks"></i>
                            </div>
                            <input type="email" name="email" class="w-full pl-12 bg-amber-50 py-3 px-3 rounded-2xl border border-teks focus:outline-none focus:border-teks placeholder:font-heading placeholder:text-sm placeholder:text-teks placeholder:opacity-50 placeholder:font-medium" placeholder="Masukkan email terdaftar">
                        </div>

                        <!-- Tombol Kirim Kode -->
                        <button type="button" class="btn-primary">
                            Kirim Kode
                        </button>
                    </div>
                    
                    <!-- Input Kode Verifikasi -->
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-5 pointer-events-none">
                            <i class="fa-solid fa-shield-halved text-md text-teks"></i>
                        </div>
                        <input type="text" name="code" class="pl-12 bg-amber-50 w-90 py-3 px-3 rounded-2xl border border-teks focus:outline-none focus:border-teks placeholder:font-heading placeholder:text-sm placeholder:text-teks placeholder:opacity-50 placeholder:font-medium" placeholder="Masukkan kode dari email">
                    </div>
                </div>

                <button type="button" class="btn-primary mt-4">Verifikasi Kode</button>

                <!-- Tombol Kembali ke Login -->
                <div class="flex w-full gap-1 justify-center mt-2">
                    <a href="{{ route('login') }}" class="text-sm font-medium teks-isi hover:text-teks transition-colors">Kembali ke Login</a>
                </div>
            </form>
        </div>

        <!-- BUAT PASSWORD BARU                 -->
        <div id="form-reset-password" class="hidden flex-col w-full gap-6">
            <div class="flex flex-col gap-2 justify-center items-center mb-2">
                <h1 class="text-teks font-semibold text-xl">Buat Password Baru</h1>
                <p class="text-sm text-center font-medium teks-isi opacity-70">
                    Atur ulang password baru<br>untuk akun Artsy Id kamu
                </p>
            </div>
            
            <form action="#" method="POST" class="flex flex-col gap-5">
                @csrf
                <div class="flex flex-col gap-5">
                    <!-- Input Password Baru -->
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-5 pointer-events-none">
                            <i class="fa-solid fa-lock text-md text-teks"></i>
                        </div>
                        <input type="password" name="password" class="pl-12 bg-amber-50 w-90 py-3 px-3 rounded-2xl border border-teks focus:outline-none focus:border-teks placeholder:font-heading placeholder:text-sm placeholder:text-teks placeholder:opacity-50 placeholder:font-medium" placeholder="Password baru">
                        <div class="absolute inset-y-0 right-4 flex items-center pl-3 cursor-pointer">
                            <i class="fa-solid fa-eye text-md text-teks"></i>
                        </div>
                    </div>
                    
                    <!-- Input Konfirmasi Password -->
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-5 pointer-events-none">
                            <i class="fa-solid fa-lock text-md text-teks"></i>
                        </div>
                        <input type="password" name="password_confirmation" class="pl-12 bg-amber-50 w-90 py-3 px-3 rounded-2xl border border-teks focus:outline-none focus:border-teks placeholder:font-heading placeholder:text-sm placeholder:text-teks placeholder:opacity-50 placeholder:font-medium" placeholder="Konfirmasi password baru">
                        <div class="absolute inset-y-0 right-4 flex items-center pl-3 cursor-pointer">
                            <i class="fa-solid fa-eye text-md text-teks"></i>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-primary mt-4">Simpan Password</button>
            </form>
        </div>

    </div>
</div>
@endsection