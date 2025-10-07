<?php

namespace App\Http\Modules\Historia\AntecedentesSexuales\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class AntecedentesSexualesRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            '*.tipo_antecedentes_sexuales' => 'required',
            '*.tipo_orientacion_sexual' => 'string|nullable',
            '*.tipo_identidad_genero' => 'string|nullable',
            '*.resultado' => 'string|nullable',
            '*.cuantos' => 'integer|nullable',
            '*.edad' => 'integer|nullable',
            '*.consulta_id' => 'exists:consultas,id'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
