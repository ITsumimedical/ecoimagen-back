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
        Schema::create('examen_fisico_fisioterapias', function (Blueprint $table) {
            $table->id();
            $table->string('dolor_presente');
            $table->string('frecuencia_dolo')->nullable();
            $table->string('intensidad_dolor')->nullable();
            $table->string('edema_presente');
            $table->text('ubicacion_edema')->nullable();
            $table->string('sensibilidad_conservada')->nullable();
            $table->string('sensibilidad_alterada')->nullable();
            $table->text('ubicacion_sensibilidad')->nullable();
            $table->string('fuerza_muscular')->nullable();
            $table->text('pruebas_semiologicas')->nullable();
            $table->string('equilibrio_conservado')->nullable();
            $table->string('equilibrio_alterado')->nullable();
            $table->string('marcha_conservada')->nullable();
            $table->string('marcha_alterada')->nullable();
            $table->text('ayudas_externas')->nullable();
            $table->foreignId('consulta_id')->constrained('consultas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('examen_fisico_fisioterapias');
    }
};
