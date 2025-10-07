<?php

namespace App\Http\Modules\Patologia\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearAntecedentesPatologiaRequest extends FormRequest
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
            'consulta_id' => 'nullable',
            'patologia_cancer_actual' => 'nullable',
            'fdx_cancer_actual' => 'nullable',
            'flaboratorio_patologia' => 'nullable',
            'tumor_segunda_biopsia' => 'nullable',
            'localizacion_cancer' => 'nullable',
            'dukes' => 'nullable',
            'gleason' => 'nullable',
            'Her2' => 'nullable',
            'estadificacion_clinica' => 'nullable',
            'estadificacion_inicial' => 'nullable',
            'fecha_estadificacion' => 'nullable|date'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
