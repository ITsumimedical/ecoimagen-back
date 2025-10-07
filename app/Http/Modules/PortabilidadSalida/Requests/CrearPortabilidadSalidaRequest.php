<?php

namespace App\Http\Modules\PortabilidadSalida\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;


class CrearPortabilidadSalidaRequest extends FormRequest
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
            'departamento_atencion' => 'required',
            'municipio_atencion' => 'required',
            'entidad' => 'required',
            'fechaInicio_portabilidad' => 'date | required',
            'fechaFinal_portabilidad' => 'date | required',
            'Motivo' => 'required',
            'cantidad' => 'numeric|required|between:15,180'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw (new HttpResponseException(response()->json($validator->errors(), 422)));
    }
}
