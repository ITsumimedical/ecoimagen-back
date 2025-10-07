<?php

namespace App\Http\Modules\Eventos\Analisis\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActualizarAnalisisEventoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'severidad_evento' => 'nullable|required_if:cerrar,true',
            'cronologia_suceso' => 'required_if:analizar,true',
            'fecha_analisis' => 'nullable|required_if:analizar,true',
            'clasificacion_analisis' => 'required_if:analizar,true',
            'metodologia_analisis' => 'required_if:analizar,true',
            'metodologia_analisis_farmaco' => 'required_if:suceso_id,109',
            'que_fallo' => 'nullable',
            'como_fallo' => 'nullable',
            'que_causo' => 'nullable',
            'plan_accion' => 'nullable',
            'accion_resarcimiento' => 'nullable',
            'desenlace_evento' => 'nullable',
            'descripcion_consecuencias' => 'nullable',
            // farmacovigilancia
            'elemento_funcion' => 'nullable',
            'modo_fallo' => 'nullable',
            'efecto' => 'nullable',
            'npr' => 'nullable',
            'acciones_propuestas' => 'nullable',
            'causas_esavi' => 'nullable',
            'asociacion_esavi' => 'nullable',
            'ventana_mayoriesgo' => 'nullable',
            'evidencia_asociacioncausal' => 'nullable',
            'factores_esavi' => 'nullable',
            'evaluacion_causalidad' => 'nullable',
            'clasificacion_invima' => 'nullable',
            'seriedad' => 'nullable',
            'fecha_muerte' => 'nullable',
            'farmaco_cinetica' => 'nullable',
            'condiciones_farmacocinetica' => 'nullable',
            'prescribio_manerainadecuada' => 'nullable',
            'medicamento_manerainadecuada' => 'nullable',
            'medicamento_entrenamiento' => 'nullable',
            'potenciales_interacciones' => 'nullable',
            'notificacion_refieremedicamento' => 'nullable',
            'problema_biofarmaceutico' => 'nullable',
            'deficiencias_sistemas' => 'nullable',
            'factores_asociados' => 'nullable',
            'administrar_medicamento_evento' => 'nullable',
            'factores_explicar_evento' => 'nullable',
            'evento_desaparecio_suspender_medicamento' => 'nullable',
            'paciente_presenta_misma_reaccion' => 'nullable',
            'ampliar_informacion_relacionada_evento' => 'nullable',
            'cantidad_dias_adicionales' => ['nullable', 'numeric', 'min:1', 'required_if:requiere_dias_adicionales,true'],
            'requiere_dias_adicionales' => 'boolean',
        ];
    }
}
