<?php

namespace App\Http\Modules\Homologo\Models;

use App\Http\Modules\ManualTarifario\Models\ManualTarifario;
use Illuminate\Database\Eloquent\Model;

class Homologo extends Model
{

    protected $fillable = [
        'tipo_manual_id',
        'cup_codigo',
        'descripcion',
        'uvr',
        'valor_uvr',
        'grupo_cx',
        'valor_grupo_cx',
        'puntaje_grupo_uvt',
        'valor_uvt',
        'valor',
        'estado',
        'anio'
    ];
    protected $table = 'homologos';
    protected $appends = [
        'valorPesos', 'valorPesosGrupo', 'valorPesosUVT', 'valorPesosUVR'
    ];

    /** Relaciones */
    public function tipoManual(){
        return $this->belongsTo(ManualTarifario::class,'tipo_manual_id');
    }

    /** Scopes */
    public function scopeWhereAnio($query, $anio){
        if($anio){
            return $query->where('anio', $anio);
        }
    }

    public function scopeWhereManual($query, $manual_id){
        if($manual_id){
            return $query->where('tipo_manual_id', $manual_id);
        }
    }

    public function scopeWhereCodigo($query, $codigo_cups){
        if($codigo_cups){
            return $query->where('cup_codigo', $codigo_cups);
        }
    }

    /** Sets y Gets */
    /**
     * Valor en pesos
     * @return string
     */
    public function getvalorPesosAttribute(){
        return number_format($this->valor);
    }

    public function getvalorPesosGrupoAttribute(){
        return number_format($this->valor_grupo_cx);
    }

    public function getvalorPesosUVTAttribute(){
        return number_format($this->valor_uvt);
    }

    public function getvalorPesosUVRAttribute(){
        return number_format($this->valor_uvr);
    }
}
