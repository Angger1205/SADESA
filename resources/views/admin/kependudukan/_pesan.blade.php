@if (session('sukses'))
    <div role="status" class="px-4 py-3 rounded-lg bg-emerald-100 text-emerald-950 border border-emerald-700 text-sm font-bold">
        {{ session('sukses') }}
    </div>
@endif
@if (session('gagal'))
    <div role="alert" class="px-4 py-3 rounded-lg bg-red-100 text-red-950 border border-red-700 text-sm font-bold">
        {{ session('gagal') }}
    </div>
@endif