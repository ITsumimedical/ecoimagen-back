<?php

namespace App\Http\Modules\Solicitudes\GestionRadicacionOnline\Repositories;

use Illuminate\Support\Facades\Auth;
use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Solicitudes\GestionRadicacionOnline\Models\GestionRadicacionOnline;

class GestionRadicacionOnlineRepository extends RepositoryBase{

    public function __construct(protected GestionRadicacionOnline $gestionRadicacionOnlineModel){
        parent::__construct($this->gestionRadicacionOnlineModel);
    }

    public function crearGestion($radicado,$usuario,$tipo,$motivo,$area){
      return  $this->gestionRadicacionOnlineModel->create([
            'radicacion_online_id' => $radicado,
            'user_id' => $usuario,
            'tipo_id' => $tipo,
            'motivo' => $motivo,
            'area_solicitudes_id'=> $area
        ]);
    }

    public function verComentariosPublicos($request){
        $comentarios = $this->gestionRadicacionOnlineModel->select('gestion_radicacion_onlines.id','gestion_radicacion_onlines.created_at',
        'gestion_radicacion_onlines.tipo_id','gestion_radicacion_onlines.motivo','gestion_radicacion_onlines.radicacion_online_id','tipos.nombre',
        'empleados.primer_nombre','empleados.primer_apellido')
        ->join('tipos','gestion_radicacion_onlines.tipo_id','tipos.id')
        ->leftjoin('users','gestion_radicacion_onlines.user_id','users.id')
        ->leftjoin('empleados','users.id','empleados.user_id')
        ->with(['adjuntosGestion'])
        ->where('gestion_radicacion_onlines.radicacion_online_id',$request['radicacion_id'])
        ->where('tipos.nombre','Comentarios al Solicitante')->get();
        return $comentarios;
    }

    public function verComentariosPrivados($request){
        $comentarios = $this->gestionRadicacionOnlineModel->select('gestion_radicacion_onlines.id','gestion_radicacion_onlines.created_at',
        'gestion_radicacion_onlines.tipo_id','gestion_radicacion_onlines.motivo','gestion_radicacion_onlines.radicacion_online_id','tipos.nombre',
        'empleados.primer_nombre','empleados.primer_apellido')
        ->join('tipos','gestion_radicacion_onlines.tipo_id','tipos.id')
        ->leftjoin('users','gestion_radicacion_onlines.user_id','users.id')
        ->leftjoin('empleados','users.id','empleados.user_id')
        ->with(['adjuntosGestion' => function($query){
            $query->select('gestion_radicacion_online_id','ruta','nombre')->get();
        }])
        ->where('gestion_radicacion_onlines.radicacion_online_id',$request['radicacion_id'])
        ->where('tipos.nombre','Comentarios Internos')->get();
        return $comentarios;
    }

    public function verDevoluciones($request){
        $comentarios = $this->gestionRadicacionOnlineModel->select('gestion_radicacion_onlines.id','gestion_radicacion_onlines.created_at',
        'gestion_radicacion_onlines.tipo_id','gestion_radicacion_onlines.motivo','gestion_radicacion_onlines.radicacion_online_id','tipos.nombre',
        'empleados.primer_nombre','empleados.primer_apellido')
        ->join('tipos','gestion_radicacion_onlines.tipo_id','tipos.id')
        ->join('users','gestion_radicacion_onlines.user_id','users.id')
        ->join('empleados','users.id','empleados.user_id')
        ->with(['adjuntosGestion' => function($query){
            $query->select('gestion_radicacion_online_id','ruta','nombre')->get();
        }])
        ->where('gestion_radicacion_onlines.radicacion_online_id',$request['radicacion_id'])
        ->where('tipos.id',22)->get();
        return $comentarios;
    }

    public function quitarRegistro($id_radicacion){
        $this->gestionRadicacionOnlineModel->where('radicacion_online_id',$id_radicacion)
        ->where('tipo_id',20)->delete();
    }

    public function obtenerRegistro($id_radicacion,$id_user){
      return  $this->gestionRadicacionOnlineModel->where('radicacion_online_id',$id_radicacion)
        ->where('user_id',$id_user)->first();
    }

    public function datosparaEmailAuditoria($id){
        return $this->gestionRadicacionOnlineModel->select('empleados.primer_nombre','empleados.primer_apellido','users.email')
        ->join('users','users.id','gestion_radicacion_onlines.user_id')
        ->join('empleados','empleados.user_id','users.id')
        ->where('gestion_radicacion_onlines.id',$id)->get();
    }



}
