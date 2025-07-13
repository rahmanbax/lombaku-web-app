<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id();

            // Foreign key ke pengguna penerima notifikasi
            $table->foreignId('id_user')->constrained('users', 'id_user')->onDelete('cascade');

            // Tipe notifikasi untuk membedakan logika di frontend
            $table->enum('tipe', [
                // Notifikasi untuk Kemahasiswaan/Admin Prodi
                'PENGAJUAN_LOMBA_BARU', // Pengajuan lomba baru dari admin lomba

                // Notifikasi untuk Admin Lomba
                'LOMBA_DISETUJUI',
                'LOMBA_DITOLAK',
                'PENDAFTAR_BARU',

                // Notifikasi untuk Dosen Pembimbing
                'PENGAJUAN_BIMBINGAN',

                // Notifikasi untuk Mahasiswa
                'PENDAFTARAN_DISETUJUI_PEMBIMBING',
                'PENDAFTARAN_DITOLAK_PEMBIMBING',
                'PENDAFTARAN_DISETUJUI_PANITIA', // Diterima oleh Kemahasiswaan/Admin Lomba
                'PENDAFTARAN_DITOLAK_PANITIA',
                'LOMBA_DIBATALKAN',
            ]);

            $table->string('judul');
            $table->text('pesan');

            // Menyimpan ID terkait untuk membuat link atau aksi
            $table->json('data')->nullable();

            $table->timestamp('dibaca_pada')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifikasi');
    }
};
