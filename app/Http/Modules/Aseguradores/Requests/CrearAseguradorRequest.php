<?php

namespace App\Http\Modules\aseguradores\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrearAseguradorRequest extends FormRequest
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
            'nombre'     => 'required|string|unique:aseguradors,nombre',
            'entidad_id' => 'required|exists:entidades,id',
        ];
    }
}
