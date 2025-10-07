<?php

namespace App\Http\Modules\Ordenamiento\Models;

use App\Http\Modules\Auditorias\Models\Auditoria;
use App\Http\Modules\CambiosOrdenes\Models\CambiosOrdene;
use App\Http\Modules\CodigoPropios\Models\CodigoPropio;
use App\Http\Modules\Contratos\Models\CobroServicio;
use App\Http\Modules\Estados\Models\Estado;
use App\Http\Modules\Ordenamiento\Models\Orden;
use App\Http\Modules\Reps\Models\Rep;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrdenCodigoPropio extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function orden()
    {
        return $this->belongsTo(Orden::class);
    }

    public function codigoPropio()
    {
        return $this->belongsTo(CodigoPropio::class);
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }

    public function rep()
    {
        return $this->belongsTo(Rep::class);
    }

    public function auditoria()
    {
        return $this->hasMany(Auditoria::class, 'orden_codigo_propio_id');
    }
    public function cambioOrden()
    {
        return $this->hasMany(CambiosOrdene::class);
    }

    public function cobro()
    {
        return $this->hasOne(CobroServicio::class,'orden_codigo_propio_id');
    }

    public function estadoGestionPrestador()
    {
        return $this->belongsTo(Estado::class, 'estado_id_gestion_prestador');
    }

     public function scopeFiltrarCupsPrestador($query, $data, $existenParametrizados = false)
    {
        $query->whereYear('orden_codigo_propios.fecha_vigencia', $data['anio'])
            ->whereMonth('orden_codigo_propios.fecha_vigencia', $data['mes'])
            ->whereNotIn('orden_codigo_propios.estado_id', [5, 3])
            ->where('orden_codigo_propios.rep_id', $data['sede']['id'])
            ->when($data['estado'],fn($q, $estado) =>$q->where('estado_id_gestion_prestador', $estado))
            ->when($data['orden_id'],fn($q, $ordenId) =>$q->where('orden_id', $ordenId));
        if ($existenParametrizados) {
            $query->join('parametrizacion_cup_prestadores as p', 'p.codigo_propio_id', '=', 'orden_codigo_propios.codigo_propio_id')
                ->where('p.rep_id', $data['sede']['id']);

            if ($data['servicioClinica']) {
                $query->where('p.categoria', $data['servicioClinica']);
            }
        }

        return $query;
    }
}
