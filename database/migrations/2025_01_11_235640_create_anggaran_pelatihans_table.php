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
        Schema::create('anggaran_pelatihans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('data_pelatihan_id');
            $table->foreignId('kategori_id');
            $table->foreignId('region_id');
            $table->integer('anggaran_min');
            $table->integer('anggaran_maks');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggaran_pelatihans');
    }
};
