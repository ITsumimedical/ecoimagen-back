<?php

namespace App\Http\Modules\Prestadores\Models;

use App\Http\Modules\Contratos\Models\Contrato;
use App\Http\Modules\Municipios\Models\Municipio;
use Illuminate\Support\Facades\DB;
use App\Http\Modules\Reps\Models\Rep;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Modules\TipoPrestador\Models\TipoPrestador;
use Illuminate\Support\Facades\Cache;

class Prestador extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $table = 'prestadores';

    public function tipoPrestador()
    {
        return $this->belongsTo(TipoPrestador::class, 'tipo_prestador_id');
    }

    public function contratos()
    {
        return $this->belongsTo(Contrato::class, 'prestador_id');
    }

    public function municipio()
    {
        return $this->belongsTo(Municipio::class, 'municipio_id');
    }

    public function reps()
    {
        return $this->hasMany(Rep::class, 'prestador_id');
    }

    public function scopeWhereNombre($query, $nombre)
    {
        if ($nombre) {
            return $query->where('nombre_prestador', 'ILIKE', '%' . $nombre . '%');
        }
    }

    public function scopeWherePrestadorId($query, $prestador_id)
    {
        if ($prestador_id) {
            return $query->where('id', $prestador_id);
        }
    }

    public function scopeWhereNit($query, $nit)
    {
        if ($nit) {
            return $query->where('nit', 'ILIKE', '%' . $nit . '%');
        }
    }

    public function scopeWhereCodigoHabilitacion($query, $codigo_habilitacion)
    {
        if ($codigo_habilitacion) {
            return $query->where('codigo_habilitacion', $codigo_habilitacion);
        }
    }

    public function scopeWhereAcumuladoPrestador($query, $data)
    {
        $query->select('prestadores.id', 'prestadores.nombre_prestador', 'prestadores.nit')
            ->selectRaw("COUNT(afs.id) as totalFacturas")
            ->selectRaw("SUM(CAST(afs.valor_neto AS float)) as totalNeto")
            ->join('reps', 'reps.prestador_id', 'prestadores.id')
            ->join('paquete_rips', 'paquete_rips.rep_id', 'reps.id')
            ->join('afs', 'afs.paquete_rip_id', 'paquete_rips.id')
            ->where('paquete_rips.estado_id', 14)
            ->where('afs.created_at', '>=', $data->fecha_inicio . ' 00:00:00.000')
            ->where('afs.created_at', '<=', $data->fecha_final . ' 23:59:59.000')
            ->where('prestadores.id', $data->prestador_id)
            ->whereNotin("afs.id", function ($datos) {
                $datos->select('af_id')
                    ->from('asignado_cuentas_medicas');
            })
            ->groupBy('prestadores.id', 'prestadores.nombre_prestador', 'prestadores.nit');
        return $query;
    }

    public function scopeWhereMisAsignadas($query, $data, $data2)
    {
        $query->select('prestadores.id', 'prestadores.nombre_prestador', 'prestadores.nit', 'permissions.name as permisos')
            ->selectRaw("COUNT(afs.id) as totalFacturas")
            ->selectRaw("SUM(CAST(afs.valor_neto AS float)) as totalNeto")
            ->join('reps', 'reps.prestador_id', 'prestadores.id')
            ->join('paquete_rips', 'paquete_rips.rep_id', 'reps.id')
            ->join('afs', 'afs.paquete_rip_id', 'paquete_rips.id')
            ->join('asignado_cuentas_medicas', 'asignado_cuentas_medicas.af_id', 'afs.id')
            ->join('permissions', 'permissions.id', 'asignado_cuentas_medicas.permission_id')
            ->whereIn('asignado_cuentas_medicas.permission_id', $data)
            ->where('afs.estado_id', null)
            ->where('paquete_rips.estado_id', 14)
            ->groupBy('prestadores.id', 'prestadores.nombre_prestador', 'prestadores.nit', 'permissions.name');
        if ($data2['nombrePrestador']) {
            $query->where('prestadores.nombre_prestador', 'ILIKE', '%' . $data2['nombrePrestador'] . '%');
        }
        if ($data2['auditor']) {
            $query->where('permissions.name', 'ILIKE', '%' . $data2['auditor'] . '%');
        }
        if ($data2['nit']) {
            $query->where('prestadores.nit', 'ILIKE', '%' . $data2['nit'] . '%');
        }
        return $query;
    }

    public function scopeWhereAuditadas($query, $data)
    {
        $query->select('prestadores.id', 'prestadores.nombre_prestador', 'prestadores.nit', 'email_cuentas_medicas.email')
            ->selectRaw("COUNT(afs.id) as totalFacturas")
            ->selectRaw("SUM(CAST(afs.valor_neto AS float)) as totalNeto")
            ->join('reps', 'reps.prestador_id', 'prestadores.id')
            ->join('paquete_rips', 'paquete_rips.rep_id', 'reps.id')
            ->join('afs', 'afs.paquete_rip_id', 'paquete_rips.id')
            ->leftjoin('email_cuentas_medicas', 'prestadores.id', 'email_cuentas_medicas.prestador_id')
            ->where('afs.estado_id', 18)
            ->where('paquete_rips.estado_id', 14)
            ->groupBy('prestadores.id', 'prestadores.nombre_prestador', 'prestadores.nit', 'email_cuentas_medicas.email');
        if ($data['nombrePrestador']) {
            $query->where('prestadores.nombre_prestador', 'ILIKE', '%' . $data['nombrePrestador'] . '%');
        }
        if ($data['nit']) {
            $query->where('prestadores.nit', 'ILIKE', '%' . $data['nit'] . '%');
        }
        return $query;
    }

    public function scopeWhereAuditoriaFinal($query, $data)
    {
        $query->select('prestadores.id', 'prestadores.nombre_prestador', 'prestadores.nit')
            ->selectRaw("COUNT(afs.id) as totalFacturas")
            ->selectRaw("SUM(CAST(afs.valor_neto AS float)) as totalNeto")
            ->join('reps', 'reps.prestador_id', 'prestadores.id')
            ->join('paquete_rips', 'paquete_rips.rep_id', 'reps.id')
            ->join('afs', 'afs.paquete_rip_id', 'paquete_rips.id')
            ->where('afs.estado_id', 10)
            ->where('paquete_rips.estado_id', 14)
            ->groupBy('prestadores.id', 'prestadores.nombre_prestador', 'prestadores.nit');
        if ($data['nombre_prestador']) {
            $query->where('prestadores.nombre_prestador', 'ILIKE', '%' . $data['nombre_prestador'] . '%');
        }
        if ($data['nit']) {
            $query->where('prestadores.nit', 'ILIKE', '%' . $data['nit'] . '%');
        }
        return $query;
    }

    public function scopeWhereConciliadasAuditoriaFinal($query, $data)
    {
        $query->select(
            'prestadores.id',
            'prestadores.nombre_prestador',
            'prestadores.nit',
        )
            ->selectRaw("SUM(CAST(afs.valor_neto AS float)) as totalNeto")
            ->selectRaw("COUNT(afs.id) as totalFacturas")
            ->join('reps', 'reps.prestador_id', 'prestadores.id')
            ->join('paquete_rips', 'paquete_rips.rep_id', 'reps.id')
            ->join('afs', 'afs.paquete_rip_id', 'paquete_rips.id')
            ->where('afs.estado_id', 21)
            ->where('paquete_rips.estado_id', 14)
            ->groupBy('prestadores.id', 'prestadores.nombre_prestador', 'prestadores.nit');
        if ($data['nombre_prestador']) {
            $query->where('prestadores.nombre_prestador', 'ILIKE', '%' . $data['nombre_prestador'] . '%');
        }
        if ($data['nit']) {
            $query->where('prestadores.nit', 'ILIKE', '%' . $data['nit'] . '%');
        }
        return $query;
    }


    public function scopeWhereFiltro($query, $filtro)
    {
        if ($filtro) {
            return $query->where('prestadores.nombre_prestador', 'ILIKE', '%' . $filtro . '%')
                ->orWhere('prestadores.nit', 'ILIKE', '%' . $filtro . '%');
        }
    }

    public function scopeWhereConciliadasConSaldo($query, $data)
    {
        $query->select(
            'prestadores.id',
            'prestadores.nombre_prestador',
            'prestadores.nit',
        )
            ->selectRaw("SUM(CAST(afs.valor_neto AS float)) as totalNeto")
            ->selectRaw("COUNT(afs.id) as totalFacturas")
            ->join('reps', 'reps.prestador_id', 'prestadores.id')
            ->join('paquete_rips', 'paquete_rips.rep_id', 'reps.id')
            ->join('afs', 'afs.paquete_rip_id', 'paquete_rips.id')
            ->where('afs.estado_id', 23)
            ->where('paquete_rips.estado_id', 14)
            ->groupBy('prestadores.id', 'prestadores.nombre_prestador', 'prestadores.nit');
        if ($data['nombre_prestador']) {
            $query->where('prestadores.nombre_prestador', 'ILIKE', '%' . $data['nombre_prestador'] . '%');
        }
        if ($data['nit']) {
            $query->where('prestadores.nit', 'ILIKE', '%' . $data['nit'] . '%');
        }
        return $query;
    }


    public function scopeWhereAuditoriaFinalCerradas($query, $data)
    {
        $query->select(
            'prestadores.id',
            'prestadores.nombre_prestador',
            'prestadores.nit',
        )
            ->selectRaw("SUM(CAST(afs.valor_neto AS float)) as totalNeto")
            ->selectRaw("COUNT(afs.id) as totalFacturas")
            ->join('reps', 'reps.prestador_id', 'prestadores.id')
            ->join('paquete_rips', 'paquete_rips.rep_id', 'reps.id')
            ->join('afs', 'afs.paquete_rip_id', 'paquete_rips.id')
            ->where('afs.estado_id', 22)
            ->where('paquete_rips.estado_id', 14)
            ->groupBy('prestadores.id', 'prestadores.nombre_prestador', 'prestadores.nit');
        if ($data['nombre_prestador']) {
            $query->where('prestadores.nombre_prestador', 'ILIKE', '%' . $data['nombre_prestador'] . '%');
        }
        if ($data['nit']) {
            $query->where('prestadores.nit', 'ILIKE', '%' . $data['nit'] . '%');
        }
        return $query;
    }

    public function scopeWhereCodigoNombre($query, $prestador)
    {
        return $query->with('reps')
            ->whereHas('reps', function ($q) use ($prestador) {
                $q->where('nombre', 'ILIKE', '%' . $prestador . '%');
            })
            ->orWhere('nit', 'ILIKE', '%' . $prestador . '%');
    }

    public function scopeWhereNombreNit($query, $nombreNit)
    {
        if ($nombreNit) {
            return $query->where('nombre_prestador', 'ILIKE', '%' . $nombreNit . '%')
                ->orWhere('nit', 'ILIKE', '' . $nombreNit . '%');
        }
    }
}
