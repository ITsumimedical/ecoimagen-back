<?php

namespace App\Http\Modules\Citas\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ActualizarCitaRequest extends FormRequest
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
            'nombre' => 'required',
            'especialidade_id' => 'required',
            'cantidad_paciente' => 'required',
            'tipo_cita_id' => 'required',
            'tipo_consulta_id' => 'required',
            'entidad_id' => 'required',
            'tiempo_consulta' => 'required',
            'sms' => 'required|boolean',
            'modalidad_id' => 'required|integer',
            'requiere_orden' => 'boolean',
            'exento' => 'boolean',
            'tipo_historia_id' => 'required',
            'primera_vez_cup_id' => 'required',
            'control_cup_id' => 'required',
            'whatsapp' => 'required|boolean',
        ];
    }

    public function faileValidation(Validator $validator)
    {
        throw (new HttpResponseException(response()->json($validator->errors(), 400)));
    }
}
