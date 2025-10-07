<?php

namespace App\Http\Modules\CuentasMedicas\CodigoGlosas\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearCodigoGlosasRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
         'codigo' => 'string|unique:codigo_glosas,codigo',
         'descripcion' => 'required|string',
         'tipo_cuenta_medica_id' => 'required'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 400));
    }
}
