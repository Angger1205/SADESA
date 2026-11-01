<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KartuKeluarga;
use App\Models\Warga;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class WargaController extends Controller
{
    public function index(Request $request)
    {
        $cari = $request->query('cari');
        $status = $request->query('status');

        $wargas = Warga::query()
            ->with('kartuKeluarga')
            ->when($cari, function ($query, $cari) {
                $query->where(function ($q) use ($cari) {
                    $q->where('nik', 'like', "%{$cari}%")
                      ->orWhere('nama_lengkap', 'like', "%{$cari}%");
                });
            })
            ->when($status, fn ($query, $status) => $query->where('status_warga', $status))
            ->orderBy('nama_lengkap')
            ->paginate(10)
            ->withQueryString();

        return view('admin.kependudukan.warga.index', compact('wargas', 'cari', 'status'));
    }

    public function create()
    {
        return view('admin.kependudukan.warga.create', [
            'kartuKeluargas' => $this->daftarKk(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Warga::create($this->validasi($request));

        return redirect()
            ->route('admin.kependudukan.warga.index')
            ->with('sukses', 'Data warga berhasil ditambahkan.');
    }

    public function edit(Warga $warga)
    {
        return view('admin.kependudukan.warga.edit', [
            'warga' => $warga,
            'kartuKeluargas' => $this->daftarKk(),
        ]);
    }

    public function update(Request $request, Warga $warga): RedirectResponse
    {
        $warga->update($this->validasi($request, $warga));

        return redirect()
            ->route('admin.kependudukan.warga.index')
            ->with('sukses', 'Data warga berhasil diperbarui.');
    }

    public function destroy(Warga $warga): RedirectResponse
    {
        // Data kependudukan sebaiknya tidak dihapus kalau sudah dipakai modul lain.
        if ($warga->user()->exists() || $warga->suratPengantars()->exists() || $warga->pengaduans()->exists()) {
            return back()->with('gagal', 'Data warga tidak dapat dihapus karena sudah terhubung dengan akun, surat, atau pengaduan. Ubah Status Warga menjadi Pindah atau Meninggal sebagai gantinya.');
        }

        $warga->delete();

        return redirect()
            ->route('admin.kependudukan.warga.index')
            ->with('sukses', 'Data warga berhasil dihapus.');
    }

    private function daftarKk()
    {
        return KartuKeluarga::orderBy('kepala_keluarga')->get(['id', 'no_kk', 'kepala_keluarga']);
    }

    private function validasi(Request $request, ?Warga $warga = null): array
    {
        return $request->validate([
            'kartu_keluarga_id' => ['required', 'exists:kartu_keluargas,id'],
            'nik' => [
                'required',
                'digits:16',
                Rule::unique('wargas', 'nik')->ignore($warga?->id),
            ],
            'nama_lengkap' => ['required', 'string', 'max:100'],
            'jenis_kelamin' => ['required', Rule::in(Warga::JENIS_KELAMIN)],
            'tempat_lahir' => ['required', 'string', 'max:50'],
            'tanggal_lahir' => ['required', 'date', 'before_or_equal:today'],
            'agama' => ['required', Rule::in(Warga::AGAMA)],
            'pendidikan_terakhir' => ['nullable', Rule::in(Warga::PENDIDIKAN)],
            'pekerjaan' => ['nullable', 'string', 'max:50'],
            'status_perkawinan' => ['required', Rule::in(Warga::STATUS_PERKAWINAN)],
            'status_hubungan_keluarga' => [
                'required',
                Rule::in(Warga::HUBUNGAN_KELUARGA),
                function ($attribute, $value, $fail) use ($request, $warga) {
                    if ($value !== 'Kepala Keluarga') {
                        return;
                    }

                    $sudahAda = Warga::query()
                        ->where('kartu_keluarga_id', $request->input('kartu_keluarga_id'))
                        ->where('status_hubungan_keluarga', 'Kepala Keluarga')
                        ->when($warga, fn ($q) => $q->where('id', '!=', $warga->id))
                        ->exists();

                    if ($sudahAda) {
                        $fail('Kartu Keluarga ini sudah memiliki Kepala Keluarga.');
                    }
                },
            ],
            'status_warga' => ['required', Rule::in(Warga::STATUS_WARGA)],
            'no_hp' => ['nullable', 'string', 'max:20', 'regex:/^[0-9+\-\s]+$/'],
        ], [
            'required' => ':attribute wajib diisi.',
            'digits' => ':attribute harus berupa :digits digit angka.',
            'unique' => ':attribute sudah terdaftar.',
            'max' => ':attribute terlalu panjang (maksimal :max karakter).',
            'string' => ':attribute tidak valid.',
            'in' => ':attribute yang dipilih tidak valid.',
            'exists' => ':attribute yang dipilih tidak ditemukan.',
            'date' => ':attribute bukan tanggal yang valid.',
            'before_or_equal' => ':attribute tidak boleh melebihi hari ini.',
            'regex' => 'Format :attribute belum benar.',
        ], [
            'kartu_keluarga_id' => 'Kartu Keluarga',
            'nik' => 'NIK',
            'nama_lengkap' => 'Nama lengkap',
            'jenis_kelamin' => 'Jenis kelamin',
            'tempat_lahir' => 'Tempat lahir',
            'tanggal_lahir' => 'Tanggal lahir',
            'agama' => 'Agama',
            'pendidikan_terakhir' => 'Pendidikan terakhir',
            'pekerjaan' => 'Pekerjaan',
            'status_perkawinan' => 'Status perkawinan',
            'status_hubungan_keluarga' => 'Status hubungan dalam keluarga',
            'status_warga' => 'Status warga',
            'no_hp' => 'Nomor HP',
        ]);
    }
}