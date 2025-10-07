<?php

namespace App\Http\Modules\Caracterizacion\Requests;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Foundation\Http\FormRequest;

class CrearEncuestaRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para hacer esta solicitud.
     */
    public function authorize(): bool
    {
        return true; // Cambia si hay reglas de permisos
    }

    /**
     * Obtiene las reglas de validación que se aplican a la solicitud.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [

            'afiliado_id' => 'required|integer|exists:afiliados,id',
            //stan1
            'departamento' => 'required|integer',
            'municipioResidencia' => 'required|integer',
            'barrioEncuestado' => 'required|string|max:255',
            'direccionEncuestado' => 'required|string|max:255',
            'numeroFamilia' => 'required|integer|min:1',
            'estratoVivienda' => 'nullable|integer',
            'numeroHogaresResiden' => 'nullable|integer|min:1',
            'numeroPersonasResiden' => 'nullable|integer|min:1',
            'numeroFamiliasQueResiden' => 'nullable|integer|min:1',
            'numeroEbs' => 'required|integer|max:3',
            'prestadorPrimario' => 'required|string|max:255',
            'codigoFicha' => 'required|integer',
            'fechaDiligenciamiento' => 'required|date',
            'nombreEncuestador' => 'required|string|max:255',
            'cargoEncuestador' => 'required|string|max:255',

            //stan2
            'tipoFamilia' => 'required|string',
            'numeroPersonasConformanFamilia' => 'nullable|integer|min:1',
            'funcionalidadFamilia' => 'required|string',
            'cuidadorNinos' => 'required|string',
            'escalaZarit' => 'nullable|string',
            'ecopama' => 'required|string',
            'ninosFamilia' => 'required|string',
            'embarazada' => 'required|string',
            'adultosFamilia' => 'required|string',
            'conflictoArmado' => 'required|string',
            'discapacidad' => 'required|string',
            'miembroEnfermo' => 'required|string',
            'enfermedadCronica' => 'required|string',
            'violencia' => 'required|string',
            'vulnerabilidadFamilia' => 'required|string',
            'cuidadoFamilia' => 'required|string',
            'antecedentesMiembro' => 'required|string',
            'cualesAntecedentesMiembro' => 'cualesAntecedentesMiembro|string',
            'ttoAntecedentesMiembro' => 'nullable|string',
            'obtieneAlimentos' => 'required|string',
            'otroObtieneAlimentos' => 'required|string',
            'habitos' => 'required|string',
            'recursos' => 'required|string',
            'cuidadoEntorno' => 'required|string',
            'practicasSanas' => 'required|string',
            'recursoSocial' => 'required|string',
            'autonomiaAdultos' => 'required|string',
            'prevencionEnfermedades' => 'required|string',
            'cuidadoAncestral' => 'required|string',
            'capacidadFamilia' => 'required|string',

            //stan 3
            'miembrosFamilia' => 'nullable',

            //stan4
            'tipoVivienda' => 'required|string',
            'otroTipoVivienda' => 'nullable|string',
            'paredVivienda' => 'nullable|string',
            'otroParedVivienda' => 'nullable|string',
            'pisoVivienda' => 'nullable|string',
            'otroPisoVivienda' => 'nullable|string',
            'techoVivienda' => 'nullable|string',
            'otroTechoVivienda' => 'nullable|string',
            'numeroCuartos' => 'nullable|integer|min:1',
            'hacinamiento' => 'nullable|string',
            'riesgosVivienda' => 'nullable',
            'entornos' => 'nullable',
            'combustible' => 'nullable|string',
            'otroCombustible' => 'nullable|string',
            'criaderos' => 'nullable|string',
            'cualesCriaderos' => 'nullable|string',
            'viviendaCondiciones' => 'nullable',
            'otroViviendaCondiciones' => 'nullable|string',
            'trabajoEnVivienda' => 'nullable|string',
            'otroMascota' => 'nullable|string',
            'agua' => 'nullable|string',
            'otroAgua' => 'nullable|string',
            'disponenExcretas' => 'nullable|string',
            'otroDisponenExcretas' => 'nullable|string',
            'aguasResiduales' => 'nullable|string',
            'otroAguasResiduales' => 'nullable|string',
            'basuras' => 'nullable|string',
            'otroBasuras' => 'nullable|string',
            'seleccionMascotas' => 'nullable',
            'mascotas' => 'nullable',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }

}
