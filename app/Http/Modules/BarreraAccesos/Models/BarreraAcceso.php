<?php

namespace App\Http\Modules\BarreraAccesos\Models;

use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Reps\Models\Rep;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarreraAcceso extends Model
{
    use HasFactory;

    protected $fillable = [
        'observacion',
        'observacion_cierre',
        'barrera',
        'activo',
        'afiliado_id',
        'rep_id',
        'usercrea_id',
        'usercierra_id',
        'estado_id',
        'tipo_barrera_acceso_id',
        'barrera_general',
        'prioridad',
        'observacion_solucion'
    ];

    protected $attributes = [
        'estado_id' => 10,
    ];

    /** Relaciones */
    public function userCrea()
    {
        return $this->belongsTo(User::class, 'usercrea_id');
    }

    public function userCierra()
    {
        return $this->belongsTo(User::class, 'usercierra_id');
    }

    public function afiliado()
    {
        return $this->belongsTo(Afiliado::class, 'afiliado_id');
    }

    public function rep()
    {
        return $this->belongsTo(Rep::class, 'rep_id');
    }

    public function tipoBarrera()
    {
        return $this->belongsTo(TipoBarreraAcceso::class, 'tipo_barrera_acceso_id');
    }

     public function adjuntos()
    {
        return $this->hasMany(AdjuntoBarreraAcceso::class, 'barrera_id');
    }

    public function responsables()
    {
        return $this->belongsToMany(
            ResponsableBarreraAcceso::class,
            'responsable_barrera_accesos_barrera_acceso', // Nombre de la tabla pivot
            'barrera_acceso_id', // Clave foránea para este modelo en la tabla pivot
            'responsable_barrera_accesos_id' // Clave foránea para el modelo relacionado en la tabla pivot
        );
    }

    public function scopeWhereBarreraAccesoId($query, $id)
    {
        if ($id) {
            return $query->where('id', $id);
        }
    }

    public function scopeWhereBarrera($query, $barrera)
    {
        if ($barrera) {
            return $query->where('barrera', $barrera);
        }
    }

    public function scopeWhereReps($query, $rep_id)
    {
        if ($rep_id) {
            return $query->where('rep_id', $rep_id);
        }
    }

    public function scopeWhereAfiliado($query, $afiliado_id)
    {
        if ($afiliado_id) {
            return $query->where('afiliado_id', $afiliado_id);
        }
    }

    public function scopeWhereNumeroDocumentoAfiliado($query, $documento) {
        if ($documento) {
            return $query->whereHas('afiliado', function ($q) use ($documento) {
                $q->where('numero_documento', $documento);
            });
        }
    }

    public function scopeWhereUserId($query, $user_id) {
        if ($user_id) {
            return $query->whereHas('userCrea', function ($q) use ($user_id) {
                $q->where('id', $user_id);
            });
        }
    }

    public function scopeWhereFechas($query, $fecha_inicio, $fecha_fin) {
        if($fecha_inicio && $fecha_fin) {
            return $query->whereBetween('created_at', [$fecha_inicio, $fecha_fin]);
        }

        if($fecha_inicio) {
            return $query->whereDate('created_at', $fecha_inicio);
        }

        if($fecha_fin) {
             return $query->whereDate('created_at', $fecha_fin);
        }

        return $query;
    }

    public function scopeWhereResponsablesBarrera($query, $id) {
        if ($id) {
            return $query->whereHas('responsables', function ($q) use ($id) {
                $q->where('responsable_barrera_accesos.id', $id);
            });
        }
    }

    public function scopeWhereUserAsignadoBarrera($query, $id) {
        if ($id) {
            return $query->whereHas('responsables', function ($q) use ($id) {
                $q->where('responsable_barrera_accesos.user_id', $id);
            });
        }
    }

}
