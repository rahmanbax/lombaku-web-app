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
        Schema::create('profil_mahasiswa', function (Blueprint $table) {
            $table->id('id_profil_mahasiswa');

            $table->integer('nim')->unique();

            // id user
            $table->unsignedBigInteger('id_user')->unique();
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');

            // id prodi
            $table->unsignedBigInteger('id_program_studi');
            $table->foreign('id_program_studi')->references('id_program_studi')->on('program_studi')->onDelete('cascade');

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
