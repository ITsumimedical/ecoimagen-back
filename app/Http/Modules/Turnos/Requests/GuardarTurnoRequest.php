<?php

namespace App\Http\Modules\Turnos\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class GuardarTurnoRequest extends FormRequest
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
            'numero_documento' => 'required|string',
            'tipo_turno_id' => 'required|exists:tipo_turnos,id',
            'area_clinica_id' => 'required|exists:areas_clinica,id',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     */
    public function failedValidation(Validator $validator)
    {
        throw (new HttpResponseException(response()->json($validator->errors(), 422)));
    }
}
