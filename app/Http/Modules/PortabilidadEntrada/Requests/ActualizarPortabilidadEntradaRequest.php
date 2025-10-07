<?php

namespace App\Http\Modules\PortabilidadEntrada\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;


class ActualizarPortabilidadEntradaRequest extends FormRequest
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
            'origen_ips' => 'required',
            'telefono_ips' => 'numeric|required',
            'correo_ips' => 'email|required',
            'fecha_inicio' => 'date | required',
            'fecha_final' => 'date | required',
            'cantidad_dias' => 'numeric|required|between:15,180',
            'afiliado_id' => 'integer|exists:afiliados,id'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw (new HttpResponseException(response()->json($validator->errors(), 422)));
    }
}
