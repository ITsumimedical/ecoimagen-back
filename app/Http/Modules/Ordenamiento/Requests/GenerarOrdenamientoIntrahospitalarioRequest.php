<?php

namespace App\Http\Modules\Ordenamiento\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class GenerarOrdenamientoIntrahospitalarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'afiliado_id' => 'required|integer|exists:afiliados,id',
            'consulta_id' => 'required|integer|exists:consultas,id',
            'articulos' => 'required|array',
            'articulos.*.articulo_id' => 'required|integer|exists:medicamentos,id',
            'articulos.*.codesumi_id' => 'required|integer|exists:codesumis,id',
            'articulos.*.via_administracion_id' => 'required|integer|exists:vias_administracion,id',
            'articulos.*.finalizacion' => 'required|string|in:DEFINIDO,DOSIS_UNICA',
            'articulos.*.dosis' => 'required|integer|min:1',
            'articulos.*.frecuencia' => 'nullable|integer',
            'articulos.*.unidad_tiempo' => 'nullable|string|in:SEGUNDOS,MINUTOS,HORAS',
            'articulos.*.horas_vigencia' => 'required|integer|min:24',
            'articulos.*.cantidad' => 'required|integer|min:1',
            'articulos.*.observacion' => 'required|string|min:10'
        ];
    }

    public function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
