<?php

namespace App\Http\Modules\IncapacidadesEmpleados\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ActualizarIncapacidadEmpleadoRequest extends FormRequest
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
            'tipo' => 'required|string',
            'cie10' => 'required|exists:cie10s,id',
            'causa_externa' => 'nullable|string',
            'clase' => 'required|string',
            'motivo' => 'nullable|string',
            'descripcion' => 'required|string',
            'recomendaciones' => 'nullable|string',
            'contrato_id' => 'exists:contrato_empleados,id',
            'estado_id' => 'exists:estados,id|required',
            'fecha_desde' => 'required|date',
            'fecha_hasta' => 'required|date|after_or_equal:fecha_desde',
            'incapacidad_id' => 'required_if:clase,Prórroga'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 400));
    }
}
