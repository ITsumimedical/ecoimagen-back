<?php

namespace App\Http\Modules\Epicrisis\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class CrearEpicrisisRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $user = $this->user();
        $this->merge([
            'created_by' => $user->id
        ]);
    }

    public function rules(): array
    {
        return [
            'motivo_salida' => 'required|string',
            'estado_salida' => 'required|string',
            'fecha_deceso'  => 'nullable|date',
            'certificado_defuncion' => 'nullable|string',
            'causa_muerte' => 'nullable|string',
            'fecha_egreso' => 'required|date',
            'orden_alta' => 'required|string',
            'observacion' => 'required|string',
            'consulta_id' => 'required|integer',
            'cie10_id'=> 'required|integer' ,
            'admision_urgencia_id' => 'required|integer',
            'created_by' => 'required|integer',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw (new HttpResponseException(response()->json($validator->errors(), 422)));
    }
}
