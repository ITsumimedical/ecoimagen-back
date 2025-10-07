<?php

namespace App\Http\Modules\Prestadores\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class FiltroTablaPrestadorRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => 'nullable|string',
            'nit' => 'nullable|string',
            'codigo_habilitacion' => 'nullable|string',
            'page' =>'numeric',
            'cant' =>'numeric'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw (new HttpResponseException(response()->json($validator->errors(), 422)));
    }

}
