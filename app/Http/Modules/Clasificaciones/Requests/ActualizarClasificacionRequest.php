<?php

namespace App\Http\Modules\Clasificaciones\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ActualizarClasificacionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'nombre' => 'required|string|unique:clasificacions,nombre,' . $this->id . ',id',
            'descripcion' => 'required|string',
            'color' => 'string'
        ];
    }

    public function failedValidation(Validator $validator){
        throw ( new HttpResponseException(response()->json($validator->errors(),422)));
    }
}
