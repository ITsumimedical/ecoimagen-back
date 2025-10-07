<?php

namespace App\Http\Modules\BarreraAccesos\Models;

use App\Http\Modules\Estados\Models\Estado;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponsableBarreraAcceso extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'correo',
        'estado_id',
        'user_id',
        'area_id',
    ];

    protected $attributes = [
        'estado_id' => 1
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function areaResponsable()
    {
        return $this->belongsTo(AreaResponsableBarreraAcceso::class, 'area_id');
    }

    public function estadoResponsable()
    {
        return $this->belongsTo(Estado::class, 'estado_id');
    }

    public function berrarasAccesos()
    {
        return $this->belongsToMany(
            BarreraAcceso::class,
            'responsable_barrera_accesos_barrera_acceso', // Nombre de la tabla pivot
            'responsable_barrera_accesos_id', // Clave foránea para este modelo en la tabla pivot
            'barrera_acceso_id' // Clave foránea para el modelo relacionado en la tabla pivot
        );
    }

    public function scopeWhereAreaResponsables($query, $id) {
        if ($id) {
            return $query->where('area_id', $id);
        }
    }

    public function scopeWhereResponsableNombre($query, $nombre) {
        if ($nombre) {
            return $query->where('nombre', 'ILIKE', '%'.$nombre.'%');
        }
    }

    public function scopeWhereBarreraId($query, $id) {
        if ($id) {
            return $query->whereHas('berrarasAccesos', function ($q) use ($id) {
                $q->where('barrera_accesos.id', $id);
            });
        }
    }
}
