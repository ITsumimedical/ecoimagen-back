<?php

namespace App\Http\Modules\Codesumis\codesumis\Request;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class  CrearCodesumiRequest extends FormRequest
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
            'codigo' => 'string|required|unique:codesumis,codigo',
            'nombre' => 'string|required|unique:codesumis,nombre',
            'nivel_portabilidad' => 'integer|required',
            'frecuencia' => 'string|required',
            'cantidad_maxima_orden' => 'string|nullable',
            'concentracion_1' => 'string|nullable',
            'concentracion_2' => 'string|nullable',
            'concentracion_3' => 'string|nullable',
            'ambito' => 'string|required',
            'unidad_concentracion' => 'string|nullable',
            'cantiad_maxima_orden_dia' => 'string|nullable',
            'unidad_aux' => 'string|nullable',
            'grupo_terapeutico_id' => 'integer|required',
            'subgrupos_terapeuticos' => 'integer|required',
            'linea_base_id' => 'integer|required',
            'grupo_id' => 'integer|required',
            'estado_id' => 'integer|required',
            'programa_farmacia_id' => 'nullable',
            'concentracion_1' => 'nullable',
            'concentracion_2' => 'nullable',
            'concentracion_3' => 'nullable',
            'abc' => 'nullable',
            'estado_normativo' => 'nullable',
            'control_especial' => 'nullable',
            'critico' => 'nullable',
            'regulado' => 'nullable',
            'activo_horus'=> 'nullable',
	        'alto_costo'=> 'nullable',
            'via'=>'nullable',
            'medicamento_vital'=>'nullable|boolean',
            'unidad_medida_id' => 'nullable|integer|exists:unidades_medidas_medicamentos,id',
            'unidad_medida_dispensacion_id' => 'nullable|integer|exists:unidades_medidas_dispensacions,id',
            'ffm_id' => 'nullable|integer|exists:forma_farmaceutica_ffm,id',
            'observacion' => 'nullable'
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'estado_id' => 1,
        ]);
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 400));
    }
}
