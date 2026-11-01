<x-admin-layout title="Tambah Akun Pengguna" activeMenu="user">
    <form
        method="POST"
        action="{{ route('admin.kependudukan.user.store') }}"
        class="bg-white rounded-2xl border-2 border-desa-border p-5 sm:p-6 space-y-5"
    >
        @csrf

        @include('admin.kependudukan.user._form', ['akun' => null])

        <div class="flex flex-wrap gap-3 pt-2">
            <x-button variant="primary" type="submit">Simpan Akun</x-button>
            <x-button variant="secondary" href="{{ route('admin.kependudukan.user.index') }}">Batal</x-button>
        </div>
    </form>
</x-admin-layout>