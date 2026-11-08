@extends('layouts.profile_layout')

@section('profile_content')
<div class="grid grid-cols-12 gap-5">
    <div class="flex flex-col col-span-4 gap-5">
        <div class="flex flex-col gap-3">
            <img src="https://i.pinimg.com/736x/1f/ab/08/1fab08609ad7b38f3e738ff6720ac7ff.jpg" alt="" class="w-full h-fit rounded-3xl">
            <span class="font-bold">Chibi Flower</span>
        </div>    
        <div class="flex flex-col gap-3">
            <img src="https://i.pinimg.com/736x/51/ba/4d/51ba4d0a9e97c61b17f55cec682dda86.jpg" alt="" class="w-full h-fit rounded-3xl">
            <span class="font-bold">Chibi Flower</span>
        </div>    

    </div>
    <div class="flex flex-col col-span-4 gap-5">
        <div class="flex flex-col gap-3">
            <img src="https://i.pinimg.com/1200x/34/32/d3/3432d3954298316cf2f760088199ab35.jpg" alt="" class="w-full h-fit rounded-3xl">
            <span class="font-bold">Chibi Flower</span>
        </div>    
        <div class="flex flex-col gap-3">
            <img src="https://i.pinimg.com/736x/6c/ad/d5/6cadd5fbaf278291525b3b7e7f0b1403.jpg" alt="" class="w-full h-fit rounded-3xl">
            <span class="font-bold">Chibi Flower</span>
        </div>    

    </div>
    <div class="flex flex-col col-span-4 gap-5">
        <div class="flex flex-col gap-3">
            <img src="{{ asset('images/cry_chibi.png') }}" alt="" class="w-full h-fit rounded-3xl">
            <span class="font-bold">Chibi Flower</span>
        </div>    
        <div class="flex flex-col gap-3">
            <img src="https://i.pinimg.com/736x/4d/4a/b5/4d4ab545b079869a9375dfa18eec31ce.jpg" alt="" class="w-full h-fit rounded-3xl">
            <span class="font-bold">Chibi Flower</span>
        </div>    

    </div>
    
</div>
@endsection