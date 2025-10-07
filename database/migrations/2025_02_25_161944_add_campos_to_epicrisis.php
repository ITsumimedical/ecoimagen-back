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
        Schema::table('epicrisis', function (Blueprint $table) {
            $table->string('peso')->nullable();
            $table->string('talla')->nullable();
            $table->string('tension_arterial')->nullable();
            $table->string('frecuencia_respiratoria')->nullable();
            $table->string('frecuencia_cardiaca')->nullable();
            $table->string('temperatura')->nullable();
            $table->text('aspecto_general')->nullable();
            $table->string('cabeza')->nullable();
            $table->string('abdomen')->nullable();
            $table->string('cuello')->nullable();
            $table->string('torax')->nullable();
            $table->string('snp')->nullable();
            $table->string('ojos')->nullable();
            $table->string('respiratorio')->nullable();
            $table->string('extremidad_superior')->nullable();
            $table->string('oidos')->nullable();
            $table->string('gastrointestinal')->nullable();
            $table->string('extremidad_inferior')->nullable();
            $table->string('boca_garganta')->nullable();
            $table->string('linfatico')->nullable();
            $table->string('funcion_cerebral')->nullable();
            $table->string('piel_mucosa')->nullable();
            $table->string('psicomotor')->nullable();
            $table->string('reflejos')->nullable();
            $table->string('urogenital')->nullable();
            $table->string('snc')->nullable();
            $table->text('evolucion_anterior')->nullable();
            $table->text('impresion_diagnostica')->nullable();
            $table->text('plan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('epicrisis', function (Blueprint $table) {
            $table->dropColumn(['peso', 'talla','tension_arterial','frecuencia_respiratoria','frecuencia_cardiaca','temperatura',
            'aspecto_general','cabeza','abdomen','cuello','torax','snp','ojos','respiratorio','extremidad_superior','oidos',
            'gastrointestinal','extremidad_inferior','boca_garganta','linfatico','funcion_cerebral','piel_mucosa','psicomotor',
            'reflejos','urogenital','snc','evolucion_anterior','impresion_diagnostica','plan']);
        });
    }
};
