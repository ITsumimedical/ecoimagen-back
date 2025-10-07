<?php

namespace App\Http\Modules\Cups\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ActualizarCupRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nombre' => 'required|string',
            'codigo' => 'required|string',
            'genero' => 'required|string',
            'edad_inicial' => 'required|string',
            'edad_final' => 'required|string',
            'archivo' => 'required|string',
            'quirurgico' => 'required|boolean',
            'diagnostico_requerido' => 'required|boolean',
            'nivel_ordenamiento' => 'required|integer',
            'nivel_portabilidad' => 'required|integer',
            'requiere_auditoria' => 'required|boolean',
            'periodicidad' => 'required|integer',
            'cantidad_max_ordenamiento' => 'required|integer',
            'ambito_id' => 'required|integer',
            'modalidad_grupo_tec_sal_id' => 'integer|exists:modalidad_grupo_tec_sals,id',
            'grupo_servicio_id' => 'integer|exists:grupo_servicios,id',
            'codigo_servicio_id' => 'integer|exists:codigo_servicios,id',
            'copago' => 'boolean',
            'moderadora' => 'boolean',

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
