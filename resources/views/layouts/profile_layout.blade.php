@extends('layouts.app')

@section('content')
<div class="flex flex-col bg-bg-light relative">
    <!-- banner -->
     <a href="{{ route('dashboard') }}" class="flex justify-center items-center absolute top-4 left-4 w-10 h-10 bg-bg-light/60 rounded-full hover:bg-bg-light/80 transition-all duration-200">
        <i class="fa-solid fa-arrow-left text-slate-dark/70 text-2xl cursor-pointer hover:text-slate-dark transition-all duration-200"></i>
     </a>
    <img src="https://i.pinimg.com/1200x/1a/47/ca/1a47ca1c4a332a7c4c7b4d7581704ef6.jpg" alt="" class="w-full h-64 object-cover ">
    <div class="grid grid-cols-12 gap-8 mt-8 pl-10 pr-10 relative">
        <!-- kiri -->
        <div class="col-span-4 bg-bg-light p-10 flex flex-col gap-2">
            <img src="https://i.pinimg.com/1200x/97/4e/a3/974ea3063a4d62048c60ab72a4aa4134.jpg" alt="" class="w-36 h-36 object-cover rounded-full absolute -top-28 border-3 border-slate-dark">
            <div class="pt-7 pb-4">
                <h2 class=" font-bold text-slate-dark text-3xl">Acery</h2>
                <p class=" font-bold text-slate-dark opacity-50">@Aceryy</p>
                <p class="font-light text-sm text-slate-dark opacity-75">Bergabung pada Juni 2026</p>
            </div>
            @if (Auth::user()->role === 'artist')
                <div class="bg-slate-muted/7 w-full min-h-20 rounded-xl px-5 py-4">
                    
                    @if (Auth::user()->bio)
                        <h2 class="text-slate-dark">{{ Auth::user()->bio }}</h2>
                    
                    @else
                        <h2 class="text-slate-dark italic opacity-70">Artist belum membuat bio</h2>
                    @endif

                </div>
            @endif

        </div>
        <!-- kanan -->
        <div class="col-span-8 bg-bg-light p-6">
            <!-- tab -->
            <div class="border-b border-gray-200 mb-6">
                <nav class="flex gap-6">
                    <a href="{{ route('profile.katalog') }}" class="pb-2 border-b-2 border-pastel-200 font-semibold text-slate-dark">Commission</a>
                    <a href="{{ route('profile.portofolio') }}" class="pb-2 text-slate-muted hover:text-slate-dark">Portofolio</a>
                    <a href="{{ route('profile.setting') }}" class="pb-2 text-slate-muted hover:text-slate-dark">Setting</a>
                </nav>
            </div>
            <div>
                @yield('profile_content')
            </div>
        </div>
    </div> 
</div>

@endsection