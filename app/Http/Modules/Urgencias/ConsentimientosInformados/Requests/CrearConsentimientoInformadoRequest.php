<?php

namespace App\Http\Modules\Urgencias\ConsentimientosInformados\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearConsentimientoInformadoRequest extends FormRequest
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
            'tipo' =>  'nullable|string',
            'fecha' => 'required|date',
            'servicio' => 'required|string',
            'canalizacion' => 'nullable|string',
            'terapias' => 'nullable|string',
            'toma_muestras' => 'nullable|string',
            'aspiracion' => 'nullable|string',
            'administracion_medicamento' => 'nullable|string',
            'curaciones' => 'nullable|string',
            'sonda_oro' => 'nullable|string',
            'inmovilizacion' => 'nullable|string',
            'cateterismo' => 'nullable|string',
            'higiene_aseo' => 'nullable|string',
            'enemas' => 'nullable|string',
            'traslados' => 'nullable|string',
            'gases_arteriales' => 'nullable|string',
            'otro' => 'nullable|string',
            'confirmacion_documento' => 'nullable|string',
            'confirmacion_paciente' => 'nullable|string',
            'certifico' => 'nullable|string',
            'doctor' => 'nullable|string',
            'acuerdo' => 'nullable|string',
            'retiro' => 'nullable|string',
            'observacion' => 'nullable|string',
            'firma_paciente' => 'required|string',
            'created_by'=> 'required|integer',
            'admision_urgencia_id' => 'required|integer'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
