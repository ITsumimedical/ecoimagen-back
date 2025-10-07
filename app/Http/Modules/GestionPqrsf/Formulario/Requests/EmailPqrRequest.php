<?php

namespace App\Http\Modules\GestionPqrsf\Formulario\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class EmailPqrRequest extends FormRequest
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
            'event' => 'required|string',
            'email' => 'required|string',
            'id' => 'required|integer',
            'date' => 'required|string',
            'ts' => 'required|integer',
            'message-id' => 'required|string',
            'ts_event' => 'required|integer',
            'ts-epoch' => 'nullable|integer',
            'subject' => 'required|string',
            'X-Mailin-custom' => 'nullable|string',
            'sending_ip' => 'required|string',
            'template_id' => 'required|integer', 
            'tags' => 'nullable|array',
            'reason' => 'nullable|string'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 400));
    }
}
