@extends('layouts.app')

@section('content')
<div class="flex flex-col bg-bg-light">
    <!-- banner -->
    <img src="{{ asset('images/logo.png') }}" alt="" class="w-full h-64 object-cover">
    <div class="grid grid-cols-12 gap-8 mt-8 pl-10 pr-10 relative">
        <!-- kiri -->
        <div class="col-span-4 bg-bg-light p-6 flex flex-col gap-2">
            <img src="{{ asset('images/logo.png') }}" alt="" class="w-36 h-36 object-cover rounded-full absolute -top-28">
            <div class="pt-7 pb-4">
                <h2 class=" font-bold text-slate-dark text-3xl">Acery</h2>
                <span class=" font-bold text-slate-body opacity-60">@Aceryy</span>
            </div>
            <h2 class=" text-slate-dark">Hi Im Acery!! i love to draw a funny things^^</h2>
        </div>
        <!-- kanan -->
        <div class="col-span-8 bg-bg-light p-6">
            <!-- tab -->
            <div class="border-b border-gray-200 mb-6">
                <nav class="flex gap-6">
                    <a href="" class="pb-2 border-b-2 border-pastel-200 font-semibold text-slate-dark">Commission</a>
                    <a href="" class="pb-2 text-slate-muted hover:text-slate-dark">Portofolio</a>
                    <a href="" class="pb-2 text-slate-muted hover:text-slate-dark">Terms of Service</a>
                    <a href="" class="pb-2 text-slate-muted hover:text-slate-dark">Setting</a>
                </nav>
            </div>
            <div>
                @yield('profile_content')
            </div>
        </div>
    </div> 
</div>

@endsection