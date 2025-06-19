<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('lomba_bookmarks', function (Blueprint $table) {
            // Foreign key yang menunjuk ke tabel 'users'
            // constrained() akan otomatis menggunakan 'id_user' jika primary key di users adalah 'id_user'
            $table->foreignId('id_user')->constrained('users', 'id_user')->onDelete('cascade');

            // Foreign key yang menunjuk ke tabel 'lomba'
            // constrained() akan otomatis menggunakan 'id_lomba' jika primary key di lomba adalah 'id_lomba'
            $table->foreignId('id_lomba')->constrained('lomba', 'id_lomba')->onDelete('cascade');

            // Menjadikan kombinasi id_user dan id_lomba sebagai Primary Key.
            // Ini adalah langkah penting untuk:
            // 1. Mencegah seorang user mem-bookmark lomba yang sama lebih dari sekali.
            // 2. Mempercepat query saat mencari data.
            $table->primary(['id_user', 'id_lomba']);

            // Opsional: Kolom timestamps untuk mengetahui kapan bookmark dibuat.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('lomba_bookmarks');
    }
};