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
        Schema::create('data_pegawais', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nppu')->unique();
            $table->string('status');
            $table->foreignId('pendidikan_terakhir_id');
            $table->string('jenis_kelamin');
            $table->string('nomor_telepon')->nullable();
            $table->string('foto')->nullable();
            $table->foreignId('unit_kerja_id');
            $table->foreignId('jabatan_id');
            $table->foreignId('user_id');
            $table->foreignId('kelompok_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_pegawais');
    }
};
