<?php

namespace App\Http\Modules\ContratosMedicamentos\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearContratoMedicamentoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'prestador_id' => 'required|integer|exists:prestadores,id',
            'entidad_id' => 'required|integer|exists:entidades,id',
            'ambito_id' => 'required|integer|exists:ambitos,id',
            'fecha_inicio' => 'required|date',
            'fecha_vigencia' => 'required|date',
            'adjuntos' => 'array|nullable',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
