<?php

namespace App\Http\Modules\Historia\AntecedentesEcomapas\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class AntecedenteEcomapaRequest extends FormRequest
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
            'asiste_colegio' => 'nullable',
            'comparte_amigos' => 'nullable',
            'comparte_vecinos' => 'nullable',
            'pertenece_club_deportivo' => 'nullable',
            'pertenece_club_social_cultural' => 'nullable',
            'asiste_iglesia' => 'nullable',
            'trabaja' => 'nullable',
            'consulta_id' => 'nullable'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
