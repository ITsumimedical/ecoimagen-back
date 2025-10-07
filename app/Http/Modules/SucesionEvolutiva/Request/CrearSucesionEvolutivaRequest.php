<?php

namespace App\Http\Modules\SucesionEvolutiva\Request;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearSucesionEvolutivaRequest extends FormRequest
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
            'sucesion_evolutiva_conducta' => 'required',
            'sucesion_evolutiva_lenguaje' => 'required',
            'sucesion_evolutiva_area' => 'required',
            'sucesion_evolutiva_conducta_personal' => 'required',
            'consulta_id' => 'required|exists:consultas,id',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw (new HttpResponseException(response()->json($validator->errors(), 422)));
    }
}
