<?php

namespace App\Http\Modules\Ordenamiento\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AgregarNuevosServiciosRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'orden_id' => 'required|integer|exists:ordenes,id',
            'servicios' => 'required|array|min:1',
            'servicios.*.cup_id' => 'required|integer|exists:cups,id',
            'servicios.*.cantidad' => 'required|integer|min:1',
            'servicios.*.fecha_vigencia' => 'required|date',
            'servicios.*.observacion' => 'required|string|min:10',
        ];
    }

    public function failedValidation(Validator $validator): void
    {
        throw (new HttpResponseException(response()->json($validator->errors(), 422)));
    }
}
