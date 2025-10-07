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
        Schema::table('analisis_eventos', function (Blueprint $table) {
            $table->string('administrar_medicamento_evento')->nullable();
            $table->string('factores_explicar_evento')->nullable();
            $table->string('evento_desaparecio_suspender_medicamento')->nullable();
            $table->string('paciente_presenta_misma_reaccion')->nullable();
            $table->string('ampliar_informacion_relacionada_evento')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('analisis_eventos', function (Blueprint $table) {
            $table->dropColumn('administrar_medicamento_evento');
            $table->dropColumn('factores_explicar_evento');
            $table->dropColumn('evento_desaparecio_suspender_medicamento');
            $table->dropColumn('paciente_presenta_misma_reaccion');
            $table->dropColumn('ampliar_informacion_relacionada_evento');
        });
    }
};
