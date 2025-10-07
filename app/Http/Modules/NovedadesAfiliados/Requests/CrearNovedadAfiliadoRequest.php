<?php

namespace App\Http\Modules\NovedadesAfiliados\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearNovedadAfiliadoRequest extends FormRequest{
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
            'fecha_novedad'     =>  'required',
            'motivo'            =>  'required|string',
            'tipo_novedad_id'   =>  'required|exists:tipo_novedad_afiliados,id',
            'afiliado_id'       =>  'required|exists:afiliados,id',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw (new HttpResponseException(response()->json($validator->errors(), 422)));
    }
}