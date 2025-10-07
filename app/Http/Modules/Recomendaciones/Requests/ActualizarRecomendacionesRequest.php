<?php

namespace App\Http\Modules\Recomendaciones\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActualizarRecomendacionesRequest extends FormRequest
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
            'cup_id' => 'nullable|integer',
            'cie10_id' => 'required|integer|exists:cie10s,id',
            'user_id' => 'required|integer|exists:users,id',
            'estado_id' => 'nullable|integer',
            'edad_minima' => 'required|integer',
            'edad_maxima' => 'required|integer',
            'sexo' => 'required|string|in:M,F,A',
        ];
    }
}
