<?php

namespace App\Http\Modules\Agendas\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrasladarConsultorioAgendaRequest extends FormRequest
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
            'agendas' => ['required', 'array', 'min:1'],
            'agendas.*' => ['integer', 'exists:agendas,id'],
            'consultorio_destino' => ['required', 'integer', 'exists:consultorios,id'],
            'motivo' => ['required', 'string', 'min:5', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'agendas.required' => 'Debe seleccionar al menos una agenda.',
            'agendas.*.exists' => 'Una de las agendas seleccionadas no existe.',
            'consultorio_destino.required' => 'El consultorio destino es obligatorio.',
            'consultorio_destino.exists'   => 'El consultorio destino no existe.',
            'motivo.required' => 'El motivo es obligatorio.',
            'motivo.min' => 'El motivo debe tener mínimo 5 caracteres.',
        ];
    }
}
