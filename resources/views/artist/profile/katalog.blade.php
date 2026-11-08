@extends('layouts.profile_layout')

@section('profile_content')
<div>
    <div class="flex flex-col gap-5">
        <div class="flex flex-row gap-5">
            <a href="#illustration" class="category-btn px-5 py-2 rounded-full transition-colors bg-gray-100 text-slate-muted hover:bg-gray-200">Illustration</a>
            <a href="#chibi" class="category-btn px-5 py-2 rounded-full transition-colors bg-gray-100 text-slate-muted hover:bg-gray-200">Chibi</a>
        </div>
        <div id="illustration" class="flex flex-col gap-5 bg-gray-100 w-full p-5 rounded-2xl">
            <h2 class="font-bold text-2xl">Illustration</h2>
            <div class="flex flex-row items-start w-full h-fit rounded-xl bg-amber-100 overflow-hidden">
                <img src="{{ asset('images/logo.png') }}" class="w-1/2 h-50 object-cover" alt="">
                <div class="flex flex-col px-5 py-7">
                    <h3 class="font-bold text-2xl">Chibi Character Icon</h3>
                    <span class="font-medium opacity-75 text-xl">Mulai dari Rp. 50.000</span>
                    <a href="{{ route('katalog.detail', ['id' => 1]) }}" class="font-bold text-lg bg-slate-dark text-white rounded-full w-fit px-5 py-2 mt-8">Lihat Detail -></a>
                </div>
            </div>
            <div class="flex flex-row items-start w-full h-fit rounded-xl bg-amber-100 overflow-hidden">
                <img src="{{ asset('images/logo.png') }}" class="w-1/2 h-50 object-cover" alt="">
                <div class="flex flex-col px-5 py-7">
                    <h3 class="font-bold text-2xl">Chibi Character Icon</h3>
                    <span class="font-medium opacity-75 text-xl">Mulai dari Rp. 50.000</span>
                    <a href="" class="font-bold text-lg bg-slate-dark text-white rounded-full w-fit px-5 py-2 mt-8">Lihat Detail -></a>
                </div>
            </div>
        </div>
        <div id="chibi" class="flex flex-col gap-5 bg-gray-100 w-full p-5 rounded-2xl">
            <h2 class="font-bold text-2xl">Chibi</h2>
            <div class="flex flex-row items-start w-full h-fit rounded-xl bg-amber-100  ">
                <img src="{{ asset('images/logo.png') }}" class="w-1/2 h-50 object-cover" alt="">
                <div class="flex flex-col px-5 py-7">
                    <h3 class="font-bold text-2xl">Chibi Character Icon</h3>
                    <span class="font-medium opacity-75 text-xl">Mulai dari Rp. 50.000</span>
                    <a href="" class="font-bold text-lg bg-slate-dark text-white rounded-full w-fit px-5 py-2 mt-8">Lihat Detail -></a>
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection
