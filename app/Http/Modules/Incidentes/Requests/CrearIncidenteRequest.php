<?php

namespace App\Http\Modules\Incidentes\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearIncidenteRequest extends FormRequest
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
            'usuario_reporta_id' => 'required|exists:users,id',
            'estado_id' => 'required|exists:estados,id',
            'fecha_incidente' => 'required|date|before_or_equal:today',
            'periodicidad_seguimiento' => 'required|string',
            'resultado' => 'required_if:cerrar,true|string',
            'gravedad' => 'required|string',
            'descripcion' => 'required|string',
            'comentarios' => 'nullable|string',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
