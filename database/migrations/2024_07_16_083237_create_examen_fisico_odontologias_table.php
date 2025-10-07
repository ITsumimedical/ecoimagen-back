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
        Schema::create('examen_fisico_odontologias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consulta_id')->constrained('consultas');
            $table->text('asimetria')->nullable();
            $table->text('lunares_manchas_tatuajes')->nullable();
            $table->text('aumento_volumen')->nullable();
            $table->text('ganglios_linfaticos')->nullable();
            $table->text('senos_maxilares')->nullable();
            $table->text('ruidos')->nullable();
            $table->text('chasquidos')->nullable();
            $table->text('crepitaciones')->nullable();
            $table->text('bloqueo_mandibular')->nullable();
            $table->text('dolor')->nullable();
            $table->text('apertura_cierre')->nullable();
            $table->text('labio_inferior')->nullable();
            $table->text('labio_superior')->nullable();
            $table->text('comisuras')->nullable();
            $table->text('mucosa_oral')->nullable();
            $table->text('carrillos')->nullable();
            $table->text('surcos_yugales')->nullable();
            $table->text('frenillos')->nullable();
            $table->text('orofaringe')->nullable();
            $table->text('paladar')->nullable();
            $table->text('glandulas_salivares')->nullable();
            $table->text('piso_boca')->nullable();
            $table->text('dorso_lengua')->nullable();
            $table->text('vientre_lengua')->nullable();
            $table->text('musculos_masticadores')->nullable();
            $table->text('riesgo_caidas')->nullable();
            $table->text('otros')->nullable();
            $table->text('masticacion')->nullable();
            $table->text('deglucion')->nullable();
            $table->text('habla')->nullable();
            $table->text('fonacion')->nullable();
            $table->string('relaciones_molares')->nullable();
            $table->string('relaciones_caninas')->nullable();
            $table->string('relacion_interdental')->nullable();
            $table->string('tipo_oclusion')->nullable();
            $table->text('apiñamiento')->nullable();
            $table->text('mordida_abierta')->nullable();
            $table->text('mordida_profunda')->nullable();
            $table->text('mordida_cruzada')->nullable();
            $table->text('discrepancias_oseas')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('examen_fisico_odontologias');
    }
};
