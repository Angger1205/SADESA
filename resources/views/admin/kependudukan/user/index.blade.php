<x-admin-layout title="Akun Pengguna" activeMenu="user">
    <div class="space-y-5">
        @include('admin.kependudukan._tab', ['aktif' => 'user'])
        @include('admin.kependudukan._pesan')

        <div class="flex flex-wrap items-end justify-between gap-3">
            <form method="GET" action="{{ route('admin.kependudukan.user.index') }}" class="flex flex-wrap items-end gap-3 grow">
                <div class="grow sm:max-w-md">
                    <label for="cari" class="block text-xs font-bold text-desa-dark mb-1">Cari Akun</label>
                    <input
                        type="text"
                        id="cari"
                        name="cari"
                        value="{{ $cari }}"
                        placeholder="Ketik nama atau email"
                        class="w-full min-h-[44px] px-3.5 py-2 rounded-lg bg-desa-mist border-2 border-desa-border text-sm text-desa-dark focus:outline-none focus:ring-2 focus:ring-desa-action"
                    />
                </div>
                <div>
                    <label for="peran" class="block text-xs font-bold text-desa-dark mb-1">Peran</label>
                    <select
                        id="peran"
                        name="peran"
                        class="min-h-[44px] px-3.5 py-2 rounded-lg bg-desa-mist border-2 border-desa-border text-sm text-desa-dark focus:outline-none focus:ring-2 focus:ring-desa-action"
                    >
                        <option value="">Semua Peran</option>
                        @foreach (\App\Models\User::PERAN as $kode => $label)
                            <option value="{{ $kode }}" @selected($peran === $kode)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <x-button variant="primary" type="submit">Cari</x-button>
                @if ($cari || $peran)
                    <x-button variant="secondary" href="{{ route('admin.kependudukan.user.index') }}">Reset</x-button>
                @endif
            </form>

            <x-button variant="primary" href="{{ route('admin.kependudukan.user.create') }}">
                + Tambah Akun
            </x-button>
        </div>

        @if ($users->isEmpty())
            <x-ui-state
                type="empty"
                title="Akun pengguna tidak ditemukan"
                message="Belum ada akun, atau kata kunci dan filter belum cocok."
                actionLabel="Tambah Akun Baru"
                :actionHref="route('admin.kependudukan.user.create')"
            />
        @else
            <div class="bg-white rounded-2xl border-2 border-desa-border overflow-hidden shadow-xs">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-desa-soft border-b-2 border-desa-border text-xs font-extrabold text-desa-dark">
                                <th class="py-3.5 px-4">No</th>
                                <th class="py-3.5 px-4">Nama</th>
                                <th class="py-3.5 px-4">Email</th>
                                <th class="py-3.5 px-4">Peran</th>
                                <th class="py-3.5 px-4">Data Warga</th>
                                <th class="py-3.5 px-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-blue-200 text-sm">
                            @foreach ($users as $u)
                                <tr class="hover:bg-desa-mist/70 transition-colors">
                                    <td class="py-3.5 px-4 font-mono">{{ $users->firstItem() + $loop->index }}</td>
                                    <td class="py-3.5 px-4">
                                        <span class="font-bold text-desa-dark">{{ $u->name }}</span>
                                        @if ($u->is(auth()->user()))
                                            <span class="ml-1 inline-flex px-2 py-0.5 rounded-full text-xs font-bold bg-desa-bright text-desa-dark border border-desa-border">Akun Anda</span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-4 font-mono text-desa-muted">{{ $u->email }}</td>
                                    <td class="py-3.5 px-4">
                                        <span class="inline-flex px-3 py-1 rounded-full text-xs font-bold bg-desa-soft text-desa-dark border border-desa-border">
                                            {{ \App\Models\User::PERAN[$u->role] ?? $u->role }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 text-desa-dark">
                                        {{ $u->warga?->nama_lengkap ?? '-' }}
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <div class="flex justify-end gap-2">
                                            <a
                                                href="{{ route('admin.kependudukan.user.edit', $u) }}"
                                                class="min-h-[44px] inline-flex items-center px-3 py-1.5 rounded-lg bg-desa-soft text-desa-dark border border-desa-border text-xs font-bold hover:bg-desa-bright"
                                            >
                                                Ubah
                                            </a>
                                            @unless ($u->is(auth()->user()))
                                                <form
                                                    method="POST"
                                                    action="{{ route('admin.kependudukan.user.destroy', $u) }}"
                                                    onsubmit="return confirm('Hapus akun {{ e($u->email) }}? Tindakan ini tidak bisa dibatalkan.')"
                                                >
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        type="submit"
                                                        class="min-h-[44px] px-3 py-1.5 rounded-lg bg-red-100 text-red-950 border border-red-700 text-xs font-bold hover:bg-red-200"
                                                    >
                                                        Hapus
                                                    </button>
                                                </form>
                                            @endunless
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{ $users->links() }}
        @endif
    </div>
</x-admin-layout>