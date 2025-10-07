<?php

namespace App\Http\Modules\Epidemiologia\Models;

use App\Http\Modules\Cie10\Models\Cie10;
use App\Http\Modules\Consultas\Models\Consulta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroSivigila extends Model
{
    use HasFactory;

    protected $fillable = [
        'evento_id',
        'consulta_id',
        'estado',
        'estado_id',
        'cie10_id',
    ];

    protected $attributes = [
        'estado_id' => 10,
    ];

    public function eventoSivigila(){
        return $this->belongsTo(EventoSivigila::class, 'evento_id');
    }

    public function consulta(){
        return $this->belongsTo(Consulta::class, 'consulta_id');
    }

    public function respuestaSivigila(){
        return $this->hasMany(RespuestaSivigila::class, 'registro_id');
    }

    public function cie10(){
        return $this->belongsTo(Cie10::class, 'cie10_id');
    }

    public function observacionRegistroSivigila(){
        return $this->hasMany(ObservacionRegistroSivigila::class, 'registro_id');
    }

    public function scopeWhereFichaId($query, $id){
        if($id){
            return $query->where('id', $id);
        }
    }

}
