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
            $table->foreignId('rumpun_id');
            $table->string('kode')->unique();
            $table->string('nama_pelatihan');
            $table->text('deskripsi')->nullable();
            $table->integer('jp');
            $table->text('materi')->nullable();
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
