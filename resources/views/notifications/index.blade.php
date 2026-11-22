@extends('layouts.app', ['title' => 'Notifikasi - Artsy ID'])

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

            <main class="p-4 sm:p-6 lg:p-8 space-y-6 max-w-5xl w-full mx-auto">

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

                @php
                    $roleBadgeLabel = match (auth()->user()?->role) {
                        'admin'  => 'Administrator Portal',
                        'artist' => 'Artist Portal',
                        default  => 'Client Portal',
                    };
                @endphp

                <div class="bg-white rounded-2xl border border-stone-200/90 shadow-2xs p-5 sm:p-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <span class="inline-block px-2.5 py-1 rounded-md bg-pastel-200 text-amber-900 font-bold text-[10px] font-heading uppercase tracking-wider">
                            {{ $roleBadgeLabel }}
                        </span>
                        <h2 class="text-xl sm:text-2xl font-black font-heading text-slate-dark mt-1.5">
                            Pusat Notifikasi
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-muted mt-0.5">
                            Pantau pemberitahuan aktivitas terbaru yang ditujukan khusus untuk akun Anda.
                        </p>
                    </div>

                    @if ($unreadCount > 0)
                        <form action="{{ route('notifications.readAll') }}" method="POST" class="shrink-0">
                            @csrf
                            <button type="submit"
                                class="cursor-pointer min-h-11 sm:min-h-0 px-4 py-2 rounded-xl bg-pastel-200 hover:bg-pastel-300 border border-pastel-300 text-slate-dark font-bold text-xs font-heading transition flex items-center justify-center gap-2 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-dark">
                                <i class="fa-solid fa-check-double text-xs" aria-hidden="true"></i>
                                <span>Tandai Semua Dibaca ({{ $unreadCount }})</span>
                            </button>
                        </form>
                    @endif
                </div>

                <div class="bg-white rounded-2xl border border-stone-200/90 shadow-2xs p-3 sm:p-4 flex flex-wrap items-center gap-2">
                    <a href="{{ route('notifications.index', ['filter' => 'all']) }}"
                        class="min-h-10 px-4 py-2 rounded-xl text-xs font-heading font-bold transition flex items-center {{ $filter === 'all' ? 'bg-pastel-200 text-slate-dark border border-pastel-300 shadow-xs' : 'text-slate-muted hover:text-slate-dark hover:bg-stone-50' }}">
                        Semua ({{ $totalCount }})
                    </a>
                    <a href="{{ route('notifications.index', ['filter' => 'unread']) }}"
                        class="min-h-10 px-4 py-2 rounded-xl text-xs font-heading font-bold transition flex items-center gap-1.5 {{ $filter === 'unread' ? 'bg-pastel-200 text-slate-dark border border-pastel-300 shadow-xs' : 'text-slate-muted hover:text-slate-dark hover:bg-stone-50' }}">
                        <span>Belum Dibaca ({{ $unreadCount }})</span>
                    </a>
                </div>

                @if ($notifications->isEmpty())
                    <div class="bg-white rounded-2xl border border-stone-200/90 shadow-2xs p-12 text-center space-y-3">
                        <div class="w-14 h-14 rounded-full bg-pastel-100 text-amber-900 flex items-center justify-center mx-auto text-2xl">
                            <i class="fa-solid fa-bell-slash" aria-hidden="true"></i>
                        </div>
                        <h3 class="font-heading font-bold text-base text-slate-dark">
                            {{ $filter === 'unread' ? 'Tidak Ada Notifikasi Belum Dibaca' : 'Belum Ada Notifikasi' }}
                        </h3>
                        <p class="text-xs text-slate-muted max-w-md mx-auto leading-relaxed">
                            @if ($filter === 'unread')
                                Seluruh notifikasi pada akun Anda sudah dibaca.
                            @else
                                Pemberitahuan terkait aktivitas akun, pesanan, atau verifikasi akan otomatis tampil di halaman ini.
                            @endif
                        </p>
                        @if ($filter === 'unread' && $totalCount > 0)
                            <a href="{{ route('notifications.index', ['filter' => 'all']) }}"
                                class="inline-flex items-center justify-center min-h-11 sm:min-h-0 mt-2 px-4 py-2 rounded-xl bg-pastel-200 hover:bg-pastel-300 border border-pastel-300 text-slate-dark text-xs font-bold font-heading transition">
                                Lihat Semua Notifikasi
                            </a>
                        @endif
                    </div>
                @else
                    <div class="bg-white rounded-2xl border border-stone-200/90 shadow-2xs divide-y divide-stone-100 overflow-hidden">
                        @foreach ($notifications as $notification)
                            @php
                                $meta = $service->resolveCategoryMeta($notification);
                            @endphp
                            <div class="p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 transition {{ !$notification->is_read ? 'bg-pastel-50/70' : 'bg-white' }} hover:bg-stone-50/70">
                                <div class="flex items-start gap-3.5 min-w-0 flex-1">
                                    <div class="w-10 h-10 rounded-xl border {{ $meta['bg'] }} flex items-center justify-center shrink-0 mt-0.5 text-sm">
                                        <i class="fa-solid {{ $meta['icon'] }}" aria-hidden="true"></i>
                                    </div>
                                    <div class="min-w-0 flex-1 space-y-1">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-pastel-100 text-amber-900 border border-pastel-300 text-[10px] font-bold font-heading">
                                                {{ $meta['label'] }}
                                            </span>
                                            @if (!$notification->is_read)
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-amber-100 text-amber-900 border border-amber-300 text-[10px] font-bold font-heading">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-600" aria-hidden="true"></span>
                                                    <span>Baru</span>
                                                </span>
                                            @endif
                                            <span class="text-[11px] text-slate-muted">
                                                {{ $notification->created_at ? $notification->created_at->timezone('Asia/Jakarta')->translatedFormat('d M Y, H:i') . ' WIB' : '-' }}
                                            </span>
                                        </div>
                                        <h3 class="font-heading font-bold text-sm text-slate-dark">
                                            {{ $notification->title }}
                                        </h3>
                                        <p class="text-xs text-slate-body leading-relaxed">
                                            {{ $notification->message }}
                                        </p>
                                    </div>
                                </div>

                                <div class="flex flex-wrap items-center gap-2 shrink-0 sm:justify-end">
                                    @if ($notification->link_url)
                                        <form action="{{ route('notifications.open', $notification->id) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="cursor-pointer min-h-11 sm:min-h-0 px-3.5 py-2 rounded-xl bg-pastel-200 hover:bg-pastel-300 border border-pastel-300 text-slate-dark font-bold text-xs font-heading transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-dark">
                                                Buka Halaman
                                            </button>
                                        </form>
                                    @endif

                                    @if (!$notification->is_read)
                                        <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="cursor-pointer min-h-11 sm:min-h-0 px-3.5 py-2 rounded-xl bg-white hover:bg-stone-100 border border-stone-200 text-slate-dark font-bold text-xs font-heading transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-dark">
                                                Tandai Dibaca
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if ($notifications->hasPages())
                        <div class="pt-2">
                            {{ $notifications->links() }}
                        </div>
                    @endif
                @endif

            </main>
        </div>
    </div>
@endsection
