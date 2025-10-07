<?php

namespace App\Http\Modules\Turnos\Models;

use App\Http\Modules\AreaClinica\Models\AreaClinica;
use App\Http\Modules\Estados\Models\Estado;
use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Taquillas\Models\Taquilla;
use App\Http\Modules\TipoTurnos\Models\TipoTurno;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Turno extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    protected $casts = [
        'created_at' => 'date:Y-m-d h:i',
    ];

    protected $appends = ['nombre_completo'];

    /** Relaciones */
    public function tipoTurno(){
        return $this->belongsTo(TipoTurno::class, 'tipo_turno_id');
    }

    public function estado(){
        return $this->belongsTo(Estado::class, 'estado_id');
    }

    public function area(){
        return $this->belongsTo(AreaClinica::class, 'area_clinica_id');
    }

    public function taquilla(){
        return $this->belongsTo(Taquilla::class, 'taquilla_id');
    }


    /** Scopes */
    public function scopeWhereTipo($query, $tipo_turno_id){
        if($tipo_turno_id){
            return $query->where('tipo_turno_id', $tipo_turno_id);
        }
    }

    public function scopeWhereArea($query, $area_id){
        if($area_id){
            return $query->where('area_clinica_id', $area_id);
        }
    }

    public function scopeWhereEstado($query, $estado_id){
        if($estado_id){
            $estado = explode(',', $estado_id);
            return $query->whereIn('estado_id', $estado);
        }
    }


/** Sets y Gets */
    /**
     * Concatena para crear el nombre completo
     * @return string
     */
    public function getNombreCompletoAttribute(){
        $afiliado = Afiliado::where('numero_documento',$this->numero_documento)->first();
        if($afiliado){
            return "{$afiliado->primer_nombre} {$afiliado->segundo_nombre} {$afiliado->primer_apellido} {$afiliado->segundo_apellido}";
        }
        return null;

    }
}
