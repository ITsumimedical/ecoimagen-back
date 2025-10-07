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
        Schema::table('afiliados', function (Blueprint $table) {
            $table->string('grupo_sanguineo')->nullable();
            $table->string('estrato')->nullable();
            $table->string('tipo_vivienda')->nullable();
            $table->string('zona_vivienda')->nullable();
            $table->string('numero_habitaciones')->nullable();
            $table->string('numero_miembros')->nullable();
            $table->string('acceso_vivienda')->nullable();
            $table->string('seguridad_vivienda')->nullable();
            $table->string('vivienda')->nullable();
            $table->string('agua_potable')->nullable();
            $table->string('preparacion_alimentos')->nullable();
            $table->string('energia_electrica')->nullable();
            $table->string('nivel_educativo')->nullable();
            $table->string('ocupacion')->nullable();
            $table->string('donde_labora')->nullable();
            $table->string('estado_civil')->nullable();
            $table->string('etnia')->nullable();
            $table->string('religion')->nullable();
            $table->string('orientacion_sexual')->nullable();
            $table->string('identidad_genero')->nullable();
            $table->string('nombre_acompanante')->nullable();
            $table->string('telefono_acompanante')->nullable();
            $table->string('nombre_responsable')->nullable();
            $table->string('telefono_responsable')->nullable();
            $table->string('parentesco_responsable')->nullable();
            $table->foreignId('municipio_nacimiento_id')->nullable()->constrained('municipios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('afiliados', function (Blueprint $table) {
            $table->string('grupo_sanguineo')->nullable();
            $table->string('estrato')->nullable();
            $table->string('tipo_vivienda')->nullable();
            $table->string('zona_vivienda')->nullable();
            $table->string('numero_habitaciones')->nullable();
            $table->string('numero_miembros')->nullable();
            $table->string('acceso_vivienda')->nullable();
            $table->string('seguridad_vivienda')->nullable();
            $table->string('vivienda')->nullable();
            $table->string('agua_potable')->nullable();
            $table->string('preparacion_alimentos')->nullable();
            $table->string('energia_electrica')->nullable();
            $table->string('nivel_educativo')->nullable();
            $table->string('ocupacion')->nullable();
            $table->string('donde_labora')->nullable();
            $table->string('estado_civil')->nullable();
            $table->string('etnia')->nullable();
            $table->string('religion')->nullable();
            $table->string('orientacion_sexual')->nullable();
            $table->string('identidad_genero')->nullable();
            $table->string('nombre_acompanante')->nullable();
            $table->string('telefono_acompanante')->nullable();
            $table->string('nombre_responsable')->nullable();
            $table->string('telefono_responsable')->nullable();
            $table->string('parentesco_responsable')->nullable();
            $table->foreignId('municipio_nacimiento_id')->nullable()->constrained('municipios');
        });
    }
};
