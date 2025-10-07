<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePerfilSociodemograficosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perfil_sociodemograficos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empleado_id')->constrained('empleados');
            $table->string('turno_trabajo')->nullable();
            $table->string('numero_personas_depende')->nullable();
            $table->string('numero_miembros_hogar')->nullable();
            $table->string('numero_hijos')->nullable();
            $table->string('rango_edad_hijos')->nullable();
            $table->string('otros_rango_edad_hijos')->nullable();
            $table->boolean('tiene_mascota')->nullable()->default(false);
            $table->string('cuantas_cuales_mascotas')->nullable();
            $table->string('tipo_vivienda')->nullable();
            $table->string('estrato_socioeconomico')->nullable();
            $table->string('servicios_publicos')->nullable();
            $table->string('seguridad_orden_publico')->nullable();
            $table->string('medio_transporte')->nullable();
            $table->string('otros_medio_transporte')->nullable();
            $table->string('tiempo_transporte')->nullable();
            $table->string('promedio_ingresos_mensuales')->nullable();
            $table->string('promedio_ingresos_mensuales_extralaborales')->nullable();
            $table->string('personas_aportan_hogar')->nullable();
            $table->string('aspectos_gasta_dinero')->nullable();
            $table->string('otros_aspectos_gasta_dinero')->nullable();
            $table->text('instituciones_ahorro')->nullable();
            $table->string('otros_instituciones_ahorro')->nullable();
            $table->boolean('negocio_propio')->nullable()->default(false);
            $table->text('uso_tiempo_libre')->nullable();
            $table->string('otros_uso_tiempo_libre')->nullable();
            $table->text('personas_comparte_tiempo')->nullable();
            $table->string('otros_personas_comparte_tiempo')->nullable();
            $table->text('barreras_uso_tiempo_libre')->nullable();
            $table->string('otros_barreras_uso_tiempo_libre')->nullable();
            $table->text('areas_estudios_interes')->nullable();
            $table->string('otros_areas_estudios_interes')->nullable();
            $table->text('actividades_gustaria_hacer')->nullable();
            $table->string('otros_actividades_gustaria_hacer')->nullable();
            $table->boolean('fuma')->nullable()->default(false);
            $table->string('fuma_periodicidad')->nullable();
            $table->boolean('bebidas_alcoholicas')->nullable()->default(false);
            $table->string('bebidas_alcoholicas_periodicidad')->nullable();
            $table->boolean('sustancias_psicoactivas')->nullable()->default(false);
            $table->string('sustancias_psicoactivas_periodicidad')->nullable();
            $table->boolean('alergico_medicamento')->nullable()->default(false);
            $table->string('alergico_medicamento_cuales')->nullable();
            $table->boolean('sufre_enfermedad')->nullable()->default(false);
            $table->string('sufre_enfermedad_cuales')->nullable();
            $table->boolean('vacunas_ultimo_anio')->nullable()->default(false);
            $table->string('vacunas_ultimo_anio_cuales')->nullable();
            $table->boolean('refuerzo_vacunas_ultimo_anio')->nullable()->default(false);
            $table->string('refuerzo_vacunas_ultimo_anio_cuales')->nullable();
            $table->boolean('salud_oral_ultimo_anio')->nullable()->default(false);
            $table->string('salud_oral_ultimo_anio_cuales')->nullable();
            $table->boolean('metodo_planificacion_familiar')->nullable()->default(false);
            $table->boolean('examen_agudeza_visual_ultimo_anio')->nullable()->default(false);
            $table->boolean('autorizacion')->default(false);
            $table->SoftDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perfil_sociodemograficos');
    }
}
