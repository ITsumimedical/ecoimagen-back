<?php

namespace App\Http\Modules\Ecomapa\Request;

use Illuminate\Foundation\Http\FormRequest;

class RelacionEcomapaRequest extends FormRequest
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
            'relaciones' => 'required|array',
            'relaciones.*.figura_origen_id' => 'nullable|integer',
            'relaciones.*.figura_destino_id' => 'nullable|integer',
            'relaciones.*.tipo_relacion' => 'nullable|string|max:255',
        ];
    }
}
