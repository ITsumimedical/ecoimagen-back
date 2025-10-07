<?php

namespace App\Http\Modules\Oncologia\TomaProcedimiento\Request;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TomaProcedimientoRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        if ($this->input('tipo_radicacion') == 'TOMA DE MUESTRA') {
            return [
                'cedula_paciente' => 'required',
                'tipo_radicacion' => 'required',
                'rep_id' => 'required',
                'correo' => 'required',
                'celular' => 'required',
                'direccion' => 'required',
                'telefono_fijo' => 'required',
                'fecha_procedimiento' => 'required',
                'organo_id' => 'required',
                'adjuntos' => 'nullable',
            ];
        }else if ($this->input('tipo_radicacion') == 'CARGA DE RESULTADOS') {
            return [
                'cedula_paciente' => 'required',
                'tipo_radicacion' => 'required',
                'rep_id' => 'required',
                'fecha_ingreso_muestra' => 'required',
                'fecha_salida_muestra' => 'required',
                'cie10_id' => 'required',
                'grado_infiltracion' => 'required',
                'grado_histologico' => 'required',
                'clasificacion_muestra' => 'required',
                'sistema' => 'required',
                'adjuntos' => 'nullable',
            ];
        }else{
            return [
                'observaciones' => 'nullable|string',
                'estado_id' => 'nullable|integer',
                'seguimiento' => 'nullable|string',
                'clasificacion_muestra' => 'nullable|string',
            ];
        }

    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
