<?php

namespace App\Http\Modules\Epicrisis\Repositories;

use Illuminate\Support\Facades\DB;
use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Epicrisis\Models\Epicrisi;

class EpicrisisRepository extends RepositoryBase {

    public function __construct(protected Epicrisi $epicrisiModel)
    {
        parent::__construct($this->epicrisiModel);
    }

    public function listarEpicrisis($data){
      return  $this->epicrisiModel::select(
            'epicrisis.id as idEpicrisis',
            'epicrisis.motivo_salida',
            'epicrisis.estado_salida',
            'epicrisis.fecha_deceso',
            'epicrisis.certificado_defuncion',
            'epicrisis.causa_muerte',
            'epicrisis.fecha_egreso',
            'epicrisis.orden_alta',
            'epicrisis.observacion',
            'epicrisis.consulta_id',
            'admisiones_urgencias.id',
            'e.nombre as estado_nombre',
            'us.email as usuario_email',
            'admisiones_urgencias.afiliado_id',
            'af.numero_documento',
            DB::raw("CONCAT(af.primer_nombre, ' ', af.segundo_nombre, ' ', af.primer_apellido, ' ', af.segundo_apellido) as nombrePaciente"),
            DB::raw("CONCAT(et.nombre, ' ', p.nombre_prestador, ' ', am.nombre) as nombreContrato"),
            DB::raw("CONCAT(cie10s.codigo_cie10, ' ', cie10s.descripcion) as cie10")
        )
        ->join('admisiones_urgencias','admisiones_urgencias.id','epicrisis.admision_urgencia_id')
        ->join('cie10s','cie10s.id','epicrisis.cie10_id')
        ->join('estados as e', 'admisiones_urgencias.estado_id', '=', 'e.id')
        ->join('afiliados as af', 'admisiones_urgencias.afiliado_id', '=', 'af.id')
        ->join('users as us', 'admisiones_urgencias.user_id', '=', 'us.id')
        ->join('contratos as c', 'c.id', '=', 'admisiones_urgencias.contrato_id')
        ->join('entidades as et', 'c.entidad_id', '=', 'et.id')
        ->join('prestadores as p', 'c.prestador_id', '=', 'p.id')
        ->join('ambitos as am', 'c.ambito_id', '=', 'am.id')
        ->with(['consulta:id,admision_urgencia_id,estado_triage',
            'consulta.HistoriaClinica:id,consulta_id,peso,presion_arterial_media,temperatura,frecuencia_cardiaca,frecuencia_respiratoria,triage',
           'consulta.cie10Afiliado:esprimario,consulta_id,cie10_id','consulta.cie10Afiliado.cie10:id,codigo_cie10,descripcion'])
        ->when(!empty($data['documento']), function($query) use ($data) {
            return $query->where('af.numero_documento', $data['documento']);
        })
        ->get();
    }

    public function listarRemision(){
        return  $this->epicrisiModel::select(
              'epicrisis.id as idEpicrisis',
              'epicrisis.motivo_salida',
              'epicrisis.estado_salida',
              'epicrisis.fecha_deceso',
              'epicrisis.certificado_defuncion',
              'epicrisis.causa_muerte',
              'epicrisis.fecha_egreso',
              'epicrisis.orden_alta',
              'epicrisis.observacion',
              'epicrisis.consulta_id',
              'admisiones_urgencias.id',
              'e.nombre as estado_nombre',
              'us.email as usuario_email',
              'admisiones_urgencias.afiliado_id',
              'af.numero_documento',
              DB::raw("CONCAT(af.primer_nombre, ' ', af.segundo_nombre, ' ', af.primer_apellido, ' ', af.segundo_apellido) as nombrePaciente"),
              DB::raw("CONCAT(et.nombre, ' ', p.nombre_prestador, ' ', am.nombre) as nombreContrato"),
              DB::raw("CONCAT(cie10s.codigo_cie10, ' ', cie10s.descripcion) as cie10")
          )
          ->join('admisiones_urgencias','admisiones_urgencias.id','epicrisis.admision_urgencia_id')
          ->join('cie10s','cie10s.id','epicrisis.cie10_id')
          ->join('estados as e', 'admisiones_urgencias.estado_id', '=', 'e.id')
          ->join('afiliados as af', 'admisiones_urgencias.afiliado_id', '=', 'af.id')
          ->join('users as us', 'admisiones_urgencias.user_id', '=', 'us.id')
          ->join('contratos as c', 'c.id', '=', 'admisiones_urgencias.contrato_id')
          ->join('entidades as et', 'c.entidad_id', '=', 'et.id')
          ->join('prestadores as p', 'c.prestador_id', '=', 'p.id')
          ->join('ambitos as am', 'c.ambito_id', '=', 'am.id')
          ->with(['consulta:id,admision_urgencia_id,estado_triage',
              'consulta.HistoriaClinica:id,consulta_id,peso,presion_arterial_media,temperatura,frecuencia_cardiaca,frecuencia_respiratoria,triage',
             'consulta.cie10Afiliado:esprimario,consulta_id,cie10_id','consulta.cie10Afiliado.cie10:id,codigo_cie10,descripcion'])
          ->where('epicrisis.motivo_salida','Remision')
          ->where('admisiones_urgencias.estado_id',61)
          ->get();
      }

      public function registroReferencia($data){
        $this->epicrisiModel::find($data['epicrisis'])->update($data);
      }

      public function listarHistoricoReferencia($data){
        return  $this->epicrisiModel::select(
              'epicrisis.id as idEpicrisis',
              'epicrisis.motivo_salida',
              'epicrisis.estado_salida',
              'epicrisis.fecha_deceso',
              'epicrisis.certificado_defuncion',
              'epicrisis.causa_muerte',
              'epicrisis.fecha_egreso',
              'epicrisis.orden_alta',
              'epicrisis.observacion',
              'epicrisis.consulta_id',
              'epicrisis.peso', 'epicrisis.talla','epicrisis.tension_arterial','epicrisis.frecuencia_respiratoria',
              'epicrisis.frecuencia_cardiaca','epicrisis.temperatura','epicrisis.aspecto_general','epicrisis.cabeza',
              'epicrisis.abdomen','epicrisis.cuello','epicrisis.torax','epicrisis.snp','epicrisis.ojos','epicrisis.respiratorio',
              'epicrisis.extremidad_superior','epicrisis.oidos','epicrisis.gastrointestinal','epicrisis.extremidad_inferior',
              'epicrisis.boca_garganta','epicrisis.linfatico','epicrisis.funcion_cerebral','epicrisis.piel_mucosa',
              'epicrisis.psicomotor', 'epicrisis.reflejos','epicrisis.urogenital','epicrisis.snc','epicrisis.evolucion_anterior',
              'epicrisis.impresion_diagnostica','epicrisis.plan',
              'admisiones_urgencias.id',
              'e.nombre as estado_nombre',
              'us.email as usuario_email',
              'admisiones_urgencias.afiliado_id',
              'af.numero_documento',
              'epicrisis.otro_servicio',
              'servicio_remision',
              'objeto_remision',
              'fecha_referencia',
              'entidades.nombre as entidadRemision',
              DB::raw("CONCAT(af.primer_nombre, ' ', af.segundo_nombre, ' ', af.primer_apellido, ' ', af.segundo_apellido) as nombrePaciente"),
              DB::raw("CONCAT(et.nombre, ' ', p.nombre_prestador, ' ', am.nombre) as nombreContrato"),
              DB::raw("CONCAT(cie10s.codigo_cie10, ' ', cie10s.descripcion) as cie10")
          )
          ->join('admisiones_urgencias','admisiones_urgencias.id','epicrisis.admision_urgencia_id')
          ->join('cie10s','cie10s.id','epicrisis.cie10_id')
          ->join('estados as e', 'admisiones_urgencias.estado_id', '=', 'e.id')
          ->join('afiliados as af', 'admisiones_urgencias.afiliado_id', '=', 'af.id')
          ->join('users as us', 'admisiones_urgencias.user_id', '=', 'us.id')
          ->join('contratos as c', 'c.id', '=', 'admisiones_urgencias.contrato_id')
          ->join('entidades as et', 'c.entidad_id', '=', 'et.id')
          ->join('prestadores as p', 'c.prestador_id', '=', 'p.id')
          ->join('ambitos as am', 'c.ambito_id', '=', 'am.id')
          ->join('entidades','entidades.id','epicrisis.entidad_id')
          ->with(['consulta:id,admision_urgencia_id,estado_triage',
              'consulta.HistoriaClinica:id,consulta_id,peso,presion_arterial_media,temperatura,frecuencia_cardiaca,frecuencia_respiratoria,triage',
             'consulta.cie10Afiliado:esprimario,consulta_id,cie10_id','consulta.cie10Afiliado.cie10:id,codigo_cie10,descripcion'])
          ->where('epicrisis.motivo_salida','Remision')
          ->where('admisiones_urgencias.estado_id',62)
          ->when(!empty($data['documento']), function($query) use ($data) {
            return $query->where('af.numero_documento', $data['documento']);
        })
          ->get();
      }
}
