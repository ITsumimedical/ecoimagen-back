<?php

namespace App\Http\Modules\Medicamentos\Models;

use App\Http\Modules\ActuacionTutelas\Models\actuacionTutelas;
use App\Http\Modules\Bodegas\Models\Bodega;
use App\Http\Modules\EntidadesCodesumiParametrizacion\Model\CodesumiEntidad;
use App\Http\Modules\Tutelas\Models\Tutela;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'cum',
        'nivel_ordenamiento',
        'codigo_barras',
        'estado_id',
        'codesumi_id',
        'deleted_at',
        'created_at',
        'updated_at',
        'codigo_lasa',
        'regulado',
        'pbs',
        'alto_costo',
        'acuerdo_228',
        'clasificacion_riesgo',
        'oncologico',
        'origen',
        'refrigerado',
        'control_especial',
        'costoso',
        'comercial',
        'generico',
        'marca_dispositivo',
        'ium_primernivel',
        'ium_segundonivel',
        'pos',
        'precio_maximo',
        'activo_horus',
        'resolucion',
        'codigo_medicamento',
        'medicamento_vital',
        'critico',
        'abc'
    ];

    public function codesumi()
    {
        return $this->belongsTo(Codesumi::class);
    }

    public function invima()
    {
        return $this->hasOne(Cum::class, 'cum_validacion', 'cum');
    }

    public function BodegaMedicamentos()
    {
        return $this->hasMany(BodegaMedicamento::class);
    }

    public function scopeWhereBuscar($query, $columna, $dato)
    {
        if ($columna && $dato) {
            return $query->whereHas('invima', function ($q) use ($columna, $dato) {
                $q->where($columna, 'ILIKE', '%' . $dato . '%');
            });
        }
    }

    public function scopeWhereBodega($query, $bodega)
    {
        if ($bodega != 0) {
            return $query
                ->join('bodega_medicamentos as bm', 'medicamentos.id', 'bm.medicamento_id')
                //     // ->where('bm.cantidad_total','>',0)
                ->whereNotNull('medicamentos.cum')
                ->where('bm.bodega_id', $bodega)
                ->select('medicamentos.cum', 'medicamentos.codesumi_id', 'medicamentos.estado_id', 'medicamentos.nivel_ordenamiento', 'medicamentos.id as medicamento_id', 'medicamentos.id');
            // ->where('bm.estado',1);
        }
    }

    public function scopeWhereNombreCodigo($query, $data)
    {
        return $query->whereHas('codesumi', function ($q) use ($data) {
            $q->where('nombre', 'ILIKE', '%' . $data . '%');
            $q->orWhere('codigo', 'ILIKE', '%' . $data . '%');
        });
    }

    public function scopeWhereTodos($query, $data)
    {

        return $query->select('medicamentos.*')->whereHas('codesumi', function ($q) use ($data) {
            $q->where('nombre', 'ILIKE', '%' . $data . '%');
            $q->orWhere('codigo', 'ILIKE', '%' . $data . '%');
        });
    }

    public function bodegas()
    {
        return $this->belongsToMany(Bodega::class, 'bodega_medicamento', 'medicamento_id', 'bodega_id');
    }

    public function actuacionTutela()
    {
        return $this->belongsToMany(actuacionTutelas::class)->withTimestamps();
    }

    public function codesumiEntidad()
    {
        return $this->hasMany(CodesumiEntidad::class);
    }
}
