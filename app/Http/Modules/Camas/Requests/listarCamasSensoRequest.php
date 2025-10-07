<?php

namespace App\Http\Modules\Camas\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class listarCamasSensoRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'estado' => 'nullable|integer',
            'afiliado' => 'nullable|integer'
        ];
    }

 protected function failedValidation(Validator $validator)
 {
     throw new HttpResponseException(response()->json($validator->errors(), 422));
 }
}
