<?php

namespace App\Http\Modules\Ecomapa\Request;

use Illuminate\Foundation\Http\FormRequest;

class GuardarImagenEcomapaRequest extends FormRequest
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
            'imagen' => 'required',
            'consulta_id' => 'required|exists:consultas,id',
            'medico_registra' => 'required|exists:users,id'
        ];
    }
}
