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
        Schema::create('universitas_can_approvings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('data_pegawai_id');
            $table->foreignId('rencana_pembelajaran_id');
            $table->string('status');
            $table->string('catatan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('universitas_can_approvings');
    }
};
