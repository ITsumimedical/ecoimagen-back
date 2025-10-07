<?php

namespace App\Http\Modules\Evoluciones\Requests;

use Illuminate\Contracts\Validation\Validator;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ActualizarEvolucionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $user = $this->user();
        $this->merge([
            'updated_by' => $user->id
        ]);
    }

    public function rules(): array
    {
        return [
           'subjetivo' => 'required|string',
           'descripcion_fisica' => 'required|string',
           'paraclinicos' => 'required|string',
           'procedimiento' => 'required|string',
           'analisis' => 'required|string',
           'tratamiento' => 'required|string',
           'consulta_id' => 'required|integer',
           'admision_urgencia_id' => 'required|integer',
           'peso' => 'nullable|numeric',
           'tension_arterial' => 'nullable|numeric',
           'frecuencia_respiratoria' => 'nullable|numeric',
           'frecuencia_cardiaca' => 'nullable|numeric',
           'temperatura' => 'nullable|numeric',
           'presion_sistolica' => 'nullable|numeric',
           'presion_diastolica' => 'nullable|numeric',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw (new HttpResponseException(response()->json($validator->errors(), 422)));
    }
}