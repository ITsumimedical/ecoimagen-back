<?php

namespace App\Http\Modules\ConsentimientosInformados\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ActualizarConsentimientoRequest extends FormRequest
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
     *
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nombre' => 'required',
            'descripcion' => 'required',
            'beneficios' => 'required',
            'riesgos' => 'required',
            'alternativas' => 'required',
            'riesgo_no_aceptar' => 'required',
            'informacion' => 'required',
            'recomendaciones' => 'required',
            'codigo' => 'required',
            'version' => 'required',
            'fecha_aprobacion' => 'required',
            'laboratorio' => 'required|boolean',
            'odontologia' => 'required|boolean',
            'estado'=> 'nullable'
        ];
    }

    public function faileValidation(Validator $validator)
    {
        throw (new HttpResponseException(response()->json($validator->errors(), 400)));
    }
}