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
        Schema::create('caracterizaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('afiliado_id')->constrained('afiliados');
            $table->string('zona_vivienda')->nullable();
            $table->string('residencia')->nullable();
            $table->string('correo')->nullable();
            $table->integer('conforman_hogar')->nullable();
            $table->string('tipo_vivienda')->nullable();
            $table->boolean('hogar_con_agua')->nullable();
            $table->string('cocina_con')->nullable();
            $table->string('energia')->nullable();
            $table->string('accesibilidad_vivienda')->nullable();
            $table->string('etnia')->nullable();
            $table->string('escolaridad')->nullable();
            $table->string('orientacion_sexual')->nullable();
            $table->string('oficio_ocupacion')->nullable();
            $table->string('metodo_planificacion')->nullable();
            $table->string('planeando_embarazo')->nullable();
            $table->string('citologia_ultimo_año')->nullable();
            $table->string('tamizaje_tamografia')->nullable();
            $table->string('tamizaje_prostata')->nullable();
            $table->string('autocuidado')->nullable();
            $table->string('victima_volencia')->nullable();
            $table->string('victima_desplazamiento')->nullable();
            $table->string('consumo_sustancias_psicoavtivas')->nullable();
            $table->string('consume_alcohol')->nullable();
            $table->string('actividad_fisica')->nullable();
            $table->string('antecedentes_cancer_familia')->nullable();
            $table->string('antecedentes_enfermedades_metabolicas_familia')->nullable();
            $table->string('diagnosticos_salud_mental')->nullable();
            $table->string('antecedente_cancer')->nullable();
            $table->string('antecedentes_enfermedades_metabolicas')->nullable();
            $table->string('antecedentes_enfermedades_riego_cardiovascular')->nullable();
            $table->string('enfermedades_respiratorias');
            $table->string('enfermedades_inmunodeficiencia');
            $table->string('medicamentos_uso_permanente')->nullable();
            $table->string('antecedente_hospitalizacion_cronica')->nullable();
            $table->string('antecedentes_riesgo_individualizado')->nullable();
            $table->string('alteraciones_nutricionales')->nullable();
            $table->string('enfermedades_infecciosas')->nullable();
            $table->string('cancer')->nullable();
            $table->string('trastornos_visuales')->nullable();
            $table->string('problemas_salud_mental')->nullable();
            $table->string('enfermedades_zonoticas')->nullable();
            $table->string('trastornos_degenerativos')->nullable();
            $table->string('trastorno_consumo_psicoactivas')->nullable();
            $table->string('enfermedad_cardiovascular')->nullable();
            $table->string('trastornos_auditivos')->nullable();
            $table->string('trastornos_salud_bucal')->nullable();
            $table->string('accidente_enfermedad_laboral')->nullable();
            $table->string('violencias')->nullable();
            $table->string('estado_paciente')->nullable();
            $table->string('maternoperinatal')->nullable();
            $table->string('nefroproteccion')->nullable();
            $table->string('respiratorias_cronicas')->nullable();
            $table->string('rehabilitacion_integral_funcional')->nullable();
            $table->string('cuidados_paliativos')->nullable();
            $table->string('oncologias')->nullable();
            $table->string('reumatologias')->nullable();
            $table->string('trasmisibles_cronicas')->nullable();
            $table->string('enfermedades_huerfanas')->nullable();
            $table->string('economia_articular');
            $table->foreignId('usuario_registra_id')->constrained('users');
            $table->foreignId('departamento_residencia_id')->nullable()->constrained('departamentos');
            $table->foreignId('municipio_residencia_id')->nullable()->constrained('municipios');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caracterizaciones');
    }
};
