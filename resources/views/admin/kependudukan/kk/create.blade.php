<x-admin-layout title="Tambah Kartu Keluarga" activeMenu="kk">
    <form
        method="POST"
        action="{{ route('admin.kependudukan.kk.store') }}"
        class="bg-white rounded-2xl border-2 border-desa-border p-5 sm:p-6 space-y-5"
    >
        @csrf

        @include('admin.kependudukan.kk._form', ['kartuKeluarga' => null])

        <div class="flex flex-wrap gap-3 pt-2">
            <x-button variant="primary" type="submit">Simpan Data</x-button>
            <x-button variant="secondary" href="{{ route('admin.kependudukan.kk.index') }}">Batal</x-button>
        </div>
    </form>
</x-admin-layout>