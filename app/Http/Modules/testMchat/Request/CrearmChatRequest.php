<?php

namespace App\Http\Modules\testMchat\Request;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearmChatRequest extends FormRequest
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
            'señala_mira' => 'required',
            'sordo' => 'required',
            'juegos_fantasia' => 'required',
            'se_sube_cosas' => 'required',
            'movimientos_inusuales_dedos' => 'required',
            'señala_cosas_fuera_alcance' => 'required',
            'muestra_llama_atencion' => 'required',
            'interesa_otros_niños' => 'required',
            'muestra_cosas_acercandolas' => 'required',
            'responde_llamado_nombre' => 'required',
            'sonrie_el_tambien' => 'required',
            'molestan_ruidos_cotidianos' => 'required',
            'camina_solo' => 'required',
            'mira_ojos_cuando_habla' => 'required',
            'imita_movimientos' => 'required',
            'gira_mirar_usted_mira' => 'required',
            'intenta_hagan_cumplidos' => 'required',
            'entiende_ordenes' => 'required',
            'mira__reacciones' => 'required',
            'gusta_juegos_movimientos' => 'required',
            'consulta_id' => 'required',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw (new HttpResponseException(response()->json($validator->errors(), 422)));
    }
}
