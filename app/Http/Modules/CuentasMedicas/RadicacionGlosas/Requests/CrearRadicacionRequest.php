<?php

namespace App\Http\Modules\CuentasMedicas\RadicacionGlosas\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearRadicacionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
          'codigo' => 'required',
          'respuesta_prestador' => 'required',
          'valor_aceptado' => 'required',
          'valor_no_aceptado' => 'required',
          'id' => 'numeric'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 400));
    }
}
