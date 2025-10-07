<?php

namespace App\Http\Modules\Prestadores\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class FiltroFacturasPrestadorRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'prestador_id' => 'required',
            'fecha_inicio' => 'required',
            'fecha_final' => 'required',
            'page' => 'nullable',
            'cantidad' => 'nullable'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw (new HttpResponseException(response()->json($validator->errors(), 422)));
    }

    public function attributes()
    {
        return [
            'prestador_id' => 'Nit prestador'
        ];
    }
}
