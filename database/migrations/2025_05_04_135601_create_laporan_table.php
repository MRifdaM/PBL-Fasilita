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
        Schema::create('laporan', function (Blueprint $table) {
            $table->id('id_laporan');
            $table->unsignedBigInteger('id_pengguna')->index();
            $table->unsignedBigInteger('id_gedung')->index();
            $table->unsignedBigInteger('id_lantai')->index();
            $table->unsignedBigInteger('id_ruangan')->index();
            $table->timestamps();

            $table->foreign('id_pengguna')->references('id_pengguna')->on('pengguna');
            $table->foreign('id_gedung')->references('id_gedung')->on('gedung');
            $table->foreign('id_lantai')->references('id_lantai')->on('lantai');
            $table->foreign('id_ruangan')->references('id_ruangan')->on('ruangan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};
