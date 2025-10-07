<?php

namespace App\Http\Modules\Cups\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearCupRequest extends FormRequest
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
            'nombre' => 'required|string',
            'codigo' => 'required|string',
            'genero' => 'required|string',
            'edad_inicial' => 'required|string',
            'edad_final' => 'required|string',
            'archivo' => 'required|string',
            'quirurgico' => 'required|boolean',
            'diagnostico_requerido' => 'required|boolean',
            'nivel_ordenamiento' => 'required|integer',
            'nivel_portabilidad' => 'required|integer',
            'requiere_auditoria' => 'required|boolean',
            'periodicidad' => 'required|integer',
            'cantidad_max_ordenamiento' => 'required|integer',
            'ambito_id' => 'required|integer',
            'copago' => 'boolean',
            'moderadora' => 'boolean',
        ];
    }


    public function failedValidation(Validator $validator)
    {
        throw (new HttpResponseException(response()->json($validator->errors(), 422)));
    }
}
