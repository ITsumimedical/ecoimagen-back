<?php

namespace App\Http\Modules\CuentasMedicas\Glosas\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearGlosaRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
          'valor' => 'required',
          'id' => 'nullable',
          'codigo' => 'nullable',
          'concepto' => 'nullable',
          'descripcion' => 'nullable',
          'af_id' => 'nullable'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 400));
    }

}
