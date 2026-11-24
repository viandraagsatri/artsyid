<div class="relative" id="notif-bell-root">
    <button type="button" id="notif-toggle-btn"
        aria-haspopup="true" aria-expanded="false" aria-controls="notif-dropdown"
        aria-label="Buka daftar notifikasi"
        title="Notifikasi"
        class="cursor-pointer relative w-11 h-11 sm:w-10 sm:h-10 rounded-xl border border-stone-200 text-slate-body hover:text-slate-dark hover:bg-stone-50 transition flex items-center justify-center focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-dark">
        <i class="fa-solid fa-bell text-sm" aria-hidden="true"></i>
        @if ($headerUnreadCount > 0)
            <span class="absolute -top-1.5 -right-1.5 min-w-5 h-5 px-1 rounded-full bg-red-700 text-white text-[10px] font-black font-heading flex items-center justify-center ring-2 ring-white tabular-nums">
                {{ $headerUnreadCount > 99 ? '99+' : $headerUnreadCount }}
            </span>
        @endif
    </button>

    <div id="notif-dropdown" role="region" aria-label="Daftar notifikasi terbaru"
        class="hidden fixed left-4 right-4 top-20 sm:absolute sm:left-auto sm:right-0 sm:top-auto sm:mt-2 sm:w-96 bg-white rounded-2xl border border-stone-200 shadow-xl z-40 overflow-hidden">
        <div class="px-4 py-3 border-b border-stone-100 bg-bg-light flex items-center justify-between gap-2">
            <div class="flex items-center gap-2 min-w-0">
                <h3 class="font-heading font-bold text-xs sm:text-sm text-slate-dark">Notifikasi</h3>
                @if ($headerUnreadCount > 0)
                    <span class="px-2 py-0.5 rounded-full bg-pastel-100 text-amber-900 border border-pastel-300 text-[10px] font-bold font-heading tabular-nums">
                        {{ $headerUnreadCount }} baru
                    </span>
                @endif
            </div>

            @if ($headerUnreadCount > 0)
                <form action="{{ route('notifications.readAll') }}" method="POST" class="shrink-0">
                    @csrf
                    <button type="submit"
                        class="cursor-pointer px-2.5 py-1 rounded-lg text-[11px] font-bold font-heading text-amber-900 hover:bg-pastel-100 transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-dark">
                        Tandai semua dibaca
                    </button>
                </form>
            @endif
        </div>

        @if ($headerNotifications->isEmpty())
            <div class="p-6 text-center space-y-2">
                <div class="w-10 h-10 rounded-full bg-stone-100 text-slate-muted flex items-center justify-center mx-auto text-sm">
                    <i class="fa-solid fa-bell-slash" aria-hidden="true"></i>
                </div>
                <p class="font-heading font-bold text-xs text-slate-dark">Belum ada notifikasi</p>
                <p class="text-[11px] text-slate-muted leading-relaxed">
                    Aktivitas penting sesuai peran akun Anda akan muncul di sini secara otomatis.
                </p>
            </div>
        @else
            <div class="max-h-96 overflow-y-auto divide-y divide-stone-100">
                @foreach ($headerNotifications as $notifItem)
                    @php
                        $meta = $notificationService->resolveCategoryMeta($notifItem);
                    @endphp
                    <div class="p-3.5 transition {{ !$notifItem->is_read ? 'bg-pastel-50/70' : 'bg-white' }} hover:bg-stone-50/90 space-y-2">
                        <form action="{{ route('notifications.open', $notifItem->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="cursor-pointer w-full text-left flex items-start gap-3 group focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-dark rounded-xl">
                                <div class="w-8 h-8 rounded-lg border {{ $meta['bg'] }} flex items-center justify-center shrink-0 mt-0.5 text-xs">
                                    <i class="fa-solid {{ $meta['icon'] }}" aria-hidden="true"></i>
                                </div>
                                <div class="min-w-0 flex-1 space-y-0.5">
                                    <div class="flex items-start justify-between gap-2">
                                        <span class="font-heading font-bold text-xs text-slate-dark group-hover:underline leading-snug">
                                            {{ $notifItem->title }}
                                        </span>
                                        @if (!$notifItem->is_read)
                                            <span class="w-2 h-2 rounded-full bg-amber-500 shrink-0 mt-1.5" aria-label="Belum dibaca"></span>
                                        @endif
                                    </div>
                                    <p class="text-[11px] text-slate-body line-clamp-2 leading-relaxed">
                                        {{ $notifItem->message }}
                                    </p>
                                    <span class="block text-[10px] text-slate-muted pt-0.5">
                                        {{ $notifItem->created_at ? $notifItem->created_at->timezone('Asia/Jakarta')->translatedFormat('d M Y, H:i') . ' WIB' : '-' }}
                                    </span>
                                </div>
                            </button>
                        </form>

                        @if (!$notifItem->is_read)
                            <div class="flex justify-end pl-11">
                                <form action="{{ route('notifications.read', $notifItem->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="cursor-pointer text-[11px] font-bold font-heading text-slate-muted hover:text-slate-dark px-2.5 py-1.5 min-h-8 rounded-md hover:bg-stone-100 transition">
                                        Tandai dibaca
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

        <div class="px-4 py-2.5 border-t border-stone-100 bg-bg-light text-center">
            <a href="{{ route('notifications.index') }}"
                class="block w-full py-1 rounded-lg text-xs font-bold font-heading text-slate-dark hover:bg-pastel-100 transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-dark">
                Lihat semua notifikasi
            </a>
        </div>
    </div>
</div>

@once
<script>
    (function () {
        if (window.__artsyNotifInit) return;
        window.__artsyNotifInit = true;

        function setOpen(isOpen) {
            const btn = document.getElementById('notif-toggle-btn');
            const dropdown = document.getElementById('notif-dropdown');
            if (!btn || !dropdown) return;

            dropdown.classList.toggle('hidden', !isOpen);
            btn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        }

        document.addEventListener('click', function (event) {
            const root = document.getElementById('notif-bell-root');
            const btn = document.getElementById('notif-toggle-btn');
            const dropdown = document.getElementById('notif-dropdown');
            if (!root || !btn || !dropdown) return;

            if (event.target.closest('#notif-toggle-btn')) {
                const currentlyHidden = dropdown.classList.contains('hidden');
                setOpen(currentlyHidden);
                return;
            }

            if (!root.contains(event.target) && !dropdown.classList.contains('hidden')) {
                setOpen(false);
            }
        });

        document.addEventListener('keydown', function (event) {
            const dropdown = document.getElementById('notif-dropdown');
            const btn = document.getElementById('notif-toggle-btn');
            if (event.key === 'Escape' && dropdown && !dropdown.classList.contains('hidden')) {
                setOpen(false);
                if (btn) btn.focus();
            }
        });
    })();
</script>
@endonce
