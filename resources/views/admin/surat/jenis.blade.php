<x-admin-layout title="Master Jenis Surat & Format Nomor" activeMenu="jenis-surat">
    <div class="space-y-6">
        @if (session('success'))
            <div class="rounded-xl border-2 border-emerald-700 bg-emerald-50 p-4 text-emerald-950 text-sm font-semibold" role="status">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded-xl border-2 border-red-700 bg-red-50 p-4 text-red-950 text-xs font-semibold" role="alert">
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Filter Kategori & Tombol Buka Form Tambah -->
        <div class="bg-white rounded-2xl border-2 border-desa-border p-5 flex flex-wrap items-center justify-between gap-4">
            <div class="flex flex-wrap items-center gap-2">
                <a
                    href="{{ route('admin.surat.jenis') }}"
                    class="min-h-[40px] inline-flex items-center px-3.5 py-1.5 rounded-lg text-xs font-bold border {{ empty($kategoriFilter) ? 'bg-desa-dark text-white border-desa-dark' : 'bg-desa-mist text-desa-dark border-desa-border hover:bg-desa-soft' }}"
                >
                    Semua Kategori (14 Layanan)
                </a>
                @foreach ($daftarKategori as $kat)
                    <a
                        href="{{ route('admin.surat.jenis', ['kategori' => $kat]) }}"
                        class="min-h-[40px] inline-flex items-center px-3.5 py-1.5 rounded-lg text-xs font-bold border {{ $kategoriFilter === $kat ? 'bg-desa-action text-white border-desa-dark' : 'bg-desa-mist text-desa-dark border-desa-border hover:bg-desa-soft' }}"
                    >
                        {{ $kat }}
                    </a>
                @endforeach
            </div>

            <button
                type="button"
                onclick="document.getElementById('panel-tambah-jenis').classList.toggle('hidden')"
                class="min-h-[44px] inline-flex items-center px-4 py-2 rounded-lg bg-desa-action text-white text-xs font-extrabold hover:bg-desa-dark transition-colors cursor-pointer"
            >
                + Tambah Jenis Surat Baru
            </button>
        </div>

        <!-- Form Tambah Master Jenis Surat Baru -->
        <div id="panel-tambah-jenis" class="hidden bg-white rounded-2xl border-2 border-desa-border p-6 space-y-4">
            <h2 class="text-lg font-extrabold text-desa-dark pb-2 border-b-2 border-desa-soft">
                Tambah Master Jenis Surat Baru
            </h2>

            <form action="{{ route('admin.surat.jenis.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-12 gap-4">
                @csrf
                <div class="md:col-span-4">
                    <label class="block text-xs font-bold text-desa-dark mb-1">Kategori Layanan *</label>
                    <select name="kategori" required class="w-full min-h-[44px] px-3 py-2 rounded-lg bg-desa-mist border-2 border-desa-border text-sm text-desa-dark">
                        @foreach ($daftarKategori as $kat)
                            <option value="{{ $kat }}">{{ $kat }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-desa-dark mb-1">Kode Surat *</label>
                    <input type="text" name="kode_surat" required placeholder="Contoh: 470" class="w-full min-h-[44px] px-3 py-2 rounded-lg bg-desa-mist border-2 border-desa-border text-sm font-mono text-desa-dark" />
                </div>

                <div class="md:col-span-6">
                    <label class="block text-xs font-bold text-desa-dark mb-1">Nama Jenis Surat *</label>
                    <input type="text" name="nama_surat" required placeholder="Contoh: Surat Keterangan Domisili" class="w-full min-h-[44px] px-3 py-2 rounded-lg bg-desa-mist border-2 border-desa-border text-sm text-desa-dark" />
                </div>

                <div class="md:col-span-5">
                    <label class="block text-xs font-bold text-desa-dark mb-1">Format Penomoran Surat</label>
                    <input type="text" name="format_nomor" placeholder="470/{NOMOR}/DS-PBL/{BULAN}/{TAHUN}" class="w-full min-h-[44px] px-3 py-2 rounded-lg bg-desa-mist border-2 border-desa-border text-sm font-mono text-desa-dark" />
                </div>

                <div class="md:col-span-7">
                    <label class="block text-xs font-bold text-desa-dark mb-1">Deskripsi Kegunaan</label>
                    <input type="text" name="deskripsi_kegunaan" placeholder="Ringkasan kegunaan surat bagi warga..." class="w-full min-h-[44px] px-3 py-2 rounded-lg bg-desa-mist border-2 border-desa-border text-sm text-desa-dark" />
                </div>

                <div class="md:col-span-6">
                    <label class="block text-xs font-bold text-desa-dark mb-1">Syarat Berkas Tambahan (1 baris per syarat)</label>
                    <textarea name="syarat_tambahan_raw" rows="3" placeholder="Pas foto 3x4&#10;Surat kuasa bermaterai (opsional)" class="w-full p-3 rounded-lg bg-desa-mist border-2 border-desa-border text-xs text-desa-dark"></textarea>
                </div>

                <div class="md:col-span-6">
                    <label class="block text-xs font-bold text-desa-dark mb-1">Input Form Tambahan (format: nama_field|Label|tipe)</label>
                    <textarea name="form_input_tambahan_raw" rows="3" placeholder="nama_usaha|Nama Usaha|text&#10;alamat_lokasi_usaha|Alamat Usaha|textarea" class="w-full p-3 rounded-lg bg-desa-mist border-2 border-desa-border text-xs font-mono text-desa-dark"></textarea>
                </div>

                <div class="md:col-span-12">
                    <label class="block text-xs font-bold text-desa-dark mb-1">Template Narasi Isi Surat</label>
                    <textarea name="template_narasi" rows="2" placeholder="Bahwa yang bersangkutan benar-benar warga Desa Pabelan..." class="w-full p-3 rounded-lg bg-desa-mist border-2 border-desa-border text-xs text-desa-dark"></textarea>
                </div>

                <div class="md:col-span-12 flex items-center justify-between pt-2">
                    <label class="inline-flex items-center gap-2 text-xs font-bold text-desa-dark">
                        <input type="checkbox" name="is_aktif" value="1" checked />
                        <span>Aktifkan layanan surat ini di Portal Warga</span>
                    </label>
                    <button type="submit" class="min-h-[44px] px-5 py-2 rounded-lg bg-desa-action text-white text-xs font-extrabold hover:bg-desa-dark cursor-pointer">
                        Simpan Jenis Surat Baru
                    </button>
                </div>
            </form>
        </div>

        <!-- Daftar 14+ Master Jenis Surat -->
        <div class="space-y-4">
            @foreach ($jenisSurats as $js)
                <div class="bg-white rounded-2xl border-2 border-desa-border p-5 space-y-4">
                    <div class="flex flex-wrap items-start justify-between gap-4">
                        <div class="space-y-1 max-w-3xl">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="px-2.5 py-0.5 rounded bg-desa-dark text-white text-xs font-mono font-bold">
                                    Kode: {{ $js->kode_surat }}
                                </span>
                                <span class="px-2.5 py-0.5 rounded bg-desa-soft text-desa-dark border border-desa-border text-xs font-bold">
                                    {{ $js->kategori }}
                                </span>
                                <span class="px-2.5 py-0.5 rounded text-xs font-bold border {{ $js->is_aktif ? 'bg-emerald-100 text-emerald-950 border-emerald-700' : 'bg-red-100 text-red-950 border-red-700' }}">
                                    {{ $js->is_aktif ? 'Aktif' : 'Nonaktif' }}
                                </span>
                                <span class="text-xs font-mono text-desa-muted">
                                    Format: {{ $js->format_nomor }} &bull; Total Ajuan: {{ $js->surat_pengantars_count }}
                                </span>
                            </div>
                            <h3 class="text-lg font-extrabold text-desa-dark">{{ $js->nama_surat }}</h3>
                            <p class="text-xs text-desa-muted">{{ $js->deskripsi_kegunaan ?? $js->deskripsi }}</p>
                        </div>

                        <div class="flex items-center gap-2">
                            <button
                                type="button"
                                onclick="document.getElementById('edit-jenis-{{ $js->id }}').classList.toggle('hidden')"
                                class="min-h-[40px] px-3.5 py-1.5 rounded-lg bg-desa-soft text-desa-dark border border-desa-border text-xs font-bold hover:bg-desa-bright cursor-pointer"
                            >
                                Edit Konfigurasi
                            </button>
                            <form action="{{ route('admin.surat.jenis.destroy', $js->id) }}" method="POST" onsubmit="return confirm('Hapus atau nonaktifkan jenis surat ini?')">
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="min-h-[40px] px-3.5 py-1.5 rounded-lg bg-red-50 text-red-900 border border-red-600 text-xs font-bold hover:bg-red-100 cursor-pointer"
                                >
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Ringkasan Syarat Khusus & Field Input Dinamis -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-3 border-t border-blue-100 text-xs">
                        <div class="bg-desa-mist p-3.5 rounded-xl border border-blue-200">
                            <p class="font-bold text-desa-dark mb-1.5">Syarat Berkas Khusus ({{ is_array($js->syarat_tambahan) ? count($js->syarat_tambahan) : 0 }} dokumen):</p>
                            @if (!empty($js->syarat_tambahan))
                                <ul class="list-disc list-inside space-y-0.5 text-desa-dark">
                                    @foreach ($js->syarat_tambahan as $st)
                                        <li>
                                            {{ $st['label'] ?? '-' }}
                                            <span class="font-semibold text-desa-muted">({{ !empty($st['required']) ? 'Wajib' : 'Opsional' }})</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-desa-muted">Hanya Syarat Dasar Umum (KTP-el, KK, Pengantar RT/RW).</p>
                            @endif
                        </div>

                        <div class="bg-desa-mist p-3.5 rounded-xl border border-blue-200">
                            <p class="font-bold text-desa-dark mb-1.5">Field Input Tambahan ({{ is_array($js->form_input_tambahan) ? count($js->form_input_tambahan) : 0 }} kolom):</p>
                            @if (!empty($js->form_input_tambahan))
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach ($js->form_input_tambahan as $fi)
                                        <span class="px-2 py-0.5 rounded bg-white border border-desa-border font-mono text-[11px] text-desa-dark">
                                            {{ $fi['name'] ?? '-' }} ({{ $fi['type'] ?? 'text' }})
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-desa-muted">Tidak ada field tambahan khusus.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Form Edit Collapsible -->
                    <div id="edit-jenis-{{ $js->id }}" class="hidden pt-4 border-t-2 border-desa-soft">
                        <form action="{{ route('admin.surat.jenis.update', $js->id) }}" method="POST" class="grid grid-cols-1 md:grid-cols-12 gap-4">
                            @csrf
                            @method('PUT')
                            <div class="md:col-span-4">
                                <label class="block text-xs font-bold text-desa-dark mb-1">Kategori</label>
                                <input type="text" name="kategori" value="{{ $js->kategori }}" required class="w-full min-h-[40px] px-3 py-1.5 rounded-lg bg-desa-mist border border-desa-border text-xs text-desa-dark" />
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-desa-dark mb-1">Kode Surat</label>
                                <input type="text" name="kode_surat" value="{{ $js->kode_surat }}" required class="w-full min-h-[40px] px-3 py-1.5 rounded-lg bg-desa-mist border border-desa-border text-xs font-mono text-desa-dark" />
                            </div>
                            <div class="md:col-span-6">
                                <label class="block text-xs font-bold text-desa-dark mb-1">Nama Jenis Surat</label>
                                <input type="text" name="nama_surat" value="{{ $js->nama_surat }}" required class="w-full min-h-[40px] px-3 py-1.5 rounded-lg bg-desa-mist border border-desa-border text-xs text-desa-dark" />
                            </div>
                            <div class="md:col-span-4">
                                <label class="block text-xs font-bold text-desa-dark mb-1">Format Penomoran</label>
                                <input type="text" name="format_nomor" value="{{ $js->format_nomor }}" class="w-full min-h-[40px] px-3 py-1.5 rounded-lg bg-desa-mist border border-desa-border text-xs font-mono text-desa-dark" />
                            </div>
                            <div class="md:col-span-8">
                                <label class="block text-xs font-bold text-desa-dark mb-1">Deskripsi Kegunaan</label>
                                <input type="text" name="deskripsi_kegunaan" value="{{ $js->deskripsi_kegunaan ?? $js->deskripsi }}" class="w-full min-h-[40px] px-3 py-1.5 rounded-lg bg-desa-mist border border-desa-border text-xs text-desa-dark" />
                            </div>
                            <div class="md:col-span-12">
                                <label class="block text-xs font-bold text-desa-dark mb-1">Template Narasi Isi Surat</label>
                                <textarea name="template_narasi" rows="2" class="w-full p-2.5 rounded-lg bg-desa-mist border border-desa-border text-xs text-desa-dark">{{ $js->template_narasi }}</textarea>
                            </div>
                            <div class="md:col-span-12 flex items-center justify-between">
                                <label class="inline-flex items-center gap-2 text-xs font-bold text-desa-dark">
                                    <input type="checkbox" name="is_aktif" value="1" {{ $js->is_aktif ? 'checked' : '' }} />
                                    <span>Status Aktif</span>
                                </label>
                                <button type="submit" class="min-h-[40px] px-4 py-1.5 rounded-lg bg-desa-action text-white text-xs font-bold hover:bg-desa-dark cursor-pointer">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        @if ($jenisSurats->hasPages())
            <div class="p-4 rounded-xl bg-white border-2 border-desa-border">
                {{ $jenisSurats->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>

