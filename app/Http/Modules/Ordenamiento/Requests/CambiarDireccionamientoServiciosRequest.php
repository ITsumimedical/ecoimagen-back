<?php

namespace App\Http\Modules\Ordenamiento\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CambiarDireccionamientoServiciosRequest extends FormRequest
{
	public function authorize(): bool
	{
		return true;
	}

	public function rules(): array
	{
		return [
			'rep_id' => 'required|integer|exists:reps,id',
			'orden_procedimientos' => 'required|array',
			'orden_procedimientos.*' => 'required|integer|exists:orden_procedimientos,id',
		];
	}

	public function failedValidation(Validator $validator): void
	{
		throw (new HttpResponseException(response()->json($validator->errors(), 422)));
	}
}
