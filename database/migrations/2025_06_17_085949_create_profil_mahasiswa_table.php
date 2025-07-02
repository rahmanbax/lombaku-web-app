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
        // Gunakan Schema::create untuk MEMBUAT tabel baru
        Schema::create('profil_mahasiswa', function (Blueprint $table) {
            // Kolom-kolom dasar
            $table->id('id_profil_mahasiswa');
            $table->integer('nim')->unique();

            // Foreign key ke tabel users
            $table->unsignedBigInteger('id_user')->unique();
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');

            // Foreign key ke tabel program_studi
            $table->unsignedBigInteger('id_program_studi');
            $table->foreign('id_program_studi')->references('id_program_studi')->on('program_studi')->onDelete('cascade');
            
            // --- Kolom-kolom baru yang Anda tambahkan ---
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil_mahasiswa');
    }
};