<?php

namespace App\Http\Modules\BarreraAccesos\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearBarreraAccesoRequest extends FormRequest
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
     * @return array
     */
    public function rules(): array
    {
        return [
            'observacion' => 'required|string',
            'barrera' => 'required|string',
            'tipo_barrera_acceso_id' => 'required|exists:tipo_barrera_accesos,id',
            'afiliado_id' => 'nullable|exists:afiliados,id',
            'rep_id' =>  'nullable|exists:reps,id',
            'barrera_general' => 'nullable|boolean',
            'usercrea_id' => 'required|exists:users,id',
            'adjuntos' => 'nullable|array',
        ];
    }

     public function prepareForValidation()
    {
        $this->merge([
            'usercrea_id' => auth()->id()
        ]);
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
