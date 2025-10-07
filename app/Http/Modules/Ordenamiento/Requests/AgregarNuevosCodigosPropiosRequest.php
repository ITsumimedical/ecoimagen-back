<?php

namespace App\Http\Modules\Ordenamiento\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AgregarNuevosCodigosPropiosRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'orden_id' => 'required|integer|exists:ordenes,id',
            'codigos_propios' => 'required|array|min:1',
            'codigos_propios.*.codigo_propio_id' => 'required|integer|exists:codigo_propios,id',
            'codigos_propios.*.cantidad' => 'required|integer|min:1',
            'codigos_propios.*.fecha_vigencia' => 'required|date',
            'codigos_propios.*.observacion' => 'required|string|min:10',
        ];
    }

    public function failedValidation(Validator $validator): void
    {
        throw (new HttpResponseException(response()->json($validator->errors(), 422)));
    }
}
