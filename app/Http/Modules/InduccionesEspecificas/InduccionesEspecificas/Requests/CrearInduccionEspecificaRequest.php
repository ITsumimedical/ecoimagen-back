<?php

namespace App\Http\Modules\InduccionesEspecificas\InduccionesEspecificas\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearInduccionEspecificaRequest extends FormRequest
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
            'empleado_id' => 'required|exists:empleados,id',
            'usuario_registra_id' => 'required|exists:users,id',
            'fecha_inicio_induccion' => 'required|date',
            'fecha_finalizacion_induccion' => 'nullable|date',
            'cumplio_totalidad' => 'boolean|nullable',
            'firma_facilitador' => 'string|nullable',
            'firma_empleado' => 'string|nullable',
            'activo' => 'boolean'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 400));
    }
}
