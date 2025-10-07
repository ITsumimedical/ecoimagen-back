<?php

namespace App\Http\Modules\CampoHistorias\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearCampoHistoriasRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
           'nombre' => 'required|string',
           'requerido' => 'required|boolean',
           'categoria_historia_id' => 'required|integer',
           'ciclo_vida' => 'required|string',
           'tipo_campo_id' => 'required|integer'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
