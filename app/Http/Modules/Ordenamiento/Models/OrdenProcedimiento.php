<?php

namespace App\Http\Modules\Ordenamiento\Models;

use App\Http\Modules\Auditorias\Models\Auditoria;
use App\Http\Modules\Consultas\Models\ConsultaOrdenProcedimientos;
use App\Http\Modules\Contratos\Models\CobroServicio;
use App\Http\Modules\Cups\Models\Cup;
use App\Http\Modules\Reps\Models\Rep;
use Illuminate\Database\Eloquent\Model;
use App\Http\Modules\Estados\Models\Estado;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Modules\CambiosOrdenes\Models\CambiosOrdene;
use App\Http\Modules\Consultas\Models\Consulta;

class OrdenProcedimiento extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    /** Relaciones */
    public function orden()
    {
        return $this->belongsTo(Orden::class);
    }

    public function cup()
    {
        return $this->belongsTo(Cup::class);
    }

    public function rep()
    {
        return $this->belongsTo(Rep::class);
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }

    public function cambioOrden()
    {
        return $this->hasMany(CambiosOrdene::class);
    }
    public function auditoria()
    {
        return $this->hasMany(Auditoria::class, 'orden_procedimiento_id');
    }

    public function estadoGestionPrestador()
    {
        return $this->belongsTo(Estado::class, 'estado_id_gestion_prestador');
    }

    public function cobro()
    {
        return $this->hasOne(CobroServicio::class, 'orden_procedimiento_id');
    }

    public function dientesConsentimiento()
    {
        return $this->hasMany(DientesOrdenProcedimiento::class,'orden_procedimiento_id');
    }


    /** Scopes */

    public function scopeFiltrarCupsPrestador($query, $data, $existenParametrizados = false)
    {
        $query->whereYear('orden_procedimientos.fecha_vigencia', $data['anio'])
            ->whereMonth('orden_procedimientos.fecha_vigencia', $data['mes'])
            ->whereNotIn('orden_procedimientos.estado_id', [5, 3])
            ->where('orden_procedimientos.rep_id', $data['sede']['id'])
            ->when($data['estado'],fn($q, $estado) =>$q->where('estado_id_gestion_prestador', $estado))
            ->when($data['orden_id'],fn($q, $ordenId) =>$q->where('orden_id', $ordenId));
        if ($existenParametrizados) {
            $query->join('parametrizacion_cup_prestadores as p', 'p.cup_id', '=', 'orden_procedimientos.cup_id')
                ->where('p.rep_id', $data['sede']['id']);

            if ($data['servicioClinica']) {
                $query->where('p.categoria', $data['servicioClinica']);
            }
        }

        return $query;
    }


    /** Sets y Gets */

}
