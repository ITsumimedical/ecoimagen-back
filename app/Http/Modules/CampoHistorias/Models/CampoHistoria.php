<?php

namespace App\Http\Modules\CampoHistorias\Models;

use App\Http\Modules\TipoCampo\Models\TipoCampo;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Modules\CategoriaHistorias\Models\CategoriaHistoria;

class CampoHistoria extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function scopeWhereBuscar($query, $filtro){
        if($filtro){
            return $query->select('campo_historias.id','categoria_historias.nombre as nombreCategoria','campo_historias.nombre','tipo_campos.nombre as nombreTipoCampo',
            DB::raw("case when campo_historias.requerido = 'true'  then 'Si' else 'No' end as campoRequerido"),'campo_historias.categoria_historia_id','campo_historias.tipo_campo_id',
            'campo_historias.requerido','campo_historias.ciclo_vida','campo_historias.orden','campo_historias.columnas')
            ->join('categoria_historias','categoria_historias.id','campo_historias.categoria_historia_id')
            ->join('tipo_campos','tipo_campos.id','campo_historias.tipo_campo_id')
            ->where('categoria_historia_id',$filtro);
        }
    }

    public function categoria(){
        return $this->belongsTo(CategoriaHistoria::class);
    }

    public function tipoCampoHistoria(){
        return $this->belongsTo(TipoCampo::class,'tipo_campo_id');
    }



}
