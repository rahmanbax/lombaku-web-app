<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('prestasi', function (Blueprint $table) {
            $table->id('id_prestasi');

            // Mahasiswa yang meraih prestasi (bisa jadi ketua tim atau perorangan)
            $table->foreignId('id_user')->constrained('users', 'id_user')->onDelete('cascade');

            // Kolom untuk membedakan jenis prestasi
            $table->enum('lomba_dari', ['internal', 'eksternal'])->default('internal');
            $table->enum('tipe_prestasi', ['pemenang', 'peserta'])->default('peserta');

            // --- Kolom untuk Prestasi Internal ---
            // Lomba dari dalam sistem
            $table->foreignId('id_lomba')->nullable()->constrained('lomba', 'id_lomba')->onDelete('set null');

            // --- PERUBAHAN DIMULAI DI SINI ---
            // Menambahkan foreign key ke tabel tim, bisa NULL jika prestasi perorangan.
            // Sama seperti pada tabel registrasi_lomba.
            $table->foreignId('id_tim')->nullable()->constrained('tim', 'id_tim')->onDelete('set null');
            // --- AKHIR PERUBAHAN ---

            // --- Kolom untuk Prestasi Eksternal ---
            $table->string('nama_lomba_eksternal')->nullable();
            $table->string('penyelenggara_eksternal')->nullable();
            $table->enum('tingkat', ['internal', 'nasional', 'internasional'])->nullable();

            // --- Kolom Umum untuk Semua Prestasi ---
            $table->string('peringkat', 100);
            $table->date('tanggal_diraih');
            $table->string('sertifikat_path');

            // --- Kolom Verifikasi ---
            $table->enum('status_verifikasi', ['menunggu', 'disetujui', 'ditolak'])->default('menunggu');
            $table->foreignId('id_verifikator')->nullable()->constrained('users', 'id_user')->onDelete('set null');
            $table->text('catatan_verifikasi')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prestasi');
    }
};