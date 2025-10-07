<?php

namespace App\Http\Modules\Solicitudes\TipoSolicitud\Models;

use App\Http\Modules\Entidad\Models\Entidad;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoSolicitudRedVital extends Model
{
    use HasFactory;

    protected $fillable =['nombre','descripcion','opcion1','opcion2','activo'];

    public function entidades() {
        return $this->belongsToMany(Entidad::class, 'tipo_solicitud_entidads', 'tipo_solicitud_id', 'entidad_id');
    }
}
