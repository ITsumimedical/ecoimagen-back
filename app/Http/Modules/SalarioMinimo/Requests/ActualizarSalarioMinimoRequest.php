<?php

namespace App\Http\Modules\SalarioMinimo\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ActualizarSalarioMinimoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'anio' => 'required|integer',
            'valor' => 'required|string',
            'cuota_moderadora_a' => 'nullable|integer',
            'cuota_moderadora_b' => 'nullable|integer',
            'cuota_moderadora_c' => 'nullable|integer',
            'copago_a' => 'nullable|decimal:0,2',
            'copago_b' => 'nullable|decimal:0,2',
            'copago_c' => 'nullable|decimal:0,2',
            'copago_tope_evento_a' => 'nullable|integer',
            'copago_tope_evento_b' => 'nullable|integer',
            'copago_tope_evento_c' => 'nullable|integer',
            'copago_tope_anual_a' => 'nullable|integer',
            'copago_tope_anual_b' => 'nullable|integer',
            'copago_tope_anual_c' => 'nullable|integer',
            'copago_subsidiado' => 'nullable|decimal:2',
            'copago_subsidiado_tope_evento' => 'nullable|integer',
            'copago_subsidiado_tope_anual' => 'nullable|integer'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 400));
    }
}
