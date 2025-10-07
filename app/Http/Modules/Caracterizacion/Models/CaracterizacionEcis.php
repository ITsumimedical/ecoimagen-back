<?php

namespace App\Http\Modules\Caracterizacion\Models;

use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Prestadores\Models\Prestador;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CaracterizacionEcis extends Model
{
    use HasFactory;

    protected $fillable = [
        'afiliado_id',
        'unidad_zonal_planeacion_evaluacion',
        'territorio_nombre',
        'territorio_id',
        'territorio_serial',
        'microterritorio_nombre',
        'microterritorio_id',
        'microterritorio_serial',
        'geopunto',
        'ubicacion_hogar',
        'numero_identificacion_familia',
        'numero_hogares_vivienda',
        'numero_familias_vivienda',
        'numero_personas_vivienda',
        'numero_identificacion_ebs',
        'prestador_id',
        'responsable_evaluacion_necesidades',
        'perfil_evaluacion_necesidades',
        'codigo_ficha',
        'fecha_diligenciamiento_ficha',
        'tipo_familia',
        'numero_personas_familia',
        'tipo_riesgo',
        'observaciones_estructura_contexto_familiar',
        'funcionalidad_familia',
        'cuidador_principal',
        'escala_zarit',
        'interrelaciones_familia_sociocultural',
        'familia_ninos_adolescentes',
        'gestante_familia',
        'familia_adultos_mayores',
        'familia_victima_conflicto_armado',
        'familia_convive_discapacidad',
        'familia_convive_enfermedad_cronica',
        'familia_convive_enfermedad_transmisible',
        'familia_vivencia_sucesos_vitales',
        'familia_sitacion_vulnerabilidad_social',
        'familia_practicas_cuidado_salud',
        'familia_antecedentes_enfermedades',
        'familia_antecedentes_enfermedades_descripcion',
        'familia_antecedentes_enfermedades_tratamiento',
        'obtencion_alimentos',
        'obtencion_alimentos_descripcion',
        'habitos_vida_saludable',
        'recursos_socioemocionales',
        'practicas_cuidado_proteccion',
        'practicas_establecimiento_relaciones',
        'recursos_sociales_comunitarios',
        'practicas_autonomia_capacidad_funcional',
        'practicas_prevencion_enfermedades',
        'practicas_cuidado_saberes_ancestrales',
        'capacidades_ejercicio_derecho_salud',
        'cumple_esquema_atenciones',
        'intervenciones_pendientes',
        'motivos_no_atencion',
        'practica_deportiva',
        'recibe_lactancia',
        'recibe_lactancia_meses',
        'es_menor_cinco_anios',
        'medidas_antropometricas_peso',
        'medidas_antropometricas_talla',
        'diagnostico_nutricional',
        'medida_complementaria_riesgo_desnutricion',
        'signos_fisicos_desnutricion',
        'enfermedades_alergias',
        'enfermedades_alergias_cuales',
        'tratamiento_enfermedad_actual',
        'motivo_no_atencion_enfermedad',
        'pertenece_poblacion_etnica',
        'tipo_vivienda',
        'tipo_vivienda_otro',
        'material_paredes',
        'material_paredes_otro',
        'material_piso',
        'material_piso_otro',
        'material_techo',
        'material_techo_otro',
        'cuartos_dormitorio',
        'hacinamiento',
        'escenarios_riesgo',
        'acceder_facilmente',
        'fuente_energia_cocinar',
        'fuente_energia_cocinar_otro',
        'criaderos_transmisores_enfermedades',
        'criaderos_cuales',
        'factores_entorno_vivienda',
        'factores_entorno_vivienda_otro',
        'vivienda_realiza_actividad_economica',
        'animales_conviven',
        'animales_conviven_otro',
        'animales_conviven_cantidad',
        'fuente_agua',
        'fuente_agua_otro',
        'sistema_disposicion_excretas',
        'sistema_disposicion_excretas_otro',
        'sistema_disposicion_aguas_residuales',
        'sistema_disposicion_aguas_residuales_otro',
        'sistema_disposicion_residuos',
        'sistema_disposicion_residuos_otro',
    ];

    public function afiliado(): BelongsTo
    {
        return $this->belongsTo(Afiliado::class, 'afiliado_id');
    }

    public function prestador(): BelongsTo
    {
        return $this->belongsTo(Prestador::class, 'prestador_id');
    }
}
