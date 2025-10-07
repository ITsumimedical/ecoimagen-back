<?php

namespace App\Http\Modules\Solicitudes\RadicacionOnline\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ComentarioRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'radicacion_online_id' => 'required',
            'motivo' => 'required',
            'accion' => 'nullable',
            'gestionando' => 'nullable',
            'numero_documento' => 'nullable',
            'adjuntos' =>'nullable'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
