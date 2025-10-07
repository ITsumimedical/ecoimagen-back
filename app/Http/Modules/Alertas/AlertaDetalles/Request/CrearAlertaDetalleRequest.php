<?php

namespace App\Http\Modules\Alertas\AlertaDetalles\Request;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class CrearAlertaDetalleRequest extends FormRequest
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
            'tipo_alerta_id' => 'integer|required|exists:tipo_alertas,id',
            'mensaje_alerta_id' => 'integer|required|exists:mensajes_alertas,id',
            'usuario_registra_id' => 'integer|required|exists:users,id',
            'estado_id' => 'integer|required|exists:estados,id',
            'alerta_id' => 'integer|required|exists:alertas,id',
            // 'interaccion_id' => 'nullable|integer|exists:cums,id'
            'interaccion' => 'nullable|string'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
