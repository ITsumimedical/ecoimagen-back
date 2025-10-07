<?php

namespace App\Http\Modules\FacturacionElectronica\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class EstructuraFacturaElectronicaRequest extends FormRequest
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
            'number' => ['required', 'integer', 'unique:documents,number'],
            'type_document_id' => ['required', 'integer'],
            'date' => ['required', 'date_format:Y-m-d'],
            'time' => ['required', 'date_format:H:i:s'],
            'resolution_number' => ['required', 'string', 'max:50'],
            'prefix' => ['required', 'string', 'max:10'],
            'notes' => ['nullable', 'string'],
            'disable_confirmation_text' => ['boolean'],
            'establishment_name' => ['required', 'string', 'max:255'],
            'establishment_address' => ['required', 'string', 'max:255'],
            'establishment_phone' => ['nullable', 'string', 'max:50'],
            'establishment_municipality' => ['required', 'integer'],
            'establishment_email' => ['nullable', 'email', 'max:255'],
            'sendmail' => ['boolean'],
            'sendmailtome' => ['boolean'],
            'send_customer_credentials' => ['boolean'],
            'seze' => ['nullable', 'string', 'max:20'],
            'email_cc_list' => ['nullable', 'array'],
            'email_cc_list.*.email' => ['sometimes', 'email'],
            'annexes' => ['nullable', 'array'],
            'annexes.*.document' => ['sometimes', 'string'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
