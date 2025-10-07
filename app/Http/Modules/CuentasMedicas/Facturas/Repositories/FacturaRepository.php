<?php

namespace App\Http\Modules\CuentasMedicas\Facturas\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\CuentasMedicas\AsignadoCuentasMedicas\Models\AsignadoCuentasMedica;
use App\Http\Modules\Rips\Af\Models\Af;
use Illuminate\Support\Facades\Auth;

class FacturaRepository extends RepositoryBase {


    public function __construct(protected Af $af) {
        parent::__construct($this->af);
    }

    public function listarFactura($data){
     $lista = $this->af->whereAcumuladoPrestador($data);
    return $data['page'] ? $lista->paginate($data['cantidad']) : $lista->get();
    }

    public function contador(){
        $permisos = Auth::user()->permissions;
        $permiso_id = [];
        foreach ($permisos as $permiso){
            array_push($permiso_id,$permiso->id);
        }

        $asignadas= AsignadoCuentasMedica::join('afs','asignado_cuentas_medicas.af_id','afs.id')
        ->join('paquete_rips','paquete_rips.id','afs.paquete_rip_id')
        ->whereIn('asignado_cuentas_medicas.permission_id',$permiso_id)
        ->where('afs.estado_id',null)
        ->where('paquete_rips.estado_id',14)
        ->distinct('afs.id')
        ->count();

        $auditas= Af::where('estado_id',18)->count();

        $prestador = Af::join('paquete_rips','paquete_rips.id','afs.paquete_rip_id')
        ->join('reps','reps.id','paquete_rips.rep_id')
        ->join('prestadores','prestadores.id','reps.prestador_id')
        ->join('operadores','prestadores.id','operadores.prestador_id')
        ->where('operadores.user_id',Auth::user()->id)
        ->where('afs.estado_id',19)
        ->where('paquete_rips.estado_id',14)
        ->distinct()
        ->count();

        $auditoriaFinal = Af::where('estado_id',10)->count();

        return (Object)[
            'asignadas' => $asignadas,
            'auditas' =>$auditas,
            'prestador' => $prestador,
            'auditoriaFinal' => $auditoriaFinal

        ];
    }

    public function guardarServicio($data,$af_id){
        $codigo = $this->af::find($af_id);
        return $codigo->update([
            'servicio' => $data['servicio']
          ]);
    }

    public function guardarAuditoria($af_id){
        $auditoria = $this->af::find($af_id);
        return $auditoria->update([
            'estado_id' => 18
          ]);
    }

    public function facturas($data, $prestador_id){

        $auditadas = $this->af->whereFacturas($prestador_id);

        return $auditadas->get();
    }

    public function devolverAuditoria($af_id){
        $auditoria = $this->af::find($af_id);
        return $auditoria->update([
            'estado_id' => null
          ]);
    }

    public function afAuditadas($prestador_id){
        $auditadas = $this->af->whereAfAuditadas($prestador_id);

        return $auditadas->get();
    }

    public function facturaPrestador($data){

        $prestador = $this->af->whereFacturasPrestador($data);
        return $data->page ? $prestador->paginate($data->cantidad) : $prestador->get();
    }

    public function guardarAuditoriaPrestador($id_af)
     {
        $auditoria = $this->af::find($id_af);
        return $auditoria->update([
            'estado_id' => 10
          ]);
     }

     public function asignacionFactura($idPrestador){
        $permisos = Auth::user()->permissions;
        $permiso_id = [];
        foreach ($permisos as $permiso){
         array_push($permiso_id,$permiso->id);
        }

        return  $this->af->whereAsignarFactura($permiso_id, $idPrestador)->get();

    }

    public function facturaConciliacion($data){
        $prestador = $this->af->whereFacturasConciliacion($data);

        return $data->page ? $prestador->paginate($data->cantidad) : $prestador->get();
    }

    public function facturaCerrada($data){
        $prestador = $this->af->whereFacturasCerrada($data);
        return $data->page ? $prestador->paginate($data->cantidad) : $prestador->get();
    }

    public function facturasAuditoriaFinal($data){

        $auditadas = $this->af->whereFacturasAuditoriaFinal($data);
        return $data->page ? $auditadas->paginate($data->cantidad) : $auditadas->get();
    }

    public function guardarAuditoriaFinal($contador,$af_id){

     $encontro = $contador > 0 ?true:false;

     if($encontro == true){
        $af = $this->af::find($af_id);
        $af->update([
            'estado_id' => 21
          ]);

        return 'Factura en proceso de conciliación!';
     }else{
        $af = $this->af::find($af_id);
        $af->update([
            'estado_id' => 22
          ]);

        return 'Factura cerrada con exito!';
     }
    }

    public function facturasConciliadasAuditoriaFinal($data){

        $auditadas = $this->af->whereFacturasConciliadasAuditoriaFinal($data);

        return $data->page ? $auditadas->paginate($data->cantidad) : $auditadas->get();
    }

    public function actualizarTerminado($af){
        $this->af::where('id',$af)
        ->update([
            'estado_id' => 22
        ]);
    }

    public function actualizarTemporal($af){
        $this->af::where('id',$af)
       ->update([
           'estado_id' => 23
       ]);
    }

    public function facturasConciliadasConSaldo($data){

        $auditadas = $this->af->whereFacturasConciliadasConSaldo($data);

        return $data->page ? $auditadas->paginate($data->cantidad) : $auditadas->get();
    }

    public function facturaCerradaAuditoriaFinal($data){

        $auditadas = $this->af->whereFacturasCerradaAuditoriaFinal($data);

        return $data->page ? $auditadas->paginate($data->cantidad) : $auditadas->get();
    }






}
