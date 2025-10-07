<?php

namespace App\Http\Modules\Camas\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Camas\Models\Cama;
use App\Http\Modules\Pabellones\Models\Pabellon;

class CamaRepository extends RepositoryBase {

    public function __construct(protected Cama $camaModel)
    {
        parent::__construct($this->camaModel);
    }

    public function listarCama(){
        return $this->camaModel::select('camas.id','camas.nombre','camas.descripcion','precio','camas.estado_id','pabellon_id',
        'pabellones.nombre as pabellon','estados.nombre as estado')
        ->join('pabellones','pabellones.id','camas.pabellon_id')
        ->join('estados','estados.id','camas.estado_id')
        ->get();
    }

    public function actualizarCama(int $id,$data){
        return $this->camaModel::where('id',$id)->update($data);
    }

    public function contadorObservacion(){
        $camas = $this->camaModel::where('pabellon_id',1)->count();
        $camasDisponibles = $this->camaModel::where('pabellon_id',1)->where('estado_id',1)->count();
        $camasOcupadas = $this->camaModel::where('pabellon_id',1)->where('estado_id','!=',1)->count();

        return (Object) [
            'camas' => $camas,
            'disponibles' => $camasDisponibles,
            'ocupadas' => $camasOcupadas
        ];
    }

    public function listarCamaCenso($data){
        return $this->camaModel::select('camas.id','camas.nombre','camas.descripcion','precio','camas.estado_id','pabellon_id',
        'pabellones.nombre as pabellon','estados.nombre as estado')
        ->join('pabellones','pabellones.id','camas.pabellon_id')
        ->join('estados','estados.id','camas.estado_id')
        ->with(['asignacionCama'=> function($query){
            $query->where('estado_id', 1);},
           'asignacionCama.admisionUrgencia:id,contrato_id,afiliado_id,created_at,estado_id',
           'asignacionCama.admisionUrgencia.consulta:id,admision_urgencia_id,afiliado_id',
           'asignacionCama.admisionUrgencia.consulta.afiliado:id,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,numero_documento,sexo,edad_cumplida,celular1,tipo_documento',
           'asignacionCama.admisionUrgencia.consulta.afiliado.tipoDocumento',
           'asignacionCama.admisionUrgencia.consulta.HistoriaClinica:id,consulta_id,alergia,peso,talla,imc,isc,presion_sistolica,presion_diastolica,presion_arterial_media,frecuencia_cardiaca,pulsos,frecuencia_respiratoria,temperatura,saturacion_oxigeno,fio',
           'asignacionCama.admisionUrgencia.evolucion',
            'asignacionCama.admisionUrgencia.notaEnfermeria',
           'asignacionCama.admisionUrgencia.contratos:id,ambito_id,prestador_id,entidad_id',
           'asignacionCama.admisionUrgencia.contratos.prestador:id,nombre_prestador,nit',
           'asignacionCama.admisionUrgencia.contratos.ambito:id,nombre',
           'asignacionCama.admisionUrgencia.contratos.entidad:id,nombre'])
        ->when(!empty($data['estado']), function($query) use ($data) {
            return $query->where('estado_id', $data['estado']);
        })
        ->when(!empty($data['afiliado']), function($query) use ($data) {
            return $query->whereHas('asignacionCama.admisionUrgencia',function($query)use ($data){
                return $query->where('afiliado_id',$data['afiliado']);
            });
        })
        ->orderBy('camas.id','ASC')
        ->get();
    }

}
