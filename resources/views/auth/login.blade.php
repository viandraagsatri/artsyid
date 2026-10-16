@extends('layouts.app')

@section('content')
<div class="body relative flex bg-background min-h-screen w-full justify-center items-center overflow-hidden">
    <div class="w-100 h-100 bg-pink-500 absolute -top-50 -right-50 rounded-full blur-3xl opacity-10"></div>
    <div class="w-100 h-100 bg-pink-500 absolute -bottom-50 -left-50 rounded-full blur-3xl opacity-10"></div>
    <div class="flex bg-card w-fit h-fit justify-center items-center flex-col p-10 rounded-4xl gap-10 shadow-md">
        <div class="flex flex-col gap-4 justify-center items-center">
            <h1 class="text-teks font-semibold text-xl">Welcome to Artsy Id</h1>
            <img src="{{ asset('images/logo.png') }}" alt="" class="object-cover w-20 h-20 rounded-full">
        </div>
        <form action="{{ route('login.post') }}" method="POST" class="flex flex-col gap-5">
            @csrf
            <div class="flex flex-col gap-5">
                <div class="relative w-full">
                    <div class="absolute inset-y-2 left-0 flex items-center pl-5 pointer-events-none">
                        <i class="fa-solid fa-user text-md text-teks"></i>
                    </div>
                    <input type="email" class="pl-12 bg-amber-50 w-90 py-3 px-3 rounded-2xl border border-teks focus:outline-none focus:border-teks placeholder:font-heading placeholder:text-sm placeholder:text-teks placeholder:opacity-50 placeholder:font-medium" placeholder="Masukkan email">
                </div>
                <div class="relative w-full">
                    <div class="absolute inset-y-2 left-0 flex items-center pl-5 pointer-events-none">
                        <i class="fa-solid fa-lock text-md text-teks"></i>
                    </div>
                    <input type="password" class="pl-12 bg-amber-50 w-90 py-3 px-3 rounded-2xl border border-teks focus:outline-none focus:border-teks placeholder:font-heading placeholder:text-sm placeholder:text-teks placeholder:opacity-50 placeholder:font-medium" placeholder="Masukkan password">
                    <div class="absolute inset-y-2 right-4 flex items-center pl-3 pointer-events-none">
                        <i class="fa-solid fa-eye text-md text-teks"></i>
                    </div>
                </div>
            </div>
            <a class="text-sm w-full text-right teks-isi font-medium" href="{{ route('lupa.password') }}">Lupa password?</a>

            <button type="submit" class="btn-primary">Masuk</button>

            <div class="flex w-full gap-1 justify-center">
                <span class="text-sm teks-isi">Belum Punya akun? </span>
                <a href="#" class="text-sm font-medium teks-isi">Daftar</a>
            </div>
        </form>
    </div>
</div>
@endsection
