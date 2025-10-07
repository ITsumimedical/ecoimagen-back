<?php

namespace App\Http\Modules\Afiliados\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearAfiliadoRequest extends FormRequest
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
        $validacionAfiliado = [
            'id_afiliado' => 'nullable',
            'region' => 'nullable',
            'primer_nombre' => 'required',
            'segundo_nombre' => 'nullable',
            'primer_apellido' => 'required',
            'segundo_apellido' => 'nullable',
            'tipo_documento' => 'required',
            'numero_documento' => 'required',
            'sexo' => 'required',
            'fecha_afiliacion' => 'required',
            'fecha_nacimiento' => 'required',
            'edad_cumplida' => 'required',
            'telefono' => 'nullable',
            'celular1' => 'required',
            'celular2' => 'nullable',
            'correo1' => 'required',
            'correo2' => 'nullable',
            'direccion_residencia_cargue' => 'nullable',
            'direccion_residencia_numero_exterior' => 'nullable',
            'direccion_residencia_via' => 'nullable',
            'direccion_residencia_numero_interior' => 'nullable',
            'direccion_residencia_interior' => 'nullable',
            'direccion_residencia_barrio' => 'nullable',
            'discapacidad' => 'required',
            'grado_discapacidad' => 'nullable',
            'parentesco' => 'nullable',
            'tipo_afiliado_id' => 'required',
            'tipo_documento_cotizante' => 'required_if:tipo_afiliado_id,1',
            'numero_documento_cotizante' => 'required_if:tipo_afiliado_id,1',
            'categorizacion' => 'nullable',
            'nivel' => 'nullable',
            'sede_odontologica' => 'nullable',
            'subregion_id' => 'nullable',
            'departamento_afiliacion_id' => 'required',
            'municipio_afiliacion_id' => 'required',
            'departamento_atencion_id' => 'required',
            'municipio_atencion_id' => 'required',
            'ips_id' => 'required',
            'medico_familia1_id' => 'nullable',
            'medico_familia2_id' => 'nullable',
            'estado_afiliacion_id' => 'nullable',
            'tipo_afiliacion_id' => 'required',
            'dpto_residencia_id' => 'nullable',
            'mpio_residencia_id' => 'nullable',
            'estado_afiliacion_id' => 'required',
            'ipsorigen_portabilidad' => 'nullable',
            'telefonoorigen_portabilidad' => 'nullable',
            'correoorigen_portabilidad' => 'nullable',
            'fechaInicio_portabilidad' => 'nullable',
            'fechaFinal_portabilidad' => 'nullable',
            'pais_id' => 'required',
            'ocupacion' => 'nullable',
            'nivel_educativo' => 'nullable',
            'estado_civil' => 'nullable',
            'colegio_id' => ($this->input('tipo_afiliado_id') == 2 && $this->input('entidad_id') == 1) ? 'required' : 'nullable',
            'entidad_id' => 'required',
            'etnia' => 'nullable',
            'exento_pago'=>'nullable',
            'plan' => 'nullable|string',
            'categoria' => 'nullable|string',
        ];
        return $validacionAfiliado;
    }

    public function failedValidation(Validator $validator)
    {
        throw (new HttpResponseException(response()->json($validator->errors(), 422)));
    }
}
