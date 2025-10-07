<?php

namespace App\Http\Modules\Direccionamientos\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ActualizarParametrosRequest extends FormRequest
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
     * @return array
     */
    public function rules(): array
    {
        return [
            'id'            => 'required|integer|exists:parametros_direccionamientos,id',
            'posicion'       => 'required|integer',
            'rep_id'         => 'required|integer|exists:reps,id',
            'direccionamiento_id' => 'required|integer|exists:direccionamientos,id',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw (new HttpResponseException(response()->json($validator->errors(), 422)));
    }
}
