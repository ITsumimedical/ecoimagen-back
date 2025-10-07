<?php

namespace App\Http\Modules\Reps\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ActualizarRepsRequest extends FormRequest
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
            'direccion' => 'required|string',
            'tipo_zona' => 'required|string',
            'numero_sede' => 'required|string',
            'sede_principal' => 'required|boolean',
            'correo1' => 'required|email',
            'correo2' => 'nullable|email',
            'telefono1' => 'required|numeric',
            'telefono2' => 'nullable|numeric',
            'nivel_atencion' => 'required|integer',
            'codigo_habilitacion' => 'required|string',
            'prestador_id' => 'required|exists:prestadores,id',
            'municipio_id' => 'required|exists:municipios,id',
            'propia' => 'required|boolean',
            'ips_primaria' => 'nullable|boolean',
            // 'codigo' => 'required'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw (new HttpResponseException(response()->json($validator->errors(), 422)));
    }
}
