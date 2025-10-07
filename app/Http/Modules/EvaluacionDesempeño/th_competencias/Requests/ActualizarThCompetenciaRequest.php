<?php

namespace App\Http\Modules\EvaluacionDesempeño\th_competencias\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ActualizarThCompetenciaRequest extends FormRequest{
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
            'competencia' =>  'required|string|unique:th_pilars,nombre,' . $this->id . ',id',
            'descripcion' => 'required|string',
            'th_pilar_id' => 'required|numeric',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw (new HttpResponseException(response()->json($validator->errors(), 422)));
    }
}
