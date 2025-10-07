<?php

namespace App\Http\Modules\Historia\estratificacionFramingham\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrearEstratificacionFraminghamsRequest extends FormRequest
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
            'tratamiento' => 'nullable',
            'edad_puntaje' => 'nullable',
            'colesterol_total' => 'nullable',
            'colesterol_puntaje' => 'nullable',
            'colesterol_hdl' => 'nullable',
            'colesterol_puntajehdl' => 'nullable',
            'fumador_puntaje' => 'nullable',
            'arterial_puntaje' => 'nullable',
            'totales' => 'nullable',
            'usuario_id' => 'nullable',
            'afiliado_id' => 'nullable',
            'consulta_id' => 'nullable',
            'estado_id' => 'nullable',
            'diabetes_puntaje' => 'nullable',
            'porcentaje' => 'nullable',
            'resultado' => 'nullable',
        ];
    }
}
