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
            $table->string('nama_lomba');
            $table->string('deskripsi');
            $table->string('jenis');
            $table->string('tingkat');
            $table->date('tanggal_akhir_registrasi');
            $table->date('tanggal_mulai_lomba');
            $table->date('tanggal_selesai_lomba');

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
