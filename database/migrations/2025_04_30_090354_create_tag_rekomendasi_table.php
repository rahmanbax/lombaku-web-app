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
        Schema::create('tag_rekomendasi', function (Blueprint $table) {
            $table->id('id_tag_rekomendasi');

            // foreign key ke mahasiswa
            $table->unsignedBigInteger('id_mahasiswa');
            $table->foreign('id_mahasiswa')->references('id_user')->on('users');

            // foreign key ke tag
            $table->unsignedBigInteger('id_tag');
            $table->foreign('id_tag')->references('id_tag')->on('tags');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tag_rekomendasi');
    }
};
