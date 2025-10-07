<?php

namespace App\Http\Modules\AfiliacionesEmpleados\Request;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearAfiliacionEmpleadoRequest extends FormRequest
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
            'fecha_afiliacion' => 'required|date',
            'fecha_fin_afiliacion' => 'date|after:fecha_afiliacion|nullable',
            'prestador_id' => 'required|exists:prestador_ths,id',
            'contrato_id' => 'required|exists:contrato_empleados,id',
            'clasificacion_riesgo' => 'nullable',
            'estado' => 'required|boolean'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 400));
    }
}
