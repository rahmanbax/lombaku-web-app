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
        Schema::create('daftar_tag', function (Blueprint $table) {
            $table->id('id_daftar_tag');

            // foreign key ke id lomba
            $table->unsignedBigInteger('id_lomba');
            $table->foreign('id_lomba')->references('id_lomba')->on('lomba');

            // foreign key ke id tag
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
        Schema::dropIfExists('daftar_tag');
    }
};
