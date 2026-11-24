@php
    $userRole = auth()->user()?->role;
    $adminIndicators = $sidebarIndicators['admin'] ?? [];
    $artistIndicators = $sidebarIndicators['artist'] ?? [];
    $clientIndicators = $sidebarIndicators['user'] ?? [];
@endphp

<aside id="app-sidebar"
    class="w-64 shrink-0 bg-white border-r border-stone-200/90 h-screen flex flex-col justify-between z-30 transition-all duration-200 font-sans">

    <div class="flex flex-col h-full overflow-hidden">

        <div class="h-20 px-5 flex items-center justify-between border-b border-stone-100 shrink-0">
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                <img src="{{ asset('images/logo-artsy.png') }}" alt="Artsy ID Logo"
                    class="h-9 w-auto object-contain transition-transform group-hover:scale-105" />
                <div class="flex flex-col">
                    <span class="text-lg font-black font-heading text-slate-dark tracking-tight leading-none">Artsy<span
                            class="text-amber-500">.ID</span></span>
                    <span class="text-[9px] font-semibold text-slate-muted uppercase tracking-wider mt-0.5">
                        @if($userRole === 'admin')
                            Admin Portal
                        @elseif($userRole === 'artist')
                            Artist Portal
                        @else
                            Client Portal
                        @endif
                    </span>
                </div>
            </a>

            <button type="button" id="sidebar-close-btn"
                class="lg:hidden p-1.5 rounded-lg text-slate-muted hover:text-slate-dark hover:bg-stone-100 transition"
                aria-label="Tutup Sidebar">
                <i class="fa-solid fa-xmark text-base"></i>
            </button>
        </div>

        <nav class="flex-1 overflow-y-auto px-3 py-3 space-y-6 hide-scrollbar">

            <!-- MENU ADMIN -->
            @if($userRole === 'admin')
                <div class="space-y-1">
                    <span
                        class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider font-heading block mb-1">
                        Menu
                    </span>

                    <a href="{{ route('dashboard') }}"
                        class="flex items-center justify-between px-3.5 py-2.5 rounded-xl font-heading text-xs font-bold transition-all {{ request()->routeIs('dashboard') ? 'bg-pastel-200 text-slate-dark border border-pastel-300 shadow-xs' : 'text-slate-body hover:text-slate-dark hover:bg-pastel-50' }}">
                        <div class="flex items-center gap-3">
                            <i
                                class="fa-solid fa-chart-pie text-sm {{ request()->routeIs('dashboard') ? 'text-slate-dark' : 'text-slate-400' }}"></i>
                            <span>Dashboard Utama</span>
                        </div>
                    </a>

                    <a href="{{ route('admin.payouts.index') }}"
                        class="flex items-center justify-between px-3.5 py-2.5 rounded-xl font-heading text-xs transition-colors {{ request()->routeIs('admin.payouts.*') ? 'bg-pastel-200 text-slate-dark border border-pastel-300 shadow-xs font-bold' : 'text-slate-body hover:text-slate-dark hover:bg-pastel-50 font-medium' }}">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-money-bill-transfer text-sm {{ request()->routeIs('admin.payouts.*') ? 'text-slate-dark' : 'text-slate-400' }}"></i>
                            <span>Pencairan Payout</span>
                        </div>
                        @if(!empty($adminIndicators['payouts']))
                            @include('layouts.partials.sidebar-indicator', [
                                'key'   => 'admin.payouts',
                                'label' => 'Ada antrean pencairan payout',
                            ])
                        @endif
                    </a>

                    <a href="{{ route('admin.payments.index') }}"
                        class="flex items-center justify-between px-3.5 py-2.5 rounded-xl font-heading text-xs transition-colors {{ request()->routeIs('admin.payments.*') ? 'bg-pastel-200 text-slate-dark border border-pastel-300 shadow-xs font-bold' : 'text-slate-body hover:text-slate-dark hover:bg-pastel-50 font-medium' }}">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-file-invoice-dollar text-sm {{ request()->routeIs('admin.payments.*') ? 'text-slate-dark' : 'text-slate-400' }}"></i>
                            <span>Audit Transaksi</span>
                        </div>
                        @if(!empty($adminIndicators['payments']))
                            @include('layouts.partials.sidebar-indicator', [
                                'key'   => 'admin.payments',
                                'label' => 'Ada transaksi menunggu verifikasi atau audit',
                            ])
                        @endif
                    </a>

                    <a href="{{ route('admin.orders.index') }}"
                        class="flex items-center justify-between px-3.5 py-2.5 rounded-xl font-heading text-xs transition-colors {{ request()->routeIs('admin.orders.*') ? 'bg-pastel-200 text-slate-dark border border-pastel-300 shadow-xs font-bold' : 'text-slate-body hover:text-slate-dark hover:bg-pastel-50 font-medium' }}">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-boxes-stacked text-sm {{ request()->routeIs('admin.orders.*') ? 'text-slate-dark' : 'text-slate-400' }}"></i>
                            <span>Semua Pesanan</span>
                        </div>
                    </a>
                </div>

                <div class="space-y-1">
                    <span
                        class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider font-heading block mb-1">
                        Verifikasi &amp; Laporan
                    </span>

                    <a href="{{ route('admin.applications.index') }}"
                        class="flex items-center justify-between px-3.5 py-2.5 rounded-xl font-heading text-xs transition-colors {{ request()->routeIs('admin.applications.*') ? 'bg-pastel-200 text-slate-dark border border-pastel-300 shadow-xs font-bold' : 'text-slate-body hover:text-slate-dark hover:bg-pastel-50 font-medium' }}">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-id-card-clip text-sm {{ request()->routeIs('admin.applications.*') ? 'text-slate-dark' : 'text-slate-400' }}"></i>
                            <span>Verifikasi Artist</span>
                        </div>
                        @if(!empty($adminIndicators['applications']))
                            @include('layouts.partials.sidebar-indicator', [
                                'key'   => 'admin.applications',
                                'label' => 'Ada pengajuan artist menunggu verifikasi',
                            ])
                        @endif
                    </a>

                    <a href="{{ route('admin.reports.index') }}"
                        class="flex items-center justify-between px-3.5 py-2.5 rounded-xl font-heading text-xs transition-colors {{ request()->routeIs('admin.reports.*') ? 'bg-pastel-200 text-slate-dark border border-pastel-300 shadow-xs font-bold' : 'text-slate-body hover:text-slate-dark hover:bg-pastel-50 font-medium' }}">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-triangle-exclamation text-sm {{ request()->routeIs('admin.reports.*') ? 'text-slate-dark' : 'text-slate-400' }}"></i>
                            <span>Laporan Sengketa</span>
                        </div>
                        @if(!empty($adminIndicators['reports']))
                            @include('layouts.partials.sidebar-indicator', [
                                'key'     => 'admin.reports',
                                'label'   => 'Ada laporan sengketa baru',
                                'variant' => 'rose',
                            ])
                        @endif
                    </a>

                    <a href="{{ route('admin.users.index') }}"
                        class="flex items-center justify-between px-3.5 py-2.5 rounded-xl font-heading text-xs transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-pastel-200 text-slate-dark border border-pastel-300 shadow-xs font-bold' : 'text-slate-body hover:text-slate-dark hover:bg-pastel-50 font-medium' }}">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-users text-sm {{ request()->routeIs('admin.users.*') ? 'text-slate-dark' : 'text-slate-400' }}"></i>
                            <span>Kelola Pengguna</span>
                        </div>
                    </a>
                </div>

                <!-- MENU ARTIST -->
            @elseif($userRole === 'artist')
                <div class="space-y-1">
                    <span
                        class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider font-heading block mb-1">
                        Menu
                    </span>

                    <a href="{{ route('dashboard') }}"
                        class="flex items-center justify-between px-3.5 py-2.5 rounded-xl font-heading text-xs font-bold transition-all {{ request()->routeIs('dashboard') ? 'bg-pastel-200 text-slate-dark border border-pastel-300 shadow-xs' : 'text-slate-body hover:text-slate-dark hover:bg-pastel-50' }}">
                        <div class="flex items-center gap-3">
                            <i
                                class="fa-solid fa-gauge-high text-sm {{ request()->routeIs('dashboard') ? 'text-slate-dark' : 'text-slate-400' }}"></i>
                            <span>Dashboard Utama</span>
                        </div>
                    </a>

                    <a href="{{ route('artist.orders.index') }}"
                        class="flex items-center justify-between px-3.5 py-2.5 rounded-xl font-heading text-xs transition-colors {{ request()->routeIs('artist.orders.*') ? 'bg-pastel-200 text-slate-dark border border-pastel-300 shadow-xs font-bold' : 'text-slate-body hover:text-slate-dark hover:bg-pastel-50 font-medium' }}">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-inbox text-sm {{ request()->routeIs('artist.orders.*') ? 'text-slate-dark' : 'text-slate-400' }}"></i>
                            <span>Pesanan Masuk</span>
                        </div>
                        @if(!empty($artistIndicators['orders']))
                            @include('layouts.partials.sidebar-indicator', [
                                'key'   => 'artist.orders',
                                'label' => 'Ada pesanan baru menunggu konfirmasi',
                            ])
                        @endif
                    </a>

                    <a href="{{ route('artist.tracker.index') }}"
                        class="flex items-center justify-between px-3.5 py-2.5 rounded-xl font-heading text-xs transition-colors {{ request()->routeIs('artist.tracker.*') ? 'bg-pastel-200 text-slate-dark border border-pastel-300 shadow-xs font-bold' : 'text-slate-body hover:text-slate-dark hover:bg-pastel-50 font-medium' }}">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-stamp text-sm {{ request()->routeIs('artist.tracker.*') ? 'text-slate-dark' : 'text-slate-400' }}"></i>
                            <span>Unggah Draf WIP</span>
                        </div>
                        @if(!empty($artistIndicators['tracker']))
                            @include('layouts.partials.sidebar-indicator', [
                                'key'   => 'artist.tracker',
                                'label' => 'Ada progres atau revisi perlu diunggah',
                            ])
                        @endif
                    </a>

                    <a href="{{ route('artist.payouts.index') }}"
                        class="flex items-center justify-between px-3.5 py-2.5 rounded-xl font-heading text-xs transition-colors {{ request()->routeIs('artist.payouts.*') ? 'bg-pastel-200 text-slate-dark border border-pastel-300 shadow-xs font-bold' : 'text-slate-body hover:text-slate-dark hover:bg-pastel-50 font-medium' }}">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-building-columns text-sm {{ request()->routeIs('artist.payouts.*') ? 'text-slate-dark' : 'text-slate-400' }}"></i>
                            <span>Pencairan Dana</span>
                        </div>
                        @if(!empty($artistIndicators['payouts']))
                            @include('layouts.partials.sidebar-indicator', [
                                'key'   => 'artist.payouts',
                                'label' => 'Ada antrean pencairan dana',
                            ])
                        @endif
                    </a>
                </div>

                <div class="space-y-1">
                    <span
                        class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider font-heading block mb-1">
                        Katalog &amp; Etalase
                    </span>

                    <a href="{{ route('artist.menus.index') }}"
                        class="flex items-center justify-between px-3.5 py-2.5 rounded-xl font-heading text-xs transition-colors {{ request()->routeIs('artist.menus.*') ? 'bg-pastel-200 text-slate-dark border border-pastel-300 shadow-xs font-bold' : 'text-slate-body hover:text-slate-dark hover:bg-pastel-50 font-medium' }}">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-layer-group text-sm {{ request()->routeIs('artist.menus.*') ? 'text-slate-dark' : 'text-slate-400' }}"></i>
                            <span>Paket Menu Komisi</span>
                        </div>
                    </a>

                    <a href="{{ route('artist.portfolios.index') }}"
                        class="flex items-center justify-between px-3.5 py-2.5 rounded-xl font-heading text-xs transition-colors {{ request()->routeIs('artist.portfolios.*') ? 'bg-pastel-200 text-slate-dark border border-pastel-300 shadow-xs font-bold' : 'text-slate-body hover:text-slate-dark hover:bg-pastel-50 font-medium' }}">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-images text-sm {{ request()->routeIs('artist.portfolios.*') ? 'text-slate-dark' : 'text-slate-400' }}"></i>
                            <span>Galeri Portofolio</span>
                        </div>
                    </a>

                    <a href="{{ route('profile') }}"
                        class="flex items-center justify-between px-3.5 py-2.5 rounded-xl font-heading text-xs font-medium text-slate-body hover:text-slate-dark hover:bg-pastel-50 transition-colors {{ request()->routeIs('profile*') ? 'bg-pastel-100 text-slate-dark font-bold' : '' }}">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-file-contract text-sm text-slate-400"></i>
                            <span>Aturan ToS &amp; Rekening</span>
                        </div>
                    </a>
                </div>

                <!-- MENU CLIENT -->
            @else
                <div class="space-y-1">
                    <span
                        class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider font-heading block mb-1">
                        Menu
                    </span>

                    <a href="{{ route('dashboard') }}"
                        class="flex items-center justify-between px-3.5 py-2.5 rounded-xl font-heading text-xs font-bold transition-all {{ request()->routeIs('dashboard') ? 'bg-pastel-200 text-slate-dark border border-pastel-300 shadow-xs' : 'text-slate-body hover:text-slate-dark hover:bg-pastel-50' }}">
                        <div class="flex items-center gap-3">
                            <i
                                class="fa-solid fa-gauge-high text-sm {{ request()->routeIs('dashboard') ? 'text-slate-dark' : 'text-slate-400' }}"></i>
                            <span>Dashboard Utama</span>
                        </div>
                    </a>

                    <a href="{{ route('user.orders.index') }}"
                        class="flex items-center justify-between px-3.5 py-2.5 rounded-xl font-heading text-xs transition-colors {{ request()->routeIs('user.orders.*') ? 'bg-pastel-200 text-slate-dark border border-pastel-300 shadow-xs font-bold' : 'text-slate-body hover:text-slate-dark hover:bg-pastel-50 font-medium' }}">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-palette text-sm {{ request()->routeIs('user.orders.*') ? 'text-slate-dark' : 'text-slate-400' }}"></i>
                            <span>Pesanan Saya</span>
                        </div>
                        @if(!empty($clientIndicators['orders']))
                            @include('layouts.partials.sidebar-indicator', [
                                'key'   => 'user.orders',
                                'label' => 'Ada progres WIP menunggu persetujuan',
                            ])
                        @endif
                    </a>

                    <a href="{{ route('user.invoices.index') }}"
                        class="flex items-center justify-between px-3.5 py-2.5 rounded-xl font-heading text-xs transition-colors {{ request()->routeIs('user.invoices.*') ? 'bg-pastel-200 text-slate-dark border border-pastel-300 shadow-xs font-bold' : 'text-slate-body hover:text-slate-dark hover:bg-pastel-50 font-medium' }}">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-receipt text-sm {{ request()->routeIs('user.invoices.*') ? 'text-slate-dark' : 'text-slate-400' }}"></i>
                            <span>Tagihan &amp; Escrow</span>
                        </div>
                        @if(!empty($clientIndicators['invoices']))
                            @include('layouts.partials.sidebar-indicator', [
                                'key'   => 'user.invoices',
                                'label' => 'Ada tagihan belum dibayar',
                            ])
                        @endif
                    </a>

                    <a href="{{ route('user.completed.index') }}"
                        class="flex items-center justify-between px-3.5 py-2.5 rounded-xl font-heading text-xs transition-colors {{ request()->routeIs('user.completed.*') ? 'bg-pastel-200 text-slate-dark border border-pastel-300 shadow-xs font-bold' : 'text-slate-body hover:text-slate-dark hover:bg-pastel-50 font-medium' }}">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-cloud-arrow-down text-sm {{ request()->routeIs('user.completed.*') ? 'text-slate-dark' : 'text-slate-400' }}"></i>
                            <span>Karya Selesai</span>
                        </div>
                    </a>
                </div>

                <div class="space-y-1">
                    <span
                        class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider font-heading block mb-1">
                        Eksplorasi
                    </span>

                    <a href="{{ route('katalog') }}"
                        class="flex items-center justify-between px-3.5 py-2.5 rounded-xl font-heading text-xs font-medium text-slate-body hover:text-slate-dark hover:bg-pastel-50 transition-colors {{ request()->routeIs('katalog*') ? 'bg-pastel-100 text-slate-dark font-bold' : '' }}">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-compass text-sm {{ request()->routeIs('katalog*') ? 'text-slate-dark' : 'text-slate-400' }}"></i>
                            <span>Katalog Komisi</span>
                        </div>
                        <i class="fa-solid fa-arrow-up-right-from-square text-[10px] text-slate-400"></i>
                    </a>

                    <a href="{{ route('register.artist') }}"
                        class="flex items-center justify-between px-3.5 py-2.5 rounded-xl font-heading text-xs font-bold text-amber-900 bg-pastel-100/60 hover:bg-pastel-100 border border-pastel-200 transition-colors {{ request()->routeIs('register.artist*') ? 'bg-pastel-200' : '' }}">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-paintbrush text-sm text-amber-600"></i>
                            <span>Buka Toko Artist</span>
                        </div>
                        <span
                            class="text-[9px] font-black uppercase text-amber-800 bg-white px-1.5 py-0.5 rounded shadow-xs">
                            Upgrade
                        </span>
                    </a>
                </div>
            @endif

            <!-- MENU BERSAMA -->
            <div class="space-y-1 pt-2 border-t border-stone-100">
                <span
                    class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider font-heading block mb-1">
                    Akun
                </span>

                <a href="{{ route('profile') }}"
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-heading text-xs font-medium text-slate-body hover:text-slate-dark hover:bg-pastel-50 transition-colors {{ request()->routeIs('profile*') ? 'bg-pastel-100 text-slate-dark font-bold' : '' }}">
                    <i class="fa-solid fa-user text-sm text-slate-400"></i>
                    <span>Profile</span>
                </a>
            </div>

        </nav>
    </div>

    <div class="p-3.5 border-t border-stone-100 bg-stone-50/70">
        <form action="{{ route('logout') }}" method="POST" class="w-full">
            @csrf
            <button type="submit"
                class="cursor-pointer group flex items-center justify-between gap-3 p-2 rounded-xl bg-white border border-stone-200/80 shadow-xs w-full">
                <div class="flex items-center gap-2.5 min-w-0">
                    @if(auth()->check() && auth()->user()->avatar_url)
                        <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}"
                            class="w-8 h-8 rounded-full object-cover ring-2 ring-pastel-300 shrink-0">
                    @else
                        <div
                            class="w-8 h-8 rounded-full bg-pastel-300 text-slate-dark flex items-center justify-center font-bold text-xs font-heading shrink-0">
                            {{ strtoupper(substr(auth()->user()?->name ?? 'User', 0, 1)) }}
                        </div>
                    @endif
                    <div class="flex flex-col items-start min-w-0">
                        <span
                            class="text-xs text-start font-bold text-slate-dark group-hover:text-red-600! transition-colors truncate font-heading leading-tight w-full">
                            {{ auth()->user()?->name ?? 'Pengguna Artsy' }}
                        </span>
                        <span class="text-[10px] text-slate-muted w-full truncate">
                            {{ auth()->user()?->email ?? 'user@artsy.id' }}
                        </span>
                    </div>
                </div>

                <div>
                    <div
                        class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 group-hover:text-rose-600 group-hover:bg-rose-50 transition cursor-pointer shrink-0">
                        <i class="fa-solid fa-arrow-right-from-bracket text-xs"></i>
                    </div>
                </div>
            </button>
        </form>
    </div>

</aside>
