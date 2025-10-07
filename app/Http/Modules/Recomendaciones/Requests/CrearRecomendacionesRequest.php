<?php

namespace App\Http\Modules\Recomendaciones\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrearRecomendacionesRequest extends FormRequest
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
            'descripcion' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'estado_id' => 'nullable|exists:estados,id',
            'edad_minima' => 'nullable|integer|min:0',
            'edad_maxima' => 'nullable|integer|min:0',
            'sexo' => 'nullable|in:M,F,A',
            'cie10_id' => 'nullable|array',
            'cie10_id.*' => 'required|integer|exists:cie10s,id',
            'cup_id' => 'nullable|array',
            'cup_id.*' => 'required|integer|exists:cups,id',
        ];
    }
}
