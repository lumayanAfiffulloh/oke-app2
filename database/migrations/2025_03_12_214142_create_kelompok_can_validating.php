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
        Schema::create('kelompok_can_validatings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelompok_id');
            $table->foreignId('rencana_pembelajaran_id');
            $table->string('status');
            $table->string('status_revisi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelompok_can_validatings');
    }
};
