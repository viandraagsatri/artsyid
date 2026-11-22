@extends('layouts.app', ['title' => 'Verifikasi Artist - Admin Artsy ID'])

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
                    <div role="status" class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm font-semibold flex items-center justify-between gap-3 shadow-2xs">
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-circle-check text-emerald-700 text-base shrink-0" aria-hidden="true"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                        <button type="button" onclick="this.parentElement.remove()" aria-label="Tutup notifikasi"
                            class="cursor-pointer min-w-11 min-h-11 sm:min-w-8 sm:min-h-8 rounded-lg text-emerald-800 hover:bg-emerald-100 font-bold flex items-center justify-center transition">
                            <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                        </button>
                    </div>
                @endif

                @if ($errors->any())
                    <div role="alert" class="p-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 text-xs sm:text-sm font-semibold flex items-center justify-between gap-3 shadow-2xs">
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-triangle-exclamation text-red-700 text-base shrink-0" aria-hidden="true"></i>
                            <span>{{ $errors->first() }}</span>
                        </div>
                        <button type="button" onclick="this.parentElement.remove()" aria-label="Tutup peringatan"
                            class="cursor-pointer min-w-11 min-h-11 sm:min-w-8 sm:min-h-8 rounded-lg text-red-800 hover:bg-red-100 font-bold flex items-center justify-center transition">
                            <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                        </button>
                    </div>
                @endif

                <div class="bg-white rounded-2xl border border-stone-200/90 shadow-2xs p-5 sm:p-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-xl sm:text-2xl font-black font-heading text-slate-dark mt-1">
                            Verifikasi Pengajuan Artist
                        </h1>
                        <p class="text-xs sm:text-sm text-slate-muted mt-0.5">
                            Tinjau kelengkapan berkas portofolio, rekening pencairan, dan ToS sebelum menyetujui akun artist baru.
                        </p>
                    </div>
                    <div class="flex items-center gap-2 shrink-0">
                        <a href="{{ route('admin.applications.index') }}"
                            class="cursor-pointer min-h-11 sm:min-h-0 px-4 py-2 rounded-xl bg-stone-100 hover:bg-stone-200 text-slate-dark font-bold text-xs font-heading transition flex items-center gap-2">
                            <i class="fa-solid fa-rotate text-xs" aria-hidden="true"></i>
                            <span>Segarkan</span>
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                    <div class="bg-white p-4 sm:p-5 rounded-2xl border border-stone-200/90 shadow-2xs flex items-center justify-between gap-2">
                        <div class="min-w-0">
                            <span class="text-[11px] sm:text-xs text-slate-muted font-medium block">Total Pemohon</span>
                            <span class="text-xl sm:text-2xl font-black font-heading text-slate-dark mt-1 block tabular-nums">
                                {{ $stats['total'] }}
                            </span>
                        </div>
                        <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-stone-100 text-slate-dark flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-users text-sm sm:text-base" aria-hidden="true"></i>
                        </div>
                    </div>

                    <div class="bg-white p-4 sm:p-5 rounded-2xl border border-stone-200/90 shadow-2xs flex items-center justify-between gap-2">
                        <div class="min-w-0">
                            <span class="text-[11px] sm:text-xs text-slate-muted font-medium block">Menunggu Review</span>
                            <span class="text-xl sm:text-2xl font-black font-heading text-amber-800 mt-1 block tabular-nums">
                                {{ $stats['pending'] }}
                            </span>
                        </div>
                        <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-amber-100 text-amber-900 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-clock-rotate-left text-sm sm:text-base" aria-hidden="true"></i>
                        </div>
                    </div>

                    <div class="bg-white p-4 sm:p-5 rounded-2xl border border-stone-200/90 shadow-2xs flex items-center justify-between gap-2">
                        <div class="min-w-0">
                            <span class="text-[11px] sm:text-xs text-slate-muted font-medium block">Disetujui</span>
                            <span class="text-xl sm:text-2xl font-black font-heading text-emerald-800 mt-1 block tabular-nums">
                                {{ $stats['approved'] }}
                            </span>
                        </div>
                        <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-circle-check text-sm sm:text-base" aria-hidden="true"></i>
                        </div>
                    </div>

                    <div class="bg-white p-4 sm:p-5 rounded-2xl border border-stone-200/90 shadow-2xs flex items-center justify-between gap-2">
                        <div class="min-w-0">
                            <span class="text-[11px] sm:text-xs text-slate-muted font-medium block">Ditolak</span>
                            <span class="text-xl sm:text-2xl font-black font-heading text-red-800 mt-1 block tabular-nums">
                                {{ $stats['rejected'] }}
                            </span>
                        </div>
                        <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-red-100 text-red-800 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-circle-xmark text-sm sm:text-base" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-stone-200/90 shadow-2xs p-4 flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4">
                    <div class="flex items-center gap-1.5 overflow-x-auto pb-1 md:pb-0 scrollbar-none">
                        <a href="{{ route('admin.applications.index', ['status' => 'all', 'search' => $search]) }}"
                            class="min-h-10 px-3.5 py-2 rounded-xl text-xs font-heading font-bold transition whitespace-nowrap flex items-center {{ $filter === 'all' ? 'bg-pastel-200 text-slate-dark border border-pastel-300 shadow-xs' : 'text-slate-muted hover:text-slate-dark hover:bg-stone-50' }}">
                            Semua ({{ $tabCounts['total'] }})
                        </a>
                        <a href="{{ route('admin.applications.index', ['status' => 'pending', 'search' => $search]) }}"
                            class="min-h-10 px-3.5 py-2 rounded-xl text-xs font-heading font-bold transition whitespace-nowrap flex items-center {{ $filter === 'pending' ? 'bg-amber-100 text-amber-900 border border-amber-300 shadow-xs' : 'text-slate-muted hover:text-slate-dark hover:bg-stone-50' }}">
                            Menunggu ({{ $tabCounts['pending'] }})
                        </a>
                        <a href="{{ route('admin.applications.index', ['status' => 'approved', 'search' => $search]) }}"
                            class="min-h-10 px-3.5 py-2 rounded-xl text-xs font-heading font-bold transition whitespace-nowrap flex items-center {{ $filter === 'approved' ? 'bg-emerald-100 text-emerald-900 border border-emerald-300 shadow-xs' : 'text-slate-muted hover:text-slate-dark hover:bg-stone-50' }}">
                            Disetujui ({{ $tabCounts['approved'] }})
                        </a>
                        <a href="{{ route('admin.applications.index', ['status' => 'rejected', 'search' => $search]) }}"
                            class="min-h-10 px-3.5 py-2 rounded-xl text-xs font-heading font-bold transition whitespace-nowrap flex items-center {{ $filter === 'rejected' ? 'bg-red-100 text-red-900 border border-red-300 shadow-xs' : 'text-slate-muted hover:text-slate-dark hover:bg-stone-50' }}">
                            Ditolak ({{ $tabCounts['rejected'] }})
                        </a>
                    </div>

                    <form action="{{ route('admin.applications.index') }}" method="GET" class="flex items-center gap-2">
                        <input type="hidden" name="status" value="{{ $filter }}">
                        <label for="application-search" class="sr-only">Cari nama atau email pemohon</label>
                        <div class="relative flex-1 md:w-64">
                            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-xs text-slate-muted" aria-hidden="true"></i>
                            <input type="text" id="application-search" name="search" value="{{ $search }}" placeholder="Cari nama / email..."
                                class="w-full min-h-11 sm:min-h-0 pl-9 pr-3.5 py-2 rounded-xl text-xs bg-bg-light border border-stone-200 focus:outline-none focus:border-amber-500 focus:bg-white transition text-slate-dark placeholder:text-slate-muted">
                        </div>
                        <button type="submit"
                            class="cursor-pointer min-h-11 sm:min-h-0 px-4 py-2 rounded-xl bg-pastel-200 hover:bg-pastel-300 border border-pastel-300 text-slate-dark font-bold text-xs font-heading transition">
                            Cari
                        </button>
                        @if ($search !== '')
                            <a href="{{ route('admin.applications.index', ['status' => $filter]) }}"
                                aria-label="Reset pencarian"
                                title="Reset pencarian"
                                class="min-h-11 min-w-11 sm:min-h-0 sm:min-w-0 px-3 py-2 rounded-xl bg-stone-100 hover:bg-stone-200 text-slate-dark text-xs font-bold font-heading flex items-center justify-center transition">
                                <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                            </a>
                        @endif
                    </form>
                </div>

                @if ($applications->isEmpty())
                    <div class="bg-white rounded-2xl border border-stone-200/90 shadow-2xs p-12 text-center space-y-3">
                        <div class="w-14 h-14 rounded-full bg-pastel-100 text-amber-900 flex items-center justify-center mx-auto text-2xl">
                            <i class="fa-solid fa-id-card" aria-hidden="true"></i>
                        </div>
                        <h3 class="font-heading font-bold text-base text-slate-dark">Tidak Ada Pengajuan</h3>
                        <p class="text-xs text-slate-muted max-w-sm mx-auto">
                            @if ($search !== '')
                                Tidak ditemukan pengajuan dengan kata kunci "{{ $search }}".
                            @else
                                Belum ada pengajuan artist pada status ini.
                            @endif
                        </p>
                        @if ($search !== '' || $filter !== 'all')
                            <a href="{{ route('admin.applications.index') }}"
                                class="inline-flex items-center justify-center min-h-11 sm:min-h-0 mt-2 px-4 py-2 rounded-xl bg-pastel-200 hover:bg-pastel-300 border border-pastel-300 text-slate-dark text-xs font-bold font-heading transition">
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
                                $safeActiveLinks = $cardData['safeActiveLinks'];
                                $activeNotes = $cardData['activeNotes'];
                                $pastRejections = $cardData['pastRejections'];
                                $isReapplication = $cardData['isReapplication'];
                                $isBlocked = $cardData['isBlocked'];
                                $canApprove = $cardData['canApprove'];
                                $canReject = $cardData['canReject'];
                                $bisaList = $cardData['bisaList'];
                                $tidakList = $cardData['tidakList'];

                                $modalPayloadJson = json_encode([
                                    'name'           => $applicant->name,
                                    'email'          => $applicant->email,
                                    'verify_url'     => route('admin.applications.verify', $applicant->id),
                                    'bank_name'      => $profile->bank_name ?? '-',
                                    'account_number' => $profile->account_number ?? '-',
                                    'account_holder' => $profile->account_holder ?? '-',
                                    'bisa_list'      => array_values($bisaList),
                                    'tidak_list'     => array_values($tidakList),
                                    'links'          => $safeActiveLinks,
                                    'status'         => $appStatus,
                                    'admin_notes'    => $activeNotes ?? '',
                                    'past_rejected'  => $pastRejections,
                                ], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
                            @endphp

                            <div class="bg-white rounded-2xl border border-stone-200/90 shadow-2xs p-5 sm:p-6 space-y-5 transition hover:shadow-xs">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-stone-100">
                                    <div class="flex items-center gap-3.5 min-w-0">
                                        <div class="w-11 h-11 rounded-full bg-pastel-300 text-slate-dark font-black text-sm flex items-center justify-center font-heading shrink-0 shadow-2xs">
                                            {{ strtoupper(substr($applicant->name, 0, 2)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <div class="flex items-center gap-2 flex-wrap">
                                                <h3 class="font-heading font-bold text-sm sm:text-base text-slate-dark">
                                                    {{ $applicant->name }}
                                                </h3>
                                                <span class="text-[11px] text-slate-muted font-normal">
                                                    ({{ $applicant->email }})
                                                </span>
                                                @if ($isReapplication)
                                                    <span class="px-2 py-0.5 rounded-full bg-purple-50 text-purple-800 border border-purple-200 text-[10px] font-bold font-heading">
                                                        <i class="fa-solid fa-rotate-right mr-1" aria-hidden="true"></i> Pengajuan Ulang
                                                    </span>
                                                @endif
                                                @if ($isBlocked)
                                                    <span class="px-2 py-0.5 rounded-full bg-red-50 text-red-800 border border-red-200 text-[10px] font-bold font-heading">
                                                        <i class="fa-solid fa-ban mr-1" aria-hidden="true"></i> Akun Diblokir
                                                    </span>
                                                @endif
                                            </div>
                                            <p class="text-xs text-slate-muted mt-0.5">
                                                @if ($appStatus === 'pending')
                                                    Diajukan: <strong class="text-slate-body font-medium">{{ $latestApp && $latestApp->created_at ? $latestApp->created_at->timezone('Asia/Jakarta')->translatedFormat('d F Y, H:i') : '-' }} WIB</strong> ({{ $latestApp && $latestApp->created_at ? $latestApp->created_at->diffForHumans() : '' }})
                                                @elseif ($appStatus === 'approved')
                                                    Diajukan: <span class="text-slate-body">{{ $latestApp && $latestApp->created_at ? $latestApp->created_at->timezone('Asia/Jakarta')->translatedFormat('d M Y') : '-' }}</span>
                                                    <span class="text-slate-300 mx-1">&bull;</span>
                                                    Disetujui Admin: <strong class="text-emerald-800 font-bold">{{ $latestApp && $latestApp->updated_at ? $latestApp->updated_at->timezone('Asia/Jakarta')->translatedFormat('d F Y, H:i') : '-' }} WIB</strong>
                                                @elseif ($appStatus === 'rejected')
                                                    Diajukan: <span class="text-slate-body">{{ $latestApp && $latestApp->created_at ? $latestApp->created_at->timezone('Asia/Jakarta')->translatedFormat('d M Y') : '-' }}</span>
                                                    <span class="text-slate-300 mx-1">&bull;</span>
                                                    Ditolak Admin: <strong class="text-red-800 font-bold">{{ $latestApp && $latestApp->updated_at ? $latestApp->updated_at->timezone('Asia/Jakarta')->translatedFormat('d F Y, H:i') : '-' }} WIB</strong>
                                                @endif
                                                <span class="text-slate-300 mx-1">&bull;</span>
                                                Role: <span class="capitalize font-semibold text-slate-dark">{{ $applicant->role }}</span>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-2 shrink-0">
                                        @if ($appStatus === 'pending')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-50 text-amber-900 border border-amber-200 text-xs font-bold font-heading">
                                                <span class="w-2 h-2 rounded-full bg-amber-600 animate-pulse"></span>
                                                Menunggu Verifikasi
                                            </span>
                                        @elseif ($appStatus === 'approved')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200 text-xs font-bold font-heading">
                                                <i class="fa-solid fa-circle-check text-emerald-700" aria-hidden="true"></i>
                                                Disetujui
                                            </span>
                                        @elseif ($appStatus === 'rejected')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-50 text-red-800 border border-red-200 text-xs font-bold font-heading">
                                                <i class="fa-solid fa-circle-xmark text-red-700" aria-hidden="true"></i>
                                                Ditolak
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs">
                                    <div class="p-3.5 rounded-xl bg-bg-light border border-stone-100 space-y-1">
                                        <span class="text-[10px] uppercase font-bold text-slate-muted font-heading block">
                                            <i class="fa-solid fa-building-columns text-amber-700 mr-1" aria-hidden="true"></i> Rekening Bank
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
                                            <i class="fa-solid fa-palette text-amber-700 mr-1" aria-hidden="true"></i> Berkas Portofolio Aktif ({{ count($safeActiveLinks) }} tautan)
                                        </span>
                                        <div class="flex flex-col gap-1 mt-1 max-h-20 overflow-y-auto">
                                            @forelse ($safeActiveLinks as $linkItem)
                                                @if ($linkItem['href'])
                                                    <a href="{{ $linkItem['href'] }}" target="_blank" rel="noopener noreferrer"
                                                        class="text-amber-900 hover:text-slate-dark font-medium hover:underline flex items-center gap-1.5 truncate">
                                                        <i class="fa-solid fa-arrow-up-right-from-square text-[10px] shrink-0" aria-hidden="true"></i>
                                                        <span class="truncate">{{ $linkItem['url'] }}</span>
                                                    </a>
                                                @else
                                                    <span class="text-slate-muted italic text-[11px] truncate">
                                                        {{ $linkItem['url'] }} (tautan tidak valid)
                                                    </span>
                                                @endif
                                            @empty
                                                <span class="text-slate-muted italic text-[11px]">Tidak ada tautan terlampir</span>
                                            @endforelse
                                        </div>
                                    </div>

                                    <div class="p-3.5 rounded-xl bg-bg-light border border-stone-100 space-y-1">
                                        <span class="text-[10px] uppercase font-bold text-slate-muted font-heading block">
                                            <i class="fa-solid fa-file-contract text-amber-700 mr-1" aria-hidden="true"></i> Ketentuan ToS
                                        </span>
                                        <p class="text-slate-body">
                                            <i class="fa-solid fa-check text-emerald-700 text-[10px]" aria-hidden="true"></i>
                                            Bisa Digambar: <strong>{{ count($bisaList) }} ketentuan</strong>
                                        </p>
                                        <p class="text-slate-body">
                                            <i class="fa-solid fa-ban text-red-700 text-[10px]" aria-hidden="true"></i>
                                            Tidak Menerima: <strong>{{ count($tidakList) }} ketentuan</strong>
                                        </p>
                                    </div>
                                </div>

                                @if ($appStatus === 'approved' && $activeNotes)
                                    <div class="p-3.5 rounded-xl bg-emerald-50/60 border border-emerald-200/80 text-xs text-emerald-900">
                                        <strong class="font-heading block mb-0.5">Catatan Persetujuan Admin:</strong>
                                        <p class="leading-relaxed">{{ $activeNotes }}</p>
                                    </div>
                                @elseif ($appStatus === 'rejected' && $activeNotes)
                                    <div class="p-3.5 rounded-xl bg-red-50/60 border border-red-200/80 text-xs text-red-900">
                                        <strong class="font-heading block mb-0.5 text-red-950">Catatan Penolakan Admin:</strong>
                                        <p class="leading-relaxed">{{ $activeNotes }}</p>
                                    </div>
                                @endif

                                <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 pt-3 border-t border-stone-100">
                                    <button type="button" data-action="detail" data-payload="{{ $modalPayloadJson }}"
                                        class="cursor-pointer min-h-11 sm:min-h-0 px-4 py-2 rounded-xl bg-pastel-100 hover:bg-pastel-200 text-slate-dark border border-pastel-300 font-bold text-xs font-heading transition flex items-center justify-center gap-2">
                                        <i class="fa-solid fa-eye text-xs" aria-hidden="true"></i>
                                        <span>Lihat Detail Berkas</span>
                                    </button>

                                    @if ($canApprove || $canReject || ($appStatus === 'pending' && $isBlocked))
                                        <div class="flex flex-wrap items-center justify-end gap-2.5">
                                            @if ($appStatus === 'pending' && $isBlocked)
                                                <span class="px-3 py-1.5 rounded-xl bg-red-50 text-red-800 border border-red-200 text-[11px] font-bold font-heading">
                                                    Akun diblokir (tidak dapat disetujui)
                                                </span>
                                            @endif
                                            @if ($canReject)
                                                <button type="button" data-action="reject" data-payload="{{ $modalPayloadJson }}"
                                                    class="flex-1 sm:flex-none min-h-11 sm:min-h-0 px-4 py-2 cursor-pointer rounded-xl bg-red-50 hover:bg-red-100 text-red-800 border border-red-200 font-bold text-xs font-heading shadow-xs transition flex items-center justify-center gap-1.5">
                                                    <i class="fa-solid fa-xmark text-xs" aria-hidden="true"></i>
                                                    <span>Tolak</span>
                                                </button>
                                            @endif
                                            @if ($canApprove)
                                                <button type="button" data-action="approve" data-payload="{{ $modalPayloadJson }}"
                                                    class="flex-1 sm:flex-none min-h-11 sm:min-h-0 px-4 py-2 cursor-pointer rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs font-heading shadow-xs transition flex items-center justify-center gap-1.5">
                                                    <i class="fa-solid fa-check text-xs" aria-hidden="true"></i>
                                                    <span>Terima Menjadi Artist</span>
                                                </button>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach

                        @if ($applications->hasPages())
                            <div class="pt-4">
                                {{ $applications->links() }}
                            </div>
                        @endif
                    </div>
                @endif

            </main>
        </div>
    </div>

    <div id="detailModal" role="dialog" aria-modal="true" aria-labelledby="modal-detail-title"
        class="fixed inset-0 z-50 hidden flex items-center justify-center bg-slate-dark/60 backdrop-blur-xs p-4">
        <div class="bg-white rounded-2xl border border-stone-200 shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto p-6 space-y-5">
            <div class="flex items-center justify-between gap-3 pb-3 border-b border-stone-200">
                <div class="min-w-0">
                    <h3 class="text-base font-bold font-heading text-slate-dark truncate" id="modal-detail-title">
                        Detail Pengajuan Artist
                    </h3>
                    <p class="text-xs text-slate-muted truncate" id="modal-detail-subtitle">
                        Periksa kelayakan ToS dan sampel portofolio.
                    </p>
                </div>
                <button type="button" data-close-modal="detailModal" aria-label="Tutup dialog detail pengajuan"
                    class="cursor-pointer w-9 h-9 rounded-full bg-stone-100 hover:bg-stone-200 text-slate-dark flex items-center justify-center font-bold transition shrink-0">
                    <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                </button>
            </div>

            <div class="p-4 rounded-xl bg-bg-light border border-stone-100 space-y-2">
                <h4 class="font-heading font-bold text-xs text-slate-dark flex items-center gap-1.5">
                    <i class="fa-solid fa-building-columns text-amber-700" aria-hidden="true"></i> Rekening Pencairan Dana
                </h4>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs">
                    <div>
                        <span class="text-[10px] text-slate-muted uppercase font-bold block">Nama Bank</span>
                        <p class="font-bold text-slate-dark" id="modal-detail-bank">-</p>
                    </div>
                    <div>
                        <span class="text-[10px] text-slate-muted uppercase font-bold block">Nomor Rekening</span>
                        <p class="font-mono font-bold text-slate-dark break-all" id="modal-detail-acc-no">-</p>
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
                        <i class="fa-solid fa-check text-emerald-700" aria-hidden="true"></i> Bisa Digambar (Accept)
                    </h4>
                    <ul class="space-y-1 list-disc list-inside text-slate-body text-[11px]" id="modal-detail-bisa">
                    </ul>
                </div>

                <div class="p-4 rounded-xl bg-red-50/50 border border-red-100 space-y-2">
                    <h4 class="font-heading font-bold text-xs text-red-900 flex items-center gap-1.5">
                        <i class="fa-solid fa-ban text-red-700" aria-hidden="true"></i> Tidak Menerima (Decline)
                    </h4>
                    <ul class="space-y-1 list-disc list-inside text-slate-body text-[11px]" id="modal-detail-tidak">
                    </ul>
                </div>
            </div>

            <div class="space-y-2">
                <h4 class="font-heading font-bold text-xs text-slate-dark flex items-center gap-1.5">
                    <i class="fa-solid fa-palette text-amber-700" aria-hidden="true"></i> Tautan Sampel Portofolio
                </h4>
                <div class="space-y-1.5" id="modal-detail-links">
                </div>
            </div>

            <div id="modal-detail-past-box" class="hidden p-4 rounded-xl bg-stone-50 border border-stone-200 text-xs space-y-2">
                <h4 class="font-heading font-bold text-xs text-slate-dark flex items-center gap-1.5">
                    <i class="fa-solid fa-clock-rotate-left text-red-700" aria-hidden="true"></i> Riwayat Penolakan Sebelumnya
                </h4>
                <div class="space-y-2 text-[11px]" id="modal-detail-past-list">
                </div>
            </div>

            <div class="flex justify-end pt-3 border-t border-stone-100">
                <button type="button" data-close-modal="detailModal"
                    class="min-h-11 sm:min-h-0 px-4 py-2 cursor-pointer rounded-xl bg-stone-100 hover:bg-stone-200 text-slate-dark text-xs font-bold font-heading transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <div id="approveModal" role="dialog" aria-modal="true" aria-labelledby="approve-modal-title"
        class="fixed inset-0 z-50 hidden flex items-center justify-center bg-slate-dark/60 backdrop-blur-xs p-4">
        <div class="bg-white rounded-2xl border border-stone-200 shadow-2xl w-full max-w-md p-6 space-y-4">
            <div class="flex items-center justify-between gap-3">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-800 flex items-center justify-center text-lg shrink-0">
                        <i class="fa-solid fa-check" aria-hidden="true"></i>
                    </div>
                    <div class="min-w-0">
                        <h3 id="approve-modal-title" class="font-heading font-bold text-base text-slate-dark">Terima Pengajuan Artist?</h3>
                        <p class="text-xs text-slate-muted truncate" id="approve-applicant-name">Pemohon</p>
                    </div>
                </div>
                <button type="button" data-close-modal="approveModal" aria-label="Tutup dialog persetujuan artist"
                    class="cursor-pointer w-9 h-9 rounded-full bg-stone-100 hover:bg-stone-200 text-slate-dark flex items-center justify-center font-bold transition shrink-0">
                    <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                </button>
            </div>

            <p class="text-xs text-slate-body leading-relaxed">
                Dengan menyetujui, akun pengguna ini akan diubah rolenya menjadi <strong>Artist</strong>. Pengguna akan dapat membuat katalog komisi dan menerima pesanan.
            </p>

            <form id="approveForm" action="" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="action" value="approve">

                <div>
                    <label for="approve-notes-input" class="block text-xs font-semibold text-slate-dark mb-1">
                        Catatan Admin untuk Artist (Opsional)
                    </label>
                    <textarea id="approve-notes-input" name="admin_notes" rows="2" maxlength="1000"
                        placeholder="Selamat bergabung sebagai artist Artsy ID!"
                        class="w-full text-xs p-3 rounded-xl bg-bg-light border border-stone-200 focus:outline-none focus:border-emerald-600 focus:bg-white text-slate-dark placeholder:text-slate-muted"></textarea>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2 border-t border-stone-100">
                    <button type="button" data-close-modal="approveModal"
                        class="min-h-11 sm:min-h-0 px-4 py-2 cursor-pointer rounded-xl bg-stone-100 hover:bg-stone-200 text-slate-dark text-xs font-bold font-heading transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="min-h-11 sm:min-h-0 px-4 py-2 cursor-pointer rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold font-heading shadow-xs transition">
                        Konfirmasi Terima
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="rejectModal" role="dialog" aria-modal="true" aria-labelledby="reject-modal-title"
        class="fixed inset-0 z-50 hidden flex items-center justify-center bg-slate-dark/60 backdrop-blur-xs p-4">
        <div class="bg-white rounded-2xl border border-stone-200 shadow-2xl w-full max-w-md p-6 space-y-4">
            <div class="flex items-center justify-between gap-3">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-10 h-10 rounded-full bg-red-100 text-red-800 flex items-center justify-center text-lg shrink-0">
                        <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                    </div>
                    <div class="min-w-0">
                        <h3 id="reject-modal-title" class="font-heading font-bold text-base text-slate-dark">Tolak Pengajuan Artist?</h3>
                        <p class="text-xs text-slate-muted truncate" id="reject-applicant-name">Pemohon</p>
                    </div>
                </div>
                <button type="button" data-close-modal="rejectModal" aria-label="Tutup dialog penolakan artist"
                    class="cursor-pointer w-9 h-9 rounded-full bg-stone-100 hover:bg-stone-200 text-slate-dark flex items-center justify-center font-bold transition shrink-0">
                    <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                </button>
            </div>

            <p class="text-xs text-slate-body leading-relaxed">
                Tuliskan alasan penolakan dengan jelas (minimal 5 karakter) agar pemohon dapat memperbaiki data atau portofolio mereka.
            </p>

            <form id="rejectForm" action="" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="action" value="reject">

                <div>
                    <label for="reject-notes-input" class="block text-xs font-semibold text-slate-dark mb-1">
                        Alasan Penolakan <span class="text-red-700">*</span>
                    </label>
                    <textarea id="reject-notes-input" name="admin_notes" rows="3" required minlength="5" maxlength="1000"
                        placeholder="Contoh: Link portofolio tidak dapat diakses atau belum memenuhi standar keaslian karya..."
                        class="w-full text-xs p-3 rounded-xl bg-bg-light border border-stone-200 focus:outline-none focus:border-red-500 focus:bg-white text-slate-dark placeholder:text-slate-muted"></textarea>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2 border-t border-stone-100">
                    <button type="button" data-close-modal="rejectModal"
                        class="min-h-11 sm:min-h-0 px-4 py-2 cursor-pointer rounded-xl bg-stone-100 hover:bg-stone-200 text-slate-dark text-xs font-bold font-heading transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="min-h-11 sm:min-h-0 px-4 py-2 cursor-pointer rounded-xl bg-red-700 hover:bg-red-800 text-white text-xs font-bold font-heading shadow-xs transition">
                        Tolak Pengajuan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        (function () {
            let activeModalId = null;
            let lastTriggerEl = null;

            function openModal(id, triggerEl) {
                if (activeModalId && activeModalId !== id) {
                    closeModal(activeModalId, false);
                }
                const modal = document.getElementById(id);
                if (!modal) return;
                activeModalId = id;
                lastTriggerEl = triggerEl || document.activeElement;
                modal.classList.remove('hidden');

                const firstFocusable = modal.querySelector('input:not([type="hidden"]):not(:disabled), textarea, select:not(:disabled), button');
                if (firstFocusable) {
                    firstFocusable.focus();
                }
            }

            function closeModal(id, restoreFocus = true) {
                const modal = document.getElementById(id);
                if (!modal) return;
                modal.classList.add('hidden');
                if (activeModalId === id) {
                    activeModalId = null;
                }
                if (restoreFocus && lastTriggerEl && typeof lastTriggerEl.focus === 'function') {
                    lastTriggerEl.focus();
                    lastTriggerEl = null;
                }
            }

            function isSafeExternalUrl(url) {
                return typeof url === 'string' && /^https?:\/\//i.test(url.trim());
            }

            function renderTosList(container, items) {
                container.replaceChildren();
                if (Array.isArray(items) && items.length > 0) {
                    items.forEach(function (item) {
                        const li = document.createElement('li');
                        li.textContent = String(item);
                        container.appendChild(li);
                    });
                } else {
                    const emptyLi = document.createElement('li');
                    emptyLi.className = 'text-slate-muted italic';
                    emptyLi.textContent = 'Tidak ada ketentuan tercantum';
                    container.appendChild(emptyLi);
                }
            }

            function buildSafeLinkRow(urlText, safeHref, compact) {
                if (isSafeExternalUrl(safeHref)) {
                    const a = document.createElement('a');
                    a.href = safeHref;
                    a.target = '_blank';
                    a.rel = 'noopener noreferrer';
                    a.className = compact
                        ? 'hover:underline truncate text-amber-900 font-medium flex items-center gap-1'
                        : 'p-2 rounded-lg bg-bg-light border border-stone-200 text-amber-900 hover:text-slate-dark font-medium hover:underline flex items-center justify-between text-xs transition';

                    const left = document.createElement('span');
                    left.className = compact ? 'truncate flex items-center gap-1' : 'truncate mr-2 flex items-center gap-1.5';
                    const icon = document.createElement('i');
                    icon.className = compact ? 'fa-solid fa-arrow-up-right-from-square text-[9px] shrink-0' : 'fa-solid fa-link text-[10px] text-slate-400 shrink-0';
                    icon.setAttribute('aria-hidden', 'true');
                    const urlSpan = document.createElement('span');
                    urlSpan.className = 'truncate';
                    urlSpan.textContent = urlText;
                    left.appendChild(icon);
                    left.appendChild(urlSpan);
                    a.appendChild(left);

                    if (!compact) {
                        const badge = document.createElement('span');
                        badge.className = 'px-2 py-0.5 rounded bg-amber-100 text-amber-900 text-[10px] font-bold shrink-0';
                        badge.textContent = 'Buka Link';
                        a.appendChild(badge);
                    }

                    return a;
                }

                const span = document.createElement('span');
                span.className = 'p-2 rounded-lg bg-stone-100 border border-stone-200 text-slate-muted italic block text-xs truncate';
                span.textContent = urlText + ' (tautan tidak valid)';
                return span;
            }

            function openDetailModal(data, triggerEl) {
                document.getElementById('modal-detail-title').textContent = 'Detail Pengajuan: ' + (data.name || '-');
                document.getElementById('modal-detail-subtitle').textContent = 'Email: ' + (data.email || '-');
                document.getElementById('modal-detail-bank').textContent = data.bank_name || '-';
                document.getElementById('modal-detail-acc-no').textContent = data.account_number || '-';
                document.getElementById('modal-detail-acc-holder').textContent = data.account_holder || '-';

                renderTosList(document.getElementById('modal-detail-bisa'), data.bisa_list);
                renderTosList(document.getElementById('modal-detail-tidak'), data.tidak_list);

                const linksContainer = document.getElementById('modal-detail-links');
                linksContainer.replaceChildren();
                if (Array.isArray(data.links) && data.links.length > 0) {
                    data.links.forEach(function (linkItem) {
                        const urlText = typeof linkItem === 'string' ? linkItem : (linkItem.url || '');
                        const safeHref = typeof linkItem === 'string' ? linkItem : (linkItem.href || '');
                        linksContainer.appendChild(buildSafeLinkRow(urlText, safeHref, false));
                    });
                } else {
                    const emptyP = document.createElement('p');
                    emptyP.className = 'text-xs text-slate-muted italic';
                    emptyP.textContent = 'Tidak ada tautan terlampir';
                    linksContainer.appendChild(emptyP);
                }

                const pastBox = document.getElementById('modal-detail-past-box');
                const pastList = document.getElementById('modal-detail-past-list');
                pastList.replaceChildren();
                if (Array.isArray(data.past_rejected) && data.past_rejected.length > 0) {
                    data.past_rejected.forEach(function (item) {
                        const card = document.createElement('div');
                        card.className = 'p-3 rounded-xl bg-white border border-stone-200 space-y-1.5 shadow-2xs';

                        const header = document.createElement('div');
                        header.className = 'flex items-center justify-between text-[11px] text-red-800 font-bold font-heading';
                        const headerSpan = document.createElement('span');
                        headerSpan.className = 'inline-flex items-center gap-1.5';
                        const warnIcon = document.createElement('i');
                        warnIcon.className = 'fa-solid fa-triangle-exclamation';
                        warnIcon.setAttribute('aria-hidden', 'true');
                        headerSpan.appendChild(warnIcon);
                        headerSpan.appendChild(document.createTextNode('Evaluasi pada ' + (item.date || '-')));
                        header.appendChild(headerSpan);
                        card.appendChild(header);

                        const noteP = document.createElement('p');
                        noteP.className = 'text-slate-dark text-xs leading-relaxed bg-red-50/50 p-2 rounded-lg border border-red-100/70 font-sans';
                        noteP.textContent = item.notes || 'Tanpa catatan';
                        card.appendChild(noteP);

                        const pastLinks = Array.isArray(item.safeLinks) ? item.safeLinks : [];
                        if (pastLinks.length > 0) {
                            const linkWrapper = document.createElement('div');
                            linkWrapper.className = 'pt-1.5 border-t border-stone-100 flex flex-col gap-1 text-[11px]';
                            const labelSpan = document.createElement('span');
                            labelSpan.className = 'text-[10px] uppercase font-bold text-slate-muted';
                            labelSpan.textContent = 'Tautan yang dilampirkan:';
                            linkWrapper.appendChild(labelSpan);

                            pastLinks.forEach(function (entry) {
                                linkWrapper.appendChild(buildSafeLinkRow(entry.url || '', entry.href || '', true));
                            });
                            card.appendChild(linkWrapper);
                        }

                        pastList.appendChild(card);
                    });
                    pastBox.classList.remove('hidden');
                } else {
                    pastBox.classList.add('hidden');
                }

                openModal('detailModal', triggerEl);
            }

            function openApproveModal(data, triggerEl) {
                document.getElementById('approveForm').action = data.verify_url || '';
                document.getElementById('approve-applicant-name').textContent = 'Pemohon: ' + (data.name || '-');
                document.getElementById('approve-notes-input').value = '';
                openModal('approveModal', triggerEl);
            }

            function openRejectModal(data, triggerEl) {
                document.getElementById('rejectForm').action = data.verify_url || '';
                document.getElementById('reject-applicant-name').textContent = 'Pemohon: ' + (data.name || '-');
                document.getElementById('reject-notes-input').value = '';
                openModal('rejectModal', triggerEl);
            }

            document.addEventListener('click', function (event) {
                const actionBtn = event.target.closest('[data-action]');
                if (actionBtn) {
                    const data = JSON.parse(actionBtn.dataset.payload);
                    const action = actionBtn.dataset.action;

                    if (action === 'detail') openDetailModal(data, actionBtn);
                    else if (action === 'approve') openApproveModal(data, actionBtn);
                    else if (action === 'reject') openRejectModal(data, actionBtn);
                    return;
                }

                const closeBtn = event.target.closest('[data-close-modal]');
                if (closeBtn) {
                    closeModal(closeBtn.dataset.closeModal);
                    return;
                }

                if (activeModalId && event.target.id === activeModalId) {
                    closeModal(activeModalId);
                }
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape' && activeModalId) {
                    closeModal(activeModalId);
                }
            });
        })();
    </script>
@endsection
