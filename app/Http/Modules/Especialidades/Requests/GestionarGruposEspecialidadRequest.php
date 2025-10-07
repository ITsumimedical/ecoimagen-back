<?php

namespace App\Http\Modules\Especialidades\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class GestionarGruposEspecialidadRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'especialidad_id' => 'required|integer|exists:especialidades,id',
            'grupos' => 'required|array',
            'grupos.*' => 'integer|exists:grupos,id',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw (new HttpResponseException(response()->json($validator->errors(), 422)));
    }
}