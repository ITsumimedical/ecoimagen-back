<?php

namespace App\Http\Modules\Rips\Af\Models;

use App\Http\Modules\CuentasMedicas\AsignadoCuentasMedicas\Models\AsignadoCuentasMedica;
use App\Http\Modules\Rips\PaquetesRips\Models\PaqueteRip;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Af extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'date:Y-m-d',
        'valor_neto' => 'integer'
    ];

    protected $fillable = ['tipo_identificacion','numero_identificacion','numero_factura',
    'fechaexpedicion_factura','fecha_inicio','fecha_final','codigo_entidad','nombre_admin','numero_contrato','plan_beneficios',
    'numero_poliza','valor_copago','valor_comision','valor_descuento','valor_neto','servicio','codigo_prestador','nombre_prestador',
    'fecha_notificacion_prestador','fecha_conciliacion','paquete_rip_id','user_id','estado_id'];

    public function paqueteRip()
    {
        return $this->belongsTo(PaqueteRip::class);
    }

    public function asignados()
    {
        return $this->hasMany(AsignadoCuentasMedica::class);
    }

    public function scopeWhereAcumuladoPrestador($query,$data){
        $query->select(
            'afs.id',
            'afs.numero_factura',
            'afs.valor_neto',
            'afs.paquete_rip_id',
            'entidades.nombre as nombreEntidad',
             'asignado_cuentas_medicas.permission_id',
             'permissions.name as asignadoA')
        ->leftjoin('asignado_cuentas_medicas','asignado_cuentas_medicas.af_id','afs.id')
        ->leftjoin('permissions','permissions.id','asignado_cuentas_medicas.permission_id')
        ->leftjoin('us', 'us.paquete_rip_id','afs.paquete_rip_id')
        ->leftjoin('afiliados', 'afiliados.numero_documento','us.numero_documento')
        ->leftjoin('entidades', 'afiliados.entidad_id', 'entidades.id')
        ->with(['paqueteRip','paqueteRip.rep'])
        ->whereNull('afs.estado_id')
        ->whereHas('paqueteRip', function ($q){
            $q->where('estado_id',14);
        })
        ->whereHas('paqueteRip', function ($q) use ($data){
            $q->where('id',$data->paquete_id);
        });
        // ->where('afs.created_at','>=',$data->fecha_inicio .' 00:00:00.000')
        // ->where('afs.created_at','<=',$data->fecha_final .' 23:59:59.000');
        // if (($data->estado == true)) {
        //     $query->whereNotin("afs.id", function ($datos) {
        //         $datos->select('af_id')
        //             ->from('asignado_cuentas_medicas');
        //     });

        // } else {
        //     $query->wherein("afs.id", function ($datos) {
        //         $datos->select('af_id')
        //         ->whereNull('estado_id')
        //             ->from('asignado_cuentas_medicas');
        //     });
        // }



        if($data['numero_factura']){
            $query->where('afs.numero_factura',$data['numero_factura']);
        }

        return $query;
    }

    public function scopeWhereAsignarFactura($query,$permiso_id,$idPrestador){
        $query->select('afs.id','afs.numero_factura','afs.valor_neto','afs.created_at','afs.servicio', 'afs.paquete_rip_id')
        ->join('paquete_rips','paquete_rips.id','afs.paquete_rip_id')
        ->join('reps','reps.id','paquete_rips.rep_id')
        ->join('prestadores','prestadores.id','reps.prestador_id')
        ->join('asignado_cuentas_medicas','asignado_cuentas_medicas.af_id','afs.id') //cambiar a join
        ->whereIn('asignado_cuentas_medicas.permission_id',$permiso_id)
        ->where('prestadores.id',$idPrestador)
        ->where('afs.estado_id',null)
        ->where('paquete_rips.estado_id',14)
        ->groupBy('afs.id','afs.numero_factura','afs.valor_neto','afs.created_at','afs.servicio');

        return $query;
    }

    public function scopeWhereFacturas($query,$prestador_id){
        $query->select('afs.id','afs.numero_factura','afs.valor_neto','afs.created_at','afs.servicio','afs.paquete_rip_id')
        ->with(['paqueteRip','asignados','paqueteRip.rep'])
        ->where('afs.estado_id',18)
        ->whereHas('paqueteRip.rep', function ($q) use ($prestador_id){
            $q->where('prestador_id',$prestador_id);
        })
        ->whereHas('paqueteRip', function ($q){
            $q->where('estado_id',14);
        });


        return $query;
    }

    public function scopeWhereAfAuditadas($query,$prestador_id){
        $query->select('afs.id')
        ->with(['paqueteRip','asignados','paqueteRip.rep'])
        ->where('afs.estado_id',18)
        ->whereHas('paqueteRip.rep', function ($q) use ($prestador_id){
            $q->where('prestador_id',$prestador_id);
        })
        ->whereHas('paqueteRip', function ($q){
            $q->where('estado_id',14);
        })
        ->groupBy('afs.id');
        return $query;
    }

    public function scopewhereFacturasPrestador($query,$data){
        $query->select('afs.id','afs.numero_factura','afs.valor_neto','afs.created_at',
        'afs.servicio','prestadores.nit')
        ->join('paquete_rips','paquete_rips.id','afs.paquete_rip_id')
        ->join('reps','reps.id','paquete_rips.rep_id')
        ->join('prestadores','prestadores.id','reps.prestador_id')
        ->join('operadores','prestadores.id','operadores.prestador_id')
        ->where('operadores.user_id',Auth::user()->id)
        ->where('afs.estado_id',19)
        ->where('paquete_rips.estado_id',14)
        ->groupBy('afs.id','afs.numero_factura','afs.valor_neto','afs.created_at',
        'afs.servicio','prestadores.nit');

        if($data['numero_factura']){
            $query->where('afs.numero_factura',$data['numero_factura']);
        }
        if($data['nit']){
            $query->where('prestadores.nit','ILIKE', '%' . $data['nit'] . '%');
        }
        return $query;
    }

    public function scopewhereFacturasConciliacion($query,$data){
        $query->select('afs.id','afs.numero_factura','afs.valor_neto','afs.created_at',
        'afs.servicio','prestadores.nit')
        ->join('paquete_rips','paquete_rips.id','afs.paquete_rip_id')
        ->join('reps','reps.id','paquete_rips.rep_id')
        ->join('prestadores','prestadores.id','reps.prestador_id')
        ->join('operadores','prestadores.id','operadores.prestador_id')
        ->where('operadores.user_id',Auth::user()->id)
        ->where('afs.estado_id',21)
        ->where('paquete_rips.estado_id',14)
        ->groupBy('afs.id','afs.numero_factura','afs.valor_neto','afs.created_at',
        'afs.servicio','prestadores.nit');
        if($data['numero_factura']){
            $query->where('afs.numero_factura',$data['numero_factura']);
        }
        if($data['nit']){
            $query->where('prestadores.nit','ILIKE', '%' . $data['nit'] . '%');
        }
        return $query;
    }

    public function scopewhereFacturasCerrada($query,$data){
        $query->select('afs.id','afs.numero_factura','afs.valor_neto','afs.created_at',
        'afs.servicio','prestadores.nit')
        ->join('paquete_rips','paquete_rips.id','afs.paquete_rip_id')
        ->join('reps','reps.id','paquete_rips.rep_id')
        ->join('prestadores','prestadores.id','reps.prestador_id')
        ->join('operadores','prestadores.id','operadores.prestador_id')
        ->where('operadores.user_id',Auth::user()->id)
        ->where('afs.estado_id',22)
        ->where('paquete_rips.estado_id',14)
        ->groupBy('afs.id','afs.numero_factura','afs.valor_neto','afs.created_at',
        'afs.servicio','prestadores.nit');
        if($data['numero_factura']){
            $query->where('afs.numero_factura',$data['numero_factura']);
        }
        if($data['nit']){
            $query->where('prestadores.nit','ILIKE', '%' . $data['nit'] . '%');
        }
        return $query;
    }

    public function scopeWhereFacturasAuditoriaFinal($query,$data){
        $query->select('afs.id','afs.numero_factura','afs.valor_neto','afs.created_at','afs.servicio')
        ->join('paquete_rips','paquete_rips.id','afs.paquete_rip_id')
        ->join('reps','reps.id','paquete_rips.rep_id')
        ->join('prestadores','prestadores.id','reps.prestador_id')
        ->join('asignado_cuentas_medicas','asignado_cuentas_medicas.af_id','afs.id')
        ->where('prestadores.id',$data['id'])
        ->where('afs.estado_id',10)
        ->where('paquete_rips.estado_id',14)
        ->groupBy('afs.id','afs.numero_factura','afs.valor_neto','afs.created_at',
        'afs.servicio');
        if($data['numeroFactura']){
            $query->where('afs.numero_factura',$data['numeroFactura']);
        }
        return $query;
    }

    public function scopeWhereFacturasConciliadasAuditoriaFinal($query,$data){
        $query->select('afs.id','afs.numero_factura','afs.valor_neto','afs.created_at','afs.servicio')
        ->join('paquete_rips','paquete_rips.id','afs.paquete_rip_id')
        ->join('reps','reps.id','paquete_rips.rep_id')
        ->join('prestadores','prestadores.id','reps.prestador_id')
        ->join('asignado_cuentas_medicas','asignado_cuentas_medicas.af_id','afs.id')
        ->where('prestadores.id',$data['id'])
        ->where('afs.estado_id',21)
        ->where('paquete_rips.estado_id',14)
        ->groupBy('afs.id','afs.numero_factura','afs.valor_neto','afs.created_at',
        'afs.servicio');
        if($data['numeroFactura']){
            $query->where('afs.numero_factura',$data['numeroFactura']);
        }
        return $query;
    }

    public function scopeWhereFacturasConciliadasConSaldo($query,$data){
        $query->select('afs.id','afs.numero_factura','afs.valor_neto','afs.created_at','afs.servicio')
        ->join('paquete_rips','paquete_rips.id','afs.paquete_rip_id')
        ->join('reps','reps.id','paquete_rips.rep_id')
        ->join('prestadores','prestadores.id','reps.prestador_id')
        ->join('asignado_cuentas_medicas','asignado_cuentas_medicas.af_id','afs.id')
        ->where('prestadores.id',$data['id'])
        ->where('afs.estado_id',23)
        ->where('paquete_rips.estado_id',14)
        ->groupBy('afs.id','afs.numero_factura','afs.valor_neto','afs.created_at',
        'afs.servicio');
        if($data['numeroFactura']){
            $query->where('afs.numero_factura',$data['numeroFactura']);
        }
        return $query;
    }

    public function scopeWhereFacturasCerradaAuditoriaFinal($query,$data){
        $query->select('afs.id','afs.numero_factura','afs.valor_neto','afs.created_at','afs.servicio')
        ->join('paquete_rips','paquete_rips.id','afs.paquete_rip_id')
        ->join('reps','reps.id','paquete_rips.rep_id')
        ->join('prestadores','prestadores.id','reps.prestador_id')
        ->join('asignado_cuentas_medicas','asignado_cuentas_medicas.af_id','afs.id')
        ->where('prestadores.id',$data['id'])
        ->where('afs.estado_id',22)
        ->where('paquete_rips.estado_id',14)
        ->groupBy('afs.id','afs.numero_factura','afs.valor_neto','afs.created_at',
        'afs.servicio');
        if($data['numeroFactura']){
            $query->where('afs.numero_factura',$data['numeroFactura']);
        }
        return $query;
    }


}
