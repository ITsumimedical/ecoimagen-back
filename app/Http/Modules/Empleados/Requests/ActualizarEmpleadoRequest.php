<?php

namespace App\Http\Modules\Empleados\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ActualizarEmpleadoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'documento' => 'string|unique:empleados,documento,' . $this->id . ',id',
            'primer_nombre' => 'required|string',
            'primer_apellido' => 'required|string',
            'fecha_nacimiento' => 'required|string',
            'fecha_expedicion_documento' => 'required|string',
            'direccion_residencia' => 'required|string',
            'barrio' => 'required|string',
            'telefono' => 'nullable|string|max:10',
            'celular' => 'required|string|max:10',
            'celular2' => 'nullable|string|max:10',
            'email_personal' => 'required|string',
            'cabeza_hogar' => 'nullable|boolean',
            'area_residencia' => 'required|string',
            'peso' => 'required|numeric',
            'altura' => 'required|numeric',
            'descripcion' => 'nullable|string',
            'rh' => 'required|string',
            'genero' => 'required|string',
            'identidad_genero' => 'required|string',
            'estado_civil' => 'required|string',
            'orientacion_sexual_id' => 'required|exists:orientacion_sexuals,id',
            'grupo_etnico' => 'required|string',
            'nivel_estudio' => 'required|string',
            'victima' => 'nullable|boolean',
            'discapacidad' => 'nullable|boolean',
            'registro_medico' => 'required_if:medico,true',
            'tipo_documento_id' => 'required|exists:tipo_documentos,id',
            'areath_id' => 'required|exists:area_ths,id',
            'municipio_expedicion_id' => 'required|exists:municipios,id',
            'municipio_residencia_id' => 'required|exists:municipios,id',
            'municipio_nacimiento_id' => 'required|exists:municipios,id',
            'estado_id' => 'required|exists:estados,id',
            // 'especialidad_id' => 'nullable|required_if:medico,true',
            'medico' => 'nullable|boolean',
            'sede_id' => 'required|exists:sedes,id',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 400));
    }
}
