<?php

namespace App\Http\Modules\Certificados\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearCertificadoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'numero_documento' => 'required',
            'tipo_documento' => 'required',
            'primer_nombre' => 'required',
            'primer_apellido' => 'required',
            'segundo_nombre' => 'nullable',
            'segundo_apellido' => 'nullable',
            'estado' => 'required',
            'tipo_afiliado' => 'nullable',
            'ips' => 'nullable'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 400));
    }
}
