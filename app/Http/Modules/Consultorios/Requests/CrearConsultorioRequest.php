<?php

namespace App\Http\Modules\Consultorios\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearConsultorioRequest extends FormRequest
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
            'cantidad_paciente' =>'required|numeric|min:1',
            'estado_id' => 'required',
            'rep_id' => 'required|exists:reps,id'
        ];
    }

    public function faileValidation(Validator $validator)
    {
        throw (new HttpResponseException(response()->json($validator->errors(), 400)));
    }
}
