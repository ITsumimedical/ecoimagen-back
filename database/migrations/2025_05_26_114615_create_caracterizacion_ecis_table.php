<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('caracterizacion_ecis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('afiliado_id')->constrained('afiliados');
            $table->string('unidad_zonal_planeacion_evaluacion');
            $table->string('territorio_nombre');
            $table->string('territorio_id');
            $table->string('territorio_serial');
            $table->string('microterritorio_nombre');
            $table->string('microterritorio_id');
            $table->string('microterritorio_serial');
            $table->string('geopunto');
            $table->string('ubicacion_hogar');
            $table->string('numero_identificacion_familia');
            $table->decimal('numero_hogares_vivienda', 8, 2);
            $table->decimal('numero_familias_vivienda', 8, 2);
            $table->decimal('numero_personas_vivienda', 8, 2);
            $table->string('numero_identificacion_ebs');
            $table->foreignId('prestador_id')->constrained('prestadores');
            $table->string('responsable_evaluacion_necesidades');
            $table->text('perfil_evaluacion_necesidades');
            $table->string('codigo_ficha');
            $table->date('fecha_diligenciamiento_ficha');
            $table->string('tipo_familia');
            $table->decimal('numero_personas_familia', 8, 2);
            $table->string('tipo_riesgo');
            $table->text('observaciones_estructura_contexto_familiar');
            $table->string('funcionalidad_familia');
            $table->boolean('cuidador_principal');
            $table->string('escala_zarit')->nullable();
            $table->string('interrelaciones_familia_sociocultural');
            $table->boolean('familia_ninos_adolescentes');
            $table->boolean('gestante_familia');
            $table->boolean('familia_adultos_mayores');
            $table->boolean('familia_victima_conflicto_armado');
            $table->boolean('familia_convive_discapacidad');
            $table->boolean('familia_convive_enfermedad_cronica');
            $table->string('familia_convive_enfermedad_transmisible');
            $table->boolean('familia_vivencia_sucesos_vitales');
            $table->boolean('familia_sitacion_vulnerabilidad_social');
            $table->boolean('familia_practicas_cuidado_salud');
            $table->boolean('familia_antecedentes_enfermedades');
            $table->text('familia_antecedentes_enfermedades_descripcion')->nullable();
            $table->boolean('familia_antecedentes_enfermedades_tratamiento')->nullable();
            $table->string('obtencion_alimentos');
            $table->text('obtencion_alimentos_descripcion')->nullable();
            $table->boolean('habitos_vida_saludable');
            $table->boolean('recursos_socioemocionales');
            $table->boolean('practicas_cuidado_proteccion');
            $table->boolean('practicas_establecimiento_relaciones');
            $table->boolean('recursos_sociales_comunitarios');
            $table->boolean('practicas_autonomia_capacidad_funcional');
            $table->boolean('practicas_prevencion_enfermedades');
            $table->boolean('practicas_cuidado_saberes_ancestrales');
            $table->boolean('capacidades_ejercicio_derecho_salud');
            $table->boolean('cumple_esquema_atenciones');
            $table->string('intervenciones_pendientes');
            $table->string('motivos_no_atencion');
            $table->boolean('practica_deportiva');
            $table->boolean('recibe_lactancia');
            $table->decimal('recibe_lactancia_meses', 8, 2);
            $table->boolean('es_menor_cinco_anios');
            $table->decimal('medidas_antropometricas_peso', 8, 2);
            $table->decimal('medidas_antropometricas_talla', 8, 2);
            $table->string('diagnostico_nutricional');
            $table->string('medida_complementaria_riesgo_desnutricion')->nullable();
            $table->string('signos_fisicos_desnutricion')->nullable();
            $table->boolean('enfermedades_alergias');
            $table->text('enfermedades_alergias_cuales')->nullable();
            $table->boolean('tratamiento_enfermedad_actual')->nullable();
            $table->string('motivo_no_atencion_enfermedad')->nullable();
            $table->boolean('pertenece_poblacion_etnica');
            $table->string('tipo_vivienda');
            $table->text('tipo_vivienda_otro')->nullable();
            $table->string('material_paredes');
            $table->text('material_paredes_otro')->nullable();
            $table->string('material_piso');
            $table->text('material_piso_otro')->nullable();
            $table->string('material_techo');
            $table->text('material_techo_otro')->nullable();
            $table->decimal('cuartos_dormitorio', 8, 2);
            $table->boolean('hacinamiento');
            $table->string('escenarios_riesgo');
            $table->string('acceder_facilmente');
            $table->string('fuente_energia_cocinar');
            $table->text('fuente_energia_cocinar_otro')->nullable();
            $table->boolean('criaderos_transmisores_enfermedades');
            $table->text('criaderos_cuales')->nullable();
            $table->text('factores_entorno_vivienda');
            $table->text('factores_entorno_vivienda_otro')->nullable();
            $table->boolean('vivienda_realiza_actividad_economica');
            $table->string('animales_conviven');
            $table->text('animales_conviven_otro')->nullable();
            $table->decimal('animales_conviven_cantidad', 8, 2)->nullable();
            $table->string('fuente_agua');
            $table->text('fuente_agua_otro')->nullable();
            $table->string('sistema_disposicion_excretas');
            $table->text('sistema_disposicion_excretas_otro')->nullable();
            $table->string('sistema_disposicion_aguas_residuales');
            $table->text('sistema_disposicion_aguas_residuales_otro')->nullable();
            $table->string('sistema_disposicion_residuos');
            $table->text('sistema_disposicion_residuos_otro')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caracterizacion_ecis');
    }
};
