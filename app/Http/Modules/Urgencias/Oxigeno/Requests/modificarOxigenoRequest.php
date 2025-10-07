<?php

namespace App\Http\Modules\Urgencias\Oxigeno\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class modificarOxigenoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'fecha' => 'nullable|date',
            'hora_inicio'=> 'nullable|string',
            'hora_final'=> 'nullable|string',
            'flujo'=> 'nullable|string',
            'flo2'=> 'nullable|string',
            'total_litros'=> 'nullable|string',
            'total_horas'=> 'nullable|string',
            'modo_administracion'=> 'nullable|string',
            'created_by'=> 'nullable|integer',
            'admision_urgencia_id' => 'nullable|integer'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
