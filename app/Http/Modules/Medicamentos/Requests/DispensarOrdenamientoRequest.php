<?php

namespace App\Http\Modules\Medicamentos\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class DispensarOrdenamientoRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'orden_articulo_id' => 'required|exists:orden_articulos,id',
            'orden_id' => 'required|exists:ordenes,id',
            'bodega_id' => 'required|exists:bodegas,id',
            'lotes' => 'required|array',
            'lotes.*.id' => 'required|exists:lotes,id',
            'lotes.*.cantidad' => 'required|numeric|min:1',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
