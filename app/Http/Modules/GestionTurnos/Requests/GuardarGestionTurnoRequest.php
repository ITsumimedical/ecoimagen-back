<?php

namespace App\Http\Modules\GestionTurnos\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class GuardarGestionTurnoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'fecha_llamado' => 'nullable|date',
            'fecha_inicio_atencion' => 'nullable|date',
            'fecha_final_atencion' => 'nullable|date',
            'fecha_fin_llamado' => 'nullable|date',
            'descripcion' => 'required|string',
            'taquilla_id' => 'required',
            'turno_id' => 'required',
            'estado_id' => 'required',
            'triage_id' => 'required',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     */
    public function failedValidation(Validator $validator)
    {
        throw (new HttpResponseException(response()->json($validator->errors(), 422)));
    }
}
