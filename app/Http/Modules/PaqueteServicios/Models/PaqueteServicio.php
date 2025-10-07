<?php

namespace App\Http\Modules\PaqueteServicios\Models;

use App\Http\Modules\CodigoPropios\Models\CodigoPropio;
use App\Http\Modules\Cups\Models\Cup;
use App\Http\Modules\Medicamentos\Models\Cum;
use App\Http\Modules\Tarifas\Models\Tarifa;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaqueteServicio extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $table = 'paquete_servicios';

    public function cupsConteo(){
        return $this->belongsToMany(Cup::class, 'cup_paquete', 'paquete_id', 'cup_id');
    }

    public function cups(){
        return $this->belongsTo(Cup::class,'cup_id');
    }

    public function cup(){
        return $this->belongsToMany(Cup::class,'cup_paquete','paquete_id','cup_id');
    }
    public function propios(){
        return $this->belongsToMany(CodigoPropio::class, 'paquete_propio', 'paquete_id', 'propio_id');
    }

  

    public function tarifa(){
        return $this->belongsToMany(Tarifa::class,'paquete_tarifas')->withPivot('user_id','valor');
    }

    /** Funciones  */
    public function cambiarEstado(){
        return $this->update([
            'activo' => !$this->activo
        ]);
    }

    public function scopeWhereCodigo($query, $codigo){
        if($codigo){
            return $query->where('codigo',$codigo);
        }
    }

    public function scopeWhereNombre($query, $nombre){
        if($nombre){
            return $query->where('nombre','ILIKE',"%{$nombre}%");
        }
    }

    public function scopeWhereCup($query, $codigo_cup){
        if($codigo_cup){
            return $query->join('cups','cups.id','paquete_servicios.cup_id')
                        ->where('cups.codigo',$codigo_cup);
        }
    }

}
