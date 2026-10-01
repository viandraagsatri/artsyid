@extends('layouts.app')

@section('content')
<div class="relative overflow-hidden bg-gradient-to-b from-[#FFFDF0] to-[#FAFAFA] py-16 sm:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#FDF1A9] text-slate-800 mb-6 shadow-xs">
                Platform Komisi Karya Seni Digital Terpercaya
            </span>
            <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight text-slate-900 leading-tight">
                Wujudkan Karya Impian Tanpa Khawatir <span class="bg-[#FFF9C4] px-2 py-0.5 rounded-lg border border-[#FCE67B]">Scam & Ghosting</span>
            </h1>
            <p class="mt-6 text-lg text-slate-600 leading-relaxed">
                Artsy ID menghubungkan Artist berbakat dan Client dengan sistem pembayaran bertahap (Escrow), perlindungan watermark otomatis, dan progress tracking transparan.
            </p>
            <div class="mt-8 flex flex-wrap justify-center gap-4">
                <a href="#explore" class="px-6 py-3.5 rounded-xl font-heading font-semibold bg-[#FDF1A9] hover:bg-[#FCE67B] text-slate-900 transition shadow-sm hover:shadow-md">
                    Jelajahi Katalog Seni
                </a>
                <a href="#how-it-works" class="px-6 py-3.5 rounded-xl font-heading font-semibold bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 transition">
                    Pelajari Cara Kerja
                </a>
            </div>
        </div>

        <!-- Fitur Unggulan Grid -->
        <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="p-6 rounded-2xl bg-white border border-slate-100 shadow-xs hover:shadow-md transition">
                <div class="w-12 h-12 rounded-xl bg-[#FFF9C4] flex items-center justify-center text-xl mb-4">
                    🛡️
                </div>
                <h3 class="text-lg font-bold text-slate-900">Pembayaran Escrow 2 Tahap</h3>
                <p class="mt-2 text-sm text-slate-600">
                    DP 50% aman di escrow. Dana baru dicairkan ke artist setelah tahap Line Art disetujui, dan pelunasan saat karya diterima.
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-white border border-slate-100 shadow-xs hover:shadow-md transition">
                <div class="w-12 h-12 rounded-xl bg-[#FFF9C4] flex items-center justify-center text-xl mb-4">
                    🔍
                </div>
                <h3 class="text-lg font-bold text-slate-900">Progress Tracker Transparan</h3>
                <p class="mt-2 text-sm text-slate-600">
                    Pantau 4 tahapan karya: Sketsa, Line Art, Pewarnaan, hingga Rendering dengan proteksi watermark otomatis.
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-white border border-slate-100 shadow-xs hover:shadow-md transition">
                <div class="w-12 h-12 rounded-xl bg-[#FFF9C4] flex items-center justify-center text-xl mb-4">
                    ⚡
                </div>
                <h3 class="text-lg font-bold text-slate-900">Dynamic Invoice & Add-ons</h3>
                <p class="mt-2 text-sm text-slate-600">
                    Minta detail tambahan di tengah pengerjaan tanpa ribet. Transparan, terinci, dan bebas scope creep.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
