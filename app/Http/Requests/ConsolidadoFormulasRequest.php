<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Rap2hpoutre\FastExcel\FastExcel;

class ConsolidadoFormulasRequest extends FormRequest
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
            'fecha' => 'required|date_format:Y-m-d',
            'file' => 'required|file|mimes:xlsx,csv',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'status' => 'error',
            'message' => 'Error de validación',
            'errors' => $validator->errors()->all(),
        ], 422);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
