<?php

namespace App\Http\Modules\Concurrencia\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActualizarConcurrenciaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'alto_costo' => 'nullable',
            'costo_atencion' => 'nullable',
            'reporte_patologia_diagnostica' => 'nullable',
            'hospitalizacion_evitable' => 'nullable',
            'fecha_egreso' => 'nullable',
            'dx_concurrencia' => 'nullable',
            'dx_egreso' => 'nullable',
            'destino_egreso' => 'nullable',
            'ingreso_concurrencia_id' => 'nullable',
            'estado_id' => 'nullable',
        ];
    }
}
