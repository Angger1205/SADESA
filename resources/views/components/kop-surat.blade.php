@props(['profil' => null])

@php
    $profil = $profil ?? once(fn () => \App\Models\ProfilDesa::first());
    $lambangPath = $profil->lambang_daerah ?? $profil->logo_desa ?? 'images/lambang-kab-sukoharjo.png';
    $lambangAda = file_exists(public_path($lambangPath));
@endphp

<div class="kop-surat-container" style="border-bottom: 4px double #000; padding-bottom: 10px; margin-bottom: 20px; font-family: 'Times New Roman', Times, serif; color: #000;">
    <table style="width: 100%; border-collapse: collapse; border: none;">
        <tr>
            <!-- Lambang Daerah Kabupaten Sukoharjo / Desa Pabelan -->
            <td style="width: 16%; text-align: center; vertical-align: middle; border: none;">
                @if ($lambangAda)
                    <img src="{{ asset($lambangPath) }}" alt="Lambang Kabupaten {{ $profil->kabupaten ?? 'Sukoharjo' }}" style="max-height: 92px; width: auto; object-fit: contain;" />
                @else
                    <div style="width: 78px; height: 78px; border: 2px solid #000; display: inline-flex; align-items: center; justify-content: center; font-size: 9pt; font-weight: bold; text-align: center;">
                        [LOGO<br>DESA]
                    </div>
                @endif
            </td>

            <!-- Identitas Resmi Pemerintah Desa Pabelan -->
            <td style="width: 84%; text-align: center; vertical-align: middle; border: none; padding-right: 16px;">
                <div style="margin: 0; font-size: 14pt; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px;">
                    PEMERINTAH KABUPATEN {{ strtoupper($profil->kabupaten ?? 'SUKOHARJO') }}
                </div>
                <div style="margin: 1px 0; font-size: 13pt; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px;">
                    KECAMATAN {{ strtoupper($profil->kecamatan ?? 'KARTASURA') }}
                </div>
                <div style="margin: 2px 0; font-size: 18pt; font-weight: 800; text-transform: uppercase; letter-spacing: 1px;">
                    PEMERINTAH DESA {{ strtoupper($profil->nama_desa ?? 'PABELAN') }}
                </div>
                <div style="margin: 2px 0; font-size: 10pt;">
                    Alamat: {{ $profil->alamat_kantor ?? 'Jl. Ahmad Yani No. 12, Desa Pabelan, Kec. Kartasura' }} &bull; Kode Pos {{ $profil->kode_pos ?? '57169' }}
                </div>
                <div style="margin: 0; font-size: 9.5pt;">
                    Surel: {{ $profil->email_desa ?? 'pemdes@pabelan.desa.id' }} &bull; Telepon: {{ $profil->telepon_desa ?? '0271-780123' }} &bull; Laman: {{ $profil->website_url ?? 'https://pabelan.desa.id' }}
                </div>
            </td>
        </tr>
    </table>
</div>
