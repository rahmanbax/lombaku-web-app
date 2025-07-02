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
        Schema::create('lomba', function (Blueprint $table) {
            $table->id('id_lomba');
            $table->string('foto_lomba');
            $table->string('nama_lomba');
            $table->text('deskripsi');
            $table->string('deskripsi_pengumpulan');
            $table->enum('jenis_lomba', ['individu', 'kelompok'])->default('individu');
            $table->enum('lokasi', ['online', 'offline'])->default('online');
            $table->string('lokasi_offline')->nullable();
            $table->enum('tingkat', ['nasional', 'internasional', 'internal'])->default('nasional');
            $table->enum('status', ['belum disetujui', 'ditolak', 'disetujui', 'berlangsung', 'selesai'])->default('belum disetujui');
            $table->string('alasan_penolakan')->nullable();
            $table->date('tanggal_akhir_registrasi');
            $table->date('tanggal_mulai_lomba');
            $table->date('tanggal_selesai_lomba');
            $table->string('penyelenggara')->nullable();

            // Kolom baru untuk mengecek kebutuhan pembimbing
            $table->boolean('butuh_pembimbing')->default(false);

            // foreign key ke id_pembuat
            $table->unsignedBigInteger('id_pembuat');
            $table->foreign('id_pembuat')->references('id_user')->on('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lomba');
    }
};
