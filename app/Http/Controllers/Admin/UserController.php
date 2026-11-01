<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Warga;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $cari = $request->query('cari');
        $peran = $request->query('peran');

        $users = User::query()
            ->with('warga')
            ->when($cari, function ($query, $cari) {
                $query->where(function ($q) use ($cari) {
                    $q->where('name', 'like', "%{$cari}%")
                      ->orWhere('email', 'like', "%{$cari}%");
                });
            })
            ->when($peran, fn ($query, $peran) => $query->where('role', $peran))
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.kependudukan.user.index', compact('users', 'cari', 'peran'));
    }

    public function create()
    {
        return view('admin.kependudukan.user.create', [
            'wargas' => $this->daftarWarga(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        // Password otomatis di-hash oleh cast 'hashed' di model User,
        // jadi tidak perlu Hash::make() lagi di sini.
        User::create($this->validasi($request));

        return redirect()
            ->route('admin.kependudukan.user.index')
            ->with('sukses', 'Akun pengguna berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('admin.kependudukan.user.edit', [
            'akun' => $user,
            'wargas' => $this->daftarWarga($user),
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $this->validasi($request, $user);

        if ($user->is($request->user()) && $data['role'] !== $user->role) {
            return back()
                ->withInput()
                ->withErrors(['role' => 'Anda tidak dapat mengubah peran akun Anda sendiri.']);
        }

        // Kolom password dikosongkan = tidak ingin mengganti password.
        if (blank($data['password'] ?? null)) {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()
            ->route('admin.kependudukan.user.index')
            ->with('sukses', 'Akun pengguna berhasil diperbarui.');
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        if ($user->is($request->user())) {
            return back()->with('gagal', 'Anda tidak dapat menghapus akun yang sedang Anda pakai.');
        }

        if ($user->suratPengantarsDiproses()->exists()
            || $user->informasis()->exists()
            || $user->pengaduansDitanggapi()->exists()) {
            return back()->with('gagal', 'Akun tidak dapat dihapus karena sudah tercatat memproses surat, menanggapi pengaduan, atau menulis informasi.');
        }

        $user->delete();

        return redirect()
            ->route('admin.kependudukan.user.index')
            ->with('sukses', 'Akun pengguna berhasil dihapus.');
    }

    /**
     * Warga yang boleh dipilih: yang aktif dan belum punya akun,
     * ditambah warga milik akun yang sedang diubah.
     */
    private function daftarWarga(?User $user = null)
    {
        return Warga::query()
            ->where(function ($q) use ($user) {
                $q->where(function ($belum) {
                    $belum->whereDoesntHave('user')->where('status_warga', 'Aktif');
                });

                if ($user?->warga_id) {
                    $q->orWhere('id', $user->warga_id);
                }
            })
            ->orderBy('nama_lengkap')
            ->get(['id', 'nik', 'nama_lengkap']);
    }

    private function validasi(Request $request, ?User $user = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => [
                'required',
                'email',
                'max:100',
                Rule::unique('users', 'email')->ignore($user?->id),
            ],
            'role' => ['required', Rule::in(array_keys(User::PERAN))],
            'warga_id' => [
                'nullable',
                'required_if:role,warga',
                'exists:wargas,id',
                Rule::unique('users', 'warga_id')->ignore($user?->id),
            ],
            'password' => [
                $user ? 'nullable' : 'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ], [
            'required' => ':attribute wajib diisi.',
            'string' => ':attribute tidak valid.',
            'max' => ':attribute terlalu panjang (maksimal :max karakter).',
            'email' => 'Format email belum benar.',
            'min' => ':attribute minimal :min karakter.',
            'confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'in' => ':attribute yang dipilih tidak valid.',
            'exists' => ':attribute yang dipilih tidak ditemukan.',
            'email.unique' => 'Email ini sudah dipakai akun lain.',
            'warga_id.unique' => 'Data warga ini sudah memiliki akun.',
            'warga_id.required_if' => 'Data warga wajib dipilih untuk akun dengan peran Warga.',
        ], [
            'name' => 'Nama',
            'email' => 'Email',
            'role' => 'Peran',
            'warga_id' => 'Data warga',
            'password' => 'Kata sandi',
        ]);
    }
}