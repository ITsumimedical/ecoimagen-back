<?php

namespace App\Http\Modules\Ordenamiento\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CambiarServicioOrdenRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'orden_procedimiento_id' => 'required|integer|exists:orden_procedimientos,id',
            'cup_id' => 'required|integer|exists:cups,id',
            'observacion' => 'required|string|min:5',
            'cantidad' => 'required|numeric|min:1',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw (new HttpResponseException(response()->json($validator->errors(), 422)));
    }
}
