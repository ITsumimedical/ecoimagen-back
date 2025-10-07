<?php

namespace App\Http\Modules\EvaluacionDesempeño\th_pilares\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateThPilarRequest extends FormRequest
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
        'nombre'                    =>  'required|string',
            'porcentaje'            =>  'required|numeric',
            'orden'                 =>  'required|numeric',
            'esta_activo'           =>  'boolean',
            'th_tipo_plantilla_id'  =>  'required|numeric',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
