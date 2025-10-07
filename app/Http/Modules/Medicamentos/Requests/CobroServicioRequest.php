<?php

namespace App\Http\Modules\Medicamentos\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CobroServicioRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'medio_pago' => 'required|string|max:255',
            'valor' => 'required|numeric|min:0',
            'servicios' => 'required|array|min:1',
            'servicios.*' => 'required|integer|exists:orden_procedimientos,id',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
