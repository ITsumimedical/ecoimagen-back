<?php

namespace App\Http\Modules\HijosEmpleados\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ActualizarHijoEmpleadoRequest extends FormRequest
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
            'nombre' => 'string|required',
            'documento' => 'string|required',
            'celular' => 'string|required',
            'telefono' => 'string|nullable',
            'fecha_nacimiento' => 'date|required',
            'comparte_vivienda' => 'boolean|nullable',
            'afiliar_caja' => 'boolean|nullable',
            'afiliar_eps' => 'boolean|nullable',
            'depende_economicamente' => 'boolean|nullable',
            'empleado_id' => 'exists:empleados,id|nullable',
            'tipo_documento_id' => 'exists:tipo_documentos,id'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 400));
    }
}
