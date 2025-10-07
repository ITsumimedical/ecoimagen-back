<?php

namespace App\Http\Modules\TratamientoFarmacologico\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AgregarTratamientoFarmacologicoRequest extends FormRequest
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
			'dosis' => 'required|string',
			'horario' => 'required|string',
			'via_administracion_id' => 'required|integer|exists:vias_administracion,id',
			'descripcion_tratamiento' => 'nullable|string',
		];
	}

	public function failedValidation(Validator $validator)
	{
		throw (new HttpResponseException(response()->json($validator->errors(), 422)));
	}
}
