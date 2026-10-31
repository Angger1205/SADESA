<?php

namespace Database\Seeders;

use App\Models\Aparatur;
use App\Models\JenisSurat;
use App\Models\KartuKeluarga;
use App\Models\KategoriInformasi;
use App\Models\Panduan;
use App\Models\ProfilDesa;
use App\Models\User;
use App\Models\Warga;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Profil Desa (Sumber data Kop Surat & Halaman About)
        ProfilDesa::query()->delete();
        ProfilDesa::create([
            'nama_desa' => 'Pabelan',
            'kode_desa' => '33.11.12.2005',
            'kecamatan' => 'Kartasura',
            'kabupaten' => 'Sukoharjo',
            'provinsi' => 'Jawa Tengah',
            'kode_pos' => '57169',
            'alamat_kantor' => 'Jl. Ahmad Yani No. 12, Desa Pabelan, Kec. Kartasura',
            'email_desa' => 'pemdes@pabelan.desa.id',
            'telepon_desa' => '0271-780123',
            'website_url' => 'https://pabelan.desa.id',
            'logo_desa' => 'images/logo-desa-pabelan.png',
            'lambang_daerah' => 'images/lambang-kab-sukoharjo.png',
            'nama_kepala_desa' => 'Sujatno, S.Sos.',
            'nip_kepala_desa' => '19750512 200212 1 003',
            'sambutan_kades' => 'Selamat datang di Sistem Administrasi dan Informasi Desa (SADESA) Pemerintah Desa Pabelan. Layanan ini hadir untuk memberikan kemudahan pelayanan persuratan dan keterbukaan informasi bagi seluruh warga desa.',
            'sejarah' => 'Desa Pabelan terletak di Kecamatan Kartasura, Kabupaten Sukoharjo dan berkembang sebagai pusat pendidikan, perdagangan, serta pemukiman masyarakat yang dinamis.',
            'visi' => 'Terwujudnya tata kelola pemerintahan Desa Pabelan yang transparan, akuntabel, dan pelayanan masyarakat berbasis digital menuju desa yang mandiri dan sejahtera.',
            'misi' => "1. Meningkatkan pelayanan publik yang cepat, mudah, dan transparan.\n2. Mengembangkan sarana prasarana desa berbasis kebutuhan masyarakat.\n3. Memberdayakan ekonomi warga dan UMKM desa.",
            'gambaran_wilayah' => 'Desa Pabelan terletak di jalur strategis Kecamatan Kartasura, Kabupaten Sukoharjo.',
            'batas_utara' => 'Desa Gonilan',
            'batas_selatan' => 'Desa Makamhaji',
            'batas_timur' => 'Kota Surakarta',
            'batas_barat' => 'Desa Gumpang',
            'luas_wilayah' => '218,4 Hektar',
            'peta_embed' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15820.4!2d110.76!3d-7.55!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a145!2sPabelan!5e0!3m2!1sid!2sid!4v1700000000000" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
        ]);

        // 2. Aparatur Pemerintahan Desa
        $kadesAparatur = Aparatur::firstOrCreate(['nama' => 'Sujatno, S.Sos.'], [
            'jabatan' => 'Kepala Desa',
            'nip_niap' => '19750512 200212 1 003',
            'pendidikan_terakhir' => 'S1 Ilmu Administrasi Negara',
            'no_sk' => '141/05/SK/2021',
            'tupoksi' => 'Memimpin penyelenggaraan pemerintahan desa, pembinaan kemasyarakatan, dan pemberdayaan masyarakat desa.',
            'urutan' => 1,
            'status_aktif' => true,
        ]);

        Aparatur::firstOrCreate(['nama' => 'Bambang Irawan, S.Kom.'], [
            'jabatan' => 'Sekretaris Desa',
            'nip_niap' => '19820815 200903 1 005',
            'pendidikan_terakhir' => 'S1 Teknik Informatika',
            'no_sk' => '141/08/SK/2021',
            'tupoksi' => 'Membantu Kepala Desa dalam bidang administrasi pemerintahan dan pelayanan surat-menyurat kependudukan.',
            'urutan' => 2,
            'status_aktif' => true,
        ]);

        // 3. Master Kartu Keluarga & Warga
        $kk = KartuKeluarga::firstOrCreate(['no_kk' => '3311121505080001'], [
            'kepala_keluarga' => 'Budi Santoso',
            'alamat' => 'Jl. Ahmad Yani RT 02 RW 01 Dusun Pabelan',
            'dusun' => 'Dusun Pabelan',
            'rt' => '02',
            'rw' => '01',
            'kode_pos' => '57169',
        ]);

        $wargaBudi = Warga::firstOrCreate(['nik' => '3311121505850001'], [
            'kartu_keluarga_id' => $kk->id,
            'nama_lengkap' => 'Budi Santoso',
            'jenis_kelamin' => 'Laki-laki',
            'tempat_lahir' => 'Sukoharjo',
            'tanggal_lahir' => '1985-05-15',
            'agama' => 'Islam',
            'pendidikan_terakhir' => 'SMA/Sederajat',
            'pekerjaan' => 'Wiraswasta',
            'status_perkawinan' => 'Kawin',
            'status_hubungan_keluarga' => 'Kepala Keluarga',
            'status_warga' => 'Aktif',
            'no_hp' => '081234567890',
        ]);

        // 4. Akun Pengguna (Users)
        User::firstOrCreate(['email' => 'admin@sadesa.id'], [
            'name' => 'Administrator Desa',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::firstOrCreate(['email' => 'kades@sadesa.id'], [
            'name' => 'Sujatno, S.Sos. (Kades)',
            'password' => Hash::make('password'),
            'role' => 'kades',
        ]);

        User::firstOrCreate(['email' => 'budi@warga.id'], [
            'warga_id' => $wargaBudi->id,
            'name' => 'Budi Santoso',
            'password' => Hash::make('password'),
            'role' => 'warga',
        ]);

        // 5. Master Jenis Surat Layanan Warga (14 Jenis Surat - Anggota 2)
        $this->call(JenisSuratSeeder::class);

        // 6. Master Kategori Informasi
        $katBerita = KategoriInformasi::firstOrCreate(['slug' => 'berita-desa'], ['nama_kategori' => 'Berita Desa']);
        KategoriInformasi::firstOrCreate(['slug' => 'pengumuman'], ['nama_kategori' => 'Pengumuman Resmi']);
        KategoriInformasi::firstOrCreate(['slug' => 'pembangunan'], ['nama_kategori' => 'Transparansi Pembangunan']);
        KategoriInformasi::firstOrCreate(['slug' => 'kegiatan-warga'], ['nama_kategori' => 'Kegiatan Warga & Pemuda']);

        // 7. Modul Panduan & Tutorial
        Panduan::firstOrCreate(['slug' => 'panduan-pengajuan-surat-online'], [
            'judul' => 'Panduan Alur Pengajuan Surat Pengantar Online',
            'kategori' => 'pengajuan_surat',
            'ringkasan' => 'Langkah praktis mengajukan surat pengantar resmi tanpa harus antre lama di kantor desa.',
            'konten' => "1. Pastikan Anda telah memiliki akun warga dengan NIK yang terdaftar.\n2. Masuk (Login) ke Portal SADESA.\n3. Pilih menu 'Layanan Surat' -> 'Ajukan Surat Baru'.\n4. Pilih jenis surat yang dibutuhkan (misal: SKU, SKTM, Pengantar SKCK).\n5. Lengkapi formulir isian data tambahan dan unggah berkas syarat (KTP/KK).\n6. Klik tombol 'Kirim Pengajuan'. Pantau status surat di menu Riwayat Surat.\n7. Setelah disetujui admin/kades, surat dengan Kop Resmi dan QR Verifikasi dapat diunduh (PDF) atau diambil di kantor desa.",
            'urutan' => 1,
            'is_aktif' => true,
        ]);

        Panduan::firstOrCreate(['slug' => 'panduan-sampaikan-pengaduan-aspirasi'], [
            'judul' => 'Panduan Menyampaikan Pengaduan & Aspirasi Warga',
            'kategori' => 'pengaduan',
            'ringkasan' => 'Cara melaporkan keluhan infrastruktur, pelayanan publik, atau aspirasi warga secara transparan.',
            'konten' => "1. Buka halaman menu 'Pengaduan Warga' di website SADESA.\n2. Isi identitas pelapor, kategori masalah (Infrastruktur/Bansos/Pelayanan), judul, dan detail kronologi keluhan.\n3. Sertakan bukti foto/dokumen pendukung jika ada.\n4. Anda dapat memilih opsi 'Kirim sebagai Anonim' bila menghendaki identitas dirahasiakan dari publik.\n5. Simpan Kode Tiket Pengaduan untuk melacak tindak lanjut aparatur desa.",
            'urutan' => 2,
            'is_aktif' => true,
        ]);
    }
}
