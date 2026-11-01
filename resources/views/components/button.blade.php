@props([
    'variant' => 'primary', // 'primary', 'bright', 'secondary', or 'outline-pill'
    'href' => null,
    'type' => 'button',
])

@php
    $baseClass = "inline-flex items-center justify-center gap-2 min-h-[44px] text-sm font-semibold transition-colors duration-150 cursor-pointer focus-visible:outline focus-visible:outline-3 focus-visible:outline-offset-2 focus-visible:outline-desa-action";

    $variantClass = match ($variant) {
        'bright' => 'bg-desa-bright text-desa-dark border border-desa-border hover:bg-blue-400 rounded-lg px-5 py-2.5',
        'secondary' => 'bg-desa-soft text-desa-dark border border-desa-border hover:bg-desa-bright rounded-lg px-5 py-2.5',
        'outline-pill' => 'bg-white border-2 border-desa-action text-desa-dark hover:bg-desa-soft rounded-full px-5 py-2',
        default => 'bg-desa-action text-white border border-desa-dark hover:bg-desa-dark rounded-lg px-5 py-2.5 shadow-xs',
    };

    $classes = "$baseClass $variantClass";
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
