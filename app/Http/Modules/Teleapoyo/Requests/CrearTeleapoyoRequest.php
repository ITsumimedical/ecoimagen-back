<?php

namespace App\Http\Modules\Teleapoyo\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearTeleapoyoRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tipo_estrategia' => 'required|string',
            'motivo_teleorientacion' => 'required|string',
            'tipo_solicitudes_id' => 'required',
            'especialidad_id' => 'required',
            'resumen_historia_clinica' => 'required',
            'c10'=> 'required',
            'adjuntos' => 'nullable',
            'numero_documento' => 'nullable',
            'afiliado_id' => 'nullable',
            'girs' => 'nullable'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 400));
    }

    public function attributes()
    {
        return [
            'tipo_solicitudes_id' => 'Tipo de solicitud',
            'especialidad_id' => 'Especialidad',
            'c10'=> 'Cie10'
        ];
    }

}
