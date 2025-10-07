<?php

namespace App\Http\Modules\Eventos\EventosAdversos\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CambiarEstadoEventoAdversoRequest extends FormRequest
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
            'evento_adverso_id' => 'required|integer|exists:evento_adversos,id',
            'estado_id' => 'required|integer|exists:estados,id',
        ];
    }
}
