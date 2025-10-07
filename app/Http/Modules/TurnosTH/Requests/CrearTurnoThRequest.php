<?php

namespace App\Http\Modules\TurnosTH\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearTurnoThRequest extends FormRequest
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
            'codigo' => 'string|required|unique:turno_ths,codigo',
            'nombre' => 'string|required',
            'hora_desde' => 'string|required',
            'hora_hasta' => 'string|required',
            'total_horas' => 'string|required',
            'horas_diurnas' => 'string|required',
            'horas_nocturnas' => 'string|required',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
