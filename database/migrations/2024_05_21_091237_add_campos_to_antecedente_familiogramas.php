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
        Schema::table('antecedente_familiogramas', function (Blueprint $table) {
            $table->string('actividad_laboral')->nullable();
            $table->string('alteraciones')->nullable();
            $table->string('descripcion_actividad')->nullable();
            $table->string('historia_repro')->nullable();
            $table->string('paridad')->nullable();
            $table->string('abortos_recurrentes')->nullable();
            $table->string('hemorragia_pos')->nullable();
            $table->string('peso_recien')->nullable();
            $table->string('mortalidad_fetal')->nullable();
            $table->string('trabajo_parto')->nullable();
            $table->string('cirugia_gineco')->nullable();
            $table->string('renal')->nullable();
            $table->string('diabetes_gestacional')->nullable();
            $table->string('diabetes_preconcepcional')->nullable();
            $table->string('hemorragia')->nullable();
            $table->string('semanas_hemorragia')->nullable();
            $table->string('anemia')->nullable();
            $table->string('valor_anemia')->nullable();
            $table->string('embarazo_prolongado')->nullable();
            $table->string('semanas_prolongado')->nullable();
            $table->string('polihidramnios')->nullable();
            $table->string('hiper_arterial')->nullable();
            $table->string('embarazo_multiple')->nullable();
            $table->string('presente_frente')->nullable();
            $table->string('isoinmunizacion')->nullable();
            $table->string('ansiedad_severa')->nullable();
            $table->string('resultadopre')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('antecedente_familiogramas', function (Blueprint $table) {
            $table->string('actividad_laboral')->nullable();
            $table->string('alteraciones')->nullable();
            $table->string('descripcion_actividad')->nullable();
            $table->string('historia_repro')->nullable();
            $table->string('paridad')->nullable();
            $table->string('abortos_recurrentes')->nullable();
            $table->string('hemorragia_pos')->nullable();
            $table->string('peso_recien')->nullable();
            $table->string('mortalidad_fetal')->nullable();
            $table->string('trabajo_parto')->nullable();
            $table->string('cirugia_gineco')->nullable();
            $table->string('renal')->nullable();
            $table->string('diabetes_gestacional')->nullable();
            $table->string('diabetes_preconcepcional')->nullable();
            $table->string('hemorragia')->nullable();
            $table->string('semanas_hemorragia')->nullable();
            $table->string('anemia')->nullable();
            $table->string('valor_anemia')->nullable();
            $table->string('embarazo_prolongado')->nullable();
            $table->string('semanas_prolongado')->nullable();
            $table->string('polihidramnios')->nullable();
            $table->string('hiper_arterial')->nullable();
            $table->string('embarazo_multiple')->nullable();
            $table->string('presente_frente')->nullable();
            $table->string('isoinmunizacion')->nullable();
            $table->string('ansiedad_severa')->nullable();
            $table->string('resultadopre')->nullable();
        });
    }
};
