<?php

namespace App\Http\Modules\Operadores\Models;

use App\Http\Modules\Cargos\Models\Cargo;
use App\Http\Modules\Especialidades\Models\Especialidade;
use App\Http\Modules\Prestadores\Models\Prestador;
use App\Http\Modules\Reps\Models\Rep;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Operadore extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'rep_id', 'nombre', 'apellido', 'tipo_doc', 'documento', 'prestador_id', 'especialidad_id', 'email_recuperacion', 'telefono_recuperacion', 'cargo_id', 'registro_medico'];
    protected $appends = ['nombre_completo', 'tipo_documento_documento'];

    public function prestador()
    {
        return $this->belongsTo(Prestador::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function cargo()
    {
        return $this->belongsTo(Cargo::class);
    }

    public function rep()
    {
        return $this->belongsTo(Rep::class, 'rep_id');
    }

    /**
     * getNombreCompletoAttribute
     * Concatena los campos de nombres y apellidos y asigna en nombre_completo
     *
     * @return void
     */
    public function getNombreCompletoAttribute()
    {
        return "{$this->nombre} {$this->apellido}";
    }


    /**
     * getCargoAttribute
     * Obtiene el nombre del cargo
     *
     * @return void
     */
    public function getCargoAttribute()
    {
        return $this->cargo()->first()?->nombre;
    }

    /**
     * getTipoDocumentoDocumentoAttribute
     * Concatena los campos de tipo_documento y docuemtno y asigna en tipo_documento_documento
     *
     * @return void
     */
    public function getTipoDocumentoDocumentoAttribute()
    {
        return "{$this->tipo_doc} - {$this->documento}";
    }

    /** Scopes */
    public function scopeWhereNombre($query, $nombre)
    {
        if ($nombre) {
            return
                $query->where('nombre', 'ILIKE', '%' . $nombre . '%')
                ->orWhere('apellido', 'ILIKE', '%' . $nombre . '%');
        }
    }

    public function especialidad()
    {
        return $this->belongsTo(Especialidade::class, 'especialidad_id');
    }
}
