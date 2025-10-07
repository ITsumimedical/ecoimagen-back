<?php

namespace App\Http\Modules\Epidemiologia\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearCampoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre_campo' => 'required|string',
            'tipo_campo' => 'required|string',
            'cabecera_id' => 'required|exists:cabecera_sivigilas,id',
            'obligatorio' => 'required',
            'min' => 'nullable',
            'max' => 'nullable',
            'condicion' => 'nullable',
            'comparacion' => 'nullable',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw (new HttpResponseException(response()->json($validator->errors(), 422)));
    }
}
