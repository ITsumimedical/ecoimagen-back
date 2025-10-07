<?php

namespace App\Http\Modules\InduccionesEspecificas\DetalleInduccionesEspecificas\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ActualizarDetalleInduccionEspecificaRequest extends FormRequest
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
            'induccion_especifica_id' => 'required|exists:induccion_especificas,id',
            'tema_id' => 'required|exists:tema_induccion_especificas,id',
            'usuario_registra_id' => 'required|exists:users,id',
            'descripcion_actividad' => 'nullable|string',
            'usuario_ingreso_plataforma' => 'nullable|string',
            'contrasena_ingreso_plataforma' => 'nullable|string',
            'fecha_realizacion' => 'date|nullable',
            'realizado' => 'nullable|string',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 400));
    }
}
