<?php

namespace App\Http\Modules\CuentasMedicas\AdjuntoRelacionPago\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AdjuntoRelacionPagoRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
          'prestador_id' => 'required',
          'fecha' => 'required',
          'page' => 'nullable',
          'cantidad'=> 'nullable'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 400));
    }

    public function attributes()
    {
        return [
            'prestador_id' => 'Nit-prestador'
        ];
    }
}
