<?php

namespace App\Http\Modules\Transcripciones\Transcripcion\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearTranscripcionRequest extends FormRequest
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
            'afiliado_id' => 'required',
            'ambito' => 'required',
            'medico_ordeno' => 'nullable',
            'finalidad' => 'required',
            'observaciones' => 'required',
            'tipo_transcripcion' => 'required',
            'prestador_id' => 'required_if:tipo_transcripcion,Externa',
            'nombre_medico_ordeno' => 'required_if:tipo_transcripcion,Externa',
            'documento_medico_ordeno' => 'required_if:tipo_transcripcion,Externa',
            'sede_id' => 'required_if:tipo_transcripcion,Interna',
            'c10' => 'required',
            'adjuntos' => 'nullable',
            'user_id' => 'nullable',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 400));
    }
}
