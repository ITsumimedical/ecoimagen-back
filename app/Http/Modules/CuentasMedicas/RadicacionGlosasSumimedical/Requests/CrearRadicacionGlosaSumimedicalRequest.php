<?php

namespace App\Http\Modules\CuentasMedicas\RadicacionGlosasSumimedical\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearRadicacionGlosaSumimedicalRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
          'tipo' => 'required',
          'respuesta_sumimedical' => 'required',
          'valorAceptadoSumi' => 'required',
          'valorNoAceptadoSumi' => 'required',
          'id' => 'required'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 400));
    }
}
