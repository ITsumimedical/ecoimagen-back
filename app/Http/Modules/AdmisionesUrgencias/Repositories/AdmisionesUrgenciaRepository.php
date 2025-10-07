<?php

namespace App\Http\Modules\AdmisionesUrgencias\Repositories;

use App\Http\Modules\AdmisionesUrgencias\Models\AdmisionesUrgencia;
use App\Http\Modules\Bases\RepositoryBase;
use Illuminate\Support\Facades\DB;

class AdmisionesUrgenciaRepository extends RepositoryBase
{

    public function __construct(
        protected AdmisionesUrgencia $admisionesUrgencia,
    ) {}


    public function getAdmisionesActivas()
    {
        return $this->admisionesUrgencia::select(
                'admisiones_urgencias.id',
                'admisiones_urgencias.causa_muerte',
                'admisiones_urgencias.causa_externa',
                'admisiones_urgencias.estado_urgencia',
                'admisiones_urgencias.estado_salida',
                'admisiones_urgencias.fecha_salida',
                'admisiones_urgencias.destino_usuario',
                'admisiones_urgencias.nombre_acompanante',
                'admisiones_urgencias.telefono_acompanante',
                'admisiones_urgencias.via_ingreso',
                'admisiones_urgencias.observacion',
                'admisiones_urgencias.direccion_acompanante',
                'admisiones_urgencias.estado_id',
                'e.nombre as estado_nombre',
                'us.email as usuario_email',
                'admisiones_urgencias.afiliado_id',
                DB::raw("CONCAT(af.primer_nombre, ' ', af.segundo_nombre, ' ', af.primer_apellido, ' ', af.segundo_apellido) as nombrePaciente"),
                DB::raw("CONCAT(et.nombre, ' ', p.nombre_prestador, ' ', am.nombre) as nombreContrato")
            )
            ->join('estados as e', 'admisiones_urgencias.estado_id', '=', 'e.id')
            ->join('afiliados as af', 'admisiones_urgencias.afiliado_id', '=', 'af.id')
            ->join('users as us', 'admisiones_urgencias.user_id', '=', 'us.id')
            ->join('contratos as c', 'c.id', '=', 'admisiones_urgencias.contrato_id')
            ->join('entidades as et', 'c.entidad_id', '=', 'et.id')
            ->join('prestadores as p', 'c.prestador_id', '=', 'p.id')
            ->join('ambitos as am', 'c.ambito_id', '=', 'am.id')
            ->with(['consulta.afiliado.tipoDocumento', 'consulta.cita', 'consulta.cita.especialidad','consulta.HistoriaClinica'])
            ->whereIn('admisiones_urgencias.estado_id', [1,9,7])
            // ->whereDate('admisiones_urgencias.created_at', now())
            ->get();
    }

    public function firmaAfiliado($data){
        $this->admisionesUrgencia::where('id',$data['id'])->update(['firma_afiliado'=>$data['firma']]);
    }

    public function firmaAcompañante($data){
        $this->admisionesUrgencia::where('id',$data['id'])->update(['firma_acompanante'=>$data['firma']]);
    }

    public function inasistir($data){
        $this->admisionesUrgencia::where('id',$data['id'])->update(['observacion_inasistencia'=>$data['observacion_inasistencia'],
                                                              'estado_id' => 8]);
    }

    public function actualizarAdmision($admision_id){
        $this->admisionesUrgencia::where('id',$admision_id)->update(['estado_id'=>9]);
    }

    public function actualizarCodigo($admision_id,$codigo){
        $this->admisionesUrgencia::where('id',$admision_id)->update(['codigo_centro_regulador'=>$codigo]);
    }

    public function actualizarEstadoAdmision($datos){
        $this->admisionesUrgencia::where('id',$datos['id'])->update(['estado_id'=>7]);
    }

    public function listarAdmisionesUrgenciasEvolucion($data){
        return $this->admisionesUrgencia::select(
            'admisiones_urgencias.id',
            'admisiones_urgencias.causa_muerte',
            'admisiones_urgencias.causa_externa',
            'admisiones_urgencias.estado_urgencia',
            'admisiones_urgencias.estado_salida',
            'admisiones_urgencias.fecha_salida',
            'admisiones_urgencias.destino_usuario',
            'admisiones_urgencias.nombre_acompanante',
            'admisiones_urgencias.telefono_acompanante',
            'admisiones_urgencias.via_ingreso',
            'admisiones_urgencias.observacion',
            'admisiones_urgencias.direccion_acompanante',
            'admisiones_urgencias.estado_id',
            'e.nombre as estado_nombre',
            'us.email as usuario_email',
            'admisiones_urgencias.afiliado_id',
            DB::raw("CONCAT(af.primer_nombre, ' ', af.segundo_nombre, ' ', af.primer_apellido, ' ', af.segundo_apellido) as nombrePaciente"),
            DB::raw("CONCAT(et.nombre, ' ', p.nombre_prestador, ' ', am.nombre) as nombreContrato")
        )
        ->join('estados as e', 'admisiones_urgencias.estado_id', '=', 'e.id')
        ->join('afiliados as af', 'admisiones_urgencias.afiliado_id', '=', 'af.id')
        ->join('users as us', 'admisiones_urgencias.user_id', '=', 'us.id')
        ->join('contratos as c', 'c.id', '=', 'admisiones_urgencias.contrato_id')
        ->join('entidades as et', 'c.entidad_id', '=', 'et.id')
        ->join('prestadores as p', 'c.prestador_id', '=', 'p.id')
        ->join('ambitos as am', 'c.ambito_id', '=', 'am.id')
        ->with(['consulta:id,admision_urgencia_id,estado_triage',
            'consulta.HistoriaClinica:id,consulta_id,peso,presion_arterial_media,temperatura,frecuencia_cardiaca,frecuencia_respiratoria,triage',
            'evolucion','consulta.cie10Afiliado:esprimario,consulta_id,cie10_id','consulta.cie10Afiliado.cie10:id,codigo_cie10,descripcion'])
        ->whereIn('admisiones_urgencias.estado_id', [60,63])
        ->when(!empty($data['numero_documento']), function($query) use ($data) {
            return $query->where('af.tipo_documento', $data['tipo_documento'])
                    ->where('af.numero_documento',$data['numero_documento']);
        })
        // ->whereDate('admisiones_urgencias.created_at', now())
        ->get();
    }

    public function actualizarFinalizar($id){
        $this->admisionesUrgencia::where('id',$id)->update(['estado_id'=>61]);
    }

    public function actualizarReferencia($id){
        $this->admisionesUrgencia::where('id',$id)->update(['estado_id'=>62]);
    }

    public function certificadoTriage($request)
    {
        $admisionUrgencia = $this->admisionesUrgencia->with('afiliado', 'afiliado.tipoDocumento')->where('id', $request['id'])->first();
        return $admisionUrgencia;
    }
    public function listarAsignacionCama($data){
        return $this->admisionesUrgencia::select(
            'admisiones_urgencias.id',
            'e.nombre as estado_nombre',
            'us.email as usuario_email',
            'admisiones_urgencias.afiliado_id',
            'af.primer_nombre',
            'af.segundo_nombre',
            'af.primer_apellido',
            'af.segundo_apellido',
            'et.nombre',
            'p.nombre_prestador',
            'am.nombre as ambito'
        )
        ->join('estados as e', 'admisiones_urgencias.estado_id', '=', 'e.id')
        ->join('afiliados as af', 'admisiones_urgencias.afiliado_id', '=', 'af.id')
        ->join('users as us', 'admisiones_urgencias.user_id', '=', 'us.id')
        ->join('contratos as c', 'c.id', '=', 'admisiones_urgencias.contrato_id')
        ->join('entidades as et', 'c.entidad_id', '=', 'et.id')
        ->join('prestadores as p', 'c.prestador_id', '=', 'p.id')
        ->join('ambitos as am', 'c.ambito_id', '=', 'am.id')
        ->with(['consulta:id,admision_urgencia_id,estado_triage',
            'consulta.HistoriaClinica:id,consulta_id,peso,presion_arterial_media,temperatura,frecuencia_cardiaca,frecuencia_respiratoria,triage',
            'evolucion','consulta.cie10Afiliado:esprimario,consulta_id,cie10_id','consulta.cie10Afiliado.cie10:id,codigo_cie10,descripcion'])
        ->where('admisiones_urgencias.estado_id', 60)
        ->when(($data['numero_documento']), function($query) use ($data) {
            return $query->where('af.tipo_documento', $data['tipo_documento'])
                    ->where('af.numero_documento',$data['numero_documento']);
        })->first();
    }

    public function actualizarAdmisionGeneral($id,$datos)
    {
        $this->admisionesUrgencia::where('id',$id)->update($datos);
    }


}
