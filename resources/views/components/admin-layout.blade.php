@props([
    'title' => 'Dashboard Pelayanan Desa',
    'activeMenu' => 'surat',
    'subtitle' => null,
])

@php
    $user = auth()->user();
    if (! $user || ! $user->isAdmin()) {
        abort(403, 'Akses ditolak. Panel pelayanan surat ini khusus untuk Admin / Perangkat Desa / Kepala Desa.');
    }

    $activeNavMap = match ($activeMenu) {
        'surat', 'jenis-surat' => 'surat',
        'kk', 'warga', 'user', 'kependudukan' => 'kependudukan',
        'pengaduan' => 'pengaduan',
        'berita', 'agenda', 'galeri', 'informasi' => 'informasi',
        'profil', 'aparatur' => 'profil',
        'panduan' => 'panduan',
        default => 'dashboard',
    };
@endphp

<x-app-layout :title="$title . ' - Panel Aparatur & Kepala Desa'" :activeNav="$activeNavMap">
    <x-section-wrapper bgVariant="mist">
        <!-- Header Halaman Bersih & Rapi -->
        <div class="mb-6">
            <span class="inline-block px-3 py-1 rounded-md bg-desa-soft text-desa-dark border border-desa-border text-xs font-bold mb-2">
                Panel Aparatur &amp; Kepala Desa &bull; Desa Pabelan
            </span>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-desa-dark tracking-tight">
                {{ $title }}
            </h1>
            <p class="text-sm text-desa-muted mt-1">
                {{ $subtitle ?? 'Panel administrasi dan pelayanan terpadu Pemerintah Desa Pabelan.' }}
            </p>
        </div>

        <!-- Konten Utama Halaman Admin / Kepala Desa -->
        <div>
            {{ $slot }}
        </div>
    </x-section-wrapper>
</x-app-layout>
