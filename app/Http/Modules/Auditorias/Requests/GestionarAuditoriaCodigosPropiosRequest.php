<?php

namespace App\Http\Modules\Auditorias\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class GestionarAuditoriaCodigosPropiosRequest extends FormRequest
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
			'orden_codigos_propios' => 'required|array',
			'orden_codigos_propios.*' => 'required|integer|exists:orden_codigo_propios,id',
            'pos_fechar' => 'required|boolean',
            'fecha_vigencia' => 'nullable|date'
		];
	}

	protected function failedValidation(Validator $validator)
	{
		throw new HttpResponseException(response()->json($validator->errors(), 422));
	}
}
