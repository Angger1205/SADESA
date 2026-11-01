<x-admin-layout title="Tambah Warga" activeMenu="warga">
    <form
        method="POST"
        action="{{ route('admin.kependudukan.warga.store') }}"
        class="bg-white rounded-2xl border-2 border-desa-border p-5 sm:p-6 space-y-5"
    >
        @csrf

        @include('admin.kependudukan.warga._form', ['warga' => null])

        <div class="flex flex-wrap gap-3 pt-2">
            <x-button variant="primary" type="submit">Simpan Data</x-button>
            <x-button variant="secondary" href="{{ route('admin.kependudukan.warga.index') }}">Batal</x-button>
        </div>
    </form>
</x-admin-layout>