<?php

namespace App\Http\Modules\Caracterizacion\Models;

use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Encuesta extends Model
{
    use HasFactory;

    protected $table = 'caracterizacion_encuestas';

    protected $fillable = [
        'afiliado_id',
        'departamento',
        'municipioResidencia',
        'barrioEncuestado',
        'direccionEncuestado',
        'numeroFamilia',
        'estratoVivienda',
        'numeroHogaresResiden',
        'numeroPersonasResiden',
        'numeroFamiliasQueResiden',
        'numeroEbs',
        'prestadorPrimario',
        'codigoFicha',
        'fechaDiligenciamiento',
        'nombreEncuestador',
        'cargoEncuestador',
        'tipoFamilia',
        'numeroPersonasConformanFamilia',
        'funcionalidadFamilia',
        'cuidadorNinos',
        'escalaZarit',
        'ecopama',
        'ninosFamilia',
        'embarazada',
        'adultosFamilia',
        'conflictoArmado',
        'discapacidad',
        'miembroEnfermo',
        'enfermedadCronica',
        'violencia',
        'vulnerabilidadFamilia',
        'cuidadoFamilia',
        'antecedentesMiembro',
        'cualesAntecedentesMiembro',
        'ttoAntecedentesMiembro',
        'obtieneAlimentos',
        'otroObtieneAlimentos',
        'habitos',
        'recursos',
        'cuidadoEntorno',
        'practicasSanas',
        'recursoSocial',
        'autonomiaAdultos',
        'prevencionEnfermedades',
        'cuidadoAncestral',
        'capacidadFamilia',
        'miembrosFamilia',
        'tipoVivienda',
        'otroTipoVivienda',
        'paredVivienda',
        'otroParedVivienda',
        'pisoVivienda',
        'otroPisoVivienda',
        'techoVivienda',
        'otroTechoVivienda',
        'numeroCuartos',
        'hacinamiento',
        'riesgosVivienda',
        'entornos',
        'combustible',
        'otroCombustible',
        'criaderos',
        'cualesCriaderos',
        'viviendaCondiciones',
        'otroViviendaCondiciones',
        'trabajoEnVivienda',
        'otroMascota',
        'agua',
        'otroAgua',
        'disponenExcretas',
        'otroDisponenExcretas',
        'aguasResiduales',
        'otroAguasResiduales',
        'basuras',
        'otroBasuras',
        'seleccionMascotas',
        'mascotas',
    ];
  
    public function afiliado(): BelongsTo
    {
        return $this->belongsTo(Afiliado::class, 'afiliado_id');
    }

    public function usuarios(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'encuesta_user', 'encuesta_id', 'user_id')
                    ->withTimestamps();
    }

}
