<?php

namespace App\Http\Modules\Ordenamiento\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CambiarDireccionamientoCodigosPropiosRequest extends FormRequest
{
	public function authorize(): bool
	{
		return true;
	}

	public function rules(): array
	{
		return [
			'rep_id' => 'required|integer|exists:reps,id',
			'orden_codigos_propios' => 'required|array',
			'orden_codigos_propios.*' => 'required|integer|exists:orden_codigo_propios,id',
		];
	}

	public function failedValidation(Validator $validator): void
	{
		throw (new HttpResponseException(response()->json($validator->errors(), 422)));
	}
}
