<?php

namespace App\Http\Modules\Urgencias\Oxigeno\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearOxigenoRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $user = $this->user();
        $this->merge([
            'created_by' => $user->id,
        ]);
    }

    public function rules(): array
    {
        return [
            'fecha' => 'required|date',
            'hora_inicio'=> 'required|string',
            'hora_final'=> 'required|string',
            'flujo'=> 'required|string',
            'flo2'=> 'nullable|string',
            'total_litros'=> 'required|string',
            'total_horas'=> 'required|string',
            'modo_administracion'=> 'required|string',
            'created_by'=> 'required|integer',
            'admision_urgencia_id' => 'required|integer'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
