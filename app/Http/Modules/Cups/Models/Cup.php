<?php

namespace App\Http\Modules\Cups\Models;

use App\Http\Modules\Citas\Models\Cita;
use Illuminate\Database\Eloquent\Model;
use App\Http\Modules\Ambitos\Models\Ambito;
use App\Http\Modules\Tarifas\Models\Tarifa;
use App\Http\Modules\Tutelas\Models\Tutela;
use App\Http\Modules\Entidad\Models\Entidad;
use App\Http\Modules\Familias\Models\Familia;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Historia\Models\HistoriaClinica;
use App\Http\Modules\Especialidades\Models\Especialidade;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Http\Modules\Ordenamiento\Models\PaqueteOrdenamiento;
use App\Http\Modules\PaqueteServicios\Models\PaqueteServicio;
use App\Http\Modules\ActuacionTutelas\Models\actuacionTutelas;
use App\Http\Modules\ModalidadGrupoTecSal\Model\modalidadGrupoTecSal;
use App\Http\Modules\ConsentimientosInformados\Models\ConsentimientosInformado;

class Cup extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nombre',
        'codigo',
        'genero',
        'edad_inicial',
        'edad_final',
        'quirurgico',
        'diagnostico_requerido',
        'nivel_ordenamiento',
        'nivel_portabilidad',
        'requiere_auditoria',
        'periodicidad',
        'cantidad_max_ordenamiento',
        'ambito_id',
        'cup_id',
        'activo',
        'archivo',
        'valor',
        'modalidad_grupo_tec_sal_id',
        'grupo_servicio_id',
        'codigo_servicio_id',
        'copago',
        'moderadora',
        'requiere_firma'
    ];

    protected $appends = [
        'codigo_nombre'
    ];

    protected $casts = ['ambito_id' => 'integer'];

    protected $table = "cups";

    /** Relaciones */
    public function ambito()
    {
        return $this->belongsTo(Ambito::class);
    }

    public function paquete()
    {
        return $this->belongsToMany(PaqueteServicio::class, 'cup_paquete');
    }
    /** Scopes */

    /** Sets y Gets */

    /**
     * Concatena para codigo y nombre
     * @return string
     */
    public function getCodigoNombreAttribute()
    {
        return "{$this->codigo} - {$this->nombre}";
    }

    public function scopeWhereCodigo($query, $codigo)
    {
        if ($codigo) {
            return $query->where('codigo', $codigo);
        }
    }

    public function scopeWhereNombre($query, $nombre)
    {
        if ($nombre) {
            return $query->where('nombre', 'ILIKE', "%{$nombre}%");
        }
    }

    public function scopeWhereNivel($query, $nivel)
    {
        if ($nivel) {
            return $query->where('nivel_ordenamiento', $nivel);
        }
    }

    public function scopeWhereAmbito($query, $ambito)
    {
        if ($ambito) {
            return $query->where('ambito_id', $ambito);
        }
    }

    public function scopeWhereCodigoNombre($query, $cup)
    {
        if ($cup) {
            return $query->where('codigo', 'ILIKE', '%' . $cup . '%')->orWhere('nombre', 'ILIKE', '%' . $cup . '%');
        }
    }

    public function scopeWhereTodos($query, $todos)
    {
        if ($todos) {
            return $query->select('cups.*');
        }
    }


    public function citas()
    {
        return $this->belongsToMany(Cita::class);
    }

    public function familias()
    {
        return $this->belongsToMany(Familia::class, 'cup_familia', 'cup_id', 'familia_id');
    }

    public function actuacionTutela()
    {
        return $this->belongsToMany(actuacionTutelas::class)->withTimestamps();
    }

    public function consultas()
    {
        return $this->belongsToMany(Consulta::class, 'odontologia_procedimientos');
    }

    public function modalidadGrupo()
    {
        return $this->belongsTo(modalidadGrupoTecSal::class, 'modalidad_grupo_tec_sal_id');
    }

    public function entidades(): BelongsToMany
    {
        return $this->belongsToMany(Entidad::class, 'cup_entidad', 'cup_id', 'entidad_id')->withPivot('diagnostico_requerido', 'nivel_ordenamiento', 'nivel_portabilidad', 'requiere_auditoria', 'periodicidad', 'cantidad_max_ordenamiento', 'copago', 'moderadora');
    }

    public function consentimientosInformado()
    {
        return $this->hasMany(ConsentimientosInformado::class, 'cup_id');
    }

    public function consulta()
    {
        return $this->hasMany(Consulta::class);
    }

    public function especialidad()
    {
        return $this->hasOne(Especialidade::class);
    }

    public function tarifas(): BelongsToMany
    {
        return $this->belongsToMany(Tarifa::class, 'cup_tarifas', 'cup_id', 'tarifa_id');
    }

    public function cupEntidad()
    {
        return $this->hasMany(CupEntidad::class, 'cup_id');
    }

    public function consentimientoInformado(){
        return $this->hasOne(ConsentimientosInformado::class,'cup_id');
    }

    public function paqueteOrdenamientos()
    {
        return $this->belongsToMany(PaqueteOrdenamiento::class, 'cup_paquete_ordenamiento');
    }

}
