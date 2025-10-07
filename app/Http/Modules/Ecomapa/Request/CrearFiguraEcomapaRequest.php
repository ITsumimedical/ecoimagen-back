<?php

namespace App\Http\Modules\Ecomapa\Request;

use Illuminate\Foundation\Http\FormRequest;

class CrearFiguraEcomapaRequest extends FormRequest
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
            'nombre' => 'required',
            'edad' => 'nullable',
            'pos_x' => 'nullable',
            'pos_y' => 'nullable',
            'class' => 'nullable',
            'principal' => 'nullable',
            'consulta_id' => 'required|exists:consultas,id',
        ];
    }
}
