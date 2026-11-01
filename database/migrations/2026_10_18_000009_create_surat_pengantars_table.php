<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_pengantars', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat', 100)->nullable()->unique();
            $table->foreignId('warga_id')
                ->constrained('wargas')
                ->cascadeOnDelete();
            $table->foreignId('jenis_surat_id')
                ->constrained('jenis_surats')
                ->restrictOnDelete();
            $table->foreignId('aparatur_id')
                ->nullable()
                ->constrained('aparaturs')
                ->nullOnDelete();
            $table->foreignId('ttd_aparatur_id')
                ->nullable()
                ->constrained('aparaturs')
                ->nullOnDelete();
            $table->foreignId('diproses_oleh')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->text('keperluan');
            $table->json('data_tambahan')->nullable(); // Isian field dinamis sesuai JenisSurat
            $table->json('data_isian')->nullable(); // Alias kompatibilitas isian formulir
            $table->json('berkas_lampiran')->nullable(); // Path berkas syarat umum (KTP, KK, Pengantar RT) & syarat khusus
            $table->string('file_lampiran')->nullable();
            $table->string('file_surat_selesai')->nullable();
            $table->string('status', 30)->default('pending'); // pending, diproses, disetujui, ditolak
            $table->text('alasan_penolakan')->nullable();
            $table->text('catatan_admin')->nullable();
            $table->string('tipe_ttd', 20)->default('qrcode'); // qrcode, basah
            $table->string('qr_token', 64)->nullable()->unique();
            $table->dateTime('tanggal_pengajuan')->nullable();
            $table->dateTime('tanggal_disetujui')->nullable();
            $table->dateTime('tanggal_selesai')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_pengantars');
    }
};
