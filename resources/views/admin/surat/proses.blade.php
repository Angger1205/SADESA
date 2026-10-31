<x-admin-layout title="Verifikasi Berkas & Keputusan Surat" activeMenu="surat">
    @php
        $dataTambahan = $surat->data_tambahan ?? $surat->data_isian ?? [];
        $berkasLampiran = $surat->berkas_lampiran ?? [];
        $pejabatTerpilih = old('aparatur_id', $surat->aparatur_id ?? $surat->ttd_aparatur_id ?? ($aparaturs->first()->id ?? ''));
        $metodeTtdTerpilih = old('tipe_ttd', $surat->tipe_ttd ?? 'qrcode');
        $alasanTolak = old('alasan_penolakan', $surat->alasan_penolakan ?? $surat->catatan_admin);
        $pejabatAktif = $surat->aparatur ?? $surat->ttdAparatur;
    @endphp

    <div class="space-y-6">
        <!-- Bar Navigasi Detail Surat (Seragam dengan Detail Surat di Portal Warga) -->
        <div class="bg-white rounded-2xl border-2 border-desa-border p-4 sm:p-5 flex flex-wrap items-center justify-between gap-4">
            <div>
                <a href="{{ route('admin.surat.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-desa-action hover:underline mb-1">
                    &larr; Kembali ke Daftar Antrean E-Surat
                </a>
                <h2 class="text-xl sm:text-2xl font-extrabold text-desa-dark">
                    [Kode {{ $surat->jenisSurat->kode_surat ?? '-' }}] {{ $surat->jenisSurat->nama_surat ?? 'Surat Pengantar' }}
                </h2>
                <p class="text-xs font-mono text-desa-muted mt-0.5">
                    ID Permohonan: #SRT-{{ str_pad((string) $surat->id, 4, '0', STR_PAD_LEFT) }} &bull; Pemohon: {{ $surat->warga->nama_lengkap ?? '-' }} (NIK: {{ $surat->warga->nik ?? '-' }})
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-2.5">
                <a
                    href="{{ route('admin.surat.cetak', $surat->id) }}"
                    target="_blank"
                    class="min-h-[44px] inline-flex items-center px-5 py-2.5 rounded-lg bg-desa-action text-white text-xs font-extrabold hover:bg-desa-dark transition-colors"
                >
                    Preview / Cetak Surat (PDF A4)
                </a>
                @if ($surat->qr_token)
                    <a
                        href="{{ route('surat.verifikasi', $surat->qr_token) }}"
                        target="_blank"
                        class="min-h-[44px] inline-flex items-center px-4 py-2.5 rounded-lg bg-white text-desa-dark border-2 border-desa-border text-xs font-bold hover:bg-desa-soft transition-colors"
                    >
                        Halaman Validasi QR Publik
                    </a>
                @endif
            </div>
        </div>

        @if (session('success'))
            <div class="rounded-xl border-2 border-emerald-700 bg-emerald-50 p-4 text-emerald-950 text-sm font-semibold" role="status">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded-xl border-2 border-red-700 bg-red-50 p-4 text-red-950 text-xs font-semibold" role="alert">
                <p class="font-bold text-sm mb-1">Periksa kembali data keputusan:</p>
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Banner Status Real-Time (Seragam dengan Komponen Status di Portal Warga) -->
        @if (in_array($surat->status, ['disetujui', 'selesai']))
            <div class="rounded-2xl border-2 border-emerald-700 bg-emerald-50 p-5 text-emerald-950 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="space-y-1">
                    <span class="inline-block px-2.5 py-0.5 rounded bg-emerald-700 text-white text-xs font-bold">
                        STATUS: DISETUJUI &amp; SIAP CETAK
                    </span>
                    <h3 class="text-lg font-extrabold">
                        Surat Telah Disahkan oleh {{ $pejabatAktif->jabatan ?? 'Kepala Desa Pabelan' }}
                    </h3>
                    <p class="text-xs">
                        Nomor Surat Resmi: <strong class="font-mono">{{ $surat->nomor_surat }}</strong> &bull;
                        Penandatangan: <strong>{{ $pejabatAktif->nama ?? 'Kepala Desa Pabelan' }}</strong> &bull;
                        Metode TTD: <strong>{{ $surat->tipe_ttd === 'qrcode' ? 'QR Code Elektronik' : 'Tanda Tangan Basah' }}</strong>
                    </p>
                </div>
                <a
                    href="{{ route('admin.surat.cetak', $surat->id) }}"
                    target="_blank"
                    class="shrink-0 min-h-[44px] inline-flex items-center justify-center px-5 py-2.5 rounded-xl bg-emerald-800 text-white text-xs font-extrabold hover:bg-emerald-950 transition-colors"
                >
                    Cetak Dokumen A4
                </a>
            </div>
        @elseif ($surat->status === 'ditolak')
            <div class="rounded-2xl border-2 border-red-700 bg-red-50 p-5 text-red-950 space-y-1">
                <span class="inline-block px-2.5 py-0.5 rounded bg-red-700 text-white text-xs font-bold">
                    STATUS: PERMOHONAN DITOLAK
                </span>
                <h3 class="text-lg font-extrabold">
                    Permohonan Dikembalikan kepada Warga untuk Diperbaiki
                </h3>
                <p class="text-sm font-semibold">
                    Alasan Penolakan: "{{ $alasanTolak ?: 'Berkas persyaratan belum lengkap atau kurang jelas.' }}"
                </p>
            </div>
        @else
            <div class="rounded-2xl border-2 border-amber-600 bg-amber-50 p-5 text-amber-950 space-y-1">
                <span class="inline-block px-2.5 py-0.5 rounded bg-amber-600 text-white text-xs font-bold">
                    STATUS: MENUNGGU KEPUTUSAN APARATUR / KEPALA DESA
                </span>
                <h3 class="text-lg font-extrabold">
                    Periksa Kelengkapan Biodata dan Berkas Lampiran Sebelum Memberikan Pengesahan (ACC)
                </h3>
                <p class="text-xs">
                    Pastikan berkas KTP-el, Kartu Keluarga, dan dokumen pendukung telah sesuai sebelum menerbitkan nomor surat resmi Desa Pabelan.
                </p>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            <!-- KOLOM KIRI (7 KOLOM): DATA PEMOHON, ISIAN KHUSUS, & PREVIEW BERKAS LAMPIRAN -->
            <div class="lg:col-span-7 space-y-6">
                <!-- 1. Biodata Lengkap Pemohon -->
                <div class="bg-white rounded-2xl border-2 border-desa-border p-6 space-y-4">
                    <div class="flex items-center justify-between pb-3 border-b-2 border-desa-soft">
                        <h3 class="text-base font-extrabold text-desa-dark">
                            1. Biodata Kependudukan Pemohon
                        </h3>
                        <span class="px-2.5 py-1 rounded bg-desa-soft text-desa-dark border border-desa-border text-xs font-bold">
                            Status Surat: {{ strtoupper($surat->status) }}
                        </span>
                    </div>

                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                        <div class="p-3 rounded-lg bg-desa-mist border border-blue-200">
                            <dt class="text-xs font-bold text-desa-muted">Nama Lengkap</dt>
                            <dd class="font-extrabold text-desa-dark mt-0.5">{{ $surat->warga->nama_lengkap ?? '-' }}</dd>
                        </div>
                        <div class="p-3 rounded-lg bg-desa-mist border border-blue-200">
                            <dt class="text-xs font-bold text-desa-muted">NIK / No. KK</dt>
                            <dd class="font-mono font-bold text-desa-dark mt-0.5">{{ $surat->warga->nik ?? '-' }} / {{ $surat->warga->kartuKeluarga->no_kk ?? '-' }}</dd>
                        </div>
                        <div class="p-3 rounded-lg bg-desa-mist border border-blue-200">
                            <dt class="text-xs font-bold text-desa-muted">Tempat, Tgl Lahir</dt>
                            <dd class="font-semibold text-desa-dark mt-0.5">
                                {{ $surat->warga->tempat_lahir ?? '-' }}, {{ $surat->warga && $surat->warga->tanggal_lahir ? $surat->warga->tanggal_lahir->format('d-m-Y') : '-' }}
                            </dd>
                        </div>
                        <div class="p-3 rounded-lg bg-desa-mist border border-blue-200">
                            <dt class="text-xs font-bold text-desa-muted">Jenis Kelamin / Agama / Pekerjaan</dt>
                            <dd class="font-semibold text-desa-dark mt-0.5">
                                {{ $surat->warga->jenis_kelamin ?? '-' }} &bull; {{ $surat->warga->agama ?? '-' }} &bull; {{ $surat->warga->pekerjaan ?? '-' }}
                            </dd>
                        </div>
                        <div class="sm:col-span-2 p-3 rounded-lg bg-desa-mist border border-blue-200">
                            <dt class="text-xs font-bold text-desa-muted">Alamat Domisili KK</dt>
                            <dd class="font-semibold text-desa-dark mt-0.5">
                                {{ $surat->warga->kartuKeluarga->alamat ?? '-' }}, RT {{ $surat->warga->kartuKeluarga->rt ?? '00' }}/RW {{ $surat->warga->kartuKeluarga->rw ?? '00' }}, {{ $surat->warga->kartuKeluarga->dusun ?? 'Dusun Krajan' }}, Desa Pabelan
                            </dd>
                        </div>
                        <div class="sm:col-span-2 p-3 rounded-lg bg-desa-soft border border-desa-border">
                            <dt class="text-xs font-bold text-desa-action">Keperluan Pengajuan</dt>
                            <dd class="font-bold text-desa-dark mt-0.5">{{ $surat->keperluan }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- 2. Data Tambahan Khusus -->
                <div class="bg-white rounded-2xl border-2 border-desa-border p-6 space-y-4">
                    <h3 class="text-base font-extrabold text-desa-dark pb-3 border-b-2 border-desa-soft">
                        2. Data Isian Tambahan Khusus ({{ $surat->jenisSurat->nama_surat ?? '-' }})
                    </h3>

                    @if (!empty($dataTambahan))
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                            @foreach ($dataTambahan as $key => $val)
                                <div class="p-3 rounded-lg bg-desa-mist border border-blue-200">
                                    <dt class="text-xs font-bold text-desa-muted">{{ ucwords(str_replace('_', ' ', $key)) }}</dt>
                                    <dd class="font-bold text-desa-dark mt-0.5">{{ is_array($val) ? implode(', ', $val) : $val }}</dd>
                                </div>
                            @endforeach
                        </dl>
                    @else
                        <p class="text-xs text-desa-muted">Tidak ada field tambahan khusus pada pengajuan ini.</p>
                    @endif
                </div>

                <!-- 3. Pemeriksaan & Preview Berkas Lampiran -->
                <div class="bg-white rounded-2xl border-2 border-desa-border p-6 space-y-4">
                    <h3 class="text-base font-extrabold text-desa-dark pb-3 border-b-2 border-desa-soft">
                        3. Pemeriksaan Berkas Persyaratan Warga
                    </h3>

                    @if (!empty($berkasLampiran))
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach ($berkasLampiran as $key => $info)
                                @php
                                    $label = is_array($info) ? ($info['label'] ?? ucwords(str_replace('_', ' ', $key))) : ucwords(str_replace('_', ' ', $key));
                                    $path = is_array($info) ? ($info['path'] ?? null) : $info;
                                    $mime = is_array($info) ? ($info['mime_type'] ?? '') : '';
                                    $isImage = str_starts_with((string) $mime, 'image/') || preg_match('/\.(jpg|jpeg|png)$/i', (string) $path);
                                @endphp
                                <div class="rounded-xl border-2 border-desa-border bg-desa-mist p-3.5 flex flex-col justify-between gap-3">
                                    <div>
                                        <span class="inline-block px-2 py-0.5 rounded bg-desa-soft text-desa-dark text-[11px] font-mono font-bold mb-1">
                                            {{ $key }}
                                        </span>
                                        <p class="text-xs font-extrabold text-desa-dark">{{ $label }}</p>
                                    </div>

                                    @if ($path && $isImage)
                                        <a href="{{ asset('storage/' . $path) }}" target="_blank" class="block rounded-lg overflow-hidden border border-desa-border bg-white">
                                            <img src="{{ asset('storage/' . $path) }}" alt="{{ $label }}" class="w-full h-36 object-cover" />
                                        </a>
                                    @endif

                                    @if ($path)
                                        <a
                                            href="{{ asset('storage/' . $path) }}"
                                            target="_blank"
                                            class="min-h-[38px] inline-flex items-center justify-center px-3 py-1.5 rounded-lg bg-white text-desa-action border border-desa-border text-xs font-bold hover:bg-desa-soft"
                                        >
                                            Buka / Periksa Berkas Asli
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-4 rounded-xl bg-desa-mist border border-desa-border text-xs font-semibold text-desa-muted">
                            Warga belum melampirkan file digital pada pengajuan ini.
                        </div>
                    @endif
                </div>
            </div>

            <!-- KOLOM KANAN (5 KOLOM): PANEL KEPUTUSAN APARATUR / KEPALA DESA (ACC ATAU TOLAK) -->
            <div class="lg:col-span-5 space-y-6">
                <!-- FORM 1: SETUJUI (ACC) & GENERATE QR CODE -->
                <div class="bg-white rounded-2xl border-2 border-desa-border p-6 space-y-4 shadow-xs">
                    <div class="pb-3 border-b-2 border-desa-soft">
                        <span class="inline-block px-2.5 py-0.5 rounded bg-emerald-700 text-white text-xs font-bold mb-1">
                            OPSI KEPUTUSAN 1 (PENGESAHAN)
                        </span>
                        <h3 class="text-lg font-extrabold text-desa-dark">
                            Setujui (ACC) &amp; Terbitkan Surat Resmi
                        </h3>
                        <p class="text-xs text-desa-muted">
                            Konfirmasi Nomor Surat Resmi, pilih Aparatur Penandatangan (Kepala Desa / Sekdes), dan tentukan metode tanda tangan.
                        </p>
                    </div>

                    <form action="{{ route('admin.surat.keputusan', $surat->id) }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="keputusan" value="setujui" />

                        <div>
                            <label for="input-nomor-surat" class="block text-xs font-bold text-desa-dark mb-1">
                                Nomor Surat Resmi Desa Pabelan <span class="text-red-700">*</span>
                            </label>
                            <input
                                id="input-nomor-surat"
                                type="text"
                                name="nomor_surat"
                                value="{{ old('nomor_surat', $rekomendasiNomor) }}"
                                required
                                class="w-full min-h-[44px] px-3.5 py-2 rounded-lg bg-desa-mist border-2 border-desa-border font-mono font-bold text-sm text-desa-dark"
                            />
                            <p class="text-[11px] text-desa-muted mt-1">
                                Format kode surat: <code>{{ $surat->jenisSurat->format_nomor ?? '-' }}</code>
                            </p>
                        </div>

                        <div>
                            <label for="select-aparatur" class="block text-xs font-bold text-desa-dark mb-1">
                                Pejabat / Aparatur Penandatangan <span class="text-red-700">*</span>
                            </label>
                            <select
                                id="select-aparatur"
                                name="aparatur_id"
                                required
                                class="w-full min-h-[44px] px-3.5 py-2 rounded-lg bg-desa-mist border-2 border-desa-border text-sm font-bold text-desa-dark"
                            >
                                @foreach ($aparaturs as $ap)
                                    <option value="{{ $ap->id }}" {{ (string) $pejabatTerpilih === (string) $ap->id ? 'selected' : '' }}>
                                        {{ $ap->jabatan }}: {{ $ap->nama }} (NIP: {{ $ap->nip_niap ?? '-' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <span class="block text-xs font-bold text-desa-dark mb-1.5">
                                Metode Tanda Tangan Pengesahan <span class="text-red-700">*</span>
                            </span>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                                <label class="flex items-start gap-2.5 p-3 rounded-xl border-2 border-desa-border bg-desa-mist cursor-pointer">
                                    <input
                                        type="radio"
                                        name="tipe_ttd"
                                        value="qrcode"
                                        {{ $metodeTtdTerpilih === 'qrcode' ? 'checked' : '' }}
                                        class="mt-1"
                                    />
                                    <span class="text-xs">
                                        <strong class="block font-extrabold text-desa-dark">QR Code Elektronik</strong>
                                        <span class="text-desa-muted">Cetak QR Code validasi otomatis</span>
                                    </span>
                                </label>

                                <label class="flex items-start gap-2.5 p-3 rounded-xl border-2 border-desa-border bg-desa-mist cursor-pointer">
                                    <input
                                        type="radio"
                                        name="tipe_ttd"
                                        value="basah"
                                        {{ $metodeTtdTerpilih === 'basah' ? 'checked' : '' }}
                                        class="mt-1"
                                    />
                                    <span class="text-xs">
                                        <strong class="block font-extrabold text-desa-dark">TTD Basah Manual</strong>
                                        <span class="text-desa-muted">Ruang tanda tangan &amp; stempel</span>
                                    </span>
                                </label>
                            </div>
                        </div>

                        <div>
                            <label for="input-catatan-acc" class="block text-xs font-bold text-desa-dark mb-1">
                                Catatan Pengesahan (Opsional)
                            </label>
                            <input
                                id="input-catatan-acc"
                                type="text"
                                name="catatan_admin"
                                value="{{ old('catatan_admin', 'Berkas lengkap, surat telah disahkan dan siap dicetak.') }}"
                                class="w-full min-h-[44px] px-3.5 py-2 rounded-lg bg-desa-mist border-2 border-desa-border text-xs text-desa-dark"
                            />
                        </div>

                        <button
                            type="submit"
                            class="w-full min-h-[46px] px-5 py-2.5 rounded-xl bg-desa-action text-white font-extrabold text-sm hover:bg-desa-dark transition-colors cursor-pointer"
                        >
                            SETUJUI (ACC) &amp; Terbitkan Surat
                        </button>
                    </form>
                </div>

                <!-- FORM 2: TOLAK PERMOHONAN -->
                <div class="bg-white rounded-2xl border-2 border-desa-border p-6 space-y-4 shadow-xs">
                    <div class="pb-3 border-b-2 border-desa-soft">
                        <span class="inline-block px-2.5 py-0.5 rounded bg-red-700 text-white text-xs font-bold mb-1">
                            OPSI KEPUTUSAN 2 (PENOLAKAN)
                        </span>
                        <h3 class="text-lg font-extrabold text-desa-dark">
                            Tolak Permohonan (Minta Perbaikan Warga)
                        </h3>
                        <p class="text-xs text-desa-muted">
                            Wajib mengisi alasan penolakan secara spesifik agar warga dapat memperbaiki data atau berkas yang salah.
                        </p>
                    </div>

                    <form action="{{ route('admin.surat.keputusan', $surat->id) }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="keputusan" value="tolak" />

                        <div>
                            <label for="input-alasan-tolak" class="block text-xs font-bold text-desa-dark mb-1">
                                Alasan Penolakan / Berkas yang Kurang <span class="text-red-700">*</span>
                            </label>
                            <textarea
                                id="input-alasan-tolak"
                                name="alasan_penolakan"
                                rows="3"
                                required
                                placeholder="Contoh: Foto KTP-el buram/tidak terbaca, mohon unggah ulang foto KTP yang jelas."
                                class="w-full p-3 rounded-lg bg-desa-mist border-2 border-desa-border text-sm text-desa-dark"
                            >{{ $surat->status === 'ditolak' ? $alasanTolak : '' }}</textarea>
                        </div>

                        <button
                            type="submit"
                            class="w-full min-h-[44px] px-5 py-2.5 rounded-xl bg-red-700 text-white font-extrabold text-sm hover:bg-red-900 transition-colors cursor-pointer"
                        >
                            Tolak Permohonan Surat
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
