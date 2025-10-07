<?php

namespace App\Http\Modules\Urgencias\SignosVitales\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class actualizarSignoVitalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'fecha' => 'nullable|date',
            'peso'  => 'nullable|string',
            'tension_arterial' => 'nullable|string',
            'frecuencia_respiratoria' => 'nullable|string',
            'frecuencia_cardiaca' => 'nullable|string',
            'temperatura' => 'nullable|string',
            'saturacion_oxigeno' => 'nullable|string',
            'glucometria' => 'nullable|string',
            'tam' => 'nullable|string',
            'created_by'=> 'nullable|integer',
            'admision_urgencia_id' => 'nullable|integer'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }

}
