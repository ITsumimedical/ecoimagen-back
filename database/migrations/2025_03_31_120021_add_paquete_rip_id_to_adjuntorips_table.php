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
        Schema::table('adjuntorips', function (Blueprint $table) {
            $table->foreignId('paquete_rip_id')->nullable()->constrained('paquete_rips');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('adjuntorips', function (Blueprint $table) {
            $table->dropForeign(['paquete_rip_id']);
            $table->dropColumn('paquete_rip_id');
        });
    }
};
