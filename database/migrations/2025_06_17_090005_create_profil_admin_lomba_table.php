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
        Schema::create('profil_admin_lomba', function (Blueprint $table) {
            $table->id('id_profil_admin_lomba');

            // id user
            $table->unsignedBigInteger('id_user')->unique();
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            
            // alamat
            $table->string('alamat')->nullable();
            
            // jenis organisasi
            $table->enum('jenis_organisasi', ['Perusahaan', 'Mahasiswa', 'Lainnya'])->default('Perusahaan');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil_admin_lomba');
    }
};
