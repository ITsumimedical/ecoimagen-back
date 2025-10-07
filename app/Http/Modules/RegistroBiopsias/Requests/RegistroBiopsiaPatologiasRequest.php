<?php

namespace App\Http\Modules\RegistroBiopsias\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;


class RegistroBiopsiaPatologiasRequest extends FormRequest
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
            'laboratorio_procesa' => 'nullable|string|max:255',
            'nombre_patologo' => 'nullable|string|max:255',

            'fecha_ingreso_ihq' => 'nullable|date',
            'fecha_salida_ihq' => 'nullable|date',

            'estrogenos' => 'nullable|string|max:255',
            'progestagenos' => 'nullable|string|max:255',
            'porcentaje_estrogenos' => 'nullable|numeric|min:0|max:100',
            'porcentaje_progestagenos' => 'nullable|numeric|min:0|max:100',

            'ki_67' => 'nullable|string|max:255',
            'her2' => 'nullable|string|max:255',

            'clasificacion_t' => 'nullable|string|max:255',
            'descripcion_t' => 'nullable|string',

            'clasificacion_n' => 'nullable|string|max:255',
            'descripcion_n' => 'nullable|string',

            'clasificacion_m' => 'nullable|string|max:255',
            'descripcion_m' => 'nullable|string',

            'subtipo_molecular' => 'nullable|string',
            'fish' => 'nullable|string',
            'brca' => 'nullable|string',
            'estadio' => 'nullable|string',
        ];
    }

     protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
