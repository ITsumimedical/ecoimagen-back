<?php

namespace App\Http\Modules\LicenciasEmpleados\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ActualizarLicenciaRequest extends FormRequest
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
            'contrato_id' => 'required|exists:empleados,id',
            'tipo_licencia_id' => 'required|exists:tipo_licencia_empleados,id',
            'estado_id' => 'required|exists:estados,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
            'observaciones' => 'required|string',
            'motivo' => 'nullable|string',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
