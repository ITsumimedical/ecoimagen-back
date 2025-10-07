<?php

namespace App\Http\Modules\PortabilidadSalida\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;


class ActualizarPortabilidadSalidaRequest extends FormRequest
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
            'departamento_receptor' => 'integer|exists:departamentos,id',
            'municipio_receptor' => 'integer|exists:municipios,id',
            'destino_ips' => 'string',
            'fecha_inicio' => 'date',
            'fecha_final' => 'date',
            'motivo' => 'string',
            'cantidad' => 'numeric|between:15,180',
            'afiliado_id' => 'integer|exists:afiliados,id'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw (new HttpResponseException(response()->json($validator->errors(), 422)));
    }
}
