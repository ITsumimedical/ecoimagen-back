<?php

namespace App\Http\Modules\Epidemiologia\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CabeceraSivigila extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_cabecera',
        'sub_titulo',
        'evento_id',
        'estado_id'
    ];

    protected $attributes = [
        'estado_id' => 1,
    ];

    public function eventoSivigila(){
        return $this->belongsTo(EventoSivigila::class, 'evento_id');
    }

    public function campoSivigila(){
        return $this->hasMany(CampoSivigila::class, 'cabecera_id');
    }

    public function scopeWhereNombreCabecera($query, $cabecera){
        if($cabecera){
            return $query->where('nombre_cabecera', 'ILIKE', '%' . $cabecera . '%');
        }
    }

    public function scopeWhereCabeceraId($query, $cabecera_id){
        if($cabecera_id){
            return $query->where('id', $cabecera_id);
        }
    }

    public function scopeWhereEventoCabecera($query, $evento) {
        if($evento) {
            $query->whereHas('eventoSivigila', function ($q) use ($evento) {
                $q->where('nombre_evento', $evento);
            });
        }
    }
}
