<?php

namespace App\Http\Modules\GestionPqrsf\Formulario\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ActualizarFormulariopqrsfRequest extends FormRequest
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
        return [
            'quien_genera' => 'required',
            'documento_genera' => 'required_if:quien_genera,Otro',
            'nombre_genera' => 'required_if:quien_genera,Otro',
            'correo' => 'required',
            'telefono' => 'required',
            'descripcion' => 'required',
            'priorizacion' => 'nullable',
            'atributo_calidad' => 'nullable',
            'deber' => 'nullable',
            'derecho' => 'nullable',
            'reabierta' => 'nullable',
            'canal_id' => 'required',
            'tipo_solicitud_id' => 'required',
            'afiliado_id' => 'required',
            'usuario_registra_id' => 'required',
            'estado_id' => 'required',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 400));
    }
}
