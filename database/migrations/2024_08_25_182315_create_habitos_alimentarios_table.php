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
        Schema::create('habitos_alimentarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consulta_id')->constrained('consultas');
            $table->boolean('lactando_actualmente')->nullable();
            $table->boolean('lactancia_materna_exclusiva')->nullable();
            $table->string('postura_madre_niño')->nullable();
            $table->string('agarre')->nullable();
            $table->string('succion')->nullable();
            $table->boolean('madre_reconoce_hambre_saciedad_bebe')->nullable();
            $table->string('necesidades_madre_lactancia_materna')->nullable();
            $table->boolean('recibio_preparacion_prenatal')->nullable();
            $table->boolean('suministra_leche_hospitalario_neonatal')->nullable();
            $table->string('expectativas_madre_familia')->nullable();
            $table->string('frecuencia_lactancia')->nullable();
            $table->string('duracion_lactancia')->nullable();
            $table->string('dificultades_lactancia_materna')->nullable();
            $table->boolean('madre_extrae_conserva_leche')->nullable();
            $table->string('como_realiza_extraccion_conservacion_leche')->nullable();
            $table->boolean('alimentado_leche_formula')->nullable();
            $table->boolean('inicio_alimentos_agua_otra_bebida')->nullable();
            $table->boolean('durante_dia_ayer_recibio_liquidos')->nullable();
            $table->boolean('durante_dia_recibio_leche')->nullable();
            $table->boolean('durante_dia_recibio_leche_vaca')->nullable();
            $table->boolean('durante_dia_recibio_sopa')->nullable();
            $table->string('edad_meses_diferentes_alimentos')->nullable();
            $table->boolean('consumo_dieta_familiar')->nullable();
            $table->string('cuantas_comidas_dia')->nullable();
            $table->boolean('consumo_5_porciones_frutas')->nullable();
            $table->boolean('dieta_balanceada_baja_azucares')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('habitos_alimentarios');
    }
};
