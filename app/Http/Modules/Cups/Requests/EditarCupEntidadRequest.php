<?php

namespace App\Http\Modules\Cups\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class EditarCupEntidadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'diagnostico_requerido' => 'required|boolean',
            'nivel_ordenamiento' => 'required|integer|in:0,1,2,3,4',
            'nivel_portabilidad' => 'required|integer|in:0,1,2,3,4',
            'requiere_auditoria' => 'required|boolean',
            'periodicidad' => 'required|integer|min:0',
            'cantidad_max_ordenamiento' => 'required|integer|min:0',
            'copago' => 'required|boolean',
            'moderadora' => 'required|boolean',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw (new HttpResponseException(response()->json($validator->errors(), 422)));
    }
}
