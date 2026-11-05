@if (request()->routeIs('home', 'katalog', 'katalog.*', 'login', 'register', 'register.*'))
    <header class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-stone-200/80 transition-all duration-200"
        id="main-header">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20 gap-4">
                <div class="flex items-center gap-8 shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                        <img src="{{ asset('images/logo-artsy.png') }}" alt="Artsy ID Logo"
                            class="h-10 w-auto object-contain transition-transform group-hover:scale-105" />
                        <span
                            class="text-xl font-extrabold font-heading text-slate-dark tracking-tight leading-none">Artsy<span
                                class="text-amber-500">.ID</span></span>
                    </a>

                    <nav class="hidden lg:flex items-center gap-1 text-sm font-medium text-slate-body">
                        <a href="{{ route('katalog') }}"
                            class="px-3.5 py-2 rounded-xl text-slate-body hover:text-slate-dark hover:bg-pastel-100 transition-colors font-heading">
                            Katalog Komisi
                        </a>
                        <a href="/#kategori"
                            class="px-3.5 py-2 rounded-xl text-slate-body hover:text-slate-dark hover:bg-pastel-100 transition-colors font-heading">
                            Kategori Seni
                        </a>
                        <a href="/#cara-kerja"
                            class="px-3.5 py-2 rounded-xl text-slate-body hover:text-slate-dark hover:bg-pastel-100 transition-colors font-heading">
                            Cara Kerja Escrow
                        </a>
                        <a href="/#keunggulan"
                            class="px-3.5 py-2 rounded-xl text-slate-body hover:text-slate-dark hover:bg-pastel-100 transition-colors font-heading">
                            Keunggulan
                        </a>
                    </nav>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('register.artist') }}"
                        class="hidden md:inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-bold text-slate-dark bg-stone-100 hover:bg-pastel-100 border border-stone-200 transition-all font-heading">
                        <span>Daftar Jadi Artist</span>
                    </a>

                    @auth
                        <div class="relative" x-data="{ open: false }">
                            <a href="{{ route('dashboard') }}"
                                class="flex items-center gap-2 p-1.5 pr-3 rounded-full hover:bg-stone-100 transition border border-stone-200">
                                @if(auth()->user()->avatar_url)
                                    <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}"
                                        class="w-8 h-8 rounded-full object-cover ring-2 ring-pastel-300">
                                @else
                                    <div
                                        class="w-8 h-8 rounded-full bg-pastel-300 text-slate-dark flex items-center justify-center font-bold text-xs font-heading">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </div>
                                @endif
                                <span
                                    class="text-xs font-bold text-slate-dark hidden sm:inline max-w-30 truncate font-heading">{{ auth()->user()->name }}</span>
                            </a>
                        </div>
                    @else
                        <div class="flex items-center gap-2">
                            <a href="{{ route('login') }}"
                                class="px-4 py-2 rounded-xl text-xs font-bold text-slate-body hover:text-slate-dark hover:bg-stone-100 transition font-heading">
                                Masuk
                            </a>
                            <a href="{{ route('register') }}"
                                class="inline-flex items-center justify-center px-4 py-2 rounded-xl text-xs font-bold text-slate-dark bg-pastel-200 hover:bg-pastel-300 border border-pastel-300 shadow-xs transition hover:shadow-sm font-heading">
                                Daftar
                            </a>
                        </div>
                    @endauth

                    <button type="button" id="mobile-menu-btn"
                        class="lg:hidden p-2.5 rounded-xl text-slate-body hover:text-slate-dark hover:bg-stone-100 transition focus:outline-none"
                        aria-label="Toggle Mobile Menu">
                        <i class="fa-solid fa-bars text-lg" id="mobile-menu-icon"></i>
                    </button>
                </div>
            </div>

            <div id="mobile-menu"
                class="hidden lg:hidden py-4 border-t border-stone-200/80 animate-in fade-in duration-200">
                <nav class="flex flex-col gap-1.5">
                    <a href="{{ route('katalog') }}"
                        class="px-4 py-2.5 rounded-xl text-sm font-medium text-slate-dark hover:bg-pastel-100 transition">
                        Katalog Komisi
                    </a>
                    <a href="/#kategori"
                        class="px-4 py-2.5 rounded-xl text-sm font-medium text-slate-dark hover:bg-pastel-100 transition">
                        Kategori Seni
                    </a>
                    <a href="#cara-kerja"
                        class="px-4 py-2.5 rounded-xl text-sm font-medium text-slate-dark hover:bg-pastel-100 transition">
                        Cara Kerja Escrow
                    </a>
                    <a href="/#keunggulan"
                        class="px-4 py-2.5 rounded-xl text-sm font-medium text-slate-dark hover:bg-pastel-100 transition">
                        Keunggulan
                    </a>
                    <div class="pt-3 mt-2 border-t border-stone-100 flex flex-col gap-2">
                        <a href="{{ route('register.artist') }}"
                            class="w-full text-center px-4 py-2.5 rounded-xl text-xs font-bold text-slate-dark bg-pastel-100 hover:bg-pastel-200 border border-pastel-200 transition">
                            Daftar Jadi Artist
                        </a>
                        @guest
                            <div class="grid grid-cols-2 gap-2 mt-1">
                                <a href="{{ route('login') }}"
                                    class="text-center px-4 py-2 rounded-xl text-xs font-bold text-slate-body bg-stone-100 hover:bg-stone-200 transition">
                                    Masuk
                                </a>
                                <a href="{{ route('register') }}"
                                    class="text-center px-4 py-2 rounded-xl text-xs font-bold text-slate-dark bg-pastel-200 hover:bg-pastel-300 transition">
                                    Daftar
                                </a>
                            </div>
                        @endguest
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const menuBtn = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            const menuIcon = document.getElementById('mobile-menu-icon');

            if (menuBtn && mobileMenu && menuIcon) {
                menuBtn.addEventListener('click', function () {
                    const isHidden = mobileMenu.classList.contains('hidden');
                    if (isHidden) {
                        mobileMenu.classList.remove('hidden');
                        menuIcon.classList.remove('fa-bars');
                        menuIcon.classList.add('fa-xmark');
                    } else {
                        mobileMenu.classList.add('hidden');
                        menuIcon.classList.remove('fa-xmark');
                        menuIcon.classList.add('fa-bars');
                    }
                });

                mobileMenu.querySelectorAll('a').forEach(function (link) {
                    link.addEventListener('click', function () {
                        mobileMenu.classList.add('hidden');
                        menuIcon.classList.remove('fa-xmark');
                        menuIcon.classList.add('fa-bars');
                    });
                });
            }
        });
    </script>
@else
    <header
        class="h-20 bg-white border-b border-stone-200/80 px-4 sm:px-6 lg:px-8 flex items-center justify-between shrink-0 sticky top-0 z-10">

        <div class="flex items-center gap-3">
            <button type="button" id="sidebar-toggle-btn"
                class="lg:hidden p-2 rounded-xl text-slate-body hover:text-slate-dark hover:bg-stone-100 transition focus:outline-none"
                aria-label="Buka Menu Sidebar">
                <i class="fa-solid fa-bars-staggered text-lg"></i>
            </button>
            <div>
                <h1 class="text-base sm:text-lg font-extrabold font-heading text-slate-dark tracking-tight">
                    @auth
                        @switch(auth()->user()->role)
                            @case('admin')
                                Dashboard Admin
                                @break
                            @case('user')
                                Dashboard Client
                                @break
                            @case('artist')
                                Dashboard Artist
                                @break
                        @endswitch
                    @endauth
                </h1>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button type="button"
                class="relative w-9 h-9 rounded-xl border border-stone-200 text-slate-600 hover:text-slate-dark hover:bg-stone-50 transition flex items-center justify-center"
                title="Notifikasi Baru">
                <i class="fa-solid fa-bell text-xs"></i>
                <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-amber-500 ring-2 ring-white"></span>
            </button>
        </div>
    </header>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleBtn = document.getElementById('sidebar-toggle-btn');
            const closeBtn = document.getElementById('sidebar-close-btn');
            const sidebarDrawer = document.getElementById('sidebar-drawer');
            const backdrop = document.getElementById('sidebar-backdrop');

            function openSidebar() {
                if (sidebarDrawer && backdrop) {
                    sidebarDrawer.classList.remove('-translate-x-full');
                    backdrop.classList.remove('hidden');
                }
            }

            function closeSidebar() {
                if (sidebarDrawer && backdrop) {
                    sidebarDrawer.classList.add('-translate-x-full');
                    backdrop.classList.add('hidden');
                }
            }

            if (toggleBtn) toggleBtn.addEventListener('click', openSidebar);
            if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
            if (backdrop) backdrop.addEventListener('click', closeSidebar);
        });
    </script>
@endif