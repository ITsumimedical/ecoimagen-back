<?php

namespace App\Http\Modules\AntecedentesOdontologicos\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearantecedentesOdontologicosRequests extends FormRequest
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
            'consulta_id' => 'required|exists:consultas,id',
            'ultima_consulta_odontologo' => 'date|required',
            'descripcion_ultima_consulta' => 'string|required',
            'aplicacion_fluor_sellantes' => 'nullable',
            'descripcion_aplicacion_fl_sellante' => 'nullable',
            'exodoncias' => 'nullable',
            'descripcion_exodoncia' => 'nullable',
            'traumas' => 'nullable',
            'descripcion_trauma' => 'nullable',
            'aparatologia' => 'nullable',
            'descripcion_aparatologia' => 'nullable',
            'biopsias' => 'nullable',
            'descripcion_biopsia' => 'nullable',
            'cirugias_orales' => 'nullable',
            'descripcion_cirugia_oral' => 'nullable',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
