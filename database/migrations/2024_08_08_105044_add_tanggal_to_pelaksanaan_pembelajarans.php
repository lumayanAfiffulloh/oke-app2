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
        Schema::table('pelaksanaan_pembelajarans', function (Blueprint $table) {
            $table->date('tanggal_pelaksanaan')->after('rencana_pembelajaran_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pelaksanaan_pembelajarans', function (Blueprint $table) {
            $table->dropColumn('tanggal_pelaksanaan');
        });
    }
};
