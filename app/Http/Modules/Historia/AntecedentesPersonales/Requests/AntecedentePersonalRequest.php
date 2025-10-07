<?php

namespace App\Http\Modules\Historia\AntecedentesPersonales\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class AntecedentePersonalRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules()
    {
        return [
            'patologias' => 'required',
            'otras' => 'nullable',
            'tipo' => 'nullable',
            'fecha_diagnostico' => 'nullable|date',
            'cual' => 'nullable',
            'descripcion' => 'nullable',
            'consulta_id' => 'nullable',
            'demanda_inducida_id' => 'integer|nullable',
            'consulta_1_demanda'  => 'nullable',
            'consulta_2_demanda' => 'nullable',
            'consulta_3_demanda' => 'nullable',
            'afiliado_id' => 'nullable',
            'cie10_id' => 'nullable'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
