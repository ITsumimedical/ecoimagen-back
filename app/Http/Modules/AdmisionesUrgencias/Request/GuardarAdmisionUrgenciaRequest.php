<?php

namespace App\Http\Modules\AdmisionesUrgencias\Request;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class GuardarAdmisionUrgenciaRequest extends FormRequest
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
            'causa_muerte' => 'nullable|string',
            'causa_externa' => 'required|string',
            'estado_urgencia' => 'required|boolean',
            'estado_salida' => 'nullable|boolean',
            'estado_id' => 'required|exists:estados,id',
            'afiliado_id' => 'required|exists:afiliados,id',
            'fecha_salida' => 'nullable|date',
            'destino_usuario' => 'nullable|string',
            'nombre_acompanante' => 'nullable|string',
            'telefono_acompanante' => 'nullable|string',
            // 'sede_id' => 'required|exists:reps,id',
            'user_id' => 'required|exists:users,id',
            'contrato_id' => 'required|exists:contratos,id',
            'via_ingreso' => 'required|string',
            'observacion' => 'required|string',
            'direccion_acompanante' => 'nullable|string',
            'adjuntoDocumento' => 'nullable',
            'entidad_afiliado' => 'nullable',
            'especialidad'=>'required'
        ];
    }

    /**
     * Manejar errores de validación.
     */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors()
        ], 422));
    }

    public function attributes()
    {
        return [
            'contrato_id' => 'Contrato'
        ];
    }
}


