<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisSurat extends Model
{
    use HasFactory;

    protected $table = 'jenis_surats';

    /**
     * Syarat Dasar Umum yang selalu ditampilkan pada setiap pengajuan surat warga.
     */
    public const SYARAT_DASAR_UMUM = [
        [
            'name' => 'ktp_el',
            'label' => 'KTP-el Pemohon (Asli / Fotokopi Jelas)',
            'required' => true,
        ],
        [
            'name' => 'kartu_keluarga',
            'label' => 'Kartu Keluarga (KK)',
            'required' => true,
        ],
        [
            'name' => 'pengantar_rt_rw',
            'label' => 'Surat Pengantar RT / RW Setempat',
            'required' => false,
        ],
    ];

    protected $fillable = [
        'kategori',
        'kode_surat',
        'nama_surat',
        'format_nomor',
        'deskripsi_kegunaan',
        'deskripsi',
        'syarat_dokumen',
        'syarat_tambahan',
        'form_input_tambahan',
        'template_narasi',
        'template_surat',
        'is_aktif',
    ];

    protected function casts(): array
    {
        return [
            'syarat_tambahan' => 'array',
            'form_input_tambahan' => 'array',
            'is_aktif' => 'boolean',
        ];
    }

    public function suratPengantars(): HasMany
    {
        return $this->hasMany(SuratPengantar::class, 'jenis_surat_id');
    }
}
