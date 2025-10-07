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
        Schema::create('registro_escala_abreviada_desarrollos', function (Blueprint $table) {
            $table->id();
            $table->integer('punto_inicio_motricidad_gruesa')->nullable();
            $table->integer('puntuacion_directa_motricidad_gruesa')->nullable();
            $table->integer('punto_inicio_motricidad_finoadaptativa')->nullable();
            $table->integer('puntuacion_directa_motricidad_finoadaptativa')->nullable();
            $table->integer('punto_inicio_audicion_lenguaje')->nullable();
            $table->integer('puntuacion_directa_audicion_lenguaje')->nullable();
            $table->integer('punto_inicio_persona_social')->nullable();
            $table->integer('puntuacion_directa_persona_social')->nullable();
            $table->foreignId('consulta_id')->constrained('consultas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_escala_abreviada_desarrollos');
    }
};
