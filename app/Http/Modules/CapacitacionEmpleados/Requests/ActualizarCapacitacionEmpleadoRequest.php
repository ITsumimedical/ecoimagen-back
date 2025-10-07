<?php

namespace App\Http\Modules\CapacitacionEmpleados\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ActualizarCapacitacionEmpleadoRequest extends FormRequest
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
            'municipio_id' => 'required|exists:municipios,id',
            'hora_inicio' => 'required|string',
            'hora_fin' => 'required|string',
            'lugar_realizacion' => 'required|string',
            'tema' => 'required|string',
            'metodologia' => 'required|string',
            'objetivo' => 'required|string',
            'contenido' => 'required|string',
            'capacitador' => 'required|string',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
