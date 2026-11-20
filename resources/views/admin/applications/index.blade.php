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

                @if (session('success'))
                    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm font-semibold flex items-center justify-between shadow-2xs">
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                        <button type="button" onclick="this.parentElement.remove()" class="text-emerald-700 hover:text-emerald-900 font-bold px-2 py-1">
                            &times;
                        </button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="p-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 text-xs sm:text-sm font-semibold flex items-center justify-between shadow-2xs">
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-triangle-exclamation text-red-600 text-base"></i>
                            <span>{{ $errors->first() }}</span>
                        </div>
                        <button type="button" onclick="this.parentElement.remove()" class="text-red-700 hover:text-red-900 font-bold px-2 py-1">
                            &times;
                        </button>
                    </div>
                @endif

                <div class="bg-white rounded-2xl border border-stone-200/90 shadow-2xs p-5 sm:p-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="px-2.5 py-1 rounded-md bg-pastel-200 text-amber-900 font-bold text-[10px] font-heading uppercase tracking-wider">
                                Administrator Portal
                            </span>
                        </div>
                        <h1 class="text-xl sm:text-2xl font-black font-heading text-slate-dark mt-1">
                            Verifikasi Pengajuan Artist
                        </h1>
                        <p class="text-xs sm:text-sm text-slate-muted mt-0.5">
                            Tinjau kelengkapan berkas portofolio, rekening pencairan, dan ToS sebelum menyetujui akun artist baru.
                        </p>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.applications.index') }}" class="px-3.5 py-2 rounded-xl bg-stone-100 hover:bg-stone-200 text-slate-dark font-bold text-xs font-heading transition flex items-center gap-2">
                            <i class="fa-solid fa-rotate text-xs"></i>
                            <span>Segarkan</span>
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                    <div class="bg-white p-4 sm:p-5 rounded-2xl border border-stone-200/90 shadow-2xs flex items-center justify-between">
                        <div>
                            <span class="text-[11px] sm:text-xs text-slate-muted font-medium block">Total Pemohon</span>
                            <span class="text-xl sm:text-2xl font-black font-heading text-slate-dark mt-1 block">
                                {{ $stats['total'] }}
                            </span>
                        </div>
                        <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-stone-100 text-slate-700 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-users text-sm sm:text-base"></i>
                        </div>
                    </div>

                    <div class="bg-white p-4 sm:p-5 rounded-2xl border border-stone-200/90 shadow-2xs flex items-center justify-between">
                        <div>
                            <span class="text-[11px] sm:text-xs text-slate-muted font-medium block">Menunggu Review</span>
                            <span class="text-xl sm:text-2xl font-black font-heading text-amber-600 mt-1 block">
                                {{ $stats['pending'] }}
                            </span>
                        </div>
                        <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-clock-rotate-left text-sm sm:text-base"></i>
                        </div>
                    </div>

                    <div class="bg-white p-4 sm:p-5 rounded-2xl border border-stone-200/90 shadow-2xs flex items-center justify-between">
                        <div>
                            <span class="text-[11px] sm:text-xs text-slate-muted font-medium block">Disetujui</span>
                            <span class="text-xl sm:text-2xl font-black font-heading text-emerald-700 mt-1 block">
                                {{ $stats['approved'] }}
                            </span>
                        </div>
                        <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-circle-check text-sm sm:text-base"></i>
                        </div>
                    </div>

                    <div class="bg-white p-4 sm:p-5 rounded-2xl border border-stone-200/90 shadow-2xs flex items-center justify-between">
                        <div>
                            <span class="text-[11px] sm:text-xs text-slate-muted font-medium block">Ditolak</span>
                            <span class="text-xl sm:text-2xl font-black font-heading text-red-700 mt-1 block">
                                {{ $stats['rejected'] }}
                            </span>
                        </div>
                        <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-red-100 text-red-800 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-circle-xmark text-sm sm:text-base"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-stone-200/90 shadow-2xs p-4 flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4">
                    <div class="flex items-center gap-1.5 overflow-x-auto pb-1 md:pb-0 scrollbar-none">
                        <a href="{{ route('admin.applications.index', ['status' => 'all', 'search' => $search]) }}"
                            class="px-3.5 py-2 rounded-xl text-xs font-heading font-bold transition whitespace-nowrap {{ $filter === 'all' ? 'bg-pastel-200 text-slate-dark border border-pastel-300 shadow-xs' : 'text-slate-muted hover:text-slate-dark hover:bg-stone-50' }}">
                            Semua ({{ $stats['total'] }})
                        </a>
                        <a href="{{ route('admin.applications.index', ['status' => 'pending', 'search' => $search]) }}"
                            class="px-3.5 py-2 rounded-xl text-xs font-heading font-bold transition whitespace-nowrap {{ $filter === 'pending' ? 'bg-amber-100 text-amber-900 border border-amber-300 shadow-xs' : 'text-slate-muted hover:text-slate-dark hover:bg-stone-50' }}">
                            Menunggu ({{ $stats['pending'] }})
                        </a>
                        <a href="{{ route('admin.applications.index', ['status' => 'approved', 'search' => $search]) }}"
                            class="px-3.5 py-2 rounded-xl text-xs font-heading font-bold transition whitespace-nowrap {{ $filter === 'approved' ? 'bg-emerald-100 text-emerald-900 border border-emerald-300 shadow-xs' : 'text-slate-muted hover:text-slate-dark hover:bg-stone-50' }}">
                            Disetujui ({{ $stats['approved'] }})
                        </a>
                        <a href="{{ route('admin.applications.index', ['status' => 'rejected', 'search' => $search]) }}"
                            class="px-3.5 py-2 rounded-xl text-xs font-heading font-bold transition whitespace-nowrap {{ $filter === 'rejected' ? 'bg-red-100 text-red-900 border border-red-300 shadow-xs' : 'text-slate-muted hover:text-slate-dark hover:bg-stone-50' }}">
                            Ditolak ({{ $stats['rejected'] }})
                        </a>
                    </div>

                    <form action="{{ route('admin.applications.index') }}" method="GET" class="flex items-center gap-2">
                        <input type="hidden" name="status" value="{{ $filter }}">
                        <div class="relative w-full md:w-64">
                            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-xs text-slate-400"></i>
                            <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama / email..."
                                class="w-full pl-9 pr-3.5 py-2 rounded-xl text-xs bg-bg-light border border-stone-200 focus:outline-none focus:border-amber-400 focus:bg-white transition text-slate-dark">
                        </div>
                        <button type="submit" class="px-3.5 py-2 rounded-xl bg-pastel-200 hover:bg-pastel-300 border border-pastel-300 text-slate-dark font-bold text-xs font-heading transition">
                            Cari
                        </button>
                        @if ($search)
                            <a href="{{ route('admin.applications.index', ['status' => $filter]) }}" class="px-2.5 py-2 rounded-xl bg-stone-100 hover:bg-stone-200 text-slate-dark text-xs font-bold font-heading transition" title="Reset pencarian">
                                <i class="fa-solid fa-xmark"></i>
                            </a>
                        @endif
                    </form>
                </div>

                @if ($applications->isEmpty())
                    <div class="bg-white rounded-2xl border border-stone-200/90 shadow-2xs p-12 text-center space-y-3">
                        <div class="w-14 h-14 rounded-full bg-pastel-100 text-amber-700 flex items-center justify-center mx-auto text-2xl">
                            <i class="fa-solid fa-id-card"></i>
                        </div>
                        <h3 class="font-heading font-bold text-base text-slate-dark">Tidak Ada Pengajuan</h3>
                        <p class="text-xs text-slate-muted max-w-sm mx-auto">
                            @if ($search)
                                Tidak ditemukan pengajuan dengan kata kunci "{{ $search }}".
                            @else
                                Belum ada pengajuan artist pada status ini.
                            @endif
                        </p>
                        @if ($search || $filter !== 'all')
                            <a href="{{ route('admin.applications.index') }}" class="inline-block mt-2 px-4 py-2 rounded-xl bg-pastel-200 hover:bg-pastel-300 text-slate-dark text-xs font-bold font-heading transition">
                                Tampilkan Semua Pengajuan
                            </a>
                        @endif
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach ($applications as $applicant)
                            @php
                                $cardData = $service->resolveApplicantCardData($applicant);
                                $profile = $cardData['profile'];
                                $latestApp = $cardData['latestApp'];
                                $appStatus = $cardData['appStatus'];
                                $activeLinks = $cardData['activeLinks'];
                                $activeNotes = $cardData['activeNotes'];
                                $pastRejections = $cardData['pastRejections'];
                                $isReapplication = $cardData['isReapplication'];
                                $bisaList = $cardData['bisaList'];
                                $tidakList = $cardData['tidakList'];
                            @endphp

                            <div class="bg-white rounded-2xl border border-stone-200/90 shadow-2xs p-5 sm:p-6 space-y-5 transition hover:shadow-xs">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-stone-100">
                                    <div class="flex items-center gap-3.5">
                                        <div class="w-11 h-11 rounded-full bg-pastel-300 text-slate-dark font-black text-sm flex items-center justify-center font-heading shrink-0 shadow-2xs">
                                            {{ strtoupper(substr($applicant->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2 flex-wrap">
                                                <h3 class="font-heading font-bold text-sm sm:text-base text-slate-dark">
                                                    {{ $applicant->name }}
                                                </h3>
                                                <span class="text-[11px] text-slate-muted font-normal">
                                                    ({{ $applicant->email }})
                                                </span>
                                                @if ($isReapplication)
                                                    <span class="px-2 py-0.5 rounded-full bg-purple-50 text-purple-800 border border-purple-200 text-[10px] font-bold font-heading">
                                                        <i class="fa-solid fa-rotate-right mr-1"></i> Pengajuan Ulang
                                                    </span>
                                                @endif
                                            </div>
                                            <p class="text-xs text-slate-muted mt-0.5">
                                                @if ($appStatus === 'pending')
                                                    Diajukan: <strong class="text-slate-body font-medium">{{ $latestApp && $latestApp->created_at ? $latestApp->created_at->timezone('Asia/Jakarta')->translatedFormat('d F Y, H:i') : '-' }} WIB</strong> ({{ $latestApp && $latestApp->created_at ? $latestApp->created_at->diffForHumans() : '' }})
                                                @elseif ($appStatus === 'approved')
                                                    Diajukan: <span class="text-slate-body">{{ $latestApp && $latestApp->created_at ? $latestApp->created_at->timezone('Asia/Jakarta')->translatedFormat('d M Y') : '-' }}</span>
                                                    <span class="text-slate-300 mx-1">•</span>
                                                    Disetujui Admin: <strong class="text-emerald-700 font-bold">{{ $latestApp && $latestApp->updated_at ? $latestApp->updated_at->timezone('Asia/Jakarta')->translatedFormat('d F Y, H:i') : '-' }} WIB</strong>
                                                @elseif ($appStatus === 'rejected')
                                                    Diajukan: <span class="text-slate-body">{{ $latestApp && $latestApp->created_at ? $latestApp->created_at->timezone('Asia/Jakarta')->translatedFormat('d M Y') : '-' }}</span>
                                                    <span class="text-slate-300 mx-1">•</span>
                                                    Ditolak Admin: <strong class="text-red-700 font-bold">{{ $latestApp && $latestApp->updated_at ? $latestApp->updated_at->timezone('Asia/Jakarta')->translatedFormat('d F Y, H:i') : '-' }} WIB</strong>
                                                @endif
                                                <span class="text-slate-300 mx-1">•</span>
                                                Role: <span class="capitalize font-semibold text-slate-dark">{{ $applicant->role }}</span>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        @if ($appStatus === 'pending')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-50 text-amber-800 border border-amber-200 text-xs font-bold font-heading">
                                                <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                                                Menunggu Verifikasi
                                            </span>
                                        @elseif ($appStatus === 'approved')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200 text-xs font-bold font-heading">
                                                <i class="fa-solid fa-circle-check text-emerald-600"></i>
                                                Disetujui
                                            </span>
                                        @elseif ($appStatus === 'rejected')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-50 text-red-800 border border-red-200 text-xs font-bold font-heading">
                                                <i class="fa-solid fa-circle-xmark text-red-600"></i>
                                                Ditolak
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs">
                                    <div class="p-3.5 rounded-xl bg-bg-light border border-stone-100 space-y-1">
                                        <span class="text-[10px] uppercase font-bold text-slate-muted font-heading block">
                                            <i class="fa-solid fa-building-columns text-amber-600 mr-1"></i> Rekening Bank
                                        </span>
                                        <p class="font-bold font-heading text-slate-dark text-sm">
                                            {{ $profile->bank_name ?? '-' }}
                                        </p>
                                        <p class="text-slate-body font-mono">
                                            {{ $profile->account_number ?? '-' }}
                                        </p>
                                        <p class="text-slate-muted">
                                            a.n. <strong class="text-slate-dark">{{ $profile->account_holder ?? '-' }}</strong>
                                        </p>
                                    </div>

                                    <div class="p-3.5 rounded-xl bg-bg-light border border-stone-100 space-y-1">
                                        <span class="text-[10px] uppercase font-bold text-slate-muted font-heading block">
                                            <i class="fa-solid fa-palette text-amber-600 mr-1"></i> Berkas Portofolio Aktif ({{ count($activeLinks) }} tautan)
                                        </span>
                                        <div class="flex flex-col gap-1 mt-1 max-h-20 overflow-y-auto">
                                            @forelse ($activeLinks as $link)
                                                <a href="{{ $link }}" target="_blank" rel="noopener noreferrer"
                                                    class="text-amber-800 hover:text-amber-900 font-medium hover:underline flex items-center gap-1.5 truncate">
                                                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px] shrink-0"></i>
                                                    <span class="truncate">{{ $link }}</span>
                                                </a>
                                            @empty
                                                <span class="text-slate-400 italic text-[11px]">Tidak ada tautan terlampir</span>
                                            @endforelse
                                        </div>
                                    </div>

                                    <div class="p-3.5 rounded-xl bg-bg-light border border-stone-100 space-y-1">
                                        <span class="text-[10px] uppercase font-bold text-slate-muted font-heading block">
                                            <i class="fa-solid fa-file-contract text-amber-600 mr-1"></i> Ketentuan ToS
                                        </span>
                                        <p class="text-slate-body">
                                            <i class="fa-solid fa-check text-emerald-600 text-[10px]"></i>
                                            Bisa Digambar: <strong>{{ count($bisaList) }} ketentuan</strong>
                                        </p>
                                        <p class="text-slate-body">
                                            <i class="fa-solid fa-ban text-red-600 text-[10px]"></i>
                                            Tidak Menerima: <strong>{{ count($tidakList) }} ketentuan</strong>
                                        </p>
                                    </div>
                                </div>

                                @if ($appStatus === 'rejected' && $activeNotes)
                                    <div class="p-3.5 rounded-xl bg-red-50/60 border border-red-200/80 text-xs text-red-900">
                                        <strong class="font-heading block mb-0.5 text-red-950">Catatan Penolakan Admin:</strong>
                                        <p class="leading-relaxed">{{ $activeNotes }}</p>
                                    </div>
                                @endif

                                <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 pt-3 border-t border-stone-100">
                                    <button type="button"
                                        onclick="openDetailModal({{ json_encode([
                                            'name' => $applicant->name,
                                            'email' => $applicant->email,
                                            'bank_name' => $profile->bank_name ?? '-',
                                            'account_number' => $profile->account_number ?? '-',
                                            'account_holder' => $profile->account_holder ?? '-',
                                            'bisa_list' => $bisaList,
                                            'tidak_list' => $tidakList,
                                            'links' => $activeLinks,
                                            'status' => $appStatus,
                                            'admin_notes' => $activeNotes ?? '',
                                            'past_rejected' => $pastRejections,
                                        ]) }})"
                                        class="px-4 py-2 rounded-xl bg-pastel-100 text-pastel-500 hover:bg-pastel-200 cursor-pointer font-bold text-xs font-heading transition flex items-center justify-center gap-2">
                                        <i class="fa-solid fa-eye text-xs"></i>
                                        <span>Lihat Detail Berkas</span>
                                    </button>

                                    @if ($appStatus === 'pending')
                                        <div class="flex items-center gap-2.5">
                                            <button type="button"
                                                onclick="openRejectModal('{{ route('admin.applications.verify', $applicant->id) }}', '{{ $applicant->name }}')"
                                                class="flex-1 sm:flex-none px-4 py-2 cursor-pointer rounded-xl bg-red-50 hover:bg-red-100 text-red-700 border border-red-200 font-bold text-xs font-heading shadow-xs transition flex items-center justify-center gap-1.5">
                                                <i class="fa-solid fa-xmark text-xs"></i>
                                                <span>Tolak</span>
                                            </button>
                                            <button type="button"
                                                onclick="openApproveModal('{{ route('admin.applications.verify', $applicant->id) }}', '{{ $applicant->name }}')"
                                                class="flex-1 sm:flex-none px-4 py-2 cursor-pointer rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-xs font-heading shadow-xs transition flex items-center justify-center gap-1.5">
                                                <i class="fa-solid fa-check text-xs"></i>
                                                <span>Terima Menjadi Artist</span>
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach

                        <div class="pt-4">
                            {{ $applications->links() }}
                        </div>
                    </div>
                @endif

            </main>
        </div>
    </div>

    <div id="detailModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-slate-dark/60 backdrop-blur-xs p-4">
        <div class="bg-white rounded-2xl border border-stone-200 shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto p-6 space-y-5">
            <div class="flex items-center justify-between pb-3 border-b border-stone-200">
                <div>
                    <h3 class="text-base font-bold font-heading text-slate-dark" id="modal-detail-title">
                        Detail Pengajuan Artist
                    </h3>
                    <p class="text-xs text-slate-muted" id="modal-detail-subtitle">
                        Periksa kelayakan ToS dan sampel portofolio.
                    </p>
                </div>
                <button type="button" onclick="closeDetailModal()" class="w-8 h-8 rounded-full bg-stone-100 hover:bg-stone-200 text-slate-600 flex items-center justify-center font-bold">
                    &times;
                </button>
            </div>

            <div class="p-4 rounded-xl bg-bg-light border border-stone-100 space-y-2">
                <h4 class="font-heading font-bold text-xs text-slate-dark flex items-center gap-1.5">
                    <i class="fa-solid fa-building-columns text-amber-600"></i> Rekening Pencairan Dana
                </h4>
                <div class="grid grid-cols-3 gap-2 text-xs">
                    <div>
                        <span class="text-[10px] text-slate-muted uppercase font-bold block">Nama Bank</span>
                        <p class="font-bold text-slate-dark" id="modal-detail-bank">-</p>
                    </div>
                    <div>
                        <span class="text-[10px] text-slate-muted uppercase font-bold block">Nomor Rekening</span>
                        <p class="font-mono font-bold text-slate-dark" id="modal-detail-acc-no">-</p>
                    </div>
                    <div>
                        <span class="text-[10px] text-slate-muted uppercase font-bold block">Nama Pemilik</span>
                        <p class="font-bold text-slate-dark" id="modal-detail-acc-holder">-</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                <div class="p-4 rounded-xl bg-emerald-50/50 border border-emerald-100 space-y-2">
                    <h4 class="font-heading font-bold text-xs text-emerald-900 flex items-center gap-1.5">
                        <i class="fa-solid fa-check text-emerald-600"></i> Bisa Digambar (Accept)
                    </h4>
                    <ul class="space-y-1 list-disc list-inside text-slate-body text-[11px]" id="modal-detail-bisa">
                    </ul>
                </div>

                <div class="p-4 rounded-xl bg-red-50/50 border border-red-100 space-y-2">
                    <h4 class="font-heading font-bold text-xs text-red-900 flex items-center gap-1.5">
                        <i class="fa-solid fa-ban text-red-600"></i> Tidak Menerima (Decline)
                    </h4>
                    <ul class="space-y-1 list-disc list-inside text-slate-body text-[11px]" id="modal-detail-tidak">
                    </ul>
                </div>
            </div>

            <div class="space-y-2">
                <h4 class="font-heading font-bold text-xs text-slate-dark flex items-center gap-1.5">
                    <i class="fa-solid fa-palette text-amber-600"></i> Tautan Sampel Portofolio
                </h4>
                <div class="space-y-1.5" id="modal-detail-links">
                </div>
            </div>

            <div id="modal-detail-past-box" class="hidden p-4 rounded-xl bg-stone-50 border border-stone-200 text-xs space-y-2">
                <h4 class="font-heading font-bold text-xs text-slate-dark flex items-center gap-1.5">
                    <i class="fa-solid fa-clock-rotate-left text-red-600"></i> Riwayat Penolakan Sebelumnya
                </h4>
                <div class="space-y-2 text-[11px]" id="modal-detail-past-list">
                </div>
            </div>

            <div class="flex justify-end pt-3 border-t border-stone-100">
                <button type="button" onclick="closeDetailModal()" class="px-4 py-2 cursor-pointer rounded-xl bg-stone-100 hover:bg-stone-200 text-slate-dark text-xs font-bold font-heading transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <div id="approveModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-slate-dark/60 backdrop-blur-xs p-4">
        <div class="bg-white rounded-2xl border border-stone-200 shadow-2xl w-full max-w-md p-6 space-y-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-lg shrink-0">
                    <i class="fa-solid fa-check"></i>
                </div>
                <div>
                    <h3 class="font-heading font-bold text-base text-slate-dark">Terima Pengajuan Artist?</h3>
                    <p class="text-xs text-slate-muted" id="approve-applicant-name">Applicant Name</p>
                </div>
            </div>

            <p class="text-xs text-slate-body leading-relaxed">
                Dengan menyetujui, akun pengguna ini akan diubah rolenya menjadi <strong>Artist</strong>. Pengguna akan dapat membuat katalog komisi dan menerima pesanan.
            </p>

            <form id="approveForm" action="" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="action" value="approve">

                <div>
                    <label class="block text-xs font-semibold text-slate-dark mb-1">
                        Catatan Admin untuk Artist (Opsional)
                    </label>
                    <textarea name="admin_notes" rows="2" placeholder="Selamat bergabung sebagai artist Artsy ID!"
                        class="w-full text-xs p-3 rounded-xl bg-bg-light border border-stone-200 focus:outline-none focus:border-emerald-500"></textarea>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2 border-t border-stone-100">
                    <button type="button" onclick="closeApproveModal()" class="px-4 py-2 cursor-pointer rounded-xl bg-stone-100 hover:bg-stone-200 text-slate-dark text-xs font-bold font-heading transition">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 cursor-pointer rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-bold font-heading shadow-xs transition">
                        Konfirmasi Terima
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="rejectModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-slate-dark/60 backdrop-blur-xs p-4">
        <div class="bg-white rounded-2xl border border-stone-200 shadow-2xl w-full max-w-md p-6 space-y-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-red-100 text-red-700 flex items-center justify-center text-lg shrink-0">
                    <i class="fa-solid fa-xmark"></i>
                </div>
                <div>
                    <h3 class="font-heading font-bold text-base text-slate-dark">Tolak Pengajuan Artist?</h3>
                    <p class="text-xs text-slate-muted" id="reject-applicant-name">Applicant Name</p>
                </div>
            </div>

            <p class="text-xs text-slate-body leading-relaxed">
                Tuliskan alasan penolakan dengan jelas agar pemohon dapat memperbaiki data atau portofolio mereka.
            </p>

            <form id="rejectForm" action="" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="action" value="reject">

                <div>
                    <label class="block text-xs font-semibold text-slate-dark mb-1">
                        Alasan Penolakan <span class="text-red-600">*</span>
                    </label>
                    <textarea name="admin_notes" rows="3" required placeholder="Contoh: Link portofolio tidak dapat diakses atau belum memenuhi standar keaslian karya..."
                        class="w-full text-xs p-3 rounded-xl bg-bg-light border border-stone-200 focus:outline-none focus:border-red-500 text-slate-dark"></textarea>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2 border-t border-stone-100">
                    <button type="button" onclick="closeRejectModal()" class="px-4 py-2 cursor-pointer rounded-xl bg-stone-100 hover:bg-stone-200 text-slate-dark text-xs font-bold font-heading transition">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 cursor-pointer rounded-xl bg-red-600 hover:bg-red-700 text-white text-xs font-bold font-heading shadow-xs transition">
                        Tolak Pengajuan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openDetailModal(data) {
            document.getElementById('modal-detail-title').innerText = 'Detail Pengajuan: ' + data.name;
            document.getElementById('modal-detail-subtitle').innerText = 'Email: ' + data.email;
            document.getElementById('modal-detail-bank').innerText = data.bank_name;
            document.getElementById('modal-detail-acc-no').innerText = data.account_number;
            document.getElementById('modal-detail-acc-holder').innerText = data.account_holder;

            // ToS Bisa list
            const bisaContainer = document.getElementById('modal-detail-bisa');
            bisaContainer.innerHTML = '';
            if (data.bisa_list && data.bisa_list.length > 0) {
                data.bisa_list.forEach(item => {
                    const li = document.createElement('li');
                    li.innerText = item;
                    bisaContainer.appendChild(li);
                });
            } else {
                bisaContainer.innerHTML = '<li class="text-slate-400 italic">Tidak ada ketentuan tercantum</li>';
            }

            // ToS Tidak Bisa list
            const tidakContainer = document.getElementById('modal-detail-tidak');
            tidakContainer.innerHTML = '';
            if (data.tidak_list && data.tidak_list.length > 0) {
                data.tidak_list.forEach(item => {
                    const li = document.createElement('li');
                    li.innerText = item;
                    tidakContainer.appendChild(li);
                });
            } else {
                tidakContainer.innerHTML = '<li class="text-slate-400 italic">Tidak ada ketentuan tercantum</li>';
            }

            const linksContainer = document.getElementById('modal-detail-links');
            linksContainer.innerHTML = '';
            if (data.links && data.links.length > 0) {
                data.links.forEach((url, i) => {
                    const a = document.createElement('a');
                    a.href = url;
                    a.target = '_blank';
                    a.rel = 'noopener noreferrer';
                    a.className = 'p-2 rounded-lg bg-bg-light border border-stone-200 text-amber-800 hover:text-amber-900 font-medium hover:underline flex items-center justify-between text-xs transition';
                    a.innerHTML = `
                        <span class="truncate mr-2"><i class="fa-solid fa-link text-[10px] mr-1 text-slate-400"></i> ${url}</span>
                        <span class="px-2 py-0.5 rounded bg-amber-100 text-amber-900 text-[10px] font-bold shrink-0">Buka Link</span>
                    `;
                    linksContainer.appendChild(a);
                });
            } else {
                linksContainer.innerHTML = '<p class="text-xs text-slate-400 italic">Tidak ada tautan terlampir</p>';
            }

            const pastBox = document.getElementById('modal-detail-past-box');
            const pastList = document.getElementById('modal-detail-past-list');
            pastList.innerHTML = '';
            if (data.past_rejected && data.past_rejected.length > 0) {
                data.past_rejected.forEach(item => {
                    const div = document.createElement('div');
                    div.className = 'p-3 rounded-xl bg-white border border-stone-200 space-y-1.5 shadow-2xs';

                    let linksHtml = '';
                    if (item.links && item.links.length > 0) {
                        linksHtml = '<div class="pt-1.5 border-t border-stone-100 flex flex-col gap-1 text-[11px]">' +
                            '<span class="text-[10px] uppercase font-bold text-slate-400">Tautan yang dilampirkan:</span>' +
                            item.links.map(url => `<a href="${url}" target="_blank" rel="noopener noreferrer" class="hover:underline truncate text-amber-800 font-medium flex items-center gap-1"><i class="fa-solid fa-arrow-up-right-from-square text-[9px] shrink-0"></i><span class="truncate">${url}</span></a>`).join('') +
                            '</div>';
                    }

                    div.innerHTML = `
                        <div class="flex items-center justify-between text-[11px] text-red-700 font-bold font-heading">
                            <span><i class="fa-solid fa-triangle-exclamation mr-1.5"></i> Evaluasi pada ${item.date}</span>
                        </div>
                        <p class="text-slate-dark text-xs leading-relaxed bg-red-50/50 p-2 rounded-lg border border-red-100/70 font-sans">${item.notes || 'Tanpa catatan'}</p>
                        ${linksHtml}
                    `;
                    pastList.appendChild(div);
                });
                pastBox.classList.remove('hidden');
            } else {
                pastBox.classList.add('hidden');
            }

            document.getElementById('detailModal').classList.remove('hidden');
        }

        function closeDetailModal() {
            document.getElementById('detailModal').classList.add('hidden');
        }

        function openApproveModal(actionUrl, applicantName) {
            document.getElementById('approveForm').action = actionUrl;
            document.getElementById('approve-applicant-name').innerText = 'Pemohon: ' + applicantName;
            document.getElementById('approveModal').classList.remove('hidden');
        }

        function closeApproveModal() {
            document.getElementById('approveModal').classList.add('hidden');
        }

        function openRejectModal(actionUrl, applicantName) {
            document.getElementById('rejectForm').action = actionUrl;
            document.getElementById('reject-applicant-name').innerText = 'Pemohon: ' + applicantName;
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }
    </script>
@endsection
