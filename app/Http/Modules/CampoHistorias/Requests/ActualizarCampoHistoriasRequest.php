<?php

namespace App\Http\Modules\CampoHistorias\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ActualizarCampoHistoriasRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'nombre' => 'string|unique:campo_historias,nombre,' . $this->id . ',id',
            'requerido' => 'required|boolean',
            'categoria_historia_id' => 'required|integer',
            'ciclo_vida' => 'required|string',
            'tipo_campo_id' => 'required|integer',
            'orden' => 'required|integer',
            'columnas' =>'required|integer'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 400));
    }
}
