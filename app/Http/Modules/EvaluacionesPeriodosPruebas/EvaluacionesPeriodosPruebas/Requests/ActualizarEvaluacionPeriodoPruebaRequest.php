<?php

namespace App\Http\Modules\EvaluacionesPeriodosPruebas\EvaluacionesPeriodosPruebas\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ActualizarEvaluacionPeriodoPruebaRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'fecha_evaluacion' => 'date|required',
            'empleado_evaluado_id' => 'required|exists:empleados,id',
            'usuario_registra_id' => 'required|exists:users,id',
            'descripcion_experiencia_empresa' => 'required',
            'descripcion_experiencia_induccion' => 'required',
            'aprueba_periodo_prueba' => 'boolean',
            'observaciones' => 'nullable'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw (new HttpResponseException(response()->json($validator->errors(), 422)));
    }
}
