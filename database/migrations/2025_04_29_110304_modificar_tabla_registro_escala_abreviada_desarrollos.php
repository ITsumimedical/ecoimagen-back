<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('registro_escala_abreviada_desarrollos', function (Blueprint $table) {
            $table->integer('puntuacion_total_motricidad_gruesa')->nullable();
            $table->integer('puntuacion_total_motricidad_finoadaptativa')->nullable();
            $table->integer('puntuacion_total_audicion_lenguaje')->nullable();
            $table->integer('puntuacion_total_persona_social')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registro_escala_abreviada_desarrollos', function (Blueprint $table) {
            $table->dropColumn([
                'puntuacion_total_motricidad_gruesa',
                'puntuacion_total_motricidad_finoadaptativa',
                'puntuacion_total_audicion_lenguaje',
                'puntuacion_total_persona_social',
            ]);
        });
    }
};
