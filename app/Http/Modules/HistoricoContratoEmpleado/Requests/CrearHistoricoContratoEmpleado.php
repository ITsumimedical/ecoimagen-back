<?php

namespace App\Http\Modules\HistoricoContratoEmpleado\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearHistoricoContratoEmpleado extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'contrato_empleado_id' => 'required',
            'user_id' => 'required',
            'cargo_id' => 'nullable',
            'proyecto_id' => 'nullable',
            'tipo_contrato_id' => 'nullable',
            'salario' => 'nullable',
            'horas' => 'nullable',
            'accion' => 'required',
            'observaciones' => 'required',
            'fecha_ingreso' => 'nullable',
            'fecha_vencimiento' => 'nullable',
            'fecha_retiro' => 'nullable',
            'fecha_fin_periodo_prueba' => 'nullable',
            'jornada' => 'nullable',
            'activo' => 'nullable',
            'tipo_terminacion' => 'nullable',
            'motivo_terminacion' => 'nullable',
            'justa_causa' => 'nullable',
            'numero_cuenta_bancaria' => 'nullable',
            'municipio_trabaja_id' => 'nullable',
            'tipo_cuenta_id' => 'nullable',
            'banco_id' => 'nullable',
            'fecha_aplicacion_novedad' => 'nullable'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
