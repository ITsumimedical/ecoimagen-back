<?php

namespace App\Http\Modules\Tarifas\Models;

use App\Http\Modules\CodigoPropios\Models\CodigoPropio;
use App\Http\Modules\Cups\Models\Cup;
use App\Http\Modules\Familias\Models\Familia;
use App\Http\Modules\ManualTarifario\Models\ManualTarifario;
use App\Http\Modules\Municipios\Models\Municipio;
use App\Http\Modules\PaqueteServicios\Models\PaqueteServicio;
use App\Http\Modules\Reps\Models\Rep;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarifa extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts =[
        'pleno' => 'boolean',
    ];

    public function cups(){
        return $this->belongsToMany(Cup::class, 'cup_tarifas');
    }

    public function rep(){
        return $this->belongsTo(Rep::class);
    }

    public function manualTarifario(){
        return $this->belongsTo(ManualTarifario::class);
    }

    public function familias(){
        return $this->belongsToMany(Familia::class,'familia_tarifas');
    }

    public function propio(){
        return $this->belongsToMany(CodigoPropio::class,'codigo_propio_tarifas')->withPivot('user_id');
    }

    public function paqueteServicio(){
        return $this->belongsToMany(PaqueteServicio::class,'paquete_tarifas')->withPivot('user_id');
    }

    public function municipioTarifas(){
        return $this->belongsToMany(Municipio::class,'municipio_tarifas')->withTimestamps();
    }

    /**
     * hace un filtrado de la informacion segun el manual tarifario que se envie
     */
    public function scopeWhereManualTarifario(Builder $query, array|int|null $manualTarifario = null)
    {
        if ($manualTarifario) {
            if (is_array($manualTarifario)){
                $query->whereIn('manual_tarifario_id', $manualTarifario);
            }
            else {
                $query->where('manual_tarifario_id', $manualTarifario);
            }
        }

    }


    /**
     * hace un filtrado de la informacion segun el manual tarifario que se envie
     */
    public function scopeWhereRep(Builder $query, array|int|null $rep = null)
    {
        if ($rep) {
            if (is_array($rep)){
                $query->whereIn('rep_id', $rep);
            }
            else {
                $query->where('rep_id', $rep);
            }
        }
    }

}
