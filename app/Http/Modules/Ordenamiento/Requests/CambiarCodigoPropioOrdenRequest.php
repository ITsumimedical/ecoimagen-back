<?php

namespace App\Http\Modules\Ordenamiento\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CambiarCodigoPropioOrdenRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'orden_codigo_propio_id' => 'required|integer|exists:orden_codigo_propios,id',
            'codigo_propio_id' => 'required|integer|exists:codigo_propios,id',
            'observacion' => 'required|string|min:5',
            'cantidad' => 'required|numeric|min:1',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw (new HttpResponseException(response()->json($validator->errors(), 422)));
    }
}
