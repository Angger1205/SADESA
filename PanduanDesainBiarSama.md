# Panduan Desain SADESA (Sistem Administrasi dan Informasi Desa)

Dokumen ini disusun sebagai pedoman desain antarmuka (UI/UX) bagi seluruh anggota tim pengembang SADESA (Anggota 1 sampai 6) agar seluruh modul yang dibuat memiliki tampilan yang seragam, rapi, profesional, dan nyaman digunakan oleh warga maupun perangkat desa.

---

## 1. Identitas Visual & Tema Warna (Civic Blue)

Aplikasi SADESA menggunakan palet tema **Biru Pemerintahan (Civic Blue)** yang sudah terkonfigurasi di Tailwind CSS dan file `public/css/sadesa.css`. 

Hindari menggunakan warna abu-abu generik (*slate/gray*) secara acak. Gunakan token warna semantik resmi berikut:

| Token Tailwind | Kode Hex | Penggunaan Utama |
|---|---|---|
| `bg-desa-dark` / `text-desa-dark` | `#172554` | Teks judul utama, isi teks tebal, header tabel, tombol dark |
| `bg-desa-muted` / `text-desa-muted` | `#1E3A8A` | Teks sekunder, label pembantu, catatan kaki, tanggal |
| `bg-desa-action` / `text-desa-action` | `#1D4ED8` | Aksen tindakan utama (tombol submit, tautan aktif, border fokus) |
| `bg-desa-border` / `border-desa-border` | `#2563EB` | Garis tepi input form, border tabel, pembatas kartu |
| `bg-desa-bright` | `#93C5FD` | Background badge sorotan, lingkaran ikon, footer publik |
| `bg-desa-soft` | `#DBEAFE` | Background navbar atas, strip judul kartu, header tabel |
| `bg-desa-mist` | `#EFF6FF` | Background dasar halaman (body canvas) yang teduh |

---

## 2. Tipografi Resmi

1. **Antarmuka Web**: `Instrument Sans` (sudah otomatis dimuat di `<x-app-layout>` dan `<x-admin-layout>`).
2. **Dokumen Cetak Surat Resmi (Kop & Narasi Naskah Dinas)**: `Times New Roman` (standar tata naskah dinas instansi desa).

---

## 3. Komponen Blade Siap Pakai

Semua halaman modul diharapkan memanfaatkan komponen Blade yang sudah disediakan di folder `resources/views/components/`:

### A. Layout Halaman Publik & Warga (`<x-app-layout>`)
Digunakan untuk halaman portal warga (Layanan Surat, Pengaduan, Profil Desa, Informasi Berita).
```blade
<x-app-layout :title="'Judul Halaman Anda'" activeNav="surat">
    <!-- Konten halaman Anda di sini -->
</x-app-layout>
```
*Pilihan nilai `activeNav`: `'beranda'`, `'profil'`, `'informasi'`, `'surat'`, `'pengaduan'`, `'panduan'*

### B. Layout Halaman Admin & Aparatur (`<x-admin-layout>`)
Digunakan untuk seluruh panel kerja admin/perangkat desa (Kependudukan, Verifikasi Surat, Tanggapan Aduan, Manajemen Berita).
```blade
<x-admin-layout :title="'Verifikasi Pengaduan Warga'" activeMenu="pengaduan">
    <!-- Konten panel admin di sini -->
</x-admin-layout>
```
*Pilihan nilai `activeMenu`: `'surat'`, `'jenis-surat'`, `'kk'`, `'warga'`, `'user'`, `'pengaduan'`, `'berita'`, `'profil'`, `'panduan'*

### C. Pembungkus Bagian Halaman (`<x-section-wrapper>`)
Memberikan padding responsif dan batas lebar kontainer `max-w-7xl mx-auto` yang seragam.
```blade
<x-section-wrapper bgVariant="mist">
    <!-- bgVariant yang tersedia: 'mist' (#EFF6FF), 'white' (#FFFFFF), 'soft' (#DBEAFE), 'dark' (#172554) -->
    <div class="space-y-6">
        <!-- Isi konten -->
    </div>
</x-section-wrapper>
```

### D. Tombol Aksi Standar (`<x-button>`)
Memastikan tinggi sentuh minimal 44px ramah perangkat seluler dan efek fokus keyboard yang jelas.
```blade
<!-- Tombol Aksi Utama (Biru Action) -->
<x-button variant="primary" type="submit">
    Simpan Data
</x-button>

<!-- Tombol Tautan Menuju Halaman Lain -->
<x-button variant="primary" href="{{ route('warga.surat.create') }}">
    + Tambah Data Baru
</x-button>

<!-- Tombol Sekunder / Batal -->
<x-button variant="secondary" href="{{ url()->previous() }}">
    Kembali
</x-button>

<!-- Tombol Outline Pill -->
<x-button variant="outline-pill" href="{{ route('home') }}">
    Lihat Panduan
</x-button>
```

### E. Tampilan Status / State Kosong / Error (`<x-ui-state>`)
Gunakan saat tabel kosong, data belum ada, atau ada kendala koneksi.
```blade
<x-ui-state
    type="empty"
    title="Belum ada data warga terdaftar"
    message="Silakan tambahkan data Kartu Keluarga atau Penduduk baru melalui formulir."
    actionLabel="Tambah Warga Baru"
    :actionHref="route('admin.kependudukan.warga.create')"
/>
```

---

## 4. Standar Styling Input Formulir & Tabel

### A. Format Input Form yang Konsisten
Gunakan border tebal 2px dengan token `border-desa-border`, latar `bg-desa-mist`, tinggi minimal 44px, dan teks `text-desa-dark`:
```blade
<div>
    <label for="nama_lengkap" class="block text-xs font-bold text-desa-dark mb-1">
        Nama Lengkap Sesuai KTP-el <span class="text-red-600">*</span>
    </label>
    <input
        type="text"
        id="nama_lengkap"
        name="nama_lengkap"
        value="{{ old('nama_lengkap') }}"
        required
        class="w-full min-h-[44px] px-3.5 py-2 rounded-lg bg-desa-mist border-2 border-desa-border text-sm text-desa-dark focus:outline-none focus:ring-2 focus:ring-desa-action"
        placeholder="Contoh: Budi Santoso"
    />
    @error('nama_lengkap')
        <p class="text-xs font-bold text-red-600 mt-1">{{ $message }}</p>
    @enderror
</div>
```

### B. Format Tabel Data yang Konsisten
Tabel diletakkan di dalam kontainer kartu putih dengan border tebal:
```blade
<div class="bg-white rounded-2xl border-2 border-desa-border overflow-hidden shadow-xs">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-desa-soft border-b-2 border-desa-border text-xs font-extrabold text-desa-dark">
                    <th class="py-3.5 px-4">No</th>
                    <th class="py-3.5 px-4">Nama Lengkap</th>
                    <th class="py-3.5 px-4">NIK</th>
                    <th class="py-3.5 px-4">Status</th>
                    <th class="py-3.5 px-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-blue-200 text-sm">
                <tr class="hover:bg-desa-mist/70 transition-colors">
                    <td class="py-3.5 px-4 font-mono">1</td>
                    <td class="py-3.5 px-4 font-bold text-desa-dark">Budi Santoso</td>
                    <td class="py-3.5 px-4 font-mono text-desa-muted">3302141505850001</td>
                    <td class="py-3.5 px-4">
                        <span class="inline-flex px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-950 border border-emerald-700">
                            Aktif
                        </span>
                    </td>
                    <td class="py-3.5 px-4 text-right">
                        <a href="#" class="px-3 py-1.5 rounded-lg bg-desa-soft text-desa-dark border border-desa-border text-xs font-bold hover:bg-desa-bright">
                            Detail
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
```

---

## 5. Ringkasan Prinsip Kualitas (Checklist Sebelum Commit)

1. **Kontras Teks Terjaga**: Jangan menaruh teks putih di atas latar terang. Teks di atas warna terang (`desa-mist`, `desa-soft`, `desa-bright`, `white`) harus selalu memakai `text-desa-dark` (`#172554`) atau `text-desa-muted` (`#1E3A8A`).
2. **Ukuran Target Sentuh (Mobile Friendly)**: Semua tombol (`<button>`, `<a>`, `<input>`) wajib memiliki tinggi minimal `44px` (`min-h-[44px]`).
3. **Pesan Validasi Bersih**: Tangani error form dengan pesan ramah bahasa Indonesia. Jangan biarkan pesan error SQL atau kode error teknis mentah tampil ke warga.
4. **Gunakan Tanda Baca Baku**: Gunakan tanda strip biasa `-` atau titik tengah `•` untuk pemisah teks (hindari karakter em dash panjang).
5. **Keseragaman Layout**: Gunakan `<x-app-layout>` untuk portal warga dan `<x-admin-layout>` untuk panel aparatur desa agar navigasi dan tata letak tidak berantakan.
