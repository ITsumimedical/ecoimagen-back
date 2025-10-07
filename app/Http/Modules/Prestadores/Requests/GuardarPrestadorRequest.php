<?php

namespace App\Http\Modules\Prestadores\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class GuardarPrestadorRequest extends FormRequest
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
            'nombre_prestador'      => "required|string|max:255|unique:prestadores,nombre_prestador",
            'municipio_id'          => "required|exists:municipios,id",
            'nit'                   => "required|string|max:255",
            'razon_social'          => "required|string|max:255",
            'naturaleza_juridica'   => "string|max:255",
            'clase_prestador'       => "string|max:255",
            'empresa_social'        => "string|max:255",
            'nivel'                 => "nullable|string|max:255",
            'caracter'              => "nullable|string|max:255",
            'direccion'             => "required|string|max:255",
            'correo1'               => "required|email|max:255",
            'correo2'               => "nullable|email|max:255",
            'telefono1'             => "required|string|max:255",
            'telefono2'             => "nullable|string|max:255",
            'codigo_habilitacion'   => "required|string|max:255|unique:prestadores,codigo_habilitacion",
            'tipo_prestador_id'     => "required|exists:tipo_prestadores,id"
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     */
    public function failedValidation(Validator $validator)
    {
        throw (new HttpResponseException(response()->json($validator->errors(), 422)));
    }
}
