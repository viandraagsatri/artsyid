@extends('layouts.profile_layout')

@section('profile_content')
<div class="flex flex-col items-center gap-6">
    <img src="{{ asset('images/cry_chibi.png') }}" alt="" class="w-30 h-30 object-cover">
    <span class="text-center">Yahh kamu belum bisa pakai fitur ini :< <br>
            Daftar jadi artist terlebih dahulu untuk membuka fitur inii</span>
    <a href="" class="bg-slate-dark text-white px-4 py-2 rounded-full w-fit">Daftar jadi artist</a>
</div>
@endsection
