<?php

namespace App\Http\Modules\Eventos\Analisis\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearAnalisisEventoRequest extends FormRequest
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
            // analizar
            'evento_adverso_id' => 'required|exists:evento_adversos,id',
            'fecha_analisis' => 'required',
            'clasificacion_analisis' => 'required',
            'metodologia_analisis' => 'required',
            'metodologia_analisis_farmaco' => 'required_if:suceso_id,109',
            'cronologia_suceso' => 'required',
            'accion_resarcimiento' => 'nullable|string',
            'desenlace_evento' => 'nullable|string',
            'descripcion_consecuencias' => 'nullable|string',
            'clasif_tecnovigilancia' => 'required_if:suceso_id,139',
            'cantidad_dias_adicionales' => ['nullable','numeric','min:1','required_if:requiere_dias_adicionales,true',],
            'requiere_dias_adicionales' => 'boolean',
            // respuesta inmediata
            'que_fallo' => 'nullable',
            'como_fallo' => 'nullable',
            'que_causo' => 'nullable',
            'plan_accion' => 'nullable',
            'estado_id' => 'required'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
