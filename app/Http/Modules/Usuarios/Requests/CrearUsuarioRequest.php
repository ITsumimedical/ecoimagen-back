<?php

namespace App\Http\Modules\Usuarios\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class CrearUsuarioRequest extends FormRequest
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
            'email'     => 'required|email|unique:users',
            // 'password'  => 'required|min:4',
            'reps_id' => 'required|exists:reps,id',
            'nombre' => 'required',
            'apellido' => 'required',
            'tipo_doc' => 'required',
            'firma' => 'nullable|file',
            'documento' => 'required|unique:operadores',
            'registro_medico' => 'nullable',
            'especialidad_id' => 'nullable',
            'cargo_id' => 'required',
            'email_recuperacion' => 'nullable',
            'telefono_recuperacion' => 'nullable'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), Response::HTTP_BAD_REQUEST));
    }
}
