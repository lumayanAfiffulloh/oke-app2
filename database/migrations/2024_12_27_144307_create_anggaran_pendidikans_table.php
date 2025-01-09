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
        Schema::create('anggaran_pendidikans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jenjang_id');
            $table->string('region');
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
        Schema::dropIfExists('anggaran_pendidikans');
    }
};
