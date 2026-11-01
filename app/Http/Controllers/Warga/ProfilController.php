<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfilController extends Controller
{
    /**
     * Tampilkan halaman profil warga beserta biodata kependudukan terintegrasi.
     */
    public function show(Request $request): View
    {
        $user = $request->user();
        $user->load(['warga.kartuKeluarga.wargas']);

        $warga = $user->warga;
        $kartuKeluarga = $warga?->kartuKeluarga;
        $anggotaKeluarga = $kartuKeluarga?->wargas ?? collect();

        return view('warga.profil', compact('user', 'warga', 'kartuKeluarga', 'anggotaKeluarga'));
    }

    /**
     * Perbarui data profil warga: foto profil, kontak handphone, email, dan kata sandi.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();
        $warga = $user->warga;

        $request->validate([
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'email' => ['required', 'string', 'email', 'max:100', Rule::unique('users')->ignore($user->id)],
            'password_lama' => ['nullable', 'required_with:password_baru', 'current_password'],
            'password_baru' => ['nullable', 'string', 'min:8', 'confirmed'],
        ], [
            'avatar.image' => 'Berkas harus berupa gambar foto.',
            'avatar.mimes' => 'Format foto harus berupa JPG, JPEG, PNG, atau WEBP.',
            'avatar.max' => 'Ukuran foto profil maksimal 2 MB.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.unique' => 'Alamat email sudah digunakan oleh pengguna lain.',
            'password_lama.current_password' => 'Kata sandi saat ini tidak sesuai.',
            'password_baru.min' => 'Kata sandi baru minimal 8 karakter.',
            'password_baru.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
        ]);

        // 1. Unggah Foto Profil (Avatar)
        if ($request->hasFile('avatar')) {
            $avatarFile = $request->file('avatar');
            if ($avatarFile && $avatarFile->isValid()) {
                $uploadDir = public_path('uploads/avatars');
                if (! File::isDirectory($uploadDir)) {
                    File::makeDirectory($uploadDir, 0755, true, true);
                }

                // Hapus avatar lama jika ada
                if ($user->avatar && File::exists(public_path($user->avatar))) {
                    @File::delete(public_path($user->avatar));
                }

                $filename = 'avatar_user_' . $user->id . '_' . time() . '.' . $avatarFile->getClientOriginalExtension();
                $targetPath = $uploadDir . DIRECTORY_SEPARATOR . $filename;
                if (! @copy($avatarFile->getRealPath(), $targetPath)) {
                    $avatarFile->move($uploadDir, $filename);
                }
                $user->avatar = 'uploads/avatars/' . $filename;
            }
        } elseif ($request->boolean('hapus_avatar')) {
            if ($user->avatar && File::exists(public_path($user->avatar))) {
                @File::delete(public_path($user->avatar));
            }
            $user->avatar = null;
        }

        // 2. Perbarui Email
        $user->email = $request->email;

        // 3. Perbarui Kata Sandi (opsional)
        if ($request->filled('password_baru')) {
            $user->password = Hash::make($request->password_baru);
        }

        $user->save();

        // 4. Perbarui Nomor HP pada Data Warga bila akun terhubung
        if ($warga && $request->has('no_hp')) {
            $warga->update([
                'no_hp' => $request->input('no_hp'),
            ]);
        }

        return redirect()
            ->route('warga.profil')
            ->with('sukses', 'Profil dan data Anda berhasil diperbarui.');
    }
}
