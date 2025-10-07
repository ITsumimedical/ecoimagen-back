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
        Schema::table('gestiones_telesaluds', function (Blueprint $table) {
            $table->foreignId('finalidad_consulta_id')->nullable()->constrained('finalidad_consultas');
            $table->foreignId('causa_externa_id')->nullable()->constrained('consulta_causa_externas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gestiones_telesaluds', function (Blueprint $table) {
            $table->dropForeign(['finalidad_consulta_id']);
            $table->dropForeign(['causa_externa_id']);
            $table->dropColumn('finalidad_consulta_id');
            $table->dropColumn('causa_externa_id');
        });
    }
};
