<?php

namespace App\Http\Modules\ActuacionTutelas\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ActualizarActuacionTutelaRequest extends FormRequest
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
        'direccion' => 'required|string',
        'telefono' => 'required|string',
        'radicado' => 'required|string',
        'exclusion' => 'required|string',
        'integralidad' => 'required|string',
        'continuidad' => 'required|string',
        'novedad_registro' => 'string',
        'gestion_documental' => 'string',
        'medicina_laboral' => 'string',
        'reembolso' => 'string',
        'transporte' => 'string',
        'motivo_reasignar' => 'required|string',
        'fecha_radica' => 'required|date',
        'fecha_cerrada' => 'date',
        'fecha_reasigna' => 'date',
        'observacion'=> 'required|string',
        'motivo_cerrar' => 'string',
        'afiliado_id' => 'required',
        'municipio_id' => 'required',
        'juzgado_id' => 'required',
        'tipo_requerimientos_id' => 'required',
        'estado_id' => 'required',
        'quien_cerro_id' => 'required',
        'quien_realizo_id' => 'required',
        'user_id' => 'required',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
