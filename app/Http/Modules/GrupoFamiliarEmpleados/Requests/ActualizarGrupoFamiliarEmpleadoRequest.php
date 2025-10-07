<?php

namespace App\Http\Modules\GrupoFamiliarEmpleados\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ActualizarGrupoFamiliarEmpleadoRequest extends FormRequest
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
            'direccion' => 'string|required',
            'celular' => 'string|required',
            'telefono' => 'string|nullable',
            'parentesco' => 'string|nullable',
            'empleado_id' => 'exists:empleados,id|required',
            'municipio_id' => 'exists:municipios,id|required'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 400));
    }
}
