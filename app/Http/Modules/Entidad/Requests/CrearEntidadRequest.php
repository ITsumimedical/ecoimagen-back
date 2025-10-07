<?php

namespace App\Http\Modules\Entidad\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearEntidadRequest extends FormRequest
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
            'nombre' => 'required|string|unique:entidades,nombre',
            'generar_ordenes' => 'nullable|boolean',
            'consultar_historicos' => 'nullable|boolean',
            'autorizar_ordenes' => 'nullable|boolean',
            'atender_pacientes' => 'nullable|boolean',
            'entregar_medicamentos' => 'nullable|boolean',
            'agendar_pacientes' => 'nullable|boolean',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
