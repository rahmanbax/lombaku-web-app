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
        Schema::create('rekognisi', function (Blueprint $table) {
            // Kolom Primary Key standar Laravel
            $table->id();

            // Kunci Asing (Foreign Key) yang menghubungkan rekognisi ini ke prestasi tertentu.
            // Ini adalah kolom yang sangat penting untuk integritas data.
            $table->unsignedBigInteger('id_prestasi');
            $table->foreign('id_prestasi')->references('id_prestasi')->on('prestasi')->onDelete('cascade');

            // Nama mata kuliah yang direkognisi.
            $table->string('mata_kuliah');

            // Jenis rekognisi yang diberikan. Enum untuk membatasi pilihan.
            // Anda bisa menyesuaikan pilihan ini sesuai kebutuhan.
            $table->string('jenis_rekognisi');

            // Bobot nilai dalam bentuk SKS (Satuan Kredit Semester) atau poin.
            // Menggunakan unsignedInteger karena bobot tidak mungkin negatif.
            $table->string('bobot_nilai');

            // Timestamps standar (created_at dan updated_at)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekognisi');
    }
};