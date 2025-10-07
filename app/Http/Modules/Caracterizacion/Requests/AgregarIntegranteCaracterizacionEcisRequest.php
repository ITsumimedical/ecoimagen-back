<?php

namespace App\Http\Modules\Caracterizacion\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AgregarIntegranteCaracterizacionEcisRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'afiliado_id' => 'required|integer|exists:afiliados,id',
            'primer_nombre' => 'required|string|max:255',
            'segundo_nombre' => 'nullable|string|max:255',
            'primer_apellido' => 'required|string|max:255',
            'segundo_apellido' => 'nullable|string|max:255',
            'tipo_documento_id' => 'required|integer|exists:tipo_documentos,id',
            'numero_documento' => 'required|string|max:50',
            'fecha_nacimiento' => 'required|date',
            'sexo' => 'required|string',
            'rol_familia' => 'required|string',
            'rol_familia_otro' => 'nullable|string|max:255',
            'ocupacion' => 'required|string',
            'nivel_educativo' => 'required|string',
            'tipo_afiliacion_id' => 'required|integer|exists:tipo_afiliacions,id',
            'entidad_id' => 'required|integer|exists:entidades,id',
            'grupo_especial_proteccion' => 'required|string',
            'pertenencia_etnica' => 'required|string',
            'comunidad_pueblo_indigena' => 'nullable|string|max:255',
            'discapacidad' => 'required|string',
            'condiciones_salud_cronica' => 'required|boolean',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}