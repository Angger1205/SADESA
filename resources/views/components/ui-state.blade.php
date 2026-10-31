@props([
    'type' => 'empty', // 'empty', 'loading', or 'error'
    'title' => null,
    'message' => null,
    'actionLabel' => null,
    'actionHref' => null,
])

@php
    $defaultTitle = match ($type) {
        'loading' => 'Sedang memuat data desa...',
        'error' => 'Gagal memuat data layanan',
        default => 'Belum ada data tercatat',
    };

    $defaultMessage = match ($type) {
        'loading' => 'Mohon tunggu sebentar, sistem sedang mengambil data terbaru dari basis data desa.',
        'error' => 'Terjadi kendala saat menghubungi basis data. Silakan muat ulang halaman atau hubungi perangkat desa.',
        default => 'Data pada bagian ini belum ditambahkan oleh perangkat desa.',
    };

    $containerStyles = match ($type) {
        'error' => 'bg-red-50 border-2 border-red-700 text-red-950',
        'loading' => 'bg-desa-soft/70 border-2 border-desa-border text-desa-dark',
        default => 'bg-white border-2 border-dashed border-desa-border text-desa-dark',
    };

    $roleAttr = $type === 'error' ? 'alert' : 'status';
@endphp

<div
    role="{{ $roleAttr }}"
    aria-live="{{ $type === 'error' ? 'assertive' : 'polite' }}"
    {{ $attributes->merge(['class' => "rounded-xl p-6 sm:p-8 text-center $containerStyles"]) }}
>
    <div class="mx-auto mb-3 w-12 h-12 rounded-full flex items-center justify-center {{ $type === 'error' ? 'bg-red-200 text-red-950 border border-red-700' : 'bg-desa-bright text-desa-dark border border-desa-border' }}">
        @if ($type === 'loading')
            <svg class="w-6 h-6 animate-spin" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3"></circle>
                <path class="opacity-90" fill="currentColor" d="M4 12a8 8 0 018-8v3a5 5 0 00-5 5H4z"></path>
            </svg>
        @elseif ($type === 'error')
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        @else
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
        @endif
    </div>

    <h3 class="text-base sm:text-lg font-bold">
        {{ $title ?? $defaultTitle }}
    </h3>

    <p class="mt-1.5 text-sm max-w-md mx-auto {{ $type === 'error' ? 'text-red-900' : 'text-desa-muted' }}">
        {{ $message ?? $defaultMessage }}
    </p>

    @if ($actionLabel && $actionHref)
        <div class="mt-5">
            <x-button :href="$actionHref" :variant="$type === 'error' ? 'outline-pill' : 'primary'">
                {{ $actionLabel }}
            </x-button>
        </div>
    @endif
</div>
