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
        Schema::create('zarits', function (Blueprint $table) {
            $table->id();
            $table->string('familia_solicita_ayuda');
            $table->string('dedica_tiempo_familia_no_para_usted');
            $table->string('agobiado_cuidar_familia_responsabilidades');
            $table->string('avergonzado_conducta_familiar');
            $table->string('enfadado_cerca_familiar');
            $table->string('familiar_afecta_relacion_otros');
            $table->string('miedo_futuro_depare');
            $table->string('familiar_depende_usted');
            $table->string('tenso_cerca_familia');
            $table->string('salud_resentida_por_familia');
            $table->string('no_tiene_intimad_por_familiar');
            $table->string('vida_social_resentida');
            $table->string('incomodidad_desatender_amistades');
            $table->string('familiar_espera_que_usted_lo_cuide');
            $table->string('no_posee_suficiente_dinero');
            $table->string('incapaz_cuidar_mas_tiempo');
            $table->string('perdido_control_vida_enfermedad_familiar');
            $table->string('desea_dejar_cuidar');
            $table->string('se_siente_indeciso');
            $table->string('deberia_hacer_mas_familiar');
            $table->string('cuidar_mejor_familiar');
            $table->string('grado_carga_experimenta');
            $table->string('interpretacion_resultados');
            $table->foreignId('consulta_id')->constrained('consultas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zarits');
    }
};
