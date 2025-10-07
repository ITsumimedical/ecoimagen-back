<?php

namespace App\Http\Modules\Auditorias\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class GestionarAuditoriaServiciosRequest extends FormRequest
{
	public function authorize(): bool
	{
		return true;
	}

	public function rules(): array
	{
		return [
			'estado' => 'required|integer|exists:estados,id',
			'observacion' => 'required|string|min:10',
			'orden_procedimientos' => 'required|array',
			'orden_procedimientos.*' => 'required|integer|exists:orden_procedimientos,id',
            'pos_fechar' => 'required|boolean',
            'fecha_vigencia' => 'nullable|date'
		];
	}

	protected function failedValidation(Validator $validator)
	{
		throw new HttpResponseException(response()->json($validator->errors(), 422));
	}
}
