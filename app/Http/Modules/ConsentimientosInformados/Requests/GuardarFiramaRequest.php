<?php

namespace App\Http\Modules\ConsentimientosInformados\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuardarFiramaRequest extends FormRequest
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
            'firma' => 'required|string',
            'nombre_profesional' => 'required|string'
        ];
    }
}
