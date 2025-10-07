<?php

namespace App\Http\Modules\CuentasMedicas\RadicacionGlosasSumimedical\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ValidacionExcelRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
          'excel' => 'required',
          'adjunto' => 'file',
          'prestador_id' => 'required',
          'nit_prestador' => 'required',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 400));
    }
}
