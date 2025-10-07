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
        Schema::create('datos_indicador_fomag_oncologicos', function (Blueprint $table) {
            $table->id();
            $table->string('clasificacion_ca_priorizado')->nullable();
            $table->string('departamento')->nullable();
            $table->string('municipio')->nullable();
            $table->string('ips')->nullable();
            $table->string('entidad')->nullable();
            $table->string('tipo_documento')->nullable();
            $table->string('documento')->nullable();
            $table->string('nombre_usuario')->nullable();
            $table->string('sexo')->nullable();
            $table->string('edad_momento_diagnostico')->nullable();
            $table->string('ciclo_vida')->nullable();
            $table->string('primera_consulta_medico_ordena')->nullable();
            $table->string('fecha_consulta_inicial_medico_ordena_biopsia')->nullable();
            $table->string('fecha_Autorizacion_biopsia')->nullable();
            $table->string('fecha_toma_muestra_biopsia')->nullable();
            $table->string('fecha_ingreso_biopsia')->nullable();
            $table->string('fecha_salida_biopsia_reporte')->nullable();
            $table->string('fecha_diagnostico_patologia_inicial')->nullable();
            $table->string('fecha_diagnosticos_ihq')->nullable();
            $table->string('fecha_diagnostico_pos_operatorio')->nullable();
            $table->string('fecha_diagnostico_por_iht_pos_operatorio')->nullable();
            $table->string('fecha_reporte_laboratorio')->nullable();
            $table->string('fecha_solicitud_primera_consulta_ingreso_programa_oncologia')->nullable();
            $table->string('fecha_primera_consulta_ingreso_programa_oncologia')->nullable();
            $table->string('oportunidad_ingreso_programa_oncologia_medico_superviviente')->nullable();
            $table->string('fecha_solicitud_primera_consulta_Especialista_tratante')->nullable();
            $table->string('fecha_primera_consulta_especialista_tratante')->nullable();
            $table->string('oportunidad_desde_dx_hasta_Evaluacion_especialista')->nullable();
            $table->string('especialidad')->nullable();
            $table->string('prestador')->nullable();
            $table->string('mes')->nullable();
            $table->string('anio')->nullable();
            $table->string('cie10')->nullable();
            $table->string('descripcion_cie10')->nullable();
            $table->string('agrupado_didier')->nullable();
            $table->string('tipo_inicio_tto_mono_poli_cx')->nullable();
            $table->string('tnm')->nullable();
            $table->string('escala_gleason')->nullable();
            $table->string('estadio')->nullable();
            $table->string('tipo_cirugia_conservadora_ca_mama')->nullable();
            $table->string('riesgo_aplica_prostata')->nullable();
            $table->string('clasificacion_ann_arbor_lugano')->nullable();
            $table->string('rh_estrogenos')->nullable();
            $table->string('rh_progestagenos')->nullable();
            $table->string('ki_67')->nullable();
            $table->string('her_2')->nullable();
            $table->string('tto_hormonal')->nullable();
            $table->string('tto_anti_her2')->nullable();
            $table->string('remision_consulta_radioterapia')->nullable();
            $table->string('fecha_inicio_radioterapia')->nullable();
            $table->string('fecha_inicio_braquiterapia')->nullable();
            $table->string('ips_direccionamiento_radioterapia')->nullable();
            $table->string('fecha_remision_medicina_dolor')->nullable();
            $table->string('fecha_programa_cita_dolor')->nullable();
            $table->string('estado_consulta')->nullable();
            $table->string('remite_cx_torax')->nullable();
            $table->string('fecha_primera_Consulta_cirugia_torax')->nullable();
            $table->string('remision_oncologia_hemato_oncologia')->nullable();
            $table->string('fecha_primera_consulta_oncologia_hemato_oncologia')->nullable();
            $table->string('remision_mastologia')->nullable();
            $table->string('fecha_primera_consulta_mastologia')->nullable();
            $table->string('remite_cx_palstica')->nullable();
            $table->string('fecha_primera_consulta_cirugia_plastica')->nullable();
            $table->string('fecha_ordena_primer_tto')->nullable();
            $table->string('fecha_inicia_primer_tto')->nullable();
            $table->string('oportunidad_inicio_tto')->nullable();
            $table->string('fecha_ordena_primer_tratamiento_pos')->nullable();
            $table->string('fecha_inicio_tto_pos')->nullable();
            $table->string('oportunidad_tto_pos_cx')->nullable();
            $table->string('fecha_ordena_primer_tratamiento_neoadyuvante')->nullable();
            $table->string('fecha_inicio_tto_neoadyuvante')->nullable();
            $table->string('oportunidad_neoadyuvante')->nullable();
            $table->string('estado_afiliado')->nullable();
            $table->string('observaciones_generales')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datos_indicador_fomag_oncologicos');
    }
};
