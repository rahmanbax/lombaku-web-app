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
        Schema::create('member_tim', function (Blueprint $table) {
            $table->id('id_member_tim');
            
            // foreign key ke id tim
            $table->unsignedBigInteger('id_tim');
            $table->foreign('id_tim')->references('id_tim')->on('tim');
           
            
            // foreign key ke id mahasiswa
            $table->unsignedBigInteger('id_mahasiswa');
            $table->foreign('id_mahasiswa')->references('id_user')->on('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_tim');
    }
};
