<?php

namespace App\Http\Modules\Contratos\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ActualizarContratoRequest extends FormRequest
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
            'novedad' => 'required|string',
            #el prestador se comenta por que no debe ser modificado al actualizar
            #'prestador_id' => 'required|exists:prestadores,id',
            'ambito_id' => 'required|exists:ambitos,id',
            'fecha_termina' => 'required|date',
            'fecha_inicio' => 'required|date',
            'entidad_id' => 'required|exists:entidades,id',
            'capitado' => 'required|boolean',
            'pgp' => 'required|boolean',
            'evento' => 'required|boolean',
            'poliza' => 'required|string',
            'renovacion' => 'required|boolean',
            'modificacion' => 'nullable|string',
            'descripcion' => 'nullable|string',
            'tipo_reporte' => 'nullable|string',
            'linea_negocio' => 'nullable|string',
            'regimen' => 'nullable|string',
            'documento_proveedor_id' => 'nullable|string',
            'documento_proveedor' => 'nullable|string',
            'naturaleza_juridica' => 'nullable|string',
            'codigo_habilitacion' => 'nullable|string',
            'componente' => 'nullable|string',
            'tipo_servicio' => 'nullable|string',
            'tipo_relacion' => 'nullable|string',
            'codigo_contrato' => 'nullable|string',
            'obj_contrato' => 'nullable|string',
            'poblacion_cubierta' => 'nullable|string',
            'modalidad_pago' => 'nullable|string',
            'otra_modalidad' => 'nullable|string',
            'tipo_modificacion' => 'nullable|string',
            'valor_contrato' => 'nullable',
            'valor_adicion' => 'nullable',
            'valor_ejecutado' => 'nullable',
            'estado' => 'nullable|string',
            'union_temporal' => 'nullable|string',
            'union_temporal_id' => 'nullable|string',
            'tipo_proveedor' => 'nullable|string',
            'tipo_red' => 'nullable|string',
            'files.*' => 'file|mimes:pdf,xlsx,jpg,png|max:2048',

        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw (new HttpResponseException(response()->json($validator->errors(), 422)));
    }
}
