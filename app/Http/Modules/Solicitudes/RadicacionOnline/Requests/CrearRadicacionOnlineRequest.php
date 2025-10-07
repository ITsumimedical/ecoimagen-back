<?php

namespace App\Http\Modules\Solicitudes\RadicacionOnline\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearRadicacionOnlineRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'afiliado_id' => 'required',
            'documento' => 'required',
            'descripcion' => 'required',
            'solicitud_id' => 'required',
            'solicitud_nombre' => 'required',
            'telefono' => 'required',
            'correo' => 'required',
            'adjuntos' =>'required'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
