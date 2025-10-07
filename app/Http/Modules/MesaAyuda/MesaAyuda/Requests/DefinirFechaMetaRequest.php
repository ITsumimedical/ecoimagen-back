<?php

namespace App\Http\Modules\MesaAyuda\MesaAyuda\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DefinirFechaMetaRequest extends FormRequest
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
            'fecha_meta_solucion' => ['required', 'date', 'after_or_equal:today'],
            'motivo' => ['nullable', 'string', 'min:10'],
        ];
    }

    public function messages(): array
    {
        return [
            'fecha_meta_solucion.required' => 'La fecha meta de solución es obligatoria.',
            'fecha_meta_solucion.date' => 'La fecha debe ser válida.',
            'fecha_meta_solucion.after_or_equal' => 'La fecha debe ser hoy o posterior.',
        ];
    }
}
