<?php

namespace App\Http\Modules\Solicitudes\RadicacionOnline\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class FiltroRadicacionOnlineRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
          'estado' => 'required',
          'documento' => 'nullable',
          'desde' => 'nullable',
          'hasta' => 'nullable',
          'radicado' => 'nullable',
          'tipoSolicitud' => 'nullable',
          'page'=> 'nullable',
          'cantidad' => 'nullable',
          'departamento' =>'nullable',
          'municipio'=>'nullable',
          'ips'=>'nullable'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
