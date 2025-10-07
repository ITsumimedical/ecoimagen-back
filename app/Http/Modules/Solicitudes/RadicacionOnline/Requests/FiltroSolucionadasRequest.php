<?php

namespace App\Http\Modules\Solicitudes\RadicacionOnline\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class FiltroSolucionadasRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
          'fechaDesde' => 'required',
          'fechaHasta' => 'required',
          'tipoSolicitud' => 'nullable',
          'departamento' => 'nullable',
          'municipio'=> 'nullable',
          'documento'=> 'nullable',
          'page'=> 'nullable',
          'cantidad' => 'nullable'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
