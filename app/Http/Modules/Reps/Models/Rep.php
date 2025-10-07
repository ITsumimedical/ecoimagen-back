<?php

namespace App\Http\Modules\Reps\Models;

use function Laravel\Prompts\select;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use App\Http\Modules\Bodegas\Models\Bodega;
use App\Http\Modules\Tarifas\Models\Tarifa;
use App\Http\Modules\Entidad\Models\Entidad;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Modules\Municipios\Models\Municipio;
use App\Http\Modules\Operadores\Models\Operadore;
use App\Http\Modules\Prestadores\Models\Prestador;
use App\Http\Modules\Consultorios\Models\Consultorio;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Modules\Rips\PaquetesRips\Models\PaqueteRip;
use App\Http\Modules\ImagenesContratoSedes\Models\ImagenesContratoSedes;

class Rep extends Model
{
    use HasFactory;

    protected $table = 'reps';

    protected $casts = [
        'ips_id' => 'integer',
    ];

    protected static function booted()
    {
        // Cuando se guarda o actualiza un registro
        static::saved(function () {
            // Elimina el caché de 'reps' cuando se guarda o actualiza un registro
            Cache::forget('reps');
        });

        // Cuando se elimina un registro
        static::deleted(function () {
            // Elimina el caché de 'reps' cuando se elimina un registro
            Cache::forget('reps');
        });
    }

    protected $fillable = [
        'codigo_habilitacion',
        'numero_sede',
        'nombre',
        'tipo_zona',
        'nivel_atencion',
        'correo1',
        'correo2',
        'telefono1',
        'telefono2',
        'direccion',
        'propia',
        'codigo',
        'sede_principal',
        'prestador_id',
        'municipio_id',
        'activo',
        'ips_primaria',
        'proovedor',
        'entidad_id',
        'proovedor',
        'agendamiento_interno',
        'cirugia'
    ];

    protected $appends = [
        'codigo_habilitacion_completo',
    ];

    public function prestadores()
    {
        return $this->belongsTo(Prestador::class, 'prestador_id');
    }

    public function municipio()
    {
        return $this->belongsTo(Municipio::class, 'municipio_id');
    }

    public function consultorios()
    {
        return $this->hasMany(Consultorio::class);
    }

    public function tarifas()
    {
        return $this->hasMany(Tarifa::class);
    }

    public function paquete()
    {
        return $this->hasMany(PaqueteRip::class);
    }

    public function bodegas()
    {
        return $this->belongsToMany(Bodega::class, 'bodegas_reps', 'rep_id', 'bodega_id');
    }

    public function entidad()
    {
        return $this->belongsTo(Entidad::class);
    }

    public function quirofanos()
    {
        return $this->hasMany(Consultorio::class);
    }

    public function prestador()
    {
        return $this->belongsTo(Prestador::class);
    }

    /**
     * Concatena codigo de habilitacion
     * @return string
     */
    public function getCodigoHabilitacionCompletoAttribute()
    {
        return "{$this->codigo_habilitacion}-{$this->numero_sede}";
    }

    /** Scopes */
    public function scopeWhereNombre($query, $nombre)
    {
        if ($nombre) {
            return $query->whereHas('prestadores', function ($query) use ($nombre) {
                $query->where('nombre_prestador', 'ILIKE', '%' . $nombre . '%');
            });
        }
    }

    public function scopeWherePropias($query, $propios)
    {
        if ($propios) {
            return $query->where('propia', true);
        }
    }

    public function scopeWhereMunicipio($query, $municipio_id)
    {
        if ($municipio_id) {
            return $query->where('municipio_id', $municipio_id);
        }
    }

    public function scopeWherePrestador($query, $prestador_id)
    {
        if ($prestador_id) {
            return $query->where('prestador_id', $prestador_id);
        }
    }


    public function scopeWherePacientes($query, $pacientes)
    {
        if (intval($pacientes) >= 1) {
            if (intval($pacientes) == 1) {
                $query->whereHas('consultorios', function ($q) use ($pacientes) {
                    $q->where('cantidad_paciente', '=', $pacientes);
                });
            } elseif ($pacientes > 1) {
                $query->whereHas('consultorios', function ($q) use ($pacientes) {
                    $q->where('cantidad_paciente', '>=', $pacientes);
                });
            }
        }
    }

    public function scopeWhereNombreNit($query, $prestador)
    {
        if ($prestador) {
            return $query->whereHas('prestadores', function ($query) use ($prestador) {
                $query->where('nit', 'ILIKE', '%' . $prestador . '%');
            })
                ->orWhere('nombre', 'ILIKE', '%' . $prestador . '%');;
        }
    }

    public function scopeWhereOperador($query, $operador)
    {

        if ($operador) {
            $usuario = auth()->id();
            $operadores = Operadore::where('user_id', $usuario)->first();
            return $query->where('prestador_id', $operadores->prestador_id);
        }
    }

    public function scopeWhereCirugia($query, $cirugia)
    {

        if ($cirugia) {
            return $query->with('quirofanos', function ($q) use ($cirugia) {
                $q->where('quirofano', 1);
            })->where('cirugia', 1);
        }
    }

    public function scopeSinRelaciones($query, $relacion)
    {
        if ($relacion) {
            return $query->without('prestadores', 'municipio', 'consultorios');
        }
    }

    public function scopeWhereNombreNitProovedor($query, $prestador)
    {
        if ($prestador) {
            return $query->whereHas('prestadores', function ($query) use ($prestador) {
                $query->where('nit', 'ILIKE', '%' . $prestador . '%');
            })
                ->orWhere('nombre', 'ILIKE', '%' . $prestador . '%')
                ->where('proovedor', 1);
        }
    }
    public function imagenes()
    {
        return $this->hasOne(ImagenesContratoSedes::class, 'rep_id');
    }
}
