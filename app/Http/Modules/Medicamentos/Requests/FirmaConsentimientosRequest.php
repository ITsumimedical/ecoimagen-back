<?php

namespace App\Http\Modules\Medicamentos\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class FirmaConsentimientosRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => 'required|array',
            'firma_paciente' => 'nullable',
            'firmante' => 'required|string',
            'numero_documento_representante' => 'nullable|integer',
            'declaracion_a' => 'required|string',
            'declaracion_b' => 'required|string',
            'declaracion_c' => 'required|string',
            'nombre_profesional' => 'required|string',
            'nombre_representante' => 'nullable|string',
            'firma_disentimiento' => 'nullable|string',
            'aceptacion_consentimiento' => 'required|string',
            'firma_representante'=>'nullable'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
