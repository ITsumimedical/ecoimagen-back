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
        Schema::create('configuraciones', function (Blueprint $table) {
            $table->id();
            $table->integer('salario_minimo_actual');
            $table->integer('cuota_moderadora_nivel_1');
            $table->integer('cuota_moderadora_nivel_2');
            $table->integer('cuota_moderadora_nivel_3');
            $table->float('porcentaje_copago_nivel_1');
            $table->float('porcentaje_copago_nivel_2');
            $table->float('porcentaje_copago_nivel_3');
            $table->integer('valor_tope_copago_nivel_1_servicio');
            $table->integer('valor_tope_copago_nivel_2_servicio');
            $table->integer('valor_tope_copago_nivel_3_servicio');
            $table->integer('valor_tope_copago_nivel_1_anio');
            $table->integer('valor_tope_copago_nivel_2_anio');
            $table->integer('valor_tope_copago_nivel_3_anio');
            $table->integer('porcentaje_copago_subsidiado');
            $table->integer('valor_tope_copago_subsidiado_servicio');
            $table->integer('valor_tope_copago_subsidiado_anio');
            $table->date('fecha_inicio_habilitacion_validador_202');
            $table->date('fecha_fin_habilitacion_validador_202');
            $table->integer('excepcion_habilitacion_validador_202');
            $table->integer('dia_inicio_habilitacion_validador_rips');
            $table->integer('dia_final_habilitacion_validador_rips');
            $table->boolean('excepcion_habilitacion_validador_rips');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configuracions');
    }
};
