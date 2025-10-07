<?php

namespace App\Http\Modules\Sedes\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ActualizarSedeRequest extends FormRequest
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
            'nombre'        => 'required|string',
            'direccion'     => 'required|string',
            'telefono'      => 'string|nullable',
            'hora_inicio'   => 'required|string',
            'hora_fin'      => 'required|string',
            'propia'        => 'boolean|nullable',
            'rep_id'        => 'required_if:propia,true'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
