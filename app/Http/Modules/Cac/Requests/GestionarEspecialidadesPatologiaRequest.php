<?php

namespace App\Http\Modules\Cac\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class GestionarEspecialidadesPatologiaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'patologia_id' => 'required|integer|exists:patologias_cacs,id',
            'especialidades' => 'required|array',
            'especialidades.*' => 'required|integer|exists:especialidades,id',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}