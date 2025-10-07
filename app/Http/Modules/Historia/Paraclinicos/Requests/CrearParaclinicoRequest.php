<?php

namespace App\Http\Modules\Historia\Paraclinicos\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrearParaclinicoRequest extends FormRequest
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
            'resultadoCreatinina' => 'nullable',
            'ultimaCreatinina' => 'nullable',
            'resultaGlicosidada' => 'nullable',
            'fechaGlicosidada' => 'nullable',
            'resultadoAlbuminuria' => 'nullable',
            'fechaAlbuminuria' => 'nullable',
            'resultadoColesterol' => 'nullable',
            'fechaColesterol' => 'nullable',
            'resultadoHdl' => 'nullable',
            'fechaHdl' => 'nullable',
            'resultadoLdl' => 'nullable',
            'fechaLdl' => 'nullable',
            'resultadoTrigliceridos' => 'nullable',
            'fechaTrigliceridos' => 'nullable',
            'resultadoGlicemia' => 'nullable',
            'fechaGlicemia' => 'nullable',
            'resultadoPht' => 'nullable',
            'fechaPht' => 'nullable',
            'resultadoHemoglobina' => 'nullable',
            'albumina' => 'nullable',
            'fechaAlbumina' => 'nullable',
            'fosforo' => 'nullable',
            'fechaFosforo' => 'nullable',
            'resultadoEkg' => 'nullable',
            'fechaEkg' => 'nullable',
            'glomerular' => 'nullable',
            'fechaGlomerular' => 'nullable',
            'usuario_id' => 'nullable',
            'afiliado_id' => 'nullable',
            'consulta_id' => 'nullable',
            'nombreParaclinico' => 'nullable',
            'resultadoParaclinico' => 'nullable',
            'checkboxParaclinicos' => 'nullable',
            'fechaParaclinico' => 'nullable',
        ];
    }
}
