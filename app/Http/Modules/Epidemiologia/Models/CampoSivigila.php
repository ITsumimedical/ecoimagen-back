<?php

namespace App\Http\Modules\Epidemiologia\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CampoSivigila extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_campo',
        'tipo_campo',
        'cabecera_id',
        'obligatorio',
        'max',
        'min',
        'condicion',
        'comparacion',
        'estado_id'
    ];

    protected $attributes = [
        'estado_id' => 1,
    ];

    public function cabeceraSivigila()
    {
        return $this->belongsTo(CabeceraSivigila::class, 'cabecera_id');
    }

    public function OpcionesCampoSivigila()
    {
        return $this->hasMany(OpcionesCampoSivigila::class, 'campo_id');
    }

    public function respuestaSivigila()
    {
        return $this->hasMany(RespuestaSivigila::class, 'campo_id');
    }

    public function campoSivigila()
    {
        return $this->belongsTo(CampoSivigila::class, 'comparacion');
    }

    public function scopeWhereTipoCampo($query, $tipo)
    {
        if ($tipo) {
            return $query->where('tipo_campo', $tipo);
        }
    }

    public function scopeWhereNombreCampo($query, $nombre)
    {
        if ($nombre) {
            return $query->where('nombre_campo', 'ILIKE', '%' . $nombre . '%');
        }
    }

    public function scopeWhereCampoId($query, $id)
    {
        if ($id) {
            return $query->where('id', $id);
        }
    }

    public function scopeWhereCabeceraId($query, $cabecera_id)
    {
        if ($cabecera_id) {
            return $query->whereHas('cabeceraSivigila', function ($q) use ($cabecera_id) {
                $q->where('id', $cabecera_id);
            });
        }
    }

    public function scopeWhereEventoNombre($query, $evento)
    {
        if ($evento) {
            $query->whereHas('cabeceraSivigila.eventoSivigila', function ($q) use ($evento) {
                $q->where('nombre_evento', $evento);
            });
        }
    }
}
