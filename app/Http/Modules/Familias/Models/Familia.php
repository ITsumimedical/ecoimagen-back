<?php

namespace App\Http\Modules\Familias\Models;

use App\Http\Modules\Cups\Models\Cup;
use App\Http\Modules\Tarifas\Models\Tarifa;
use App\Http\Modules\TipoFamilia\Models\TipoFamilia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Familia extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
            'nombre',
            'descripcion',
            'user_id',
            'tipo_familia_id',
            'activo'
    ];
    protected $table = 'familias';

    protected $casts = [
        'created_at' => 'date:Y-m-d',
    ];

    public function scopeWhereBuscar($query, $buscar){
        if($buscar){
            return $query->where('nombre', 'ILIKE', '%' . $buscar . '%');
        }
    }

    public function scopeWhereTipoFamilia($query, $tipo_familia_id){
        if($tipo_familia_id){
            return $query->where('tipo_familia_id', $tipo_familia_id);
        }
    }

    /**
     * uno a muchos con tipo de familia
     */
    public function tipo_familia(){
        return $this->belongsTo(TipoFamilia::class,'tipo_familia_id');
    }

    public function tarifas(){
        return $this->belongsToMany(Tarifa::class,'familia_tarifas');
    }

    /**
     * Muchos a muchos con cups
     */
    public function cups(){
        return $this->belongsToMany(Cup::class, 'cup_familia');
    }

    public function scopeWhereCupFamilia($familia_id){
        if($familia_id){

        }

    }
}
