<?php

namespace App\Http\Modules\EvolucionSignosSintomas\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AgregarEvolucionRequest extends FormRequest
{
	public function authorize(): bool
	{
		return true;
	}

	public function rules(): array
	{
		return [
			'consulta_id' => 'required|integer|exists:consultas,id',
			'creado_por' => 'required|integer|exists:users,id',
			'fecha_inicio' => 'required|date',
			'tiempo_inicio' => 'required|date_format:H:i',
			'signos_sintomas' => 'required|string',
			'estresores_importantes' => 'required|string',
			'estado_actual' => 'required|string',
			'profesional_consultado_antes' => 'required|string',
		];
	}

	public function failedValidation(Validator $validator)
	{
		throw (new HttpResponseException(response()->json($validator->errors(), 422)));
	}
}
