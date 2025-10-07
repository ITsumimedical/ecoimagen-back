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
        Schema::create('ingreso_domiciliarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('afiliado_id')->constrained('afiliados');
            $table->foreignId('orden_id')->constrained('ordenes');
            $table->foreignId('referencia_id')->nullable()->constrained('referencias');
            $table->foreignId('consulta_id')->nullable()->constrained('consultas');
            $table->boolean('vivienda_zona_cobertura')->nullable();
            $table->string('zona_riesgo_accesibilidad')->nullable();
            $table->foreignId('user_criterio_riesgo_id')->constrained('users');
            $table->string('higiene_afiliado')->nullable();
            $table->string('alimentacion_afiliado')->nullable();
            $table->string('telefono_casa')->nullable();
            $table->string('agua_potable')->nullable();
            $table->string('nevera')->nullable();
            $table->string('luz_electrica')->nullable();
            $table->string('unidad_sanitaria')->nullable();
            $table->string('estabilidad_paciente')->nullable();
            $table->string('barthel')->nullable();
            $table->string('karnofsky')->nullable();
            $table->string('plan_manejo')->nullable();
            $table->string('aceptacion_familia')->nullable();
            $table->string('cumple_criterio')->nullable();
            $table->string('programa')->nullable();
            $table->string('observaciones')->nullable();
            $table->foreignId('estado_id')->constrained('estados');
            $table->foreignId('user_ingreso_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingreso_domiciliarios');
    }
};
