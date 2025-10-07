<?php

namespace App\Http\Modules\Historia\estratificacionFindrisks\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrearEstratificacionFindrisksRequest extends FormRequest
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
            'edad_puntaje' => 'nullable',
            'indice_corporal' => 'nullable',
            'perimetro_abdominal' => 'nullable',
            'actividad_fisica' => 'nullable',
            'puntaje_fisica' => 'nullable',
            'frutas_verduras' => 'nullable',
            'hipertension' => 'nullable',
            'resultado_hipertension' => 'nullable',
            'glucosa' => 'nullable',
            'resultado_glucosa' => 'nullable',
            'diabetes' => 'nullable',
            'parentezco' => 'nullable',
            'resultado_diabetes' => 'nullable',
            'totales' => 'nullable',
            'usuario_id' => 'nullable',
            'afiliado_id' => 'nullable',
            'consulta_id' => 'nullable',
            'estado_id' => 'nullable',
        ];
    }
}
