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
        Schema::create('cuestionario_vales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consulta_id')->constrained('consultas');
            $table->string('bajo_peso')->nullable();
            $table->string('nacio_antes')->nullable();
            $table->string('estancia_superior')->nullable();
            $table->string('complicaciones_bebe')->nullable();
            $table->string('descripcion_complicaciones')->nullable();
            $table->string('bebe_diagnosticado')->nullable();
            $table->string('descripcion_diagnosticos')->nullable();
            $table->string('condicion_riesgo_social')->nullable();
            $table->string('descripcion_riesgo_social')->nullable();
            $table->string('dificultad_aprendizaje')->nullable();
            $table->string('descripcion_dificultades')->nullable();
            $table->string('orejas')->nullable();
            $table->string('labios')->nullable();
            $table->string('lengua')->nullable();
            $table->string('nariz')->nullable();
            $table->string('paladar')->nullable();
            $table->string('ojos')->nullable();
            $table->string('dientes')->nullable();
            $table->string('cuello')->nullable();
            $table->string('hombros')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuestionario_vales');
    }
};
