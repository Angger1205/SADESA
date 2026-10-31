@props([
    'bgVariant' => 'mist', // 'mist' (#EFF6FF), 'soft' (#DBEAFE), 'white' (#FFFFFF), or 'dark' (#172554)
    'id' => null,
])

@php
    $bgClass = match ($bgVariant) {
        'soft' => 'bg-desa-soft text-desa-dark',
        'white' => 'bg-white text-desa-dark',
        'dark' => 'bg-desa-dark text-white',
        default => 'bg-desa-mist text-desa-dark',
    };
@endphp

<section @if($id) id="{{ $id }}" @endif {{ $attributes->merge(['class' => "w-full $bgClass"]) }}>
    <div class="py-10 sm:py-14 lg:py-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        {{ $slot }}
    </div>
</section>
