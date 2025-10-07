<?php

namespace App\Http\Modules\Afiliados\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearAfiliadoAseguramientoRequest extends FormRequest
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
    public function rules()
    {
        return [
            'tipo_documento' => 'required|integer',
            'numero_documento' => 'required|string',
            'primer_nombre' => 'required|string',
            'segundo_nombre' => 'nullable|string',
            'primer_apellido' => 'required|string',
            'segundo_apellido' => 'nullable|string',
            'entidad_id' => 'required|integer',
            'sexo' => 'required|string',
            'fecha_nacimiento' => 'required|date',
            'fecha_afiliacion' => 'required|date',
            'tipo_afiliado_id' => 'required|integer',
            'tipo_afiliacion_id' => 'required|integer',
            'estado_afiliacion_id' => 'required|integer',
            'grupo_sanguineo' => 'nullable|string',
            'nivel_educativo' => 'nullable|string',
            'ocupacion' => 'nullable|string',
            'estado_civil' => 'nullable|string',
            'orientacion_sexual' => 'nullable|string',
            'identidad_genero' => 'nullable|string',
            'discapacidad' => 'required|string',
            'grado_discapacidad' => 'nullable|string',
            'salario_minimo_afiliado' => 'nullable|string',
            'pais_id' => 'required|integer',
            'departamento_afiliacion_id' => 'required|integer',
            'municipio_afiliacion_id' => 'required|integer',
            'departamento_atencion_id' => 'required|integer',
            'municipio_atencion_id' => 'required|integer',
            'dpto_residencia_id' => 'required|integer',
            'mpio_residencia_id' => 'required|integer',
            'region' => 'required|string',
            'ips_id' => 'required|integer',
            'medico_familia1_id' => 'nullable|integer',
            'medico_familia2_id' => 'nullable|integer',
            'telefono' => 'nullable|string',
            'celular1' => 'required|string',
            'celular2' => 'nullable|string',
            'correo1' => 'required|string',
            'correo2' => 'nullable|string',
            'direccion_residencia_cargue' => 'required|string',
            'direccion_residencia_via' => 'nullable|string',
            'direccion_residencia_numero_interior' => 'nullable|string',
            'direccion_residencia_interior' => 'nullable|string',
            'direccion_residencia_numero_exterior' => 'nullable|string',
            'direccion_residencia_barrio' => 'nullable|string',
            'colegio_id' => 'nullable|integer',
            'tipo_documento_cotizante' => 'required_if:tipo_afiliado_id,1',
            'numero_documento_cotizante' => 'required_if:tipo_afiliado_id,1',
            'parentesco' => 'nullable',
            'plan' => 'string|nullable',
            'categoria' => 'string|nullable',
        ];

        if ($this->input('entidad_id') != 1){
            $rules['plan'] = ['required', 'string'];
            $rules['categoria'] = ['required', 'string'];
        }
    }

    public function failedValidation(Validator $validator)
    {
        throw (new HttpResponseException(response()->json($validator->errors(), 422)));
    }
}
