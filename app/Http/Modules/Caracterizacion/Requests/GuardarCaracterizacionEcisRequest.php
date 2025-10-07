<?php

namespace App\Http\Modules\Caracterizacion\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class GuardarCaracterizacionEcisRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'afiliado_id' => 'required|integer|exists:afiliados,id',
            'dpto_residencia_id' => 'required|integer|exists:departamentos,id',
            'mpio_residencia_id' => 'required|integer|exists:municipios,id',
            'direccion_residencia_barrio' => 'required|string',
            'direccion_residencia_cargue' => 'required|string',
            'estrato' => 'required|string',
            'unidad_zonal_planeacion_evaluacion' => 'required|string',
            'territorio_nombre' => 'required|string',
            'territorio_id' => 'required|string',
            'territorio_serial' => 'required|string',
            'microterritorio_nombre' => 'required|string',
            'microterritorio_id' => 'required|string',
            'microterritorio_serial' => 'required|string',
            'geopunto' => 'required|string',
            'ubicacion_hogar' => 'required|string',
            'numero_identificacion_familia' => 'required|string',
            'numero_hogares_vivienda' => 'required|numeric|min:0',
            'numero_familias_vivienda' => 'required|numeric|min:0',
            'numero_personas_vivienda' => 'required|numeric|min:0',
            'numero_identificacion_ebs' => 'required|string',
            'prestador_id' => 'required|integer|exists:prestadores,id',
            'responsable_evaluacion_necesidades' => 'required|string',
            'perfil_evaluacion_necesidades' => 'required|string',
            'codigo_ficha' => 'required|string',
            'fecha_diligenciamiento_ficha' => 'required|date',
            'tipo_familia' => 'required|string',
            'numero_personas_familia' => 'required|numeric|min:0',
            'tipo_riesgo' => 'required|string',
            'observaciones_estructura_contexto_familiar' => 'required|string',
            'funcionalidad_familia' => 'required|string',
            'cuidador_principal' => 'required|boolean',
            'interrelaciones_familia_sociocultural' => 'required|string',
            'familia_ninos_adolescentes' => 'required|boolean',
            'gestante_familia' => 'required|boolean',
            'familia_adultos_mayores' => 'required|boolean',
            'familia_victima_conflicto_armado' => 'required|boolean',
            'familia_convive_discapacidad' => 'required|boolean',
            'familia_convive_enfermedad_cronica' => 'required|boolean',
            'familia_convive_enfermedad_transmisible' => 'required|string',
            'familia_vivencia_sucesos_vitales' => 'required|boolean',
            'familia_sitacion_vulnerabilidad_social' => 'required|boolean',
            'familia_practicas_cuidado_salud' => 'required|boolean',
            'familia_antecedentes_enfermedades' => 'required|boolean',
            'obtencion_alimentos' => 'required|string',
            'habitos_vida_saludable' => 'required|boolean',
            'recursos_socioemocionales' => 'required|boolean',
            'practicas_cuidado_proteccion' => 'required|boolean',
            'practicas_establecimiento_relaciones' => 'required|boolean',
            'recursos_sociales_comunitarios' => 'required|boolean',
            'practicas_autonomia_capacidad_funcional' => 'required|boolean',
            'practicas_prevencion_enfermedades' => 'required|boolean',
            'practicas_cuidado_saberes_ancestrales' => 'required|boolean',
            'capacidades_ejercicio_derecho_salud' => 'required|boolean',
            'cumple_esquema_atenciones' => 'required|boolean',
            'intervenciones_pendientes' => 'required|string',
            'motivos_no_atencion' => 'required|string',
            'practica_deportiva' => 'required|boolean',
            'recibe_lactancia' => 'required|boolean',
            'recibe_lactancia_meses' => 'required|numeric|min:0',
            'es_menor_cinco_anios' => 'required|boolean',
            'medidas_antropometricas_peso' => 'required|numeric|min:0',
            'medidas_antropometricas_talla' => 'required|numeric|min:0',
            'diagnostico_nutricional' => 'required|string',
            'enfermedades_alergias' => 'required|boolean',
            'tipo_vivienda' => 'required|string',
            'material_paredes' => 'required|string',
            'material_piso' => 'required|string',
            'material_techo' => 'required|string',
            'cuartos_dormitorio' => 'required|numeric|min:0',
            'hacinamiento' => 'required|boolean',
            'escenarios_riesgo' => 'required|string',
            'acceder_facilmente' => 'required|string',
            'fuente_energia_cocinar' => 'required|string',
            'criaderos_transmisores_enfermedades' => 'required|boolean',
            'factores_entorno_vivienda' => 'required|string',
            'vivienda_realiza_actividad_economica' => 'required|boolean',
            'animales_conviven' => 'required|string',
            'fuente_agua' => 'required|string',
            'sistema_disposicion_excretas' => 'required|string',
            'sistema_disposicion_aguas_residuales' => 'required|string',
            'sistema_disposicion_residuos' => 'required|string',
            'escala_zarit' => 'nullable',
            'familia_antecedentes_enfermedades_descripcion' => 'nullable',
            'familia_antecedentes_enfermedades_tratamiento' => 'nullable',
            'obtencion_alimentos_descripcion' => 'nullable',
            'medida_complementaria_riesgo_desnutricion' => 'nullable',
            'signos_fisicos_desnutricion' => 'nullable',
            'enfermedades_alergias_cuales' => 'nullable',
            'tratamiento_enfermedad_actual' => 'nullable',
            'motivo_no_atencion_enfermedad' => 'nullable',
            'tipo_vivienda_otro' => 'nullable',
            'material_paredes_otro' => 'nullable',
            'material_piso_otro' => 'nullable',
            'material_techo_otro' => 'nullable',
            'fuente_energia_cocinar_otro' => 'nullable',
            'criaderos_cuales' => 'nullable',
            'factores_entorno_vivienda_otro' => 'nullable',
            'animales_conviven_otro' => 'nullable',
            'animales_conviven_cantidad' => 'nullable',
            'fuente_agua_otro' => 'nullable',
            'sistema_disposicion_excretas_otro' => 'nullable',
            'sistema_disposicion_aguas_residuales_otro' => 'nullable',
            'sistema_disposicion_residuos_otro' => 'nullable',
            'pertenece_poblacion_etnica' => 'required|boolean',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}