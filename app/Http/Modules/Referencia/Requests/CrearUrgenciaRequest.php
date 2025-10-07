<?php

namespace App\Http\Modules\Referencia\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearUrgenciaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'consulta' => 'required|integer',
            'admision' => 'required|integer',
            'descripcion' => 'required|string',
            'entidad_id' => 'required|integer',
            'afiliado_id' => 'required|integer',
            'tipo_anexo' => 'required|string',
            'cie10s' => 'required|array'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
