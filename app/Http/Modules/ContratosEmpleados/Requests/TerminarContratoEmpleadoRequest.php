<?php

namespace App\Http\Modules\ContratosEmpleados\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TerminarContratoEmpleadoRequest extends FormRequest
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
            'tipo_terminacion' => 'required',
            'justa_causa' => 'required_if:tipo_terminacion,Terminación de contrato',
            'motivo_terminacion' => 'required_unless:tipo_terminacion,Fallecimiento',
            'activo' => 'required|boolean',
            'fecha_retiro' => 'required'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 400));
    }
}
