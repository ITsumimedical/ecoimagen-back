<?php

namespace App\Http\Modules\TipoPrestador\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ActualizarTipoPrestadorRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'nombre' => 'required|string|unique:tipo_prestadores,nombre,' . $this->id . ',id',
        ];
    }

    public function failedValidation(Validator $validator){
        throw ( new HttpResponseException(response()->json($validator->errors(),422)));
    }
}
