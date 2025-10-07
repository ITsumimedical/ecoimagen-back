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
        Schema::table('antecedente_ecomapas', function (Blueprint $table) {
            $table->string('orientacion_sex')->nullable();
            $table->string('identidad_genero')->nullable();
            $table->string('identidad_generoTransgenero')->nullable();
            $table->string('Espermarquia')->nullable();
            $table->string('edad_esperma')->nullable();
            $table->string('Menarquia')->nullable();
            $table->string('edad_menarquia')->nullable();
            $table->string('Ciclos')->nullable();
            $table->string('CiclosMnestruales')->nullable();
            $table->string('inicio_sexual')->nullable();
            $table->string('numero_relaciones')->nullable();
            $table->string('activo_sexual')->nullable();
            $table->string('dificultades_relaciones')->nullable();
            $table->string('Descripciondificultad')->nullable();
            $table->string('uso_anticonceptivos')->nullable();
            $table->string('tipo_anticonceptivos')->nullable();
            $table->string('conocimiento_its')->nullable();
            $table->string('sufrido_its')->nullable();
            $table->string('CualIts')->nullable();
            $table->string('fecha_enfermedadIts')->nullable();
            $table->string('TratamientoIts')->nullable();
            $table->string('trasnmision_sexual')->nullable();
            $table->string('derechos_sexuales')->nullable();
            $table->string('decisionesSexRep')->nullable();
            $table->string('victima_identidadgenero')->nullable();
            $table->string('tipo_victimagenero')->nullable();
            $table->string('victima_genero')->nullable();
            $table->string('tipo_victima_violencia_genero')->nullable();
            $table->string('violencia')->nullable();
            $table->string('PresenciaMutilacion')->nullable();
            $table->string('MatrimonioInfantil')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('antecedente_ecomapas', function (Blueprint $table) {
            $table->string('orientacion_sex')->nullable();
            $table->string('identidad_genero')->nullable();
            $table->string('identidad_generoTransgenero')->nullable();
            $table->string('Espermarquia')->nullable();
            $table->string('edad_esperma')->nullable();
            $table->string('Menarquia')->nullable();
            $table->string('edad_menarquia')->nullable();
            $table->string('Ciclos')->nullable();
            $table->string('CiclosMnestruales')->nullable();
            $table->string('inicio_sexual')->nullable();
            $table->string('numero_relaciones')->nullable();
            $table->string('activo_sexual')->nullable();
            $table->string('dificultades_relaciones')->nullable();
            $table->string('Descripciondificultad')->nullable();
            $table->string('uso_anticonceptivos')->nullable();
            $table->string('tipo_anticonceptivos')->nullable();
            $table->string('conocimiento_its')->nullable();
            $table->string('sufrido_its')->nullable();
            $table->string('CualIts')->nullable();
            $table->string('fecha_enfermedadIts')->nullable();
            $table->string('TratamientoIts')->nullable();
            $table->string('trasnmision_sexual')->nullable();
            $table->string('derechos_sexuales')->nullable();
            $table->string('decisionesSexRep')->nullable();
            $table->string('victima_identidadgenero')->nullable();
            $table->string('tipo_victimagenero')->nullable();
            $table->string('victima_genero')->nullable();
            $table->string('tipo_victima_violencia_genero')->nullable();
            $table->string('violencia')->nullable();
            $table->string('PresenciaMutilacion')->nullable();
            $table->string('MatrimonioInfantil')->nullable();
        });
    }
};
