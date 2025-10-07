<?php

namespace App\Http\Modules\ContratosEmpleados\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearContratoEmpleadoRequest extends FormRequest
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
            'tipo_contrato_id' => 'required|exists:tipo_contrato_ths,id',
            'cargo_id' => 'required|exists:cargos,id',
            'empleado_id' => 'required|exists:empleados,id',
            'proyecto_id' => 'required|exists:proyectos,id',
            'municipio_trabaja_id' => 'required|exists:municipios,id',
            'fecha_ingreso' => 'required|date',
            'fecha_retiro' => 'nullable|date|after_or_equal:fecha_ingreso|required_if:activo,false',
            'fecha_fin_periodo_prueba' => 'required|date',
            'salario' => 'required|numeric',
            'jornada' => 'required|string',
            'activo' => 'required|boolean',
            'prerrogativa' => 'boolean',
            'descripcion_prerrogativa' => 'required_if:prerrogativa,true',
            'numero_cuenta_bancaria' => 'nullable',
            'tipo_cuenta_id' => 'nullable',
            'banco_id' => 'nullable',
            'descripcion_obra_labor' => 'required_if:tipo_contrato_id,3',
            'horas' => 'required',
            'fecha_vencimiento' => 'required_unless:tipo_contrato_id,2'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 400));
    }
}
