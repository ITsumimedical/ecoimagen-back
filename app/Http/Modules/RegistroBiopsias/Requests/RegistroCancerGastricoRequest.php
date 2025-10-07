<?php

namespace App\Http\Modules\RegistroBiopsias\Requests;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegistroCancerGastricoRequest extends FormRequest
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

            'laboratorio_procesa' => 'required|string|max:255',
            'ubicacion_leson' => 'required|string|max:255',
            'fecha_ingreso_ihq' => 'required|date',
            'fecha_salida_ihq' => 'required|date|after_or_equal:fecha_ingreso_ihq',
            'tipo_cancer_gastrico' => 'required|string|max:255',
            'clasificacion_t' => 'required|string',
            'clasificacion_n' => 'required|string',
            'clasificacion_m' => 'required|string',
            'estadio' => 'required|string',
            'her_2' => 'nullable|string',
            'pd_l1' => 'nullable|string',
            'inestabilidad_microsatelital' => 'nullable|string',
            'gen_ntrk' => 'nullable|string',
            'nombre_patologo' => 'nullable|string'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
