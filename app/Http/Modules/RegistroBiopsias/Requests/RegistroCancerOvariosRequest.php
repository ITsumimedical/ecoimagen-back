<?php

namespace App\Http\Modules\RegistroBiopsias\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegistroCancerOvariosRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'cie10_id' => 'required|exists:cie10s,id',
            'afiliado_id' => 'required|exists:afiliados,id',
            'consulta_id' => 'nullable|exists:consultas,id',
            'fecha_inicial_biopsia' => 'required|date',
            'fecha_final_biopsia' => 'nullable|date|after_or_equal:fecha_inicial_biopsia',
            'lateralidad' => 'required|string|max:255',
            'fecha_inicio_patologia' => 'required|date',
            'fecha_final_patologia' => 'nullable|date|after_or_equal:fecha_inicio_patologia',
            'id' => 'nullable|integer',

            'lateralidad_1' => 'required|string|max:255',
            'lateralidad_2' => 'required|string|max:255',
            'laboratorio_procesa' => 'required|string|max:255',
            'nombre_patologo' => 'required|string|max:255',
            'fecha_ingreso_ihq' => 'required|date',
            'fecha_salida_ihq' => 'required|date|after_or_equal:fecha_ingreso_ihq',
            'clasificacion_t' => 'required|string|max:255',
            'clasificacion_n' => 'required|string|max:255',
            'clasificacion_m' => 'required|string|max:255',
            'descripcion_estadio_figo' => 'required|string',
            'estadio_figo' => 'required|string',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
