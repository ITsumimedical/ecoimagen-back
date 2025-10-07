<?php

namespace App\Http\Modules\Tutelas\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class GuardarTutelaRequest extends FormRequest
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
        $tutela = [
            'radicado'          => 'required',
            'fecha_radica'      => 'required|date',
            'observacion'       => 'required',
            'afiliado_id'        => 'required|exists:afiliados,id',
            'municipio_id'      => 'required|exists:municipios,id',
            'juzgado_id'        => 'required|exists:juzgados,id',
            'continuidad'       => 'required|string',
            'exclusion'         => 'required|string',
            'integralidad'      => 'required|string',
            'tipo_actuacion_id' => 'required|exists:tipo_actuaciones,id',
            'dias'              => 'required|integer',
            'proceso_id'        => 'required',
            'direccion'         => 'required|string',
            'radicado_corto'    => 'required',
            'telefono'          => 'integer',
            'celular'           => 'integer',
            'correo'            => 'required|string',
            // 'tipo_servicio'     => 'required',
            //'servicios'         =>'nullable',
            'medicamentos'      =>'nullable',
            'hospitalizacion'  =>'nullable',
            'reintegro_laboral' => 'nullable',
            'adjuntos'          => 'nullable'
        ];
        // foreach ($this->input('tipo_servicio') as $tipo_servicio){
        //     if($tipo_servicio == 'NOVEDADES Y REGISTRO'){
        //         $tutela['novedad_registro'] = 'required';
        //     }

        //     if($tipo_servicio == 'EXCLUSION'){
        //         $tutela['exclusiones'] = 'required';
        //     }

        //     if($tipo_servicio == 'GESTION DOCUMENTAL'){
        //         $tutela['gestion_documental'] = 'required';
        //     }

        //     if($tipo_servicio == 'MEDICINA LABORAL'){
        //         $tutela['medicina_laboral'] = 'required';
        //     }

        //     if($tipo_servicio == 'REEMBOLSO'){
        //         $tutela['reembolso'] = 'required';
        //     }

        //     if($tipo_servicio == 'TRANSPORTE'){
        //         $tutela['transporte'] = 'required';
        //     }
        // }


        return $tutela;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
