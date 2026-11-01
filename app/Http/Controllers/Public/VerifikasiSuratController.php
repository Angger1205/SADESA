<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\ProfilDesa;
use App\Models\SuratPengantar;

class VerifikasiSuratController extends Controller
{
    /**
     * Menampilkan halaman pembuktian keaslian dokumen surat berdasarkan pindai QR Code (qr_token).
     */
    public function show($token)
    {
        $surat = SuratPengantar::with(['warga.kartuKeluarga', 'jenisSurat', 'aparatur', 'ttdAparatur', 'diprosesOleh'])
            ->where('qr_token', $token)
            ->first();

        $profil = ProfilDesa::first();

        return view('public.verifikasi-surat', compact('surat', 'profil', 'token'));
    }
}
