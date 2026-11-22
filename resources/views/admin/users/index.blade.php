@extends('layouts.app', ['title' => 'Kelola Pengguna - Admin Artsy ID'])

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
                    <div role="status"
                        class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm font-semibold flex items-center justify-between gap-3 shadow-2xs">
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-circle-check text-emerald-700 text-base shrink-0" aria-hidden="true"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                        <button type="button" onclick="this.parentElement.remove()" aria-label="Tutup notifikasi"
                            class="cursor-pointer min-w-11 min-h-11 sm:min-w-8 sm:min-h-8 rounded-lg text-emerald-800 hover:bg-emerald-100 font-bold flex items-center justify-center transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-dark">
                            <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                        </button>
                    </div>
                @endif

                @if ($errors->any())
                    <div role="alert"
                        class="p-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 text-xs sm:text-sm font-semibold flex items-center justify-between gap-3 shadow-2xs">
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-triangle-exclamation text-red-700 text-base shrink-0" aria-hidden="true"></i>
                            <span>{{ $errors->first() }}</span>
                        </div>
                        <button type="button" onclick="this.parentElement.remove()" aria-label="Tutup peringatan"
                            class="cursor-pointer min-w-11 min-h-11 sm:min-w-8 sm:min-h-8 rounded-lg text-red-800 hover:bg-red-100 font-bold flex items-center justify-center transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-dark">
                            <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                        </button>
                    </div>
                @endif

                <div class="bg-white rounded-2xl border border-stone-200/90 shadow-2xs p-5 sm:p-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-xl sm:text-2xl font-black font-heading text-slate-dark mt-1.5">
                            Kelola Pengguna
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-muted mt-0.5">
                            Kelola akun client, artist, dan administrator, tinjau riwayat laporan, serta kontrol pemblokiran akun bermasalah.
                        </p>
                    </div>
                    <div class="flex items-center gap-2 shrink-0">
                        <a href="{{ route('admin.users.index') }}"
                            class="cursor-pointer min-h-11 sm:min-h-0 px-4 py-2 rounded-xl bg-stone-100 hover:bg-stone-200 text-slate-dark font-bold text-xs font-heading transition flex items-center justify-center gap-2 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-dark">
                            <i class="fa-solid fa-rotate text-xs" aria-hidden="true"></i>
                            <span>Segarkan</span>
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                    <div class="bg-white p-4 sm:p-5 rounded-2xl border border-stone-200/90 shadow-2xs flex items-center justify-between gap-2">
                        <div>
                            <span class="text-[11px] sm:text-xs text-slate-muted font-medium block">Total Pengguna</span>
                            <span class="text-xl sm:text-2xl font-black font-heading text-slate-dark mt-1 block">
                                {{ $stats['total'] }}
                            </span>
                        </div>
                        <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-stone-100 text-slate-dark flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-users text-sm sm:text-base" aria-hidden="true"></i>
                        </div>
                    </div>

                    <div class="bg-white p-4 sm:p-5 rounded-2xl border border-stone-200/90 shadow-2xs flex items-center justify-between gap-2">
                        <div>
                            <span class="text-[11px] sm:text-xs text-slate-muted font-medium block">Client / User</span>
                            <span class="text-xl sm:text-2xl font-black font-heading text-sky-800 mt-1 block">
                                {{ $stats['clients'] }}
                            </span>
                        </div>
                        <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-sky-50 text-sky-800 border border-sky-200 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-user text-sm sm:text-base" aria-hidden="true"></i>
                        </div>
                    </div>

                    <div class="bg-white p-4 sm:p-5 rounded-2xl border border-stone-200/90 shadow-2xs flex items-center justify-between gap-2">
                        <div>
                            <span class="text-[11px] sm:text-xs text-slate-muted font-medium block">Artist Terdaftar</span>
                            <span class="text-xl sm:text-2xl font-black font-heading text-amber-900 mt-1 block">
                                {{ $stats['artists'] }}
                            </span>
                        </div>
                        <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-pastel-100 text-amber-900 border border-pastel-300 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-palette text-sm sm:text-base" aria-hidden="true"></i>
                        </div>
                    </div>

                    <div class="bg-white p-4 sm:p-5 rounded-2xl border border-stone-200/90 shadow-2xs flex items-center justify-between gap-2">
                        <div>
                            <span class="text-[11px] sm:text-xs text-slate-muted font-medium block">Akun Diblokir</span>
                            <span class="text-xl sm:text-2xl font-black font-heading {{ $stats['blocked'] > 0 ? 'text-red-800' : 'text-slate-dark' }} mt-1 block">
                                {{ $stats['blocked'] }}
                            </span>
                        </div>
                        <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-red-50 text-red-800 border border-red-200 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-user-slash text-sm sm:text-base" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-stone-200/90 shadow-2xs p-4 space-y-4">
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-3">
                        <div class="flex items-center gap-1.5 overflow-x-auto pb-1 lg:pb-0">
                            <a href="{{ route('admin.users.index', ['role' => 'all', 'status' => $status, 'search' => $search]) }}"
                                class="min-h-10 px-3.5 py-2 rounded-xl text-xs font-heading font-bold transition whitespace-nowrap flex items-center {{ $role === 'all' ? 'bg-pastel-200 text-slate-dark border border-pastel-300 shadow-xs' : 'text-slate-muted hover:text-slate-dark hover:bg-stone-50' }}">
                                Semua Role ({{ $stats['total'] }})
                            </a>
                            <a href="{{ route('admin.users.index', ['role' => 'user', 'status' => $status === 'reported' ? 'all' : $status, 'search' => $search]) }}"
                                class="min-h-10 px-3.5 py-2 rounded-xl text-xs font-heading font-bold transition whitespace-nowrap flex items-center {{ $role === 'user' ? 'bg-pastel-200 text-slate-dark border border-pastel-300 shadow-xs' : 'text-slate-muted hover:text-slate-dark hover:bg-stone-50' }}">
                                Client ({{ $stats['clients'] }})
                            </a>
                            <a href="{{ route('admin.users.index', ['role' => 'artist', 'status' => $status, 'search' => $search]) }}"
                                class="min-h-10 px-3.5 py-2 rounded-xl text-xs font-heading font-bold transition whitespace-nowrap flex items-center {{ $role === 'artist' ? 'bg-pastel-200 text-slate-dark border border-pastel-300 shadow-xs' : 'text-slate-muted hover:text-slate-dark hover:bg-stone-50' }}">
                                Artist ({{ $stats['artists'] }})
                            </a>
                            <a href="{{ route('admin.users.index', ['role' => 'admin', 'status' => $status === 'reported' ? 'all' : $status, 'search' => $search]) }}"
                                class="min-h-10 px-3.5 py-2 rounded-xl text-xs font-heading font-bold transition whitespace-nowrap flex items-center {{ $role === 'admin' ? 'bg-pastel-200 text-slate-dark border border-pastel-300 shadow-xs' : 'text-slate-muted hover:text-slate-dark hover:bg-stone-50' }}">
                                Admin ({{ $stats['admins'] }})
                            </a>
                        </div>

                        <form action="{{ route('admin.users.index') }}" method="GET" class="flex items-center gap-2">
                            <input type="hidden" name="role" value="{{ $role }}">
                            <input type="hidden" name="status" value="{{ $status }}">
                            <label for="user-search" class="sr-only">Cari pengguna berdasarkan nama atau email</label>
                            <div class="relative flex-1 lg:w-64">
                                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-xs text-slate-muted" aria-hidden="true"></i>
                                <input type="text" id="user-search" name="search" value="{{ $search }}" placeholder="Cari nama atau email..."
                                    class="w-full min-h-11 sm:min-h-0 pl-9 pr-3.5 py-2 rounded-xl text-xs bg-bg-light border border-stone-200 focus:outline-none focus:border-amber-500 focus:bg-white transition text-slate-dark placeholder:text-slate-muted">
                            </div>
                            <button type="submit"
                                class="cursor-pointer min-h-11 sm:min-h-0 px-4 py-2 rounded-xl bg-pastel-200 hover:bg-pastel-300 border border-pastel-300 text-slate-dark font-bold text-xs font-heading transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-dark">
                                Cari
                            </button>
                            @if ($search !== '')
                                <a href="{{ route('admin.users.index', ['role' => $role, 'status' => $status]) }}"
                                    aria-label="Reset pencarian"
                                    title="Reset pencarian"
                                    class="min-h-11 min-w-11 sm:min-h-0 sm:min-w-0 px-3 py-2 rounded-xl bg-stone-100 hover:bg-stone-200 text-slate-dark text-xs font-bold font-heading flex items-center justify-center transition">
                                    <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                                </a>
                            @endif
                        </form>
                    </div>

                    <div class="pt-3 border-t border-stone-100 flex flex-wrap items-center gap-2 text-xs">
                        <span class="text-[11px] font-bold font-heading text-slate-muted uppercase tracking-wider mr-1">Filter Status:</span>
                        <a href="{{ route('admin.users.index', ['role' => $role, 'status' => 'all', 'search' => $search]) }}"
                            class="px-3 py-1.5 rounded-lg font-heading font-semibold transition {{ $status === 'all' ? 'bg-amber-100 text-amber-900 border border-amber-300' : 'bg-stone-100 text-slate-body hover:bg-stone-200' }}">
                            Semua Status ({{ $statusCounts['all'] }})
                        </a>
                        <a href="{{ route('admin.users.index', ['role' => $role, 'status' => 'active', 'search' => $search]) }}"
                            class="px-3 py-1.5 rounded-lg font-heading font-semibold transition {{ $status === 'active' ? 'bg-amber-100 text-amber-900 border border-amber-300' : 'bg-stone-100 text-slate-body hover:bg-stone-200' }}">
                            Aktif ({{ $statusCounts['active'] }})
                        </a>
                        <a href="{{ route('admin.users.index', ['role' => $role, 'status' => 'blocked', 'search' => $search]) }}"
                            class="px-3 py-1.5 rounded-lg font-heading font-semibold transition {{ $status === 'blocked' ? 'bg-amber-100 text-amber-900 border border-amber-300' : 'bg-stone-100 text-slate-body hover:bg-stone-200' }}">
                            Diblokir ({{ $statusCounts['blocked'] }})
                        </a>
                        @if ($role === 'all' || $role === 'artist')
                            <a href="{{ route('admin.users.index', ['role' => $role, 'status' => 'reported', 'search' => $search]) }}"
                                class="px-3 py-1.5 rounded-lg font-heading font-semibold transition {{ $status === 'reported' ? 'bg-amber-100 text-amber-900 border border-amber-300' : 'bg-stone-100 text-slate-body hover:bg-stone-200' }}">
                                <span>Ada Laporan ({{ $statusCounts['reported'] }})</span>
                            </a>
                        @endif
                    </div>
                </div>

                @if ($users->isEmpty())
                    <div class="bg-white rounded-2xl border border-stone-200/90 shadow-2xs p-12 text-center space-y-3">
                        <div class="w-14 h-14 rounded-full bg-pastel-100 text-amber-900 flex items-center justify-center mx-auto text-2xl">
                            <i class="fa-solid fa-users-slash" aria-hidden="true"></i>
                        </div>
                        <h3 class="font-heading font-bold text-base text-slate-dark">Tidak Ada Pengguna Ditemukan</h3>
                        <p class="text-xs text-slate-muted max-w-md mx-auto leading-relaxed">
                            @if ($search !== '')
                                Tidak ada pengguna yang cocok dengan pencarian "{{ $search }}".
                            @elseif ($role !== 'all' || $status !== 'all')
                                Belum ada pengguna yang memenuhi kombinasi filter role dan status yang Anda pilih.
                            @else
                                Belum ada pengguna terdaftar di dalam sistem saat ini.
                            @endif
                        </p>
                        @if ($search !== '' || $role !== 'all' || $status !== 'all')
                            <a href="{{ route('admin.users.index') }}"
                                class="inline-flex items-center justify-center min-h-11 sm:min-h-0 mt-2 px-4 py-2 rounded-xl bg-pastel-200 hover:bg-pastel-300 border border-pastel-300 text-slate-dark text-xs font-bold font-heading transition">
                                Tampilkan Semua Pengguna
                            </a>
                        @endif
                    </div>
                @else
                    <div class="hidden lg:block bg-white rounded-2xl border border-stone-200/90 shadow-2xs overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b border-stone-200 bg-bg-light text-[11px] font-bold font-heading uppercase tracking-wider text-slate-muted">
                                        <th scope="col" class="py-3.5 px-5">Pengguna</th>
                                        <th scope="col" class="py-3.5 px-4">Role</th>
                                        <th scope="col" class="py-3.5 px-4">Aktivitas</th>
                                        <th scope="col" class="py-3.5 px-4">Status Akun</th>
                                        <th scope="col" class="py-3.5 px-4">Terdaftar</th>
                                        <th scope="col" class="py-3.5 px-5 text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-stone-100 text-xs">
                                    @foreach ($users as $listedUser)
                                        @php
                                            $payload = $service->buildUserModalPayload($listedUser);
                                            $payloadJson = json_encode($payload, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
                                            $isSelf = $listedUser->id === auth()->id();
                                            $isAdminTarget = $listedUser->role === 'admin';
                                            $canEditRole = !$isSelf && $listedUser->role !== 'artist' && !$listedUser->is_blocked;
                                        @endphp
                                        <tr class="hover:bg-pastel-50/40 transition">
                                            <td class="py-4 px-5">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-10 h-10 rounded-full bg-pastel-200 border border-pastel-300 text-slate-dark font-black text-xs flex items-center justify-center font-heading shrink-0">
                                                        {{ strtoupper(substr($listedUser->name, 0, 2)) }}
                                                    </div>
                                                    <div class="min-w-0">
                                                        <div class="flex items-center gap-1.5 flex-wrap">
                                                            <span class="font-heading font-bold text-sm text-slate-dark">
                                                                {{ $listedUser->name }}
                                                            </span>
                                                            @if ($isSelf)
                                                                <span class="px-2 py-0.5 rounded-md bg-pastel-100 border border-pastel-300 text-amber-900 text-[10px] font-bold font-heading">
                                                                    Anda
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <span class="text-slate-muted block mt-0.5">{{ $listedUser->email }}</span>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="py-4 px-4 whitespace-nowrap">
                                                @if ($listedUser->role === 'artist')
                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-pastel-100 text-amber-900 border border-pastel-300 text-[11px] font-bold font-heading">
                                                        <i class="fa-solid fa-palette text-[10px]" aria-hidden="true"></i>
                                                        <span>Artist</span>
                                                    </span>
                                                @elseif ($listedUser->role === 'admin')
                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-pastel-100 text-amber-900 border border-pastel-300 text-[11px] font-bold font-heading">
                                                        <i class="fa-solid fa-shield-halved text-[10px]" aria-hidden="true"></i>
                                                        <span>Admin</span>
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-pastel-100 text-amber-900 border border-pastel-300 text-[11px] font-bold font-heading">
                                                        <i class="fa-solid fa-user text-[10px]" aria-hidden="true"></i>
                                                        <span>Client</span>
                                                    </span>
                                                @endif
                                            </td>

                                            <td class="py-4 px-4">
                                                <div class="space-y-1">
                                                    <p class="text-slate-body">
                                                        @if ($listedUser->role === 'artist')
                                                            {{ $payload['orders_as_artist_count'] }} orderan, {{ $payload['commission_menus_count'] }} menu
                                                        @elseif ($listedUser->role === 'user')
                                                            {{ $payload['orders_as_client_count'] }} pesanan dibuat, {{ $payload['reviews_given_count'] }} ulasan
                                                        @else
                                                            {{ $payload['payouts_processed_count'] }} payout, {{ $payload['reports_handled_count'] }} laporan
                                                        @endif
                                                    </p>
                                                    @if ($payload['is_high_risk'])
                                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-red-50 text-red-800 border border-red-200 text-[10px] font-bold font-heading">
                                                            <i class="fa-solid fa-triangle-exclamation text-[9px]" aria-hidden="true"></i>
                                                            <span>Rawan ({{ $payload['unique_reporters_count'] }} pelapor)</span>
                                                        </span>
                                                    @elseif ($payload['reports_against_count'] > 0)
                                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-amber-100 text-amber-900 border border-amber-200 text-[10px] font-bold font-heading">
                                                            <i class="fa-solid fa-flag text-[9px]" aria-hidden="true"></i>
                                                            <span>{{ $payload['reports_against_count'] }} laporan</span>
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>

                                            <td class="py-4 px-4">
                                                @if ($listedUser->is_blocked)
                                                    <div class="space-y-1">
                                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-red-50 text-red-800 border border-red-200 text-[11px] font-bold font-heading">
                                                            <i class="fa-solid fa-ban text-[10px]" aria-hidden="true"></i>
                                                            <span>Diblokir</span>
                                                        </span>
                                                        @if ($listedUser->blocked_at)
                                                            <span class="block text-[10px] text-slate-muted">
                                                                {{ $listedUser->blocked_at->timezone('Asia/Jakarta')->translatedFormat('d M Y') }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                @else
                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200 text-[11px] font-bold font-heading">
                                                        <i class="fa-solid fa-circle-check text-[10px]" aria-hidden="true"></i>
                                                        <span>Aktif</span>
                                                    </span>
                                                @endif
                                            </td>

                                            <td class="py-4 px-4 whitespace-nowrap text-slate-muted">
                                                {{ $listedUser->created_at ? $listedUser->created_at->timezone('Asia/Jakarta')->translatedFormat('d M Y') : '-' }}
                                            </td>

                                            <td class="py-4 px-5 text-right whitespace-nowrap">
                                                <div class="inline-flex items-center justify-end gap-1.5">
                                                    <button type="button" data-action="detail" data-user="{{ $payloadJson }}"
                                                        class="cursor-pointer px-3 py-1.5 rounded-xl bg-pastel-100 hover:bg-pastel-200 text-slate-dark border border-pastel-300 font-bold text-xs font-heading transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-dark">
                                                        Detail
                                                    </button>
                                                    @if ($canEditRole)
                                                        <button type="button" data-action="edit" data-user="{{ $payloadJson }}"
                                                            class="cursor-pointer px-3 py-1.5 rounded-xl bg-white hover:bg-stone-100 text-slate-dark border border-stone-200 font-bold text-xs font-heading transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-dark">
                                                            Ubah Role
                                                        </button>
                                                    @endif
                                                    @if (!$isSelf && !$isAdminTarget)
                                                        @if ($listedUser->is_blocked)
                                                            <button type="button" data-action="unblock" data-user="{{ $payloadJson }}"
                                                                class="cursor-pointer px-3 py-1.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-200 font-bold text-xs font-heading transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-dark">
                                                                Buka Blokir
                                                            </button>
                                                        @else
                                                            <button type="button" data-action="block" data-user="{{ $payloadJson }}"
                                                                class="cursor-pointer px-3 py-1.5 rounded-xl bg-red-50 hover:bg-red-100 text-red-800 border border-red-200 font-bold text-xs font-heading transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-dark">
                                                                Blokir
                                                            </button>
                                                        @endif
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="lg:hidden grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach ($users as $listedUser)
                            @php
                                $payload = $service->buildUserModalPayload($listedUser);
                                $payloadJson = json_encode($payload, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
                                $isSelf = $listedUser->id === auth()->id();
                                $isAdminTarget = $listedUser->role === 'admin';
                                $canEditRole = !$isSelf && $listedUser->role !== 'artist' && !$listedUser->is_blocked;
                            @endphp
                            <div class="bg-white rounded-2xl border border-stone-200/90 shadow-2xs p-4 space-y-4">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <div class="w-10 h-10 rounded-full bg-pastel-200 border border-pastel-300 text-slate-dark font-black text-xs flex items-center justify-center font-heading shrink-0">
                                            {{ strtoupper(substr($listedUser->name, 0, 2)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <div class="flex items-center gap-1.5 flex-wrap">
                                                <h3 class="font-heading font-bold text-sm text-slate-dark truncate">
                                                    {{ $listedUser->name }}
                                                </h3>
                                                @if ($isSelf)
                                                    <span class="px-2 py-0.5 rounded-md bg-pastel-100 border border-pastel-300 text-amber-900 text-[10px] font-bold font-heading">
                                                        Anda
                                                    </span>
                                                @endif
                                            </div>
                                            <p class="text-xs text-slate-muted truncate">{{ $listedUser->email }}</p>
                                        </div>
                                    </div>

                                    @if ($listedUser->is_blocked)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-red-50 text-red-800 border border-red-200 text-[10px] font-bold font-heading shrink-0">
                                            <i class="fa-solid fa-ban text-[9px]" aria-hidden="true"></i>
                                            <span>Diblokir</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200 text-[10px] font-bold font-heading shrink-0">
                                            <i class="fa-solid fa-circle-check text-[9px]" aria-hidden="true"></i>
                                            <span>Aktif</span>
                                        </span>
                                    @endif
                                </div>

                                <div class="flex flex-wrap items-center gap-2 text-xs">
                                    @if ($listedUser->role === 'artist')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-pastel-100 text-amber-900 border border-pastel-300 text-[11px] font-bold font-heading">
                                            <i class="fa-solid fa-palette text-[10px]" aria-hidden="true"></i>
                                            <span>Artist</span>
                                        </span>
                                    @elseif ($listedUser->role === 'admin')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-pastel-100 text-amber-900 border border-pastel-300 text-[11px] font-bold font-heading">
                                            <i class="fa-solid fa-shield-halved text-[10px]" aria-hidden="true"></i>
                                            <span>Admin</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-pastel-100 text-amber-900 border border-pastel-300 text-[11px] font-bold font-heading">
                                            <i class="fa-solid fa-user text-[10px]" aria-hidden="true"></i>
                                            <span>Client</span>
                                        </span>
                                    @endif

                                    @if ($payload['is_high_risk'])
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-red-50 text-red-800 border border-red-200 text-[11px] font-bold font-heading">
                                            <i class="fa-solid fa-triangle-exclamation text-[10px]" aria-hidden="true"></i>
                                            <span>Rawan ({{ $payload['unique_reporters_count'] }} pelapor)</span>
                                        </span>
                                    @elseif ($payload['reports_against_count'] > 0)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-amber-100 text-amber-900 border border-amber-200 text-[11px] font-bold font-heading">
                                            <i class="fa-solid fa-flag text-[10px]" aria-hidden="true"></i>
                                            <span>{{ $payload['reports_against_count'] }} laporan</span>
                                        </span>
                                    @endif
                                </div>

                                <div class="p-3 rounded-xl bg-bg-light border border-stone-100 text-xs text-slate-body flex items-center justify-between gap-2">
                                    <span>
                                        @if ($listedUser->role === 'artist')
                                            {{ $payload['orders_as_artist_count'] }} orderan, {{ $payload['commission_menus_count'] }} menu
                                        @elseif ($listedUser->role === 'user')
                                            {{ $payload['orders_as_client_count'] }} pesanan dibuat, {{ $payload['reviews_given_count'] }} ulasan
                                        @else
                                            {{ $payload['payouts_processed_count'] }} payout, {{ $payload['reports_handled_count'] }} laporan
                                        @endif
                                    </span>
                                    <span class="text-slate-muted">
                                        {{ $listedUser->created_at ? $listedUser->created_at->timezone('Asia/Jakarta')->translatedFormat('d M Y') : '-' }}
                                    </span>
                                </div>

                                <div class="flex flex-wrap items-center gap-2 pt-2 border-t border-stone-100">
                                    <button type="button" data-action="detail" data-user="{{ $payloadJson }}"
                                        class="cursor-pointer flex-1 min-h-11 px-3 py-2 rounded-xl bg-pastel-100 hover:bg-pastel-200 text-slate-dark border border-pastel-300 font-bold text-xs font-heading transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-dark">
                                        Detail
                                    </button>
                                    @if ($canEditRole)
                                        <button type="button" data-action="edit" data-user="{{ $payloadJson }}"
                                            class="cursor-pointer flex-1 min-h-11 px-3 py-2 rounded-xl bg-white hover:bg-stone-100 text-slate-dark border border-stone-200 font-bold text-xs font-heading transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-dark">
                                            Ubah Role
                                        </button>
                                    @endif
                                    @if (!$isSelf && !$isAdminTarget)
                                        @if ($listedUser->is_blocked)
                                            <button type="button" data-action="unblock" data-user="{{ $payloadJson }}"
                                                class="cursor-pointer w-full min-h-11 px-3 py-2 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-200 font-bold text-xs font-heading transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-dark">
                                                Buka Blokir
                                            </button>
                                        @else
                                            <button type="button" data-action="block" data-user="{{ $payloadJson }}"
                                                class="cursor-pointer w-full min-h-11 px-3 py-2 rounded-xl bg-red-50 hover:bg-red-100 text-red-800 border border-red-200 font-bold text-xs font-heading transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-dark">
                                                Blokir Akun
                                            </button>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if ($users->hasPages())
                        <div class="pt-2">
                            {{ $users->links() }}
                        </div>
                    @endif
                @endif

            </main>
        </div>
    </div>

    <div id="userDetailModal" role="dialog" aria-modal="true" aria-labelledby="detail-modal-title"
        class="fixed inset-0 z-50 hidden flex items-center justify-center bg-slate-dark/60 backdrop-blur-xs p-4">
        <div class="bg-white rounded-2xl border border-stone-200 shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto p-6 space-y-5">
            <div class="flex items-center justify-between pb-3 border-b border-stone-200">
                <div>
                    <h3 id="detail-modal-title" class="text-base font-bold font-heading text-slate-dark">
                        Detail Pengguna
                    </h3>
                    <p id="detail-modal-subtitle" class="text-xs text-slate-muted">
                        Informasi lengkap akun pengguna
                    </p>
                </div>
                <button type="button" data-close-modal="userDetailModal" aria-label="Tutup dialog detail"
                    class="cursor-pointer w-9 h-9 rounded-full bg-stone-100 hover:bg-stone-200 text-slate-dark flex items-center justify-center font-bold transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-dark">
                    <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                </button>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs">
                <div class="p-3.5 rounded-xl bg-bg-light border border-stone-100">
                    <span class="text-[10px] uppercase font-bold text-slate-muted font-heading block">Role Akun</span>
                    <p id="detail-role" class="font-bold font-heading text-slate-dark mt-1 capitalize">-</p>
                </div>
                <div class="p-3.5 rounded-xl bg-bg-light border border-stone-100">
                    <span class="text-[10px] uppercase font-bold text-slate-muted font-heading block">Status Akun</span>
                    <p id="detail-status" class="font-bold font-heading mt-1">-</p>
                </div>
                <div class="p-3.5 rounded-xl bg-bg-light border border-stone-100">
                    <span class="text-[10px] uppercase font-bold text-slate-muted font-heading block">Tanggal Terdaftar</span>
                    <p id="detail-created-at" class="font-semibold text-slate-dark mt-1">-</p>
                </div>
            </div>

            <div id="detail-bio-box" class="hidden p-4 rounded-xl bg-bg-light border border-stone-100 text-xs space-y-1">
                <span class="text-[10px] uppercase font-bold text-slate-muted font-heading block">Bio Profil</span>
                <p id="detail-bio-text" class="text-slate-body leading-relaxed"></p>
            </div>

            <div id="detail-block-box" class="hidden p-4 rounded-xl bg-red-50 border border-red-200 text-xs space-y-1.5">
                <div class="flex items-center justify-between gap-2">
                    <span class="font-heading font-bold text-red-900">Status Pemblokiran Aktif</span>
                    <span id="detail-blocked-at" class="text-red-800 font-medium"></span>
                </div>
                <p id="detail-block-reason" class="text-red-900 leading-relaxed"></p>
            </div>

            <div id="detail-artist-app-box" class="hidden p-4 rounded-xl bg-pastel-50 border border-pastel-300 text-xs flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <span class="text-[10px] uppercase font-bold text-amber-900 font-heading block">Pengajuan Jadi Artist</span>
                    <p id="detail-artist-app-label" class="font-bold text-slate-dark mt-0.5">-</p>
                </div>
                <a id="detail-artist-app-link" href="#"
                    class="inline-flex items-center justify-center px-3.5 py-2 rounded-xl bg-pastel-200 hover:bg-pastel-300 border border-pastel-300 text-slate-dark font-bold text-xs font-heading transition shrink-0">
                    Tinjau di Verifikasi Artist
                </a>
            </div>

            <div class="space-y-2">
                <h4 id="detail-metrics-title" class="font-heading font-bold text-xs text-slate-dark">Aktivitas Pengguna</h4>
                <div id="detail-metrics-grid" class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs"></div>
            </div>

            <div id="detail-bank-box" class="hidden p-4 rounded-xl bg-bg-light border border-stone-100 space-y-2 text-xs">
                <h4 class="font-heading font-bold text-slate-dark">Profil Rekening Artist</h4>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                    <div>
                        <span class="text-[10px] text-slate-muted uppercase font-bold block">Bank</span>
                        <p id="detail-bank-name" class="font-bold text-slate-dark">-</p>
                    </div>
                    <div>
                        <span class="text-[10px] text-slate-muted uppercase font-bold block">Nomor Rekening</span>
                        <p id="detail-acc-number" class="font-mono font-bold text-slate-dark">-</p>
                    </div>
                    <div>
                        <span class="text-[10px] text-slate-muted uppercase font-bold block">Atas Nama</span>
                        <p id="detail-acc-holder" class="font-bold text-slate-dark">-</p>
                    </div>
                </div>
            </div>

            <div id="detail-reports-box" class="hidden p-4 rounded-xl bg-stone-50 border border-stone-200 space-y-2.5 text-xs">
                <div class="flex items-center justify-between gap-2 flex-wrap">
                    <h4 class="font-heading font-bold text-slate-dark">Riwayat Laporan Terbaru</h4>
                    <span id="detail-high-risk-badge" class="hidden px-2.5 py-0.5 rounded-full bg-red-50 text-red-800 border border-red-200 text-[10px] font-bold font-heading">
                        Lebih dari 3 pembeli berbeda melaporkan akun ini
                    </span>
                </div>
                <div id="detail-reports-list" class="space-y-2"></div>
            </div>

            <div class="flex flex-wrap items-center justify-between gap-2 pt-3 border-t border-stone-100">
                <div id="detail-action-buttons" class="flex flex-wrap items-center gap-2"></div>
                <button type="button" data-close-modal="userDetailModal"
                    class="cursor-pointer min-h-11 sm:min-h-0 px-4 py-2 rounded-xl bg-stone-100 hover:bg-stone-200 text-slate-dark text-xs font-bold font-heading transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-dark">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <div id="editUserModal" role="dialog" aria-modal="true" aria-labelledby="edit-modal-title"
        class="fixed inset-0 z-50 hidden flex items-center justify-center bg-slate-dark/60 backdrop-blur-xs p-4">
        <div class="bg-white rounded-2xl border border-stone-200 shadow-2xl w-full max-w-md p-6 space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-stone-200">
                <div>
                    <h3 id="edit-modal-title" class="font-heading font-bold text-base text-slate-dark">Ubah Role Pengguna</h3>
                    <p id="edit-modal-subtitle" class="text-xs text-slate-muted">Ubah role akun antara Client (user) dan Administrator (admin)</p>
                </div>
                <button type="button" data-close-modal="editUserModal" aria-label="Tutup dialog ubah role"
                    class="cursor-pointer w-9 h-9 rounded-full bg-stone-100 hover:bg-stone-200 text-slate-dark flex items-center justify-center font-bold transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-dark">
                    <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                </button>
            </div>

            <div class="p-3.5 rounded-xl bg-bg-light border border-stone-200 text-xs space-y-1">
                <div class="flex items-center justify-between gap-2">
                    <span id="edit-user-name" class="font-heading font-bold text-sm text-slate-dark">-</span>
                    <span id="edit-current-role" class="px-2 py-0.5 rounded-full bg-pastel-100 text-amber-900 border border-pastel-300 text-[10px] font-bold font-heading">-</span>
                </div>
                <p id="edit-user-email" class="text-slate-muted">-</p>
            </div>

            <form id="editUserForm" action="" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="edit-role" class="block text-xs font-semibold text-slate-dark mb-1">
                        Role Tujuan <span class="text-red-700">*</span>
                    </label>
                    <select id="edit-role" name="role"
                        class="cursor-pointer w-full text-xs p-3 rounded-xl bg-bg-light border border-stone-200 focus:outline-none focus:border-amber-500 focus:bg-white text-slate-dark">
                        <option value="user">Client (user)</option>
                        <option value="admin">Administrator (admin)</option>
                    </select>
                    <p class="text-[11px] text-slate-muted mt-1.5 leading-relaxed">
                        Hanya role antara Client (user) dan Administrator (admin) yang dapat diubah.
                    </p>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2 border-t border-stone-100">
                    <button type="button" data-close-modal="editUserModal"
                        class="cursor-pointer min-h-11 sm:min-h-0 px-4 py-2 rounded-xl bg-stone-100 hover:bg-stone-200 text-slate-dark text-xs font-bold font-heading transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="cursor-pointer min-h-11 sm:min-h-0 px-4 py-2 rounded-xl bg-pastel-200 hover:bg-pastel-300 border border-pastel-300 text-slate-dark text-xs font-bold font-heading shadow-xs transition">
                        Simpan Role Baru
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="blockUserModal" role="dialog" aria-modal="true" aria-labelledby="block-modal-title"
        class="fixed inset-0 z-50 hidden flex items-center justify-center bg-slate-dark/60 backdrop-blur-xs p-4">
        <div class="bg-white rounded-2xl border border-stone-200 shadow-2xl w-full max-w-md p-6 space-y-4">
            <div class="flex items-center justify-between gap-3 pb-3 border-b border-stone-200">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-red-50 border border-red-200 text-red-800 flex items-center justify-center text-base shrink-0">
                        <i class="fa-solid fa-ban" aria-hidden="true"></i>
                    </div>
                    <div>
                        <h3 id="block-modal-title" class="font-heading font-bold text-base text-slate-dark">Blokir Akun Pengguna?</h3>
                        <p id="block-user-label" class="text-xs text-slate-muted">Nama Pengguna</p>
                    </div>
                </div>
                <button type="button" data-close-modal="blockUserModal" aria-label="Tutup dialog blokir"
                    class="cursor-pointer w-9 h-9 rounded-full bg-stone-100 hover:bg-stone-200 text-slate-dark flex items-center justify-center font-bold transition">
                    <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                </button>
            </div>

            <p class="text-xs text-slate-body leading-relaxed">
                Akun yang diblokir akan langsung dikeluarkan dari seluruh sesi aktif dan tidak dapat masuk ke Artsy ID sampai pemblokiran dicabut oleh administrator.
            </p>

            <form id="blockUserForm" action="" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="block-reason-input" class="block text-xs font-semibold text-slate-dark mb-1">
                        Alasan Pemblokiran <span class="text-red-700">*</span>
                    </label>
                    <textarea id="block-reason-input" name="block_reason" rows="3" required minlength="5" maxlength="1000"
                        placeholder="Tuliskan alasan pemblokiran yang jelas (minimal 5 karakter)..."
                        class="w-full text-xs p-3 rounded-xl bg-bg-light border border-stone-200 focus:outline-none focus:border-red-500 focus:bg-white text-slate-dark placeholder:text-slate-muted"></textarea>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2 border-t border-stone-100">
                    <button type="button" data-close-modal="blockUserModal"
                        class="cursor-pointer min-h-11 sm:min-h-0 px-4 py-2 rounded-xl bg-stone-100 hover:bg-stone-200 text-slate-dark text-xs font-bold font-heading transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="cursor-pointer min-h-11 sm:min-h-0 px-4 py-2 rounded-xl bg-red-700 hover:bg-red-800 text-white text-xs font-bold font-heading shadow-xs transition">
                        Konfirmasi Blokir
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="unblockUserModal" role="dialog" aria-modal="true" aria-labelledby="unblock-modal-title"
        class="fixed inset-0 z-50 hidden flex items-center justify-center bg-slate-dark/60 backdrop-blur-xs p-4">
        <div class="bg-white rounded-2xl border border-stone-200 shadow-2xl w-full max-w-md p-6 space-y-4">
            <div class="flex items-center justify-between gap-3 pb-3 border-b border-stone-200">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-center text-base shrink-0">
                        <i class="fa-solid fa-unlock" aria-hidden="true"></i>
                    </div>
                    <div>
                        <h3 id="unblock-modal-title" class="font-heading font-bold text-base text-slate-dark">Aktifkan Kembali Akun?</h3>
                        <p id="unblock-user-label" class="text-xs text-slate-muted">Nama Pengguna</p>
                    </div>
                </div>
                <button type="button" data-close-modal="unblockUserModal" aria-label="Tutup dialog buka blokir"
                    class="cursor-pointer w-9 h-9 rounded-full bg-stone-100 hover:bg-stone-200 text-slate-dark flex items-center justify-center font-bold transition">
                    <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                </button>
            </div>

            <div class="p-3.5 rounded-xl bg-bg-light border border-stone-200 text-xs space-y-1">
                <span class="text-[10px] uppercase font-bold text-slate-muted font-heading block">Catatan Blokir Sebelumnya</span>
                <p id="unblock-prev-reason" class="text-slate-dark leading-relaxed">-</p>
                <span id="unblock-prev-date" class="text-[11px] text-slate-muted block"></span>
            </div>

            <form id="unblockUserForm" action="" method="POST" class="space-y-4">
                @csrf

                <div class="flex items-center justify-end gap-2 pt-2 border-t border-stone-100">
                    <button type="button" data-close-modal="unblockUserModal"
                        class="cursor-pointer min-h-11 sm:min-h-0 px-4 py-2 rounded-xl bg-stone-100 hover:bg-stone-200 text-slate-dark text-xs font-bold font-heading transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="cursor-pointer min-h-11 sm:min-h-0 px-4 py-2 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold font-heading shadow-xs transition">
                        Aktifkan Kembali
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        (function () {
            const CURRENT_ADMIN_ID = {{ (int) auth()->id() }};
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

            function openDetailModal(data, triggerEl) {
                document.getElementById('detail-modal-title').textContent = 'Detail Pengguna: ' + data.name;
                document.getElementById('detail-modal-subtitle').textContent = data.email;

                const roleMap = { user: 'Client (user)', artist: 'Artist (artist)', admin: 'Administrator (admin)' };
                document.getElementById('detail-role').textContent = roleMap[data.role] || data.role;

                const statusEl = document.getElementById('detail-status');
                statusEl.textContent = data.is_blocked ? 'Diblokir' : 'Aktif';
                statusEl.className = 'font-bold font-heading mt-1 ' + (data.is_blocked ? 'text-red-800' : 'text-emerald-800');

                document.getElementById('detail-created-at').textContent = data.created_at_formatted || '-';

                const bioBox = document.getElementById('detail-bio-box');
                if (data.bio && String(data.bio).trim() !== '') {
                    document.getElementById('detail-bio-text').textContent = data.bio;
                    bioBox.classList.remove('hidden');
                } else {
                    bioBox.classList.add('hidden');
                }

                const blockBox = document.getElementById('detail-block-box');
                if (data.is_blocked) {
                    document.getElementById('detail-blocked-at').textContent = data.blocked_at_formatted || '';
                    document.getElementById('detail-block-reason').textContent = data.block_reason || 'Tanpa alasan tercatat.';
                    blockBox.classList.remove('hidden');
                } else {
                    blockBox.classList.add('hidden');
                }

                const appBox = document.getElementById('detail-artist-app-box');
                if (data.role === 'user' && data.artist_application) {
                    document.getElementById('detail-artist-app-label').textContent = data.artist_application.label;
                    document.getElementById('detail-artist-app-link').href = data.artist_application.url;
                    appBox.classList.remove('hidden');
                } else {
                    appBox.classList.add('hidden');
                }

                const metricsTitle = document.getElementById('detail-metrics-title');
                const metricsGrid = document.getElementById('detail-metrics-grid');
                const metrics = Array.isArray(data.role_metrics) ? data.role_metrics : [];
                metricsTitle.textContent = data.role_metrics_title || 'Aktivitas Pengguna';
                if (metrics.length === 4) {
                    metricsGrid.className = 'grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs';
                } else if (metrics.length === 2) {
                    metricsGrid.className = 'grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs';
                } else {
                    metricsGrid.className = 'grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs';
                }
                metricsGrid.replaceChildren();

                const toneClassMap = {
                    danger: 'text-red-800',
                    warning: 'text-amber-900',
                    default: 'text-slate-dark',
                };

                metrics.forEach(function (metric) {
                    const card = document.createElement('div');
                    card.className = 'p-3 rounded-xl bg-bg-light border border-stone-100';

                    const label = document.createElement('span');
                    label.className = 'text-[10px] text-slate-muted font-bold block';
                    label.textContent = metric.label;

                    const value = document.createElement('span');
                    value.className = 'text-base font-black font-heading ' + (toneClassMap[metric.tone] || 'text-slate-dark');
                    value.textContent = String(metric.value);

                    card.appendChild(label);
                    card.appendChild(value);
                    metricsGrid.appendChild(card);
                });

                const bankBox = document.getElementById('detail-bank-box');
                if (data.role === 'artist' && data.artist_profile) {
                    document.getElementById('detail-bank-name').textContent = data.artist_profile.bank_name || '-';
                    document.getElementById('detail-acc-number').textContent = data.artist_profile.account_number || '-';
                    document.getElementById('detail-acc-holder').textContent = data.artist_profile.account_holder || '-';
                    bankBox.classList.remove('hidden');
                } else {
                    bankBox.classList.add('hidden');
                }

                const reportsBox = document.getElementById('detail-reports-box');
                const reportsList = document.getElementById('detail-reports-list');
                const highRiskBadge = document.getElementById('detail-high-risk-badge');
                reportsList.replaceChildren();

                if (data.role === 'artist' && data.recent_reports && data.recent_reports.length > 0) {
                    highRiskBadge.classList.toggle('hidden', !data.is_high_risk);
                    data.recent_reports.forEach(function (rep) {
                        const row = document.createElement('div');
                        row.className = 'p-3 rounded-xl bg-white border border-stone-200 space-y-1';

                        const head = document.createElement('div');
                        head.className = 'flex items-center justify-between gap-2 text-[11px]';

                        const reporter = document.createElement('span');
                        reporter.className = 'font-heading font-bold text-slate-dark';
                        reporter.textContent = 'Pelapor: ' + rep.reporter_name + (rep.order_number ? ' (Order #' + rep.order_number + ')' : '');

                        const date = document.createElement('span');
                        date.className = 'text-slate-muted';
                        date.textContent = rep.date;

                        head.appendChild(reporter);
                        head.appendChild(date);

                        const reason = document.createElement('p');
                        reason.className = 'text-slate-body text-xs';
                        reason.textContent = rep.reason + ' (Status: ' + rep.status + ')';

                        row.appendChild(head);
                        row.appendChild(reason);
                        reportsList.appendChild(row);
                    });
                    reportsBox.classList.remove('hidden');
                } else {
                    highRiskBadge.classList.add('hidden');
                    reportsBox.classList.add('hidden');
                }

                const actionsContainer = document.getElementById('detail-action-buttons');
                actionsContainer.replaceChildren();

                if (data.id !== CURRENT_ADMIN_ID && data.role !== 'artist' && !data.is_blocked) {
                    const editBtn = document.createElement('button');
                    editBtn.type = 'button';
                    editBtn.className = 'cursor-pointer px-4 py-2 rounded-xl bg-pastel-200 hover:bg-pastel-300 border border-pastel-300 text-slate-dark text-xs font-bold font-heading transition';
                    editBtn.textContent = 'Ubah Role';
                    editBtn.addEventListener('click', function () {
                        openEditModal(data, triggerEl);
                    });
                    actionsContainer.appendChild(editBtn);
                }

                if (data.id !== CURRENT_ADMIN_ID && data.role !== 'admin') {
                    const toggleBtn = document.createElement('button');
                    toggleBtn.type = 'button';
                    if (data.is_blocked) {
                        toggleBtn.className = 'cursor-pointer px-4 py-2 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-200 text-xs font-bold font-heading transition';
                        toggleBtn.textContent = 'Buka Blokir Akun';
                        toggleBtn.addEventListener('click', function () {
                            openUnblockModal(data, triggerEl);
                        });
                    } else {
                        toggleBtn.className = 'cursor-pointer px-4 py-2 rounded-xl bg-red-50 hover:bg-red-100 text-red-800 border border-red-200 text-xs font-bold font-heading transition';
                        toggleBtn.textContent = 'Blokir Akun';
                        toggleBtn.addEventListener('click', function () {
                            openBlockModal(data, triggerEl);
                        });
                    }
                    actionsContainer.appendChild(toggleBtn);
                }

                openModal('userDetailModal', triggerEl);
            }

            function openEditModal(data, triggerEl) {
                document.getElementById('editUserForm').action = data.update_url;
                document.getElementById('edit-user-name').textContent = data.name;
                document.getElementById('edit-user-email').textContent = data.email;
                document.getElementById('edit-current-role').textContent = data.role === 'admin' ? 'Saat ini: Admin' : 'Saat ini: Client';

                const roleSelect = document.getElementById('edit-role');
                roleSelect.value = data.role === 'user' ? 'admin' : 'user';

                openModal('editUserModal', triggerEl);
            }

            function openBlockModal(data, triggerEl) {
                document.getElementById('blockUserForm').action = data.block_url;
                document.getElementById('block-user-label').textContent = data.name + ' (' + data.email + ')';
                document.getElementById('block-reason-input').value = '';
                openModal('blockUserModal', triggerEl);
            }

            function openUnblockModal(data, triggerEl) {
                document.getElementById('unblockUserForm').action = data.unblock_url;
                document.getElementById('unblock-user-label').textContent = data.name + ' (' + data.email + ')';
                document.getElementById('unblock-prev-reason').textContent = data.block_reason || 'Tidak ada catatan alasan tersimpan.';
                document.getElementById('unblock-prev-date').textContent = data.blocked_at_formatted ? 'Diblokir pada: ' + data.blocked_at_formatted : '';
                openModal('unblockUserModal', triggerEl);
            }

            document.addEventListener('click', function (event) {
                const actionBtn = event.target.closest('[data-action]');
                if (actionBtn) {
                    const data = JSON.parse(actionBtn.dataset.user);
                    const action = actionBtn.dataset.action;

                    if (action === 'detail') openDetailModal(data, actionBtn);
                    else if (action === 'edit') openEditModal(data, actionBtn);
                    else if (action === 'block') openBlockModal(data, actionBtn);
                    else if (action === 'unblock') openUnblockModal(data, actionBtn);
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
