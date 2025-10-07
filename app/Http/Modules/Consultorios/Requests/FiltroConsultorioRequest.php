<?php

namespace App\Http\Modules\Consultorios\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FiltroConsultorioRequest extends FormRequest
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
            'nombre' => ['nullable', 'string'],
            'nombre_reps' => ['nullable', 'string'],
            'page' => ['nullable', 'boolean'],
            'cant' => ['nullable', 'integer', 'min:1'],
        ];
    }
}
