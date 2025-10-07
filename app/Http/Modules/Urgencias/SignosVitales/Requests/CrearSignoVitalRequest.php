<?php

namespace App\Http\Modules\Urgencias\SignosVitales\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearSignoVitalRequest extends FormRequest
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
            'peso'  => 'required|string',
            'tension_arterial' => 'required|string',
            'frecuencia_respiratoria' => 'required|string',
            'frecuencia_cardiaca' => 'required|string',
            'temperatura' => 'required|string',
            'saturacion_oxigeno' => 'required|string',
            'glucometria' => 'nullable|string',
            'tam' => 'nullable|string',
            'created_by'=> 'required|integer',
            'admision_urgencia_id' => 'required|integer'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }

}
