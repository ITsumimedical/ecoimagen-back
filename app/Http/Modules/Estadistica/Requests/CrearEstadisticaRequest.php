<?php

namespace App\Http\Modules\Estadistica\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearEstadisticaRequest extends FormRequest
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
            'titulo'            => 'string|required',
            'inframe'           => 'string|required',
            'permission_id'     => 'integer|required',
            'estado_id'         => 'integer|required|exists:estados,id',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'estado_id' => $this->input('estado_id', 1),
        ]);
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
