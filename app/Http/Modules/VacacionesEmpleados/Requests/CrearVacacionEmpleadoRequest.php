<?php

namespace App\Http\Modules\VacacionesEmpleados\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearVacacionEmpleadoRequest extends FormRequest
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
            'fecha_inicio_disfrute' => 'date|required',
            'fecha_fin_disfrute' => 'date|required|after:fecha_inicio_disfrute',
            'anio_periodo' => 'string|required',
            'fecha_incorporacion' => 'date|date|after:fecha_fin_disfrute',
            'dias_disfrutados' => 'integer|required|min:6',
            'dias_pagados' => 'integer|required',
            'contrato_id' => 'required|exists:contrato_empleados,id',
            'estado_id' => 'required|exists:estados,id',
            'requiere_reemplazo' => 'boolean|nullable'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 400));
    }
}
