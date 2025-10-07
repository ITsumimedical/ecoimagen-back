<?php

namespace App\Http\Modules\BarreraAccesos\Models;

use App\Http\Modules\Estados\Models\Estado;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaResponsableBarreraAcceso extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'estado_id',
    ];

    protected $attributes = [
        'estado_id' => 1
    ];

    public function responsables()
    {
        return $this->hasMany(ResponsableBarreraAcceso::class, 'estado_id');
    }

    public function estadoAreaResponsable()
    {
        return $this->belongsTo(Estado::class, 'estado_id');
    }

    public function scopeWhereNombreArea($query, $nombre) {
        if ($nombre) {
            return $query->where('nombre', 'ILIKE', '%'.$nombre.'%');
        }
    }
}
