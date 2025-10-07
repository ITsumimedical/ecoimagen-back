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
            $table->text('elemento_funcion')->nullable();
            $table->text('modo_fallo')->nullable();
            $table->text('efecto')->nullable();
            $table->integer('npr')->nullable();
            $table->text('acciones_propuestas')->nullable();
            $table->string('causas_esavi')->nullable();
            $table->string('asociacion_esavi')->nullable();
            $table->string('ventana_mayoriesgo')->nullable();
            $table->string('evidencia_asociacioncausal')->nullable();
            $table->string('factores_esavi')->nullable();
            $table->text('evaluacion_causalidad')->nullable();
            $table->string('clasificacion_invima')->nullable();
            $table->string('seriedad')->nullable();
            $table->date('fecha_muerte')->nullable();
            $table->string('farmaco_cinetica')->nullable();
            $table->string('condiciones_farmacocinetica')->nullable();
            $table->string('prescribio_manerainadecuada')->nullable();
            $table->string('medicamento_manerainadecuada')->nullable();
            $table->string('medicamento_entrenamiento')->nullable();
            $table->string('potenciales_interacciones')->nullable();
            $table->string('notificacion_refieremedicamento')->nullable();
            $table->string('problema_biofarmaceutico')->nullable();
            $table->string('deficiencias_sistemas')->nullable();
            $table->string('factores_asociados')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('analisis_eventos', function (Blueprint $table) {
            $table->text('elemento_funcion')->nullable();
            $table->text('modo_fallo')->nullable();
            $table->text('efecto')->nullable();
            $table->integer('npr')->nullable();
            $table->text('acciones_propuestas')->nullable();
            $table->string('causas_esavi')->nullable();
            $table->string('asociacion_esavi')->nullable();
            $table->string('ventana_mayoriesgo')->nullable();
            $table->string('evidencia_asociacioncausal')->nullable();
            $table->string('factores_esavi')->nullable();
            $table->text('evaluacion_causalidad')->nullable();
            $table->string('clasificacion_invima')->nullable();
            $table->string('seriedad')->nullable();
            $table->date('fecha_muerte')->nullable();
            $table->string('farmaco_cinetica')->nullable();
            $table->string('condiciones_farmacocinetica')->nullable();
            $table->string('prescribio_manerainadecuada')->nullable();
            $table->string('medicamento_manerainadecuada')->nullable();
            $table->string('medicamento_entrenamiento')->nullable();
            $table->string('potenciales_interacciones')->nullable();
            $table->string('notificacion_refieremedicamento')->nullable();
            $table->string('problema_biofarmaceutico')->nullable();
            $table->string('deficiencias_sistemas')->nullable();
            $table->string('factores_asociados')->nullable();
        });
    }
};
