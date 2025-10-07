<?php

namespace App\Http\Modules\Epidemiologia\Models;

use App\Http\Modules\Cie10\Models\Cie10;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventoSivigila extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_evento',
        'rango_edad_inicio',
        'rango_edad_final',
        'gestante',
        'estado_id'
    ];

    protected $attributes = [
        'estado_id' => 1,
    ];

    public function cabeceraSivigila(){
        return $this->hasMany(CabeceraSivigila::class, 'evento_id');
    }

    public function resgistroSivigila(){
        return $this->hasOne(RegistroSivigila::class, 'evento_id');
    }

    public function cie10(){
        return $this->hasMany(Cie10::class, 'evento_id');
    }

    public function scopeWhereNombreEvento($query, $nombre){
        if($nombre){
            return $query->where('nombre_evento', $nombre);
        }
    }
}
