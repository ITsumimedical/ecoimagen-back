<?php

namespace App\Http\Modules\Caracterizacion\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class AsociarIntegranteExistenteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'afiliado_id' => 'required|integer|exists:afiliados,id',
            'tipo_documento_id' => 'required|integer|exists:tipo_documentos,id',
            'numero_documento' => 'required|string',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}