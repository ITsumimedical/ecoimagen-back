<?php

namespace App\Http\Modules\ContratosMedicamentos\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearCumTarifaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cum_validacion' => 'required|string|exists:cums,cum_validacion',
            'tarifa_id' => 'required|exists:tarifas_contratos_medicamentos,id',
            'precio' => 'required|numeric|min:0',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
