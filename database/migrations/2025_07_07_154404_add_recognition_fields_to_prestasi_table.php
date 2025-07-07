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
        Schema::table('prestasi', function (Blueprint $table) {
            // Kolom ini akan menyimpan status rekognisi untuk prestasi INTERNAL.
            $table->enum('status_rekognisi', ['menunggu', 'disetujui', 'ditolak'])->nullable()->after('status_verifikasi');

            // Kolom ini akan menautkan prestasi eksternal hasil rekognisi ke prestasi internal aslinya.
            $table->unsignedBigInteger('id_prestasi_internal_sumber')->nullable()->after('id_prestasi');
            $table->foreign('id_prestasi_internal_sumber')->references('id_prestasi')->on('prestasi')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prestasi', function (Blueprint $table) {
            $table->dropForeign(['id_prestasi_internal_sumber']);
            $table->dropColumn('id_prestasi_internal_sumber');
            $table->dropColumn('status_rekognisi');
        });
    }
};