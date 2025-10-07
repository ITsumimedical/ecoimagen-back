<?php

namespace App\Http\Modules\Solicitudes\TipoSolicitud\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ActualizarTipoSolicitudRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required',
            'descripcion' => 'required',
            'opcion1' => 'nullable',
            'opcion2' => 'required_if:opcion1,Medico Familia',
            'empleados' => 'nullable',
            'entidades' => 'nullable',
            'id'=> 'required'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
