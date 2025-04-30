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
        Schema::create('registrasi_lomba', function (Blueprint $table) {
            $table->id('id_registrasi_lomba');
            $table->string('link_pengumpulan');

            // foreign key ke id mahasiswa
            $table->unsignedBigInteger('id_mahasiswa');
            $table->foreign('id_mahasiswa')->references('id_user')->on('users');

            // foreign key ke id lomba
            $table->unsignedBigInteger('id_lomba');
            $table->foreign('id_lomba')->references('id_lomba')->on('lomba');

            // foreign key ke id tim
            $table->unsignedBigInteger('id_tim')->nullable();
            $table->foreign('id_tim')->references('id_tim')->on('tim');

            // foreign key ke id dosen untuk bimbingan
            $table->unsignedBigInteger('id_dosen')->nullable();
            $table->foreign('id_dosen')->references('id_user')->on('users');

            

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrasi_lomba');
    }
};
