<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuratPengantar extends Model
{
    use HasFactory;

    protected $table = 'surat_pengantars';

    protected $fillable = [
        'nomor_surat',
        'warga_id',
        'jenis_surat_id',
        'aparatur_id',
        'ttd_aparatur_id',
        'diproses_oleh',
        'keperluan',
        'data_tambahan',
        'data_isian',
        'berkas_lampiran',
        'file_lampiran',
        'file_surat_selesai',
        'status',
        'alasan_penolakan',
        'catatan_admin',
        'tipe_ttd',
        'qr_token',
        'tanggal_pengajuan',
        'tanggal_disetujui',
        'tanggal_selesai',
    ];

    protected function casts(): array
    {
        return [
            'data_tambahan' => 'array',
            'data_isian' => 'array',
            'berkas_lampiran' => 'array',
            'tanggal_pengajuan' => 'datetime',
            'tanggal_disetujui' => 'datetime',
            'tanggal_selesai' => 'datetime',
        ];
    }

    public function warga(): BelongsTo
    {
        return $this->belongsTo(Warga::class, 'warga_id');
    }

    public function jenisSurat(): BelongsTo
    {
        return $this->belongsTo(JenisSurat::class, 'jenis_surat_id');
    }

    public function aparatur(): BelongsTo
    {
        return $this->belongsTo(Aparatur::class, 'aparatur_id');
    }

    public function ttdAparatur(): BelongsTo
    {
        return $this->belongsTo(Aparatur::class, 'ttd_aparatur_id');
    }

    public function diprosesOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diproses_oleh');
    }

    /**
     * Nama warga yang disensor sebagian untuk halaman verifikasi QR Code publik.
     */
    public function getNamaWargaDisensorAttribute(): string
    {
        $nama = trim($this->warga->nama_lengkap ?? 'Warga Desa');

        return collect(explode(' ', $nama))
            ->map(function (string $kata) {
                $len = mb_strlen($kata);
                if ($len <= 2) {
                    return mb_substr($kata, 0, 1) . '*';
                }

                return mb_substr($kata, 0, 2) . str_repeat('*', max(2, $len - 3)) . mb_substr($kata, -1);
            })
            ->implode(' ');
    }
}
