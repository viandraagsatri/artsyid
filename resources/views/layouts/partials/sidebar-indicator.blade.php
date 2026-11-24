@php
    $isDanger = ($variant ?? 'amber') === 'rose';
    $pingClass = $isDanger ? 'bg-rose-400' : 'bg-amber-400';
    $dotClass = $isDanger ? 'bg-rose-600' : 'bg-amber-600';
@endphp

<span data-sidebar-indicator="{{ $key }}"
    role="img"
    class="relative flex h-2.5 w-2.5 shrink-0"
    title="{{ $label }}"
    aria-label="{{ $label }}">
    <span aria-hidden="true"
        class="animate-ping motion-reduce:animate-none absolute inline-flex h-full w-full rounded-full {{ $pingClass }} opacity-75"></span>
    <span aria-hidden="true"
        class="relative inline-flex rounded-full h-2.5 w-2.5 {{ $dotClass }}"></span>
</span>
