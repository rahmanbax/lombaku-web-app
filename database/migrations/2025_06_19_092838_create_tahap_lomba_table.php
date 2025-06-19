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
        Schema::create('tahap_lomba', function (Blueprint $table) {
            $table->id('id_tahap');

            // Relasi ke tabel lomba
            $table->foreignId('id_lomba')->constrained('lomba', 'id_lomba')->onDelete('cascade');

            $table->string('nama_tahap', 100);
            $table->unsignedTinyInteger('urutan')->default(1);
            $table->text('deskripsi')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tahap_lomba');
    }
};
