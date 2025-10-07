<?php

namespace App\Http\Modules\Agendas\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActualizarCitaAgendaRequest extends FormRequest
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
            'agenda_id' => 'required',
            'cita_id' => 'required'
        ];
    }
}
