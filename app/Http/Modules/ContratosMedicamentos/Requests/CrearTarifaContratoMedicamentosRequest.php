<?php

namespace App\Http\Modules\ContratosMedicamentos\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearTarifaContratoMedicamentosRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'contrato_medicamentos_id' => 'required|integer|exists:contratos_medicamentos,id',
            'rep_id' => 'required|integer|exists:reps,id',
            'manual_tarifario_id' => 'required|integer|exists:manual_tarifarios,id',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
