<?php

namespace App\Http\Modules\Aspirantes\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrearAspiranteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'documento'     => 'required|documento|unique:aspirantes',
            'primer_nombre' => 'required|string',
            'segundo_nombre' => 'string',
            'primer_apellido' => 'required|string',
            'segundo_apellido' => 'string',
            'documento' => 'required|string',
            'tipo_documento' => 'required|string',
            'sexo' => 'required|string',
            'telefono' => 'required|string',
            'orientacion_sexual' => 'string',
        ];
    }
}
