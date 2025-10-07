<?php

namespace App\Http\Modules\Solicitudes\TipoSolicitud\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearTipoSolicitudRedVitalRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|unique:tipo_solicitud_red_vitals,nombre',
            'descripcion' => 'required',
            'opcion1' => 'required',
            'opcion2' => 'required_if:opcion1,Medico Familia'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
