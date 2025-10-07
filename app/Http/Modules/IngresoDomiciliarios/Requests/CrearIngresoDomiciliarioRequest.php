<?php

namespace App\Http\Modules\IngresoDomiciliarios\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearIngresoDomiciliarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'afiliado_id' => 'required|integer',
            'orden_id' => 'required|integer',
            'referencia_id' => 'integer',
            'consulta_id' => 'integer',
            'vivienda_zona_cobertura' => 'required|boolean',
            'zona_riesgo_accesibilidad' => 'required|string',
            'user_criterio_riesgo_id' => 'required|integer',
            'higiene_afiliado' => 'required|string',
            'alimentacion_afiliado' => 'required|string',
            'telefono_casa' => 'required|string',
            'agua_potable' => 'required|string',
            'nevera' => 'required|string',
            'luz_electrica' => 'required|string',
            'unidad_sanitaria' => 'required|string',
            'estabilidad_paciente' => 'required|string',
            'barthel' => 'required|string',
            'karnofsky' => 'required|string',
            'plan_manejo' => 'required|string',
            'aceptacion_familia' => 'required|string',
            'cumple_criterio' => 'required|string',
            'programa' => 'required|string',
            'observaciones' => 'required|string',
            'estado_id' => 'required|integer',
            'user_ingreso_id' => 'required|integer'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
