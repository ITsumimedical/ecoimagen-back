<?php

namespace App\Http\Modules\Historia\Odontograma\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ActualizarParametrizacionOdontogramaRequest extends FormRequest
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
            'tipo' => 'nullable|string|max:255',
			'categoria' => 'nullable|string|max:255',
			'color' => 'required|string',
			'descripcion' => 'required|string',
			'identificador' => 'required|string',
			'caracter' => 'nullable|string',
			'estado' => 'boolean|required',
			'clasificacion_cop_ceo' => 'nullable|string',
			'informe_202' => 'nullable|string'
        ];
    }

	public function faileValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
