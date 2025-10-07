<?php

namespace App\Http\Modules\EvaluacionDesempeño\evaluaciones_desempeños\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class CreateEvaluacionesDesempenoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'fecha_inicial_periodo'         =>  'required|date',
            'fecha_final_periodo'         =>  'required|date',
            'th_tipo_plantilla_id' =>  'required|numeric',
            'empleado_id'     =>  'required|numeric',
            'esta_activo'     => 'boolean',
            'evaluador_id' => 'numeric'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
