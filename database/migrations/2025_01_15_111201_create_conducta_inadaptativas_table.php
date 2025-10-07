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
        Schema::create('conducta_inadaptativas', function (Blueprint $table) {
            $table->id();
            $table->boolean('come_unas');
            $table->boolean('succiona_dedos');
            $table->boolean('muerde_labio');
            $table->boolean('sudan_manos');
            $table->boolean('tiemblan_manos');
            $table->boolean('agrege_sin_motivo');
            $table->boolean('se_caen_cosas');
            $table->text('trastornos_comportamiento');
            $table->text('trastornos_emocionales');
            $table->text('juega_solo');
            $table->text('juegos_prefiere');
            $table->text('prefiere_jugar_ninos');
            $table->text('distracciones_hijos');
            $table->text('conductas_juegos');
            $table->text('inicio_escolaridad');
            $table->text('cambio_colegio');
            $table->text('dificultad_aprendizaje');
            $table->text('repeticiones_escolares');
            $table->text('conducta_clase');
            $table->text('materias_mayor_nivel');
            $table->text('materias_menor_nivel');
            $table->foreignId('consulta_id')->constrained('consultas');
            $table->foreignId('creado_por')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conducta_inadaptativas');
    }
};
