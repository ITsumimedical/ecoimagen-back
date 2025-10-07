<?php

namespace App\Http\Modules\BarreraAccesos\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ActualizarBarreraAccesoRequest extends FormRequest
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
            'tipo_barrera_acceso_id' => 'nullable|exists:tipo_barrera_accesos,id',
            'barrera' => 'nullable|string',
            'observacion' => 'nullable|string',
            'prioridad' => 'nullable|boolean',
            'estado_id' => 'nullable|exists:estados,id'
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
