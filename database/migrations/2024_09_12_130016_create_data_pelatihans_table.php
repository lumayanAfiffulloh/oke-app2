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
        Schema::create('data_pelatihans', function (Blueprint $table) {
            $table->id();
            $table->enum('kategori', ['klasikal', 'non-klasikal']);
            $table->string('bentuk_jalur');
            $table->string('nama_pelatihan');
            $table->string('min_anggaran');
            $table->string('maks_anggaran');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_pelatihans');
    }
};
