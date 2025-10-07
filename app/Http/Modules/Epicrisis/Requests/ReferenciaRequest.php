<?php

namespace App\Http\Modules\Epicrisis\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class ReferenciaRequest extends FormRequest
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
            'objeto_remision' => 'required|string',
            'fecha_referencia' => 'required',
            'entidad_id' => 'required|integer',
            'servicio_remision' => 'required|string',
            'otro_servicio' => 'nullable|string',
            'epicrisis' => 'required|integer',
            'admision_urgencia_id' => 'required|integer',
            'updated_by' => 'required|integer',
            'peso' => 'nullable|string',
            'talla' => 'nullable|string',
            'tension_arterial' => 'nullable|string',
            'frecuencia_respiratoria' => 'nullable|string',
            'frecuencia_cardiaca' => 'nullable|string',
            'temperatura' => 'nullable|string',
            'aspecto_general' => 'nullable|string',
            'cabeza' => 'nullable|string',
            'abdomen' => 'nullable|string',
            'cuello' => 'nullable|string',
            'torax' => 'nullable|string',
            'snp' => 'nullable|string',
            'ojos' => 'nullable|string',
            'respiratorio' => 'nullable|string',
            'extremidad_superior' => 'nullable|string',
            'oidos' => 'nullable|string',
            'gastrointestinal' => 'nullable|string',
            'extremidad_inferior' => 'nullable|string',
            'boca_garganta' => 'nullable|string',
            'linfatico' => 'nullable|string',
            'funcion_cerebral' => 'nullable|string',
            'piel_mucosa' => 'nullable|string',
            'psicomotor' => 'nullable|string',
            'reflejos' => 'nullable|string',
            'urogenital' => 'nullable|string',
            'snc' => 'nullable|string',
            'evolucion_anterior' => 'nullable|string',
            'impresion_diagnostica' => 'nullable|string',
            'plan' => 'nullable|string',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw (new HttpResponseException(response()->json($validator->errors(), 422)));
    }
}
