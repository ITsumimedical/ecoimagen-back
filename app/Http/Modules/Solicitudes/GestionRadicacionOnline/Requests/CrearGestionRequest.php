<?php

namespace App\Http\Modules\Solicitudes\GestionRadicacionOnline\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearGestionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'tipo' => 'required',
            'motivo' => 'required_if:tipo,Devolver',
            'radicacion_online_id' =>'nullable',
            'usuario_id' => 'nullable',
            'delusuario_id' => 'required_if:radicacion_online_id,null',
            'alusuario_id' => 'nullable'

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
