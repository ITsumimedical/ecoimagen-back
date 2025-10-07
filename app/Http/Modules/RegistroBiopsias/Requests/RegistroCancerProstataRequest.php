<?php

namespace App\Http\Modules\RegistroBiopsias\Requests;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegistroCancerProstataRequest extends FormRequest
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
            'psa' => 'required|integer|min:0',
            'lobulo' => 'required|string|max:255',
            'lobulo_derecho' => 'nullable|string|max:255',
            'lobulo_izquierdo' => 'nullable|string|max:255',
            'fecha_ingreso_ihq' => 'required|date',
            'fecha_salida_ihq' => 'required|date|after_or_equal:fecha_ingreso_ihq',
            'grado' => 'required|string|max:255',
            'riesgo' => 'required|string|max:255',
            'clasificacion_t' => 'required|string|max:255',
            'descripcion_clasificacion_t' => 'nullable|string',
            'clasificacion_m' => 'nullable|string|max:255',
            'descripcion_clasificacion_m' => 'nullable|string',
            'clasificacion_n' => 'nullable|string|max:255',
            'descripcion_clasificacion_n' => 'nullable|string',
            'estadio' => 'nullable|string',
            'extension' => 'nullable|string',
        ];
    }

     protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
