<?php

namespace App\Http\Modules\Incapacidades\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearIncapacidadRequest extends FormRequest
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
            'contingencia' => 'required',
            'diagnostico_id' => 'required',
            'fecha_inicio' => 'required',
            'dias' => 'required',
            'fecha_final' => 'required',
            'prorroga' => 'nullable',
            'consulta_id' => 'required',
            'colegio_id' => 'nullable',
            'descripcion_incapacidad' => 'required',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
