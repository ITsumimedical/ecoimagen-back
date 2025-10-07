<?php

namespace App\Http\Modules\ConductasInadaptativas\Request;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearConductaInadaptativaRequest extends FormRequest
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
            'come_unas' => 'required',
            'succiona_dedos' => 'required',
            'muerde_labio' => 'required',
            'sudan_manos' => 'required',
            'tiemblan_manos' => 'required',
            'agrege_sin_motivo' => 'required',
            'se_caen_cosas' => 'required',
            'trastornos_comportamiento' => 'required',
            'trastornos_emocionales' => 'required',
            'juega_solo' => 'required',
            'juegos_prefiere' => 'required',
            'prefiere_jugar_ninos' => 'required',
            'distracciones_hijos' => 'required',
            'conductas_juegos' => 'required',
            'inicio_escolaridad' => 'required',
            'cambio_colegio' => 'required',
            'dificultad_aprendizaje' => 'required',
            'repeticiones_escolares' => 'required',
            'conducta_clase' => 'required',
            'materias_mayor_nivel' => 'required',
            'materias_menor_nivel' => 'required',
            'consulta_id' => 'required|exists:consultas,id',
            'creado_por' => 'required|exists:users,id'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
