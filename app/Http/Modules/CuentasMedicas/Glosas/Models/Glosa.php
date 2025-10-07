<?php

namespace App\Http\Modules\CuentasMedicas\Glosas\Models;

use App\Http\Modules\CuentasMedicas\RadicacionGlosas\Models\RadicacionGlosa;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Glosa extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function radicacionGlosa()
    {
        return $this->hasOne(RadicacionGlosa::class);
    }

    public function scopeWhereGlosasPrestador($query,$af_id){
        $query->select('glosas.concepto','glosas.descripcion','glosas.codigo as codigoGlosa','glosas.valor',
        'glosas.id','radicacion_glosas.codigo','radicacion_glosas.respuesta_prestador','radicacion_glosas.estado',
        'radicacion_glosas.valor_aceptado','radicacion_glosas.valor_no_aceptado','radicacion_glosas.archivo')
        ->leftjoin('radicacion_glosas','glosas.id','radicacion_glosas.glosa_id')
        ->where('glosas.af_id',$af_id);

        return $query;
    }

    public function scopeWhereGlosasConciliacion($query,$af_id){
        $query->select('glosas.valor','glosas.id','rg.codigo','rg.respuesta_prestador',
        'rg.valor_aceptado as valorAceptadoPrestador','rg.valor_no_aceptado as valorNoAceptadoPrestador',
        'rg.estado','rg.archivo','rs.respuesta_sumimedical','rs.valor_aceptado as valorAceptadoSumi',
        'rs.valor_no_aceptado as valorNoAceptadoSumi','rs.estado_id')
        ->join('radicacion_glosas as rg','glosas.id','rg.glosa_id')
        ->join('radicacion_glosa_sumimedicals as rs','glosas.id','rs.glosa_id')
        ->where('glosas.af_id',$af_id)
        ->where('rs.estado_id',1);

        return $query;
    }

    public function scopeWhereGlosasCerradas($query,$af_id){
        $query->select('glosas.valor','glosas.id','rg.codigo','rg.respuesta_prestador',
        'rg.valor_aceptado as valorAceptadoPrestador','rg.valor_no_aceptado as valorNoAceptadoPrestador',
        'rg.estado','rg.archivo','rs.respuesta_sumimedical','rs.valor_aceptado as valorAceptadoSumi',
        'rs.valor_no_aceptado as valorNoAceptadoSumi','rs.estado_id')
        ->join('radicacion_glosas as rg','glosas.id','rg.glosa_id')
        ->join('radicacion_glosa_sumimedicals as rs','glosas.id','rs.glosa_id')
        ->where('glosas.af_id',$af_id)
        ->where('rs.estado_id',2);

        return $query;
    }

    public function scopeWhereGlosasAuditoriaFinal($query,$af_id){
        $query->select('glosas.valor','glosas.id','rg.codigo','rg.respuesta_prestador',
        'rg.valor_aceptado as valorAceptadoPrestador','rg.valor_no_aceptado as valorNoAceptadoPrestador',
        'rg.estado','rg.archivo','rs.respuesta_sumimedical','rs.valor_aceptado as valorAceptadoSumi',
        'rs.valor_no_aceptado as valorNoAceptadoSumi','rs.estado_id')
        ->join('radicacion_glosas as rg','glosas.id','rg.glosa_id')
        ->leftjoin('radicacion_glosa_sumimedicals as rs','glosas.id','rs.glosa_id')
        ->where('glosas.af_id',$af_id);

        return $query;
    }

    public function scopeWhereGlosasFacturasConciliadas($query,$af_id){
        $query->select('glosas.valor','glosas.id','rg.codigo','rg.respuesta_prestador',
        'rg.valor_aceptado as valorAceptadoPrestador','rg.valor_no_aceptado as valorNoAceptadoPrestador',
        'rg.estado','rg.archivo','rs.respuesta_sumimedical','rs.valor_aceptado as valorAceptadoSumi',
        'rs.valor_no_aceptado as valorNoAceptadoSumi','rs.estado_id')
        ->join('radicacion_glosas as rg','glosas.id','rg.glosa_id')
        ->join('radicacion_glosa_sumimedicals as rs','glosas.id','rs.glosa_id')
        ->where('glosas.af_id',$af_id)
        ->where('rs.estado_id', 1);
        return $query;
    }

    public function scopeWhereGlosasFacturasConciliadasConSaldo($query,$af_id){
        $query->select('glosas.valor','glosas.id','rg.codigo','rg.respuesta_prestador',
        'rg.valor_aceptado as valorAceptadoPrestador','rg.valor_no_aceptado as valorNoAceptadoPrestador',
        'rg.estado','rg.archivo','rs.respuesta_sumimedical','rs.valor_aceptado as valorAceptadoSumi',
        'rs.valor_no_aceptado as valorNoAceptadoSumi','rs.estado_id')
        ->join('radicacion_glosas as rg','glosas.id','rg.glosa_id')
        ->join('radicacion_glosa_sumimedicals as rs','glosas.id','rs.glosa_id')
        ->where('glosas.af_id',$af_id)
        ->where('rs.estado_id', 20);
        return $query;
    }


}




