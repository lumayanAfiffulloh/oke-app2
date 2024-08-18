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
        Schema::create('rencana_pembelajarans', function (Blueprint $table) {
            $table->id();
            $table->year('tahun');
            $table->enum('klasifikasi',['pelatihan', 'pendidikan']);
            $table->enum('kategori_klasifikasi', ['gelar', 'non-gelar', 'teknis', 'fungsional', 'sosial kultural']);
            $table->enum('kategori', ['klasikal', 'non-klasikal']);
            $table->string('bentuk_jalur');
            $table->string('nama_pelatihan');
            $table->integer('jam_pelajaran');
            $table->enum('regional', ['nasional', 'internasional']);
            $table->integer('anggaran');
            $table->enum('prioritas', ['rendah', 'sedang', 'tinggi']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rencana_pembelajarans');
    }
};