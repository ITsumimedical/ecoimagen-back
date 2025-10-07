<?php

namespace App\Http\Modules\ComponentesHistoriaClinica\Request;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ActualizarComponenteHistoriaRequest extends FormRequest
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
            'nombre' => 'required|string',
            'ruta' => 'required|string',
            'modelo' => 'required|string',
            'ruta_pdf' => 'required|string',
            'escala' => 'required|boolean',
            'sexo' => 'required|string',
            'edad_inicial' => 'required|integer|min:0',
            'edad_final' => 'required|integer|min:0|gte:edad_inicial',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
