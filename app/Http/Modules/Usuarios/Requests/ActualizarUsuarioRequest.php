<?php

namespace App\Http\Modules\Usuarios\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ActualizarUsuarioRequest extends FormRequest
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
            'password'  => 'min:4',
            'email'   => 'email|unique:users,email,' . $this->id . ',id',
            'reps_id' => 'required|exists:reps,id',
            'nombre' => 'required',
            'apellido' => 'required',
            'tipo_doc' => 'required',
            'documento' => 'required',
            'firma' => 'nullable|file',
            'registro_medico' => 'nullable',
            'especialidad_id' => 'nullable',
            'cargo_id' => 'required',
            'email_recuperacion' => 'nullable',
            'telefono_recuperacion' => 'nullable'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
