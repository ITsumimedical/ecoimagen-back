<?php

namespace App\Http\Modules\Afiliados\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;


class ActualizarAfiliadoHistoriaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'tipo_documento' => 'required|exists:tipo_documentos,id',
            'numero_documento' => 'required',
            'primer_nombre' => 'required',
            'primer_apellido' => 'required',
            'segundo_apellido' => 'nullable',
            'estado_civil' => 'required',
            'fecha_nacimiento' => 'required',
            'edad_cumplida' => 'required',
            'sexo' => 'required',
            'ocupacion' => 'min:5|required',
            'direccion_residencia_cargue' => 'required',
            'telefono' => 'min:7|max:10',
            'tipo_afiliado_id' => 'required|exists:tipo_afiliados,id',
            'entidad_id' => 'required|exists:entidades,id',
            'etnia' => 'required',
            'celular1' => 'min:7|max:10',
            'nombre_acompanante' => 'required|min:5',
            'telefono_acompanante' => 'nullable',
            'nivel_educativo' => 'required',
            'parentesco_responsable' => 'required',
            'telefono_responsable' => 'nullable',
            'nombre_responsable' => 'required',
            'discapacidad' => 'nullable',
            'grado_discapacidad' => 'nullable',
            'ciclo_vida_atencion' => 'required',
            'zona_vivienda' => 'required',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw (new HttpResponseException(response()->json($validator->errors(), 422)));
    }
}

