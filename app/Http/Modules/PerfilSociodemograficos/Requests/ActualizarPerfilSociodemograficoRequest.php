<?php

namespace App\Http\Modules\perfilSociodemograficos\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ActualizarPerfilSociodemograficoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'empleado_id' => 'required|exists:empleados,id',
            'turno_trabajo' => 'required',
            'numero_personas_depende' => 'required',
            'numero_miembros_hogar' => 'required',
            'numero_hijos' => 'required',
            'rango_edad_hijos' => 'required_unless:numero_hijos,No tengo hijos',
            'otros_rango_edad_hijos' => 'required_if:rango_edad_hijos,Otros',
            'tiene_mascota' => 'required',
            'cuantas_cuales_mascotas' => 'required_if:tiene_mascota,true',
            'tipo_vivienda' => 'required',
            'estrato_socioeconomico' => 'required',
            'servicios_publicos' => 'required',
            'seguridad_orden_publico' => 'required',
            'medio_transporte' => 'required',
            'otros_medio_transporte' => 'required_if:medio_transporte,Otros',
            'tiempo_transporte' => 'required',
            'promedio_ingresos_mensuales' => 'required',
            'promedio_ingresos_mensuales_extralaborales' => 'required',
            'personas_aportan_hogar' => 'required',
            'aspectos_gasta_dinero' => 'required',
            'otros_aspectos_gasta_dinero' => 'required_if:aspectos_gasta_dinero,Otros',
            'instituciones_ahorro' => 'required',
            'otros_instituciones_ahorro' => 'required_if:instituciones_ahorro,Otros',
            // 'negocio_propio' => 'required',
            'uso_tiempo_libre' => 'required',
            'otros_uso_tiempo_libre' => 'required_if:uso_tiempo_libre,Otros',
            'personas_comparte_tiempo' => 'required',
            'otros_personas_comparte_tiempo' => 'required_if:personas_comparte_tiempo,Otros',
            'barreras_uso_tiempo_libre' => 'required',
            'otros_barreras_uso_tiempo_libre' => 'required_if:barreras_uso_tiempo_libre,Otros',
            'areas_estudios_interes' => 'required',
            'otros_areas_estudios_interes' => 'required_if:areas_estudios_interes,Otros',
            'actividades_gustaria_hacer' => 'required',
            'otros_actividades_gustaria_hacer' => 'required_if:actividades_gustaria_hacer,Otros',
            // 'habilidades_talento' => 'required',
            // 'otros_habilidades_talento' => 'required_if:habilidades_talento,Otros',
            'fuma' => 'required',
            'fuma_periodicidad' => 'required_if:fuma,true',
            'bebidas_alcoholicas' => 'required',
            'bebidas_alcoholicas_periodicidad' => 'required_if:bebidas_alcoholicas,true',
            'sustancias_psicoactivas' => 'required',
            'sustancias_psicoactivas_periodicidad' => 'required_if:sustancias_psicoactivas,true',
            'alergico_medicamento' => 'required',
            'alergico_medicamento_cuales' => 'required_if:alergico_medicamento,true',
            'sufre_enfermedad' => 'required',
            'sufre_enfermedad_cuales' => 'required_if:sufre_enfermedad,true',
            'vacunas_ultimo_anio' => 'required',
            'vacunas_ultimo_anio_cuales' => 'required_if:vacunas_ultimo_anio,true',
            'refuerzo_vacunas_ultimo_anio' => 'required',
            'refuerzo_vacunas_ultimo_anio_cuales' => 'required_if:refuerzo_vacunas_ultimo_anio,true',
            'salud_oral_ultimo_anio' => 'required',
            'salud_oral_ultimo_anio_cuales' => 'required_if:salud_oral_ultimo_anio,true',
            'metodo_planificacion_familiar' => 'required',
            'examen_agudeza_visual_ultimo_anio' => 'required',
            'autorizacion' => 'required_if:autorizacion,false',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
