<?php

namespace App\Http\Modules\Concurrencia\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrearEventoNotiInmediataRequest extends FormRequest
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
            'evento' => 'required',
            'descripciones' => 'nullable',
            'ingreso_concurrencia_id' => 'required|exists:ingreso_concurrencias,id',
        ];
    }
}
