<?php

namespace App\Http\Modules\Eventos\EventosAdversos\Requests;

use Illuminate\Foundation\Http\FormRequest;

class listarSeguimientoIAASRequest extends FormRequest
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
            'mes'  => ['required', 'integer', 'between:1,12'],
            'anio' => ['required', 'integer', 'digits:4', 'min:2000', 'max:' . date('Y')],
        ];
    }
}
