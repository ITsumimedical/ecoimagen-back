<?php

namespace App\Http\Modules\Afiliados\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ActualizarAfiliadoRequest extends FormRequest
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
            'primer_nombre' => 'nullable',
            'segundo_nombre' => 'nullable',
            'primer_apellido' => 'nullable',
            'segundo_apellido' => 'nullable',
            'tipo_documento' => 'nullable',
            'numero_documento' => 'nullable',
            'sexo' => 'nullable',
            'fecha_afiliacion' => 'nullable',
            'fecha_nacimiento' => 'nullable',
            'edad_cumplida' => 'nullable',
            'telefono' => 'nullable',
            'celular1' => 'nullable',
            'celular2' => 'nullable',
            'correo1' => 'nullable',
            'correo2' => 'nullable',
            'direccion_residencia_cargue' => 'nullable|string',
            'direccion_residencia_numero_exterior' => 'nullable|string',
            'direccion_residencia_via' => 'nullable|string',
            'direccion_residencia_interior' => 'nullable|string',
            'direccion_residencia_numero_interior' => 'nullable|string',
            'direccion_residencia_barrio' => 'nullable|string',
            'discapacidad' => 'nullable',
            'grado_discapacidad' => 'nullable',
            'parentesco' => 'nullable',
            'tipo_afiliado_id' => 'nullable',
            'tipo_documento_cotizante' => 'required_if:tipo_afiliado_id,1',
            'numero_documento_cotizante' => 'required_if:tipo_afiliado_id,1',
            'tipo_cotizante' => 'nullable',
            'categorizacion' => 'nullable',
            'nivel' => 'nullable',
            'sede_odontologica' => 'nullable',
            'subregion_id' => 'nullable',
            'departamento_afiliacion_id' => 'nullable',
            'municipio_afiliacion_id' => 'nullable',
            'departamento_atencion_id' => 'nullable',
            'municipio_atencion_id' => 'nullable',
            'ips_id' => 'nullable',
            'medico_familia1_id' => 'nullable',
            'medico_familia2_id' => 'nullable',
            'estado_afiliacion_id' => 'nullable',
            'tipo_afiliacion_id' => 'nullable',
            'dpto_residencia_id' => 'nullable',
            'mpio_residencia_id' => 'nullable',
            'entidad_id' => 'nullable',
            'ipsorigen_portabilidad' => 'nullable',
            'telefonoorigen_portabilidad' => 'nullable',
            'correoorigen_portabilidad' => 'nullable',
            'fechaInicio_portabilidad' => 'nullable',
            'fechaFinal_portabilidad' => 'nullable',
            'pais_id' => 'nullable | exists:paises,id',
            'ocupacion' => 'nullable',
            'donde_labora' => 'nullable',
            'nivel_educativo' => 'nullable',
            'estado_civil' => 'nullable',
            'religion' => 'nullable',
            'orientacion_sexual' => 'nullable',
            'identidad_genero' => 'nullable',
            'nombre_acompanante' => 'nullable',
            'telefono_acompanante' => 'nullable',
            'nombre_responsable' => 'nullable',
            'telefono_responsable' => 'nullable',
            'parentesco_responsable' => 'nullable',
            'colegio_id' => 'nullable|exists:colegios,id',
            'nivel_ensenanza' => 'nullable',
            'area_ensenanza_nombrado' => 'nullable',
            'escalafon' => 'nullable',
            'cargo' => 'nullable',
            'nombre_cargo' => 'nullable',
            'tipo_vinculacion' => 'nullable',
            'grupo_sanguineo' => 'nullable',
            'salario_minimo_afiliado' => 'nullable',
            'plan' => 'nullable',
            'categoria' => 'nullable',
            'localidad' => 'nullable',
            'zona_vivienda' => 'nullable',
            'numero_folio' => 'nullable',
            'fecha_folio' => 'nullable',
            'cuidad_orden_judicial' => 'nullable',
            'fecha_expedicion_documento' => 'nullable',
            'fecha_vigencia_documento' => 'nullable',
            'fecha_defuncion' => 'nullable',
            'tipo_documento_padre_beneficiario' => 'nullable',
            'municipio_nacimiento_id' => 'nullable',
            'fecha_posible_parto' => 'nullable',
            'asegurador_id' => 'nullable',
            'acceso_vivienda' => 'nullable',
            'seguridad_vivienda' => 'nullable',
            'vivienda' => 'nullable',
            'agua_potable' => 'nullable',
            'preparacion_alimentos' => 'nullable',
            'energia_electrica' => 'nullable',
            'nombre_acompanante' => 'nullable',
            'telefono_acompanante' => 'nullable',
            'nombre_responsable' => 'nullable',
            'telefono_responsable' => 'nullable',
            'parentesco_responsable' => 'nullable',
            'orden_judicial' => 'nullable',
            'proferido' => 'nullable',
            'ruta_adj_doc_cotizante' => 'nullable',
            'ruta_adj_doc_beneficiario' => 'nullable',
            'ruta_adj_solic_firmada' => 'nullable',
            'ruta_adj_matrimonio' => 'nullable',
            'ruta_adj_rc_nacimiento_beneficiario' => 'nullable',
            'ruta_adj_rc_nacimiento_cotizante' => 'nullable',
            'ruta_adj_cert_discapacidad_hijo' => 'nullable',
            'numero_documento_padre_beneficiario' => 'nullable',
            'tipo_nombramiento' => 'nullable',
            'gestante' => 'nullable',
            'semanas_gestacion' => 'nullable',
            'grupo_poblacional' => 'nullable',
            'victima_conflicto_armado' => 'nullable',
            'zona_residencia' => 'nullable',
            'tipo_vivienda' => 'nullable',
            'etnia' => 'nullable',
            'exento_pago' => 'nullable',
        ];

        if ($this->input('actualizacionTotal') == 1) {
            $validacionAfiliado['fecha_novedad'] = 'required|date';
            $validacionAfiliado['motivo'] = 'required';
            $validacionAfiliado['tipo_novedad_afiliados_id'] = 'required';
        }

        return $validacionAfiliado;
    }

    public function failedValidation(Validator $validator)
    {
        throw (new HttpResponseException(response()->json($validator->errors(), 422)));
    }
}
