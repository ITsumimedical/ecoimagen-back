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
        Schema::create('srqs', function (Blueprint $table) {
            $table->id();
            $table->string('dolor_cabeza_frecuente');
            $table->string('mal_apetito');
            $table->string('duerme_mal');
            $table->string('asusta_facilidad');
            $table->string('temblor_manos');
            $table->string('nervioso_tenso');
            $table->string('mala_digestion');
            $table->string('pensar_claridad');
            $table->string('siente_triste');
            $table->string('llora_frecuencia');
            $table->string('dificultad_disfrutar');
            $table->string('tomar_decisiones');
            $table->string('dificultad_hacer_trabajo');
            $table->string('incapaz_util');
            $table->string('interes_cosas');
            $table->string('inutil');
            $table->string('idea_acabar_vida');
            $table->string('cansado_tiempo');
            $table->string('estomago_desagradable');
            $table->string('cansa_facilidad');
            $table->string('herirlo_forma');
            $table->string('importante_demas');
            $table->string('voces');
            $table->string('convulsiones_ataques');
            $table->string('demasiado_licor');
            $table->string('dejar_beber');
            $table->string('beber_trabajo');
            $table->string('detenido_borracho');
            $table->string('bebia_demasiado');
            $table->foreignId('consulta_id')->constrained('consultas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('srqs');
    }
};
