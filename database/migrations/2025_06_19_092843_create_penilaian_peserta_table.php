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
        Schema::create('penilaian_peserta', function (Blueprint $table) {
            $table->id('id_penilaian');

            // Relasi ke peserta spesifik di sebuah lomba
            $table->foreignId('id_registrasi_lomba')->constrained('registrasi_lomba', 'id_registrasi_lomba')->onDelete('cascade');

            // Relasi ke tahap lomba yang sedang dinilai
            $table->foreignId('id_tahap')->constrained('tahap_lomba', 'id_tahap')->onDelete('cascade');

            // Relasi ke user yang menjadi penilai/juri
            $table->foreignId('id_penilai')->constrained('users', 'id_user')->onDelete('cascade');

            $table->unsignedInteger('nilai');
            $table->text('catatan')->nullable();

            $table->timestamps();

            // Unique constraint untuk mencegah juri menilai peserta yang sama di tahap yang sama lebih dari sekali
            $table->unique(['id_registrasi_lomba', 'id_tahap', 'id_penilai']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penilaian_peserta');
    }
};
