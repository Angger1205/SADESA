<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Warga extends Model
{
    use HasFactory;

    protected $table = 'wargas';

    public const JENIS_KELAMIN = ['Laki-laki', 'Perempuan'];

    public const AGAMA = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'];

    public const PENDIDIKAN = [
        'Tidak/Belum Sekolah', 'SD/Sederajat', 'SMP/Sederajat', 'SMA/Sederajat',
        'D1/D2/D3', 'S1', 'S2', 'S3',
    ];

    public const STATUS_PERKAWINAN = ['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'];

    public const HUBUNGAN_KELUARGA = [
        'Kepala Keluarga', 'Istri', 'Anak', 'Menantu', 'Cucu',
        'Orang Tua', 'Mertua', 'Famili Lain', 'Lainnya',
    ];

    public const STATUS_WARGA = ['Aktif', 'Pindah', 'Meninggal'];

    protected $fillable = [
        'kartu_keluarga_id',
        'nik',
        'nama_lengkap',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'pendidikan_terakhir',
        'pekerjaan',
        'status_perkawinan',
        'status_hubungan_keluarga',
        'status_warga',
        'no_hp',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
        ];
    }

    public function kartuKeluarga(): BelongsTo
    {
        return $this->belongsTo(KartuKeluarga::class, 'kartu_keluarga_id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'warga_id');
    }

    public function suratPengantars(): HasMany
    {
        return $this->hasMany(SuratPengantar::class, 'warga_id');
    }

    public function pengaduans(): HasMany
    {
        return $this->hasMany(Pengaduan::class, 'warga_id');
    }
}
