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
        Schema::create('program_studi', function (Blueprint $table) {
            $table->id('id_program_studi');
            $table->string('nama_program_studi');

            // foreign key ke tabel user
            $table->unsignedBigInteger('id_fakultas');
            $table->foreign('id_fakultas')->references('id_fakultas')->on('fakultas');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_studi');
    }
};
