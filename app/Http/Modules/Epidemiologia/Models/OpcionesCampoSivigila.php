<?php

namespace App\Http\Modules\Epidemiologia\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OpcionesCampoSivigila extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_opcion',
        'campo_id',
        'estado_id'
    ];

    protected $attributes = [
        'estado_id' => 1,
    ];

    public function campoSivigila()
    {
        return $this->belongsTo(CampoSivigila::class, 'campo_id');
    }

    public function scopeWhereNombreOpcion($query, $nombre)
    {
        if ($nombre) {
            return $query->where('nombre_opcion', 'ILIKE', '%' . $nombre . '%');
        }
    }

    public function scopeWhereOpcionId($query, $id)
    {
        if ($id) {
            return $query->where('id', $id);
        }
    }

    public function scopeWhereCampoId($query, $campo_id)
    {
        if ($campo_id) {
            $query->whereHas('campoSivigila', function ($q) use ($campo_id) {
                $q->where('id', $campo_id);
            });
        }
    }

    public function scopeWhereCabeceraId($query, $cabecera_id)
    {
        if ($cabecera_id) {
            $query->whereHas('campoSivigila.cabeceraSivigila', function ($q) use ($cabecera_id) {
                $q->where('id', $cabecera_id);
            });
        }
    }

    public function scopeWhereEventoNombre($query, $evento)
    {
        if ($evento) {
            $query->whereHas('campoSivigila.cabeceraSivigila.eventoSivigila', function ($q) use ($evento) {
                $q->where('nombre_evento', $evento);
            });
        }
    }
}
