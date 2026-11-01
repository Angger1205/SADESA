@php
    $tab = [
        'kk' => ['Kartu Keluarga', route('admin.kependudukan.kk.index')],
        'warga' => ['Data Warga', route('admin.kependudukan.warga.index')],
    ];
@endphp

<div class="flex flex-wrap gap-2" role="navigation" aria-label="Menu Kependudukan">
    @foreach ($tab as $kode => [$label, $url])
        <a
            href="{{ $url }}"
            class="min-h-[44px] inline-flex items-center px-4 py-2 rounded-lg text-xs font-bold border-2 transition-colors {{ $aktif === $kode ? 'bg-desa-dark text-white border-desa-dark' : 'bg-white text-desa-dark border-desa-border hover:bg-desa-soft' }}"
        >
            {{ $label }}
        </a>
    @endforeach
</div>