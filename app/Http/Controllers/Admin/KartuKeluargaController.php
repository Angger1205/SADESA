<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KartuKeluarga;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KartuKeluargaController extends Controller
{
    public function index(Request $request)
    {
        $cari = $request->query('cari');

        $kartuKeluargas = KartuKeluarga::query()
            ->withCount('wargas')
            ->when($cari, function ($query, $cari) {
                $query->where(function ($q) use ($cari) {
                    $q->where('no_kk', 'like', "%{$cari}%")
                      ->orWhere('kepala_keluarga', 'like', "%{$cari}%");
                });
            })
            ->orderBy('kepala_keluarga')
            ->paginate(10)
            ->withQueryString();

        return view('admin.kependudukan.kk.index', compact('kartuKeluargas', 'cari'));
    }

    public function create()
    {
        return view('admin.kependudukan.kk.create');
    }

    public function store(Request $request): RedirectResponse
    {
        KartuKeluarga::create($this->validasi($request));

        return redirect()
            ->route('admin.kependudukan.kk.index')
            ->with('sukses', 'Data Kartu Keluarga berhasil ditambahkan.');
    }

    public function edit(KartuKeluarga $kartuKeluarga)
    {
        return view('admin.kependudukan.kk.edit', compact('kartuKeluarga'));
    }

    public function update(Request $request, KartuKeluarga $kartuKeluarga): RedirectResponse
    {
        $kartuKeluarga->update($this->validasi($request, $kartuKeluarga));

        return redirect()
            ->route('admin.kependudukan.kk.index')
            ->with('sukses', 'Data Kartu Keluarga berhasil diperbarui.');
    }

    public function destroy(KartuKeluarga $kartuKeluarga): RedirectResponse
    {
        // Menghapus KK akan ikut menghapus semua wargas di dalamnya (cascade),
        // jadi kita tolak kalau masih ada anggota.
        if ($kartuKeluarga->wargas()->exists()) {
            return back()->with('gagal', 'KK tidak dapat dihapus karena masih memiliki anggota. Pindahkan atau hapus data wargannya terlebih dahulu.');
        }

        $kartuKeluarga->delete();

        return redirect()
            ->route('admin.kependudukan.kk.index')
            ->with('sukses', 'Data Kartu Keluarga berhasil dihapus.');
    }

    private function validasi(Request $request, ?KartuKeluarga $kartuKeluarga = null): array
    {
        return $request->validate([
            'no_kk' => [
                'required',
                'digits:16',
                Rule::unique('kartu_keluargas', 'no_kk')->ignore($kartuKeluarga?->id),
            ],
            'kepala_keluarga' => ['required', 'string', 'max:100'],
            'alamat' => ['required', 'string'],
            'dusun' => ['required', 'string', 'max:50'],
            'rt' => ['required', 'string', 'max:5'],
            'rw' => ['required', 'string', 'max:5'],
            'kode_pos' => ['nullable', 'string', 'max:10'],
        ], [
            'required' => ':attribute wajib diisi.',
            'digits' => ':attribute harus berupa :digits digit angka.',
            'unique' => ':attribute sudah terdaftar.',
            'max' => ':attribute terlalu panjang (maksimal :max karakter).',
            'string' => ':attribute tidak valid.',
        ], [
            'no_kk' => 'Nomor KK',
            'kepala_keluarga' => 'Nama kepala keluarga',
            'alamat' => 'Alamat',
            'dusun' => 'Dusun',
            'rt' => 'RT',
            'rw' => 'RW',
            'kode_pos' => 'Kode pos',
        ]);
    }
}