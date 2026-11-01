@props([
    'title' => 'Dashboard Pelayanan Desa',
    'activeMenu' => 'surat',
])

@php
    $user = auth()->user();
    if (! $user || ! $user->isAdmin()) {
        abort(403, 'Akses ditolak. Panel pelayanan surat ini khusus untuk Admin / Perangkat Desa / Kepala Desa.');
    }

    $namaPetugas = $user->name;
    $emailPetugas = $user->email;
    $kodeRole = $user->role;

    $roleLabel = match ($kodeRole) {
        'kades' => 'Kepala Desa Pabelan',
        'sekdes' => 'Sekretaris Desa Pabelan',
        'staf' => 'Staf Pelayanan Administrasi',
        'warga' => 'Warga Desa',
        default => 'Administrator Sistem Desa Pabelan',
    };

    $activeNavMap = match ($activeMenu) {
        'surat', 'jenis-surat' => 'surat',
        'pengaduan' => 'pengaduan',
        'berita', 'agenda', 'galeri' => 'informasi',
        'profil', 'aparatur' => 'profil',
        'panduan' => 'panduan',
        default => 'surat',
    };
@endphp

<x-app-layout :title="$title . ' - Panel Aparatur & Kepala Desa'" :activeNav="$activeNavMap">
    <x-section-wrapper bgVariant="mist">
        <!-- Header Halaman Seragam dengan Template Warga -->
        <div class="flex flex-wrap items-end justify-between gap-4 mb-6">
            <div>
                <span class="inline-block px-3 py-1 rounded-md bg-desa-soft text-desa-dark border border-desa-border text-xs font-bold mb-2">
                    Panel Aparatur &amp; Kepala Desa &bull; Desa Pabelan
                </span>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-desa-dark tracking-tight">
                    {{ $title }}
                </h1>
                <p class="text-sm text-desa-muted mt-1">
                    Kelola verifikasi permohonan surat warga, pengesahan tanda tangan elektronik QR Code, serta pengaturan master layanan Desa Pabelan.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-2.5">
                @if ($activeMenu !== 'surat')
                    <x-button variant="primary" href="{{ route('admin.surat.index') }}">
                        Antrean E-Surat
                    </x-button>
                @else
                    <x-button variant="primary" href="{{ route('admin.surat.jenis') }}">
                        Master 14 Jenis Surat
                    </x-button>
                @endif
            </div>
        </div>

        <!-- Kartu Identitas Pejabat / Admin / Kepala Desa (Seragam dengan Kartu Pemohon di Warga) -->
        <div class="mb-6 bg-white rounded-2xl border-2 border-desa-border p-4 sm:p-5 flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="w-12 h-12 rounded-xl bg-desa-dark text-white font-bold text-base flex items-center justify-center shrink-0">
                    {{ strtoupper(substr($namaPetugas, 0, 2)) }}
                </div>
                <div>
                    <p class="text-xs font-bold text-desa-action">Pejabat / Aparatur Pemeriksa Aktif</p>
                    <h2 class="text-base sm:text-lg font-extrabold text-desa-dark">{{ $namaPetugas }}</h2>
                    <p class="text-xs font-mono text-desa-muted">
                        Jabatan: {{ $roleLabel }} &bull; Akun: {{ $emailPetugas }}
                    </p>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-2.5 text-xs">
                <span class="px-3 py-1.5 rounded-lg bg-desa-soft text-desa-dark border border-desa-border font-bold">
                    Hak Akses: {{ strtoupper($kodeRole) }}
                </span>
            </div>
        </div>

        <!-- Bar Navigasi Antar-Modul Admin & Kepala Desa (Seragam dengan Bar Filter Pill di Warga) -->
        <div class="flex flex-wrap items-center gap-2 mb-6" role="navigation" aria-label="Menu Modul Panel Aparatur">
            <a
                href="{{ route('admin.surat.index') }}"
                class="min-h-[44px] inline-flex items-center gap-2 px-4 py-2 rounded-lg text-xs font-bold border-2 transition-colors {{ $activeMenu === 'surat' ? 'bg-desa-dark text-white border-desa-dark' : 'bg-white text-desa-dark border-desa-border hover:bg-desa-soft' }}"
            >
                <span>Antrean E-Surat</span>
                <span class="px-2 py-0.5 rounded bg-desa-soft text-desa-dark font-mono">Anggota 2</span>
            </a>

            <a
                href="{{ route('admin.surat.jenis') }}"
                class="min-h-[44px] inline-flex items-center gap-2 px-4 py-2 rounded-lg text-xs font-bold border-2 transition-colors {{ $activeMenu === 'jenis-surat' ? 'bg-desa-action text-white border-desa-dark' : 'bg-white text-desa-dark border-desa-border hover:bg-desa-soft' }}"
            >
                <span>Master 14 Jenis Surat</span>
                <span class="px-2 py-0.5 rounded bg-desa-soft text-desa-dark font-mono">CRUD</span>
            </a>

            <a
                href="{{ route('admin.kependudukan.kk.index') }}"
                class="min-h-[44px] inline-flex items-center gap-2 px-4 py-2 rounded-lg text-xs font-bold border-2 transition-colors {{ in_array($activeMenu, ['kk', 'warga', 'user']) ? 'bg-desa-dark text-white border-desa-dark' : 'bg-white text-desa-dark border-desa-border hover:bg-desa-soft' }}"
            >
                <span>Kependudukan &amp; Akun</span>
            </a>

            <a
                href="{{ route('admin.pengaduan.index') }}"
                class="min-h-[44px] inline-flex items-center gap-2 px-4 py-2 rounded-lg text-xs font-bold border-2 transition-colors {{ $activeMenu === 'pengaduan' ? 'bg-desa-dark text-white border-desa-dark' : 'bg-white text-desa-dark border-desa-border hover:bg-desa-soft' }}"
            >
                <span>Pengaduan Warga</span>
            </a>

            <a
                href="{{ route('admin.informasi.berita.index') }}"
                class="min-h-[44px] inline-flex items-center gap-2 px-4 py-2 rounded-lg text-xs font-bold border-2 transition-colors {{ in_array($activeMenu, ['berita', 'agenda', 'galeri']) ? 'bg-desa-dark text-white border-desa-dark' : 'bg-white text-desa-dark border-desa-border hover:bg-desa-soft' }}"
            >
                <span>Informasi &amp; Kegiatan</span>
            </a>

            <a
                href="{{ route('admin.profil.edit') }}"
                class="min-h-[44px] inline-flex items-center gap-2 px-4 py-2 rounded-lg text-xs font-bold border-2 transition-colors {{ in_array($activeMenu, ['profil', 'aparatur']) ? 'bg-desa-dark text-white border-desa-dark' : 'bg-white text-desa-dark border-desa-border hover:bg-desa-soft' }}"
            >
                <span>Profil &amp; Aparatur Desa</span>
            </a>

            <a
                href="{{ route('admin.panduan.index') }}"
                class="min-h-[44px] inline-flex items-center gap-2 px-4 py-2 rounded-lg text-xs font-bold border-2 transition-colors {{ $activeMenu === 'panduan' ? 'bg-desa-dark text-white border-desa-dark' : 'bg-white text-desa-dark border-desa-border hover:bg-desa-soft' }}"
            >
                <span>Panduan Layanan</span>
            </a>
        </div>

        <!-- Konten Utama Halaman Admin / Kepala Desa -->
        <div>
            {{ $slot }}
        </div>
    </x-section-wrapper>
</x-app-layout>
