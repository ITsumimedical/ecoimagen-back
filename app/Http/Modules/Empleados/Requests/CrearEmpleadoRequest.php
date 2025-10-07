<?php

namespace App\Http\Modules\Empleados\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearEmpleadoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'primer_nombre' => 'required|string',
            'segundo_nombre' => 'string|nullable',
            'primer_apellido' => 'required|string',
            'segundo_apellido' => 'string|nullable',
            'documento' => 'required|string|unique:empleados,documento',
            'fecha_nacimiento' => 'required|string',
            'fecha_expedicion_documento' => 'required|string',
            'direccion_residencia' => 'required|string',
            'barrio' => 'required|string',
            'telefono' => 'nullable|string|max:10',
            'celular' => 'required|string|max:10',
            'celular2' => 'nullable|string|max:10',
            'email_personal' => 'required|string',
            'email_corporativo' => 'required|string',
            'cabeza_hogar' => 'nullable|boolean',
            'area_residencia' => 'required|string',
            'peso' => 'required|integer|min:40',
            'altura' => 'required|integer|min:100',
            'descripcion' => 'nullable|string',
            'rh' => 'required|string',
            'genero' => 'required|string',
            'estado_civil' => 'required|string',
            'orientacion_sexual_id' => 'required|exists:orientacion_sexuals,id',
            'identidad_genero' => 'required|string',
            'grupo_etnico' => 'required|string',
            'nivel_estudio' => 'required|string',
            'victima' => 'nullable|boolean',
            'discapacidad' => 'nullable|boolean',
            'descripcion_discapacidad' => 'nullable|string',
            'ajuste_puesto' => 'nullable|string',
            'registro_medico' => 'required_if:medico,true',
            'tipo_documento_id' => 'required|exists:tipo_documentos,id',
            'municipio_expedicion_id' => 'required|exists:municipios,id',
            'municipio_residencia_id' => 'required|exists:municipios,id',
            'municipio_nacimiento_id' => 'required|exists:municipios,id',
            'areath_id' => 'required|exists:area_ths,id',
            'estado_id' => 'required|exists:estados,id',
            'especialidad_id' => 'nullable|required_if:medico,true',
            'medico' => 'nullable|boolean',
            'sede_id' => 'required|exists:sedes,id',
        ];
    }


    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
