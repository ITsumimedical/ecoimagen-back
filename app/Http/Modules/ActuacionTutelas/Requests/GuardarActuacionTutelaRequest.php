<?php

namespace App\Http\Modules\ActuacionTutelas\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class GuardarActuacionTutelaRequest extends FormRequest
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
            'direccion' => 'required|min:5',
            'telefono' => 'required|min_digits:7',
            'exclusion' => 'required',
            'integralidad' => 'required',
            'continuidad' => 'required',
            'gestion_documental' => 'nullable',
            'medicina_laboral' => 'nullable',
            'reembolso' => 'nullable',
            'transporte' => 'nullable',
            'fecha_radica' => 'required|date',
            'fecha_cerrada' => 'nullable',
            'fecha_reasigna' => 'nullable',
            'motivo_cerrar' => 'nullable',
            'proceso_id' => 'nullable',
            'tipo_actuacion_id' => 'required',
            'observacion' => 'nullable',
            'celular' => 'nullable',
            'correo' => 'required|email',
            'dias' => 'required|integer',
            'novedad_registro' => 'nullable',
            'tutela_id' => 'required'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
