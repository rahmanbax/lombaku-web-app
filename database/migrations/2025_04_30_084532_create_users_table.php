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
        Schema::create('users', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('nama');
            $table->string('notelp')->nullable();
            $table->string('email')->unique();
            $table->integer('nim_atau_nip')->nullable();
            $table->string('instansi')->nullable();
            $table->enum('role', ['mahasiswa', 'dosen', 'admin_lomba', 'admin_prodi', 'kemahasiswaan'])->default('mahasiswa');
            $table->rememberToken();

            // foreign key ke tabel program_studi
            $table->unsignedBigInteger('id_program_studi')->nullable();
            $table->foreign('id_program_studi')->references('id_program_studi')->on('program_studi');

            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
