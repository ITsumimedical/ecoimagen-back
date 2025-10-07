<?php

namespace App\Http\Modules\Concurrencia\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrearEventosIngresosConcurrenciaRequest extends FormRequest
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
            'evento' => 'required|string',
            'observaciones' => 'required|string',
            'tipo_evento' => 'required|string',
            'ingreso_concurrencia_id' => 'required|exists:ingreso_concurrencias,id',
            'user_id' => 'required|exists:users,id',
            'motivo_eliminacion' => 'nullable',
            'user_elimina_id' => 'nullable|exists:users,id',
        ];
    }
}
