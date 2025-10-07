<?php

namespace App\Http\Modules\TipoTurnos\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class GuardarTipoTurnoRequest extends FormRequest
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
            'nombre' => 'required|string|unique:tipo_turnos,nombre',
            'prefijo' => 'required|string',
            'color' => 'required|string',
            'imagen' => 'required|string',
            'prioridad' => 'required|string',
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
