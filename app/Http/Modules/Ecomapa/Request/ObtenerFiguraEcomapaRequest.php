<?php

namespace App\Http\Modules\Ecomapa\Request;

use Illuminate\Foundation\Http\FormRequest;

class ObtenerFiguraEcomapaRequest extends FormRequest
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
            'consulta_id' => 'required|integer|exists:consultas,id',
        ];
    }
}
