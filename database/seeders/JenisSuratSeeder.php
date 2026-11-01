<?php

namespace Database\Seeders;

use App\Models\JenisSurat;
use Illuminate\Database\Seeder;

class JenisSuratSeeder extends Seeder
{
    public function run(): void
    {
        $daftarSurat = [
            // =========================================================================
            // KATEGORI A: KEPENDUDUKAN & CATATAN SIPIL
            // =========================================================================
            [
                'kategori' => 'Kategori A: Kependudukan & Catatan Sipil',
                'kode_surat' => '470',
                'nama_surat' => 'Surat Keterangan Domisili',
                'format_nomor' => '470/{NOMOR}/DS-PBL/{BULAN}/{TAHUN}',
                'deskripsi_kegunaan' => 'Bukti tempat tinggal warga lokal/pendatang (bank, sekolah, kerja).',
                'syarat_tambahan' => [
                    ['name' => 'pas_foto', 'label' => 'Pas foto 3x4 atau 4x6', 'required' => true],
                    ['name' => 'surat_kuasa', 'label' => 'Surat kuasa bermaterai (jika diwakilkan)', 'required' => false],
                    ['name' => 'bukti_sewa_kontrak', 'label' => 'Bukti sewa/kontrak atau surat pernyataan pemilik kos/rumah (khusus pendatang)', 'required' => false],
                ],
                'form_input_tambahan' => [
                    ['name' => 'status_tempat_tinggal', 'label' => 'Status Tempat Tinggal', 'type' => 'select', 'options' => ['Milik Sendiri', 'Menumpang Orang Tua/Keluarga', 'Sewa / Kontrak / Kos'], 'required' => true],
                    ['name' => 'alamat_domisili_sekarang', 'label' => 'Alamat Domisili Sekarang', 'type' => 'textarea', 'placeholder' => 'Jl. ... RT/RW ... Dusun ...', 'required' => true],
                    ['name' => 'sejak_tanggal', 'label' => 'Menetap Sejak Tanggal', 'type' => 'date', 'required' => true],
                ],
                'template_narasi' => 'Bahwa yang bersangkutan di atas adalah benar-benar bertempat tinggal dan berdomisili di wilayah Desa Pabelan sesuai keterangan pada data isian di bawah ini.',
            ],
            [
                'kategori' => 'Kategori A: Kependudukan & Catatan Sipil',
                'kode_surat' => '472.11',
                'nama_surat' => 'Surat Keterangan Kelahiran',
                'format_nomor' => '472.11/{NOMOR}/DS-PBL/{BULAN}/{TAHUN}',
                'deskripsi_kegunaan' => 'Pengantar pembuatan Akta Kelahiran dan penambahan anggota di KK.',
                'syarat_tambahan' => [
                    ['name' => 'surat_lahir_bidan_rs', 'label' => 'Surat Keterangan Lahir asli dari Bidan/RS', 'required' => true],
                    ['name' => 'buku_nikah_ortu', 'label' => 'Fotokopi Buku Nikah / Akta Perkawinan orang tua', 'required' => true],
                    ['name' => 'ktp_kedua_ortu', 'label' => 'Fotokopi KTP kedua orang tua', 'required' => true],
                    ['name' => 'ktp_dua_saksi', 'label' => 'Fotokopi KTP 2 orang saksi', 'required' => true],
                ],
                'form_input_tambahan' => [
                    ['name' => 'nama_bayi', 'label' => 'Nama Lengkap Bayi', 'type' => 'text', 'required' => true],
                    ['name' => 'jenis_kelamin_bayi', 'label' => 'Jenis Kelamin Bayi', 'type' => 'select', 'options' => ['Laki-laki', 'Perempuan'], 'required' => true],
                    ['name' => 'tempat_lahir_bayi', 'label' => 'Tempat Kelahiran (RS/Puskesmas/Bidan)', 'type' => 'text', 'required' => true],
                    ['name' => 'tanggal_jam_lahir', 'label' => 'Tanggal & Jam Kelahiran', 'type' => 'text', 'placeholder' => 'Contoh: 12 Oktober 2026 Pukul 08.30 WIB', 'required' => true],
                    ['name' => 'nama_ayah', 'label' => 'Nama Lengkap Ayah Kandung', 'type' => 'text', 'required' => true],
                    ['name' => 'nama_ibu', 'label' => 'Nama Lengkap Ibu Kandung', 'type' => 'text', 'required' => true],
                    ['name' => 'anak_ke', 'label' => 'Anak Ke-', 'type' => 'number', 'required' => true],
                ],
                'template_narasi' => 'Bahwa telah lahir seorang anak dari pasangan suami-istri warga Desa Pabelan dengan rincian data kelahiran sebagai berikut.',
            ],
            [
                'kategori' => 'Kategori A: Kependudukan & Catatan Sipil',
                'kode_surat' => '472.12',
                'nama_surat' => 'Surat Keterangan Kematian',
                'format_nomor' => '472.12/{NOMOR}/DS-PBL/{BULAN}/{TAHUN}',
                'deskripsi_kegunaan' => 'Pengantar pembuatan Akta Kematian dan pembaruan KK/KTP pasangan.',
                'syarat_tambahan' => [
                    ['name' => 'surat_kematian_rs', 'label' => 'Surat Keterangan Kematian dari RS/Dokter atau Surat Pernyataan Kematian dari keluarga', 'required' => true],
                    ['name' => 'ktp_kk_almarhum', 'label' => 'KTP dan KK asli almarhum/almarhumah', 'required' => true],
                    ['name' => 'ktp_pelapor_saksi', 'label' => 'Fotokopi KTP pelapor dan 2 orang saksi', 'required' => true],
                ],
                'form_input_tambahan' => [
                    ['name' => 'nama_almarhum', 'label' => 'Nama Lengkap Almarhum / Almarhumah', 'type' => 'text', 'required' => true],
                    ['name' => 'nik_almarhum', 'label' => 'NIK Almarhum / Almarhumah', 'type' => 'text', 'required' => true],
                    ['name' => 'tanggal_meninggal', 'label' => 'Tanggal Meninggal Dunia', 'type' => 'date', 'required' => true],
                    ['name' => 'jam_meninggal', 'label' => 'Pukul / Jam Meninggal', 'type' => 'text', 'placeholder' => 'Contoh: 14.15 WIB', 'required' => true],
                    ['name' => 'tempat_meninggal', 'label' => 'Tempat Meninggal Dunia', 'type' => 'text', 'required' => true],
                    ['name' => 'penyebab_kematian', 'label' => 'Penyebab Kematian', 'type' => 'text', 'required' => true],
                    ['name' => 'hubungan_pelapor', 'label' => 'Hubungan Pelapor dengan Almarhum', 'type' => 'text', 'required' => true],
                ],
                'template_narasi' => 'Bahwa warga yang tersebut di bawah ini telah meninggal dunia sesuai laporan keluarga dan pemeriksaan berkas administrasi kependudukan desa.',
            ],
            [
                'kategori' => 'Kategori A: Kependudukan & Catatan Sipil',
                'kode_surat' => '475',
                'nama_surat' => 'Surat Pengantar Pindah (SKPWNI)',
                'format_nomor' => '475/{NOMOR}/DS-PBL/{BULAN}/{TAHUN}',
                'deskripsi_kegunaan' => 'Mengurus kepindahan domisili antar-desa, kecamatan, atau kabupaten/kota.',
                'syarat_tambahan' => [
                    ['name' => 'kk_tujuan', 'label' => 'Fotokopi KK tempat tujuan (jika menumpang KK)', 'required' => false],
                    ['name' => 'pas_foto_3x4', 'label' => 'Pas foto 3x4', 'required' => true],
                ],
                'form_input_tambahan' => [
                    ['name' => 'alamat_tujuan_lengkap', 'label' => 'Alamat Tujuan Lengkap (RT/RW, Desa, Kecamatan, Kab/Kota, Kode Pos)', 'type' => 'textarea', 'required' => true],
                    ['name' => 'alasan_pindah', 'label' => 'Alasan Kepindahan', 'type' => 'select', 'options' => ['Pekerjaan', 'Pendidikan', ' Mengikuti Suami/Istri', 'Perumahan Baru', 'Keluarga / Lainnya'], 'required' => true],
                    ['name' => 'jumlah_pengikut_pindah', 'label' => 'Jumlah Anggota Keluarga yang Ikut Pindah (Orang)', 'type' => 'number', 'required' => true],
                ],
                'template_narasi' => 'Bahwa warga tersebut di atas mengajukan permohonan pindah tempat tinggal (SKPWNI) dengan rincian alamat tujuan dan jumlah pengikut sebagai berikut.',
            ],

            // =========================================================================
            // KATEGORI B: SOSIAL, EKONOMI & PEKERJAAN
            // =========================================================================
            [
                'kategori' => 'Kategori B: Sosial, Ekonomi & Pekerjaan',
                'kode_surat' => '401',
                'nama_surat' => 'Surat Keterangan Tidak Mampu (SKTM)',
                'format_nomor' => '401/{NOMOR}/DS-PBL/{BULAN}/{TAHUN}',
                'deskripsi_kegunaan' => 'Pengajuan beasiswa (KIP Kuliah/Sekolah), keringanan biaya RS, atau bansos.',
                'syarat_tambahan' => [
                    ['name' => 'pernyataan_tidak_mampu', 'label' => 'Surat Pernyataan Tidak Mampu diketahui RT/RW (bermaterai Rp10.000)', 'required' => true],
                    ['name' => 'foto_kondisi_rumah', 'label' => 'Foto kondisi rumah (tampak depan, ruang tamu, dapur)', 'required' => true],
                    ['name' => 'slip_penghasilan_ortu', 'label' => 'Rincian/slip penghasilan orang tua (jika untuk pendidikan)', 'required' => false],
                ],
                'form_input_tambahan' => [
                    ['name' => 'peruntukan_sktm', 'label' => 'Peruntukan SKTM', 'type' => 'select', 'options' => ['Beasiswa Pendidikan / KIP Kuliah', 'Keringanan Biaya Rumah Sakit / Kesehatan', 'Pengajuan Bantuan Sosial'], 'required' => true],
                    ['name' => 'nama_tujuan_instansi', 'label' => 'Nama Sekolah / Universitas / Rumah Sakit / Instansi Tujuan', 'type' => 'text', 'required' => true],
                    ['name' => 'penghasilan_rata_rata', 'label' => 'Penghasilan Rata-rata Keluarga per Bulan (Rp)', 'type' => 'text', 'placeholder' => 'Contoh: Rp 1.200.000', 'required' => true],
                ],
                'template_narasi' => 'Bahwa nama yang tersebut di atas adalah benar warga Desa Pabelan yang tergolong keluarga kurang mampu / prasejahtera dan membutuhkan surat keterangan ini untuk keperluan berikut.',
            ],
            [
                'kategori' => 'Kategori B: Sosial, Ekonomi & Pekerjaan',
                'kode_surat' => '503',
                'nama_surat' => 'Surat Keterangan Usaha (SKU)',
                'format_nomor' => '503/{NOMOR}/DS-PBL/{BULAN}/{TAHUN}',
                'deskripsi_kegunaan' => 'Syarat pengajuan kredit bank (KUR), pembukaan rekening bisnis, atau pengurusan NIB.',
                'syarat_tambahan' => [
                    ['name' => 'foto_tempat_usaha', 'label' => 'Foto lokasi/tempat usaha (pemohon terlihat di depan tempat usaha)', 'required' => true],
                    ['name' => 'pernyataan_memiliki_usaha', 'label' => 'Surat Pernyataan Memiliki Usaha bermaterai Rp10.000', 'required' => true],
                    ['name' => 'bukti_pbb_sewa', 'label' => 'Bukti lunas PBB atau surat sewa tempat', 'required' => true],
                ],
                'form_input_tambahan' => [
                    ['name' => 'nama_usaha', 'label' => 'Nama Usaha / Toko / UMKM', 'type' => 'text', 'required' => true],
                    ['name' => 'jenis_bidang_usaha', 'label' => 'Jenis / Bidang Usaha', 'type' => 'text', 'placeholder' => 'Contoh: Perdagangan Sembako / Kuliner / Pertanian', 'required' => true],
                    ['name' => 'alamat_lokasi_usaha', 'label' => 'Alamat Lengkap Lokasi Usaha', 'type' => 'textarea', 'required' => true],
                    ['name' => 'lama_usaha_berdiri', 'label' => 'Lama Usaha Berdiri / Sejak Tahun', 'type' => 'text', 'placeholder' => 'Contoh: 4 Tahun (Sejak 2022)', 'required' => true],
                ],
                'template_narasi' => 'Bahwa yang bersangkutan benar-benar memiliki dan menjalankan kegiatan usaha mandiri di wilayah Desa Pabelan dengan rincian usaha sebagai berikut.',
            ],
            [
                'kategori' => 'Kategori B: Sosial, Ekonomi & Pekerjaan',
                'kode_surat' => '402',
                'nama_surat' => 'Surat Keterangan Penghasilan',
                'format_nomor' => '402/{NOMOR}/DS-PBL/{BULAN}/{TAHUN}',
                'deskripsi_kegunaan' => 'Syarat daftar kuliah/beasiswa anak atau pengajuan kredit pekerja informal.',
                'syarat_tambahan' => [
                    ['name' => 'bukti_atau_pernyataan_penghasilan', 'label' => 'Slip gaji resmi ATAU Surat Pernyataan Penghasilan rata-rata bulanan bermaterai Rp10.000', 'required' => true],
                ],
                'form_input_tambahan' => [
                    ['name' => 'pekerjaan_saat_ini', 'label' => 'Pekerjaan / Profesi Saat Ini', 'type' => 'text', 'required' => true],
                    ['name' => 'nominal_penghasilan_bulanan', 'label' => 'Nominal Penghasilan Rata-rata Bulanan (Rp)', 'type' => 'text', 'placeholder' => 'Contoh: Rp 2.500.000', 'required' => true],
                    ['name' => 'nama_anak_atau_tanggungan', 'label' => 'Nama Anak / Tanggungan yang Diajukan', 'type' => 'text', 'required' => true],
                ],
                'template_narasi' => 'Bahwa berdasarkan pernyataan pemohon dan keterangan lingkungan setempat, yang bersangkutan memiliki penghasilan rata-rata bulanan sebagaimana tercantum di bawah ini.',
            ],
            [
                'kategori' => 'Kategori B: Sosial, Ekonomi & Pekerjaan',
                'kode_surat' => '331',
                'nama_surat' => 'Surat Pengantar SKCK',
                'format_nomor' => '331/{NOMOR}/DS-PBL/{BULAN}/{TAHUN}',
                'deskripsi_kegunaan' => 'Pengantar ke Polsek/Polres untuk membuat SKCK (melamar kerja, CPNS, sekolah kedinasan).',
                'syarat_tambahan' => [
                    ['name' => 'akta_atau_ijazah', 'label' => 'Fotokopi Akta Kelahiran atau Ijazah terakhir', 'required' => true],
                    ['name' => 'pas_foto_merah_4x6', 'label' => 'Pas foto 4x6 latar belakang merah (berpakaian rapi/berkerah)', 'required' => true],
                ],
                'form_input_tambahan' => [
                    ['name' => 'keperluan_skck', 'label' => 'Keperluan Pembuatan SKCK', 'type' => 'text', 'placeholder' => 'Contoh: Melamar Pekerjaan / Pemberkasan CPNS', 'required' => true],
                    ['name' => 'polsek_polres_tujuan', 'label' => 'Polsek / Polres Tujuan', 'type' => 'text', 'placeholder' => 'Contoh: Polsek Kartasura / Polres Sukoharjo', 'required' => true],
                ],
                'template_narasi' => 'Sepanjang pengetahuan kami dan catatan pemerintahan desa, warga tersebut di atas berkelakuan baik, tidak pernah tersangkut perkara pidana, dan surat pengantar ini diterbitkan untuk pengurusan SKCK pada kepolisian.',
            ],

            // =========================================================================
            // KATEGORI C: PERNIKAHAN & KELUARGA
            // =========================================================================
            [
                'kategori' => 'Kategori C: Pernikahan & Keluarga',
                'kode_surat' => '474.2',
                'nama_surat' => 'Surat Pengantar Nikah (Model N1, N2, N4)',
                'format_nomor' => '474.2/{NOMOR}/DS-PBL/{BULAN}/{TAHUN}',
                'deskripsi_kegunaan' => 'Syarat pendaftaran pernikahan ke KUA (Muslim) atau Dinas Dukcapil (Non-Muslim).',
                'syarat_tambahan' => [
                    ['name' => 'ktp_kk_ortu', 'label' => 'Fotokopi KTP dan KK kedua orang tua calon pengantin', 'required' => true],
                    ['name' => 'akta_ijazah_catin', 'label' => 'Fotokopi Akta Kelahiran dan Ijazah terakhir calon pengantin', 'required' => true],
                    ['name' => 'pas_foto_biru', 'label' => 'Pas foto latar biru (2x3 dan 4x6)', 'required' => true],
                    ['name' => 'akta_cerai_kematian', 'label' => 'Akta Cerai asli / Surat Kematian pasangan terdahulu (jika duda/janda)', 'required' => false],
                    ['name' => 'rekomendasi_kua_asal', 'label' => 'Surat Rekomendasi Nikah KUA asal (jika luar kecamatan)', 'required' => false],
                ],
                'form_input_tambahan' => [
                    ['name' => 'status_perkawinan_saat_ini', 'label' => 'Status Perkawinan Saat Ini', 'type' => 'select', 'options' => ['Jejaka', 'Perawan', 'Duda', 'Janda'], 'required' => true],
                    ['name' => 'nama_calon_pasangan', 'label' => 'Nama Lengkap Calon Pasangan', 'type' => 'text', 'required' => true],
                    ['name' => 'nik_calon_pasangan', 'label' => 'NIK Calon Pasangan', 'type' => 'text', 'required' => true],
                    ['name' => 'alamat_calon_pasangan', 'label' => 'Alamat Lengkap Calon Pasangan', 'type' => 'textarea', 'required' => true],
                    ['name' => 'nama_ayah_kandung', 'label' => 'Nama Lengkap Ayah Kandung Pemohon', 'type' => 'text', 'required' => true],
                    ['name' => 'nama_ibu_kandung', 'label' => 'Nama Lengkap Ibu Kandung Pemohon', 'type' => 'text', 'required' => true],
                ],
                'template_narasi' => 'Bahwa warga tersebut di atas akan melangsungkan pernikahan dan telah memenuhi pemeriksaan administrasi pengantar nikah desa dengan rincian data calon pasangan serta orang tua sebagai berikut.',
            ],
            [
                'kategori' => 'Kategori C: Pernikahan & Keluarga',
                'kode_surat' => '474.21',
                'nama_surat' => 'Surat Keterangan Belum Menikah',
                'format_nomor' => '474.21/{NOMOR}/DS-PBL/{BULAN}/{TAHUN}',
                'deskripsi_kegunaan' => 'Syarat melamar pekerjaan tertentu, pengajuan KPR, atau lampiran menikah.',
                'syarat_tambahan' => [
                    ['name' => 'pernyataan_belum_menikah', 'label' => 'Surat Pernyataan Belum Pernah Menikah bermaterai Rp10.000 ditandatangani pemohon dan 2 orang saksi', 'required' => true],
                ],
                'form_input_tambahan' => [
                    ['name' => 'keperluan_surat', 'label' => 'Keperluan Penggunaan Surat', 'type' => 'text', 'placeholder' => 'Contoh: Persyaratan Melamar Kerja / Pengajuan KPR', 'required' => true],
                ],
                'template_narasi' => 'Bahwa berdasarkan data kependudukan desa dan pernyataan saksi, yang bersangkutan hingga surat keterangan ini diterbitkan berstatus belum pernah menikah (Jejaka/Perawan).',
            ],
            [
                'kategori' => 'Kategori C: Pernikahan & Keluarga',
                'kode_surat' => '470.1',
                'nama_surat' => 'Surat Keterangan Beda Nama / Identitas',
                'format_nomor' => '470.1/{NOMOR}/DS-PBL/{BULAN}/{TAHUN}',
                'deskripsi_kegunaan' => 'Menjelaskan perbedaan ejaan nama/tanggal lahir antara KTP/KK dengan dokumen lain (Ijazah, Sertifikat, Buku Nikah).',
                'syarat_tambahan' => [
                    ['name' => 'scan_dokumen_berbeda', 'label' => 'Scan/Fotokopi dokumen asli yang mengalami perbedaan data', 'required' => true],
                    ['name' => 'pernyataan_satu_orang_sama', 'label' => 'Surat Pernyataan Satu Orang yang Sama bermaterai Rp10.000', 'required' => true],
                ],
                'form_input_tambahan' => [
                    ['name' => 'jenis_dokumen_berbeda', 'label' => 'Jenis Dokumen yang Berbeda (Ijazah / Buku Nikah / Sertifikat / Akta)', 'type' => 'text', 'required' => true],
                    ['name' => 'data_tertulis_di_ktp', 'label' => 'Data yang Tertulis pada KTP-el / KK', 'type' => 'text', 'required' => true],
                    ['name' => 'data_tertulis_di_dokumen_lain', 'label' => 'Data yang Tertulis pada Dokumen Lain Tersebut', 'type' => 'text', 'required' => true],
                    ['name' => 'bagian_yang_berbeda', 'label' => 'Bagian Elemen Data yang Berbeda (Ejaan Nama / Tempat Tanggal Lahir)', 'type' => 'text', 'required' => true],
                ],
                'template_narasi' => 'Bahwa meskipun terdapat perbedaan penulisan data antara dokumen kependudukan (KTP-el/KK) dengan dokumen lainnya sebagaimana dirinci di bawah ini, kedua identitas tersebut adalah benar-benar merujuk pada satu orang yang sama.',
            ],

            // =========================================================================
            // KATEGORI D: PERTANAHAN, WARIS & KEGIATAN
            // =========================================================================
            [
                'kategori' => 'Kategori D: Pertanahan, Waris & Kegiatan',
                'kode_surat' => '590.1',
                'nama_surat' => 'Surat Keterangan Ahli Waris',
                'format_nomor' => '590.1/{NOMOR}/DS-PBL/{BULAN}/{TAHUN}',
                'deskripsi_kegunaan' => 'Pencairan tabungan bank pewaris, balik nama sertifikat tanah, atau klaim asuransi/pensiun.',
                'syarat_tambahan' => [
                    ['name' => 'akta_kematian_pewaris', 'label' => 'Fotokopi Akta/Surat Kematian pewaris', 'required' => true],
                    ['name' => 'ktp_kk_akta_ahli_waris', 'label' => 'Fotokopi KTP, KK, dan Akta Kelahiran seluruh ahli waris', 'required' => true],
                    ['name' => 'buku_nikah_pewaris', 'label' => 'Fotokopi Buku Nikah pewaris', 'required' => true],
                    ['name' => 'bagan_silsilah_waris', 'label' => 'Bagan silsilah keluarga bermaterai ditandatangani semua ahli waris', 'required' => true],
                    ['name' => 'ktp_dua_saksi_waris', 'label' => 'Fotokopi KTP 2 orang saksi', 'required' => true],
                ],
                'form_input_tambahan' => [
                    ['name' => 'nama_pewaris_almarhum', 'label' => 'Nama Lengkap Pewaris (Almarhum/Almarhumah)', 'type' => 'text', 'required' => true],
                    ['name' => 'tanggal_wafat_pewaris', 'label' => 'Tanggal Wafat Pewaris', 'type' => 'date', 'required' => true],
                    ['name' => 'daftar_nama_ahli_waris', 'label' => 'Daftar Nama & Hubungan Seluruh Ahli Waris', 'type' => 'textarea', 'placeholder' => '1. Nama (Istri/Suami), 2. Nama (Anak Kandung)...', 'required' => true],
                    ['name' => 'keperluan_waris', 'label' => 'Keperluan Pengurusan Ahli Waris', 'type' => 'text', 'required' => true],
                ],
                'template_narasi' => 'Bahwa berdasarkan silsilah keluarga dan dokumen kematian yang sah, nama-nama yang tercantum di bawah ini adalah ahli waris yang sah dari almarhum/almarhumah.',
            ],
            [
                'kategori' => 'Kategori D: Pertanahan, Waris & Kegiatan',
                'kode_surat' => '593',
                'nama_surat' => 'Surat Keterangan Riwayat Tanah / Tidak Sengketa',
                'format_nomor' => '593/{NOMOR}/DS-PBL/{BULAN}/{TAHUN}',
                'deskripsi_kegunaan' => 'Pengurusan sertifikat tanah (PTSL/BPN) atau transaksi jual-beli tanah.',
                'syarat_tambahan' => [
                    ['name' => 'bukti_kepemilikan_tanah', 'label' => 'Fotokopi bukti kepemilikan tanah (Letter C/Girik/Petok D/Sertifikat/AJB)', 'required' => true],
                    ['name' => 'sppt_pbb_berjalan', 'label' => 'Bukti lunas SPPT PBB tahun berjalan', 'required' => true],
                    ['name' => 'pernyataan_tidak_sengketa', 'label' => 'Surat pernyataan tanah tidak sengketa bermaterai Rp10.000 (ditandatangani pemilik & saksi batas tanah)', 'required' => true],
                ],
                'form_input_tambahan' => [
                    ['name' => 'nomor_alas_hak_atau_nop', 'label' => 'Nomor Alas Hak / Letter C / NOP PBB', 'type' => 'text', 'required' => true],
                    ['name' => 'luas_tanah_m2', 'label' => 'Luas Tanah (m2)', 'type' => 'number', 'required' => true],
                    ['name' => 'lokasi_letak_tanah', 'label' => 'Lokasi / Blok Letak Tanah', 'type' => 'text', 'required' => true],
                    ['name' => 'batas_utara', 'label' => 'Batas Sebelah Utara', 'type' => 'text', 'required' => true],
                    ['name' => 'batas_timur', 'label' => 'Batas Sebelah Timur', 'type' => 'text', 'required' => true],
                    ['name' => 'batas_selatan', 'label' => 'Batas Sebelah Selatan', 'type' => 'text', 'required' => true],
                    ['name' => 'batas_barat', 'label' => 'Batas Sebelah Barat', 'type' => 'text', 'required' => true],
                ],
                'template_narasi' => 'Bahwa bidang tanah yang terletak di Desa Pabelan dengan rincian nomor alas hak, luas, serta batas-batas di bawah ini adalah benar tidak dalam keadaan sengketa dengan pihak mana pun.',
            ],
            [
                'kategori' => 'Kategori D: Pertanahan, Waris & Kegiatan',
                'kode_surat' => '300',
                'nama_surat' => 'Surat Pengantar Izin Keramaian',
                'format_nomor' => '300/{NOMOR}/DS-PBL/{BULAN}/{TAHUN}',
                'deskripsi_kegunaan' => 'Pengantar ke Kepolisian untuk mengadakan acara besar (hajatan, konser, turnamen desa).',
                'syarat_tambahan' => [
                    ['name' => 'proposal_rincian_kegiatan', 'label' => 'Proposal atau rincian kegiatan', 'required' => true],
                    ['name' => 'pernyataan_ketertiban', 'label' => 'Surat pernyataan sanggup menjaga ketertiban bermaterai Rp10.000', 'required' => true],
                ],
                'form_input_tambahan' => [
                    ['name' => 'nama_jenis_acara', 'label' => 'Nama / Jenis Acara Kegiatan', 'type' => 'text', 'required' => true],
                    ['name' => 'tanggal_acara', 'label' => 'Tanggal Pelaksanaan Acara', 'type' => 'date', 'required' => true],
                    ['name' => 'waktu_acara', 'label' => 'Waktu Pelaksanaan (Mulai s.d. Selesai)', 'type' => 'text', 'placeholder' => 'Contoh: 09.00 s.d. 21.00 WIB', 'required' => true],
                    ['name' => 'lokasi_acara', 'label' => 'Lokasi Tempat Acara', 'type' => 'text', 'required' => true],
                    ['name' => 'estimasi_jumlah_hadirin', 'label' => 'Estimasi Jumlah Undangan / Hadirin (Orang)', 'type' => 'number', 'required' => true],
                    ['name' => 'hiburan_yang_didatangkan', 'label' => 'Jenis Hiburan yang Didatangkan', 'type' => 'text', 'placeholder' => 'Contoh: Karawitan / Organ Tunggal / Pengajian', 'required' => true],
                ],
                'template_narasi' => 'Pemerintah Desa Pabelan menerangkan bahwa warga tersebut di atas bermaksud menyelenggarakan kegiatan masyarakat dan diberikan surat pengantar ini guna pengurusan Izin Keramaian pada pihak Kepolisian.',
            ],
        ];

        foreach ($daftarSurat as $item) {
            $syaratUmumText = collect(JenisSurat::SYARAT_DASAR_UMUM)
                ->map(fn ($s, $idx) => ($idx + 1) . '. ' . $s['label'] . ($s['required'] ? ' (Wajib)' : ' (Opsional)'))
                ->implode("\n");

            $syaratKhususText = collect($item['syarat_tambahan'])
                ->map(fn ($s, $idx) => ($idx + 4) . '. ' . $s['label'] . ($s['required'] ? ' (Wajib)' : ' (Opsional)'))
                ->implode("\n");

            JenisSurat::updateOrCreate(
                ['kode_surat' => $item['kode_surat']],
                [
                    'kategori' => $item['kategori'],
                    'nama_surat' => $item['nama_surat'],
                    'format_nomor' => $item['format_nomor'],
                    'deskripsi_kegunaan' => $item['deskripsi_kegunaan'],
                    'deskripsi' => $item['deskripsi_kegunaan'],
                    'syarat_dokumen' => trim($syaratUmumText . "\n" . $syaratKhususText),
                    'syarat_tambahan' => $item['syarat_tambahan'],
                    'form_input_tambahan' => $item['form_input_tambahan'],
                    'template_narasi' => $item['template_narasi'],
                    'template_surat' => 'surat.cetak.template-surat',
                    'is_aktif' => true,
                ]
            );
        }

        // Contoh Data Pengajuan Surat untuk Pengujian Langsung Warga & Admin
        $warga = \App\Models\Warga::first();
        $kades = \App\Models\Aparatur::orderBy('urutan')->first();
        $admin = \App\Models\User::where('role', 'admin')->first();

        if ($warga) {
            $jenisSku = JenisSurat::where('kode_surat', '503')->first();
            $jenisDomisili = JenisSurat::where('kode_surat', '470')->first();
            $jenisSkck = JenisSurat::where('kode_surat', '331')->first();

            if ($jenisSku) {
                \App\Models\SuratPengantar::updateOrCreate(
                    ['nomor_surat' => '503/001/DS-PBL/X/2026'],
                    [
                        'warga_id' => $warga->id,
                        'jenis_surat_id' => $jenisSku->id,
                        'aparatur_id' => $kades?->id,
                        'ttd_aparatur_id' => $kades?->id,
                        'diproses_oleh' => $admin?->id,
                        'keperluan' => 'Persyaratan Pengajuan Kredit Usaha Rakyat (KUR) di Bank BRI Unit Kartasura',
                        'data_tambahan' => [
                            'nama_usaha' => 'Toko Kelontong & Sembako Berkah Pabelan',
                            'jenis_bidang_usaha' => 'Perdagangan Eceran Sembako',
                            'alamat_lokasi_usaha' => 'Jl. Ahmad Yani RT 02 RW 01 Dusun Pabelan, Desa Pabelan',
                            'lama_usaha_berdiri' => '5 Tahun (Sejak 2021)',
                        ],
                        'data_isian' => [
                            'nama_usaha' => 'Toko Kelontong & Sembako Berkah Pabelan',
                            'jenis_bidang_usaha' => 'Perdagangan Eceran Sembako',
                            'alamat_lokasi_usaha' => 'Jl. Ahmad Yani RT 02 RW 01 Dusun Pabelan, Desa Pabelan',
                            'lama_usaha_berdiri' => '5 Tahun (Sejak 2021)',
                        ],
                        'status' => 'disetujui',
                        'tipe_ttd' => 'qrcode',
                        'qr_token' => 'pabelan-sku-2026-001-valid-token-k3524062',
                        'catatan_admin' => 'Seluruh dokumen persyaratan SKU telah diverifikasi lengkap dan disahkan.',
                        'tanggal_pengajuan' => now()->subDays(2),
                        'tanggal_disetujui' => now()->subDay(),
                        'tanggal_selesai' => now()->subDay(),
                    ]
                );
            }

            if ($jenisDomisili && ! \App\Models\SuratPengantar::where('jenis_surat_id', $jenisDomisili->id)->where('status', 'pending')->exists()) {
                \App\Models\SuratPengantar::create([
                    'warga_id' => $warga->id,
                    'jenis_surat_id' => $jenisDomisili->id,
                    'keperluan' => 'Kelengkapan Administrasi Pembukaan Rekening Bank Jateng Cabang Sukoharjo',
                    'data_tambahan' => [
                        'status_tempat_tinggal' => 'Milik Sendiri',
                        'alamat_domisili_sekarang' => 'Jl. Ahmad Yani RT 02 RW 01 Dusun Pabelan, Desa Pabelan',
                        'sejak_tanggal' => '2015-03-10',
                    ],
                    'data_isian' => [
                        'status_tempat_tinggal' => 'Milik Sendiri',
                        'alamat_domisili_sekarang' => 'Jl. Ahmad Yani RT 02 RW 01 Dusun Pabelan, Desa Pabelan',
                        'sejak_tanggal' => '2015-03-10',
                    ],
                    'status' => 'pending',
                    'tipe_ttd' => 'qrcode',
                    'tanggal_pengajuan' => now()->subHours(3),
                ]);
            }

            if ($jenisSkck && ! \App\Models\SuratPengantar::where('jenis_surat_id', $jenisSkck->id)->where('status', 'ditolak')->exists()) {
                \App\Models\SuratPengantar::create([
                    'warga_id' => $warga->id,
                    'jenis_surat_id' => $jenisSkck->id,
                    'diproses_oleh' => $admin?->id,
                    'keperluan' => 'Pemberkasan Melamar Pekerjaan Swasta di Surakarta',
                    'data_tambahan' => [
                        'keperluan_skck' => 'Melamar Pekerjaan',
                        'polsek_polres_tujuan' => 'Polsek Kartasura / Polres Sukoharjo',
                    ],
                    'data_isian' => [
                        'keperluan_skck' => 'Melamar Pekerjaan',
                        'polsek_polres_tujuan' => 'Polsek Kartasura / Polres Sukoharjo',
                    ],
                    'status' => 'ditolak',
                    'alasan_penolakan' => 'Lampiran foto KTP-el belum terlihat jelas pada bagian NIK dan pas foto belum berlatar belakang merah. Mohon unggah ulang berkas yang jelas.',
                    'catatan_admin' => 'Lampiran foto KTP-el belum terlihat jelas pada bagian NIK dan pas foto belum berlatar belakang merah. Mohon unggah ulang berkas yang jelas.',
                    'tanggal_pengajuan' => now()->subDays(4),
                    'tanggal_selesai' => now()->subDays(3),
                ]);
            }
        }
    }
}

