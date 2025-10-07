<?php

namespace App\Http\Modules\Medicamentos\Models;


use Illuminate\Database\Eloquent\Model;
use App\Http\Modules\Grupos\Models\Grupo;
use App\Http\Modules\Estados\Models\Estado;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Modules\Codesumis\lineasBases\Model\lineasBases;
use App\Http\Modules\Ordenamiento\Models\PaqueteOrdenamiento;
use App\Http\Modules\PrincipiosActivos\Model\principioActivo;
use App\Http\Modules\ProgramasFarmacia\Models\ProgramasFarmacia;
use App\Http\Modules\Codesumis\viasAdministracion\Model\viasAdministracion;
use App\Http\Modules\Codesumis\gruposTerapeuticos\Models\gruposTerapeuticos;
use App\Http\Modules\EntidadesCodesumiParametrizacion\Model\CodesumiEntidad;
use App\Http\Modules\Codesumis\FormasFarmaceuticas\Models\formasFarmaceuticas;
use App\Http\Modules\Codesumis\subgruposTerapeuticos\Models\subgruposTerapeuticos;

class Codesumi extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'created_at',
        'deleted_at',
        'estado_id',
        'nivel_ordenamiento',
        'nivel_portabilidad',
        'nombre',
        'principio_activo',
        'requiere_autorizacion',
        'tipo_codesumi',
        'unidad_presentacion',
        'updated_at',
        'via',
        'frecuencia',
        'cantidad_maxima_orden',
        'ambito',
        'unidad_medida',
        'unidad_concentracion',
        'cantiad_maxima_orden_dia',
        'unidad_aux',
        'grupo_terapeutico_id',
        'subgrupos_terapeuticos',
        'forma_farmaceutica_id',
        'linea_base_id',
        'grupo_id',
        'concentracion_1',
        'concentracion_2',
        'concentracion_3',
        'abc',
        'estado_normativo',
        'control_especial',
        'critico',
        'regulado',
        'activo_horus',
        'alto_costo',
        'codigo_lasa',
        'medicamento_vital',
        'unidad_medida_id',
        'unidad_medida_dispensacion_id',
        'ffm_id',
        'observacion'
    ];

       /**
     * Get all of the comments for the Codesumi
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function medicamentos()
    {
        return $this->hasMany(Medicamento::class);
    }

    public function grupoTerapeutico()
    {
        return $this->belongsTo(gruposTerapeuticos::class, 'grupo_terapeutico_id');
    }

    public function subgrupoTerapeutico()
    {
        return $this->belongsTo(subgruposTerapeuticos::class, 'subgrupos_terapeuticos');
    }

    public function formaFarmaceutica()
    {
        return $this->belongsTo(formasFarmaceuticas::class, 'forma_farmaceutica_id');
    }

    public function lineaBase()
    {
        return $this->belongsTo(lineasBases::class, 'linea_base_id');
    }

    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'grupo_id');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id');
    }
    public function viasAdministracion()
    {
        return $this->belongsToMany(viasAdministracion::class, 'codesumi_vias_administracion', 'codesumi_id', 'vias_administracion_id')->withTimestamps();
    }

    public function scopeWhereCodigo($query, $data) {
        if($data){
            return $query->where('codigo',$data);
        }
    }

    public function scopeWhereProducto($query, $data) {
        if($data){
            return $query->where('nombre','ILIKE',"%{$data}%");
        }
    }

    public function scopeWhereNombreOrCodigo($query, $data) {
        if($data){
            return $query->where('nombre','ILIKE',"%{$data}%")->whereOr('codigo','ILIKE',"%{$data}%");
        }
    }

    public function programasFarmacia()
    {
        return $this->belongsToMany( ProgramasFarmacia::class)->withTimestamps();
    }

    public function principioActivos()
    {
        return $this->belongsToMany(principioActivo::class, 'codesumi_principio_activo')->withTimestamps();
    }

    public function codesumiEntidad()
    {
        return $this->hasMany(CodesumiEntidad::class);
    }

    public function paqueteOrdenamientos()
    {
        return $this->belongsToMany(PaqueteOrdenamiento::class, 'codesumi_paquete_ordenamiento');
    }

}
