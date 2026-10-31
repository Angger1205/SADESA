<?php

use App\Http\Controllers\Warga\SuratController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Portal Warga Routes (Wajib Login sebagai Warga)
|--------------------------------------------------------------------------
| Dikelola oleh: Anggota 2 (Surat) & Anggota 3 (Pengaduan)
*/

Route::prefix('warga')->name('warga.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('warga.dashboard');
    })->name('dashboard');

    // Pengajuan & Pemantauan Surat Mandiri (Anggota 2: Nadhif Athaasyam Nurdewana - K3524062)
    Route::prefix('surat')->name('surat.')->middleware(['can:akses-surat-warga'])->group(function () {
        Route::get('/', [SuratController::class, 'index'])->name('index');
        Route::get('/buat', [SuratController::class, 'create'])->name('create');
        Route::post('/kirim', [SuratController::class, 'store'])->name('store');
        Route::get('/{id}/detail', [SuratController::class, 'show'])->name('show');
        Route::get('/{id}/cetak', [SuratController::class, 'cetak'])->name('cetak');
    });

    // Riwayat Pengaduan Saya
    Route::prefix('pengaduan')->name('pengaduan.')->group(function () {
        Route::get('/', function () {
            return view('warga.pengaduan.index');
        })->name('index');
    });

    // Profil Biodata Warga & Anggota Keluarga
    Route::get('/profil', function () {
        return view('warga.profil');
    })->name('profil');
});
