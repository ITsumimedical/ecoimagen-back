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
        Schema::table('evento_asignados', function (Blueprint $table) {
            $table->foreignId('accion_mejora_id')->nullable()->constrained('acciones_mejora_eventos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('evento_asignados', function (Blueprint $table) {
            $table->dropForeign(['accion_mejora_id']);
            $table->dropColumn('accion_mejora_id');
        });
    }
};
