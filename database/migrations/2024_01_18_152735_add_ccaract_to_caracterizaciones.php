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
        Schema::table('caracterizaciones', function (Blueprint $table) {
            $table->string('estrato')->nullable();
            $table->string('estado_civil')->nullable();
            $table->string('seguridad_orden')->nullable();
            $table->string('tipo_violencia')->nullable();
            $table->string('violencia_sexual')->nullable();
            $table->string('violencia_no_sexual')->nullable();
            $table->string('frecuencia_consumo_sustancias_psicoactivas')->nullable();
            $table->string('frecuencia_consumo_alcohol')->nullable();
            $table->string('conflicto_armado')->nullable();
            $table->string('tipo_conflicto_armado')->nullable();
            $table->string('frecuencia_actividad_fisica')->nullable();
            $table->string('descripcion_Maternoperinatal')->nullable();
            $table->string('descripcion_Nefroproteccion')->nullable();
            $table->string('descripcion_Respiratorias_cronicas')->nullable();
            $table->string('descripcion_Cuidados_paliativos')->nullable();
            $table->string('descripcion_Oncologias')->nullable();
            $table->string('descripcion_Reumatologias')->nullable();
            $table->string('descripcion_Trasmisibles_cronicas')->nullable();
            $table->string('descripcion_enfermedades_huerfanas')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('caracterizaciones', function (Blueprint $table) {
            //
        });
    }
};
