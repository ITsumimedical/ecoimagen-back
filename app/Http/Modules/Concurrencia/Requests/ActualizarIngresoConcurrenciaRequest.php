<?php

namespace App\Http\Modules\Concurrencia\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActualizarIngresoConcurrenciaRequest extends FormRequest
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
            'fecha_ingreso' => 'required|date',
            'tipo_hospitalizacion' => 'required|string|max:255',
            'via_ingreso' => 'required|string|max:255',
            'reingreso_15_dias' => 'required|string',
            'reingreso_30_dias' => 'required|string',
            'cama_piso' => 'nullable|string|max:255',
            'codigo_habilitacion' => 'nullable|string|max:255',
            'especialidad_id' => 'required|integer',
            'nota_seguimiento' => 'required|string',

        ];
    }
}
