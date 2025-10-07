<?php

namespace App\Http\Modules\Afiliados\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrearAfiliadoAdmisionRequest extends FormRequest
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
           'correo1' => 'nullable',
          'departamento_afiliacion_id' => 'nullable',
          'departamento_atencion_id' => 'nullable',
          'direccion_residencia_barrio' => 'nullable',
          'direccion_residencia_cargue' => 'nullable',
          'discapacidad' =>'nullable',
          'dpto_residencia_id' => 'nullable',
          'entidad_id' => 'nullable',
          'estado_afiliacion_id' => 'nullable',
          'estado_civil' => 'nullable',
          'fecha_afiliacion' => 'nullable',
          'fecha_nacimiento' => 'nullable',
          'grupo_sanguineo' => 'nullable',
          'identidad_genero' => 'nullable',
          'ips_id' =>'nullable',
          'mpio_residencia_id' => 'nullable',
          'municipio_afiliacion_id' => 'nullable',
          'municipio_atencion_id' => 'nullable',
          'nivel_educativo' => 'nullable',
          'nombre_responsable' => 'nullable',
          'numero_documento' =>'nullable',
          'ocupacion' => 'nullable',
          'orientacion_sexual' => 'nullable',
          'pais_id' => 'nullable',
          'parentesco_responsable' => 'nullable',
          'primer_apellido' => 'nullable',
          'primer_nombre' => 'nullable',
          'region' => 'nullable',
          'salario_minimo_afiliado' => 'nullable',
          'segundo_apellido' => 'nullable',
          'segundo_nombre' => 'nullable',
          'sexo' => 'nullable',
          'telefono' => 'nullable',
          'telefono_responsable' => 'nullable',
          'tipo_documento' => 'nullable',
          'tipo_afiliado_id' => 'nullable',
          'tipo_afiliacion_id' => 'nullable',
        ];
    }
}
