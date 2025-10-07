<?php

namespace App\Http\Modules\Cups\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class GestionarEntidadesCups extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cup_id' => 'required|integer|exists:cups,id',
            'entidades' => 'required|array',
            'entidades.*' => 'required|integer|exists:entidades,id',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw (new HttpResponseException(response()->json($validator->errors(), 422)));
    }

}
