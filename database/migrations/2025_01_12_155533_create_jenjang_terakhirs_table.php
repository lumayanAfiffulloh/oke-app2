<?php

use App\Models\JenjangTerakhir;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jenjang_terakhirs', function (Blueprint $table) {
            $table->id();
            $table->string('jenjang_terakhir');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenjang_terakhirs');
    }
};
