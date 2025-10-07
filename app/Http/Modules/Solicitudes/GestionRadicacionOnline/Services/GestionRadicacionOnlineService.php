<?php

namespace App\Http\Modules\Solicitudes\GestionRadicacionOnline\Services;


use App\Http\Modules\Solicitudes\GestionRadicacionOnline\Repositories\GestionRadicacionOnlineRepository;
use App\Http\Modules\Solicitudes\RadicacionOnline\Repositories\RadicacionOnlineRepository;
use Illuminate\Support\Facades\Auth;

class GestionRadicacionOnlineService{


    public function __construct(private GestionRadicacionOnlineRepository $gestionRadicacionOnlineRepository,
                                private RadicacionOnlineRepository $radicacionOnlineRepository)
    {

    }

    public function gestion($request){
        if($request['radicacion_online_id'] !='null'){
            switch ($request['tipo']) {
                case 'Reasignar':

                    foreach ($request['radicacion_online_id'] as $keyRadicado){
                        $this->gestionRadicacionOnlineRepository->quitarRegistro($keyRadicado);
                    }

                    foreach ($request['usuario_id'] as $keyUsuario) {
                        foreach ($request['radicacion_online_id'] as $keyRadicadoCrear) {
                            $this->gestionRadicacionOnlineRepository->crearGestion($keyRadicadoCrear,$keyUsuario,20,'Asignado');
                        }
                    }
                    break;
                 case 'Compartir':
                    foreach ($request['usuario_id'] as $keyUsuario){
                        foreach ($request['radicacion_online_id'] as $keyRadicadoCrear) {
                            $existe = $this->gestionRadicacionOnlineRepository->obtenerRegistro($keyRadicadoCrear,$keyUsuario);
                            if(!$existe){
                                $this->gestionRadicacionOnlineRepository->crearGestion($keyRadicadoCrear,$keyUsuario,20,'Asignado');
                            }
                        }
                    }
                    break;
                case 'Devolver':
                    foreach ($request['radicacion_online_id'] as $keyRadicado){
                        $this->gestionRadicacionOnlineRepository->quitarRegistro($keyRadicado);
                        $this->radicacionOnlineRepository->actualizarEstadoPendiente($keyRadicado);
                        $this->gestionRadicacionOnlineRepository->crearGestion($keyRadicado,Auth::user()->id,22,$request['motivo']);
                    }
                    break;
            }
        } else {
            switch ($request['tipo']) {
                case 'Reasignar':
                   $radicadosActivos = $this->radicacionOnlineRepository->radicadosActivados($request['delusuario_id']);
                   if(count($radicadosActivos) ==0){
                    return 'No se han encontrado radicados pendientes del usuario seleccionado';
                   }

                   foreach ($radicadosActivos as $keyRadicado){
                    $this->gestionRadicacionOnlineRepository->quitarRegistro($keyRadicado->id);
                   }
                   foreach($request['alusuario_id'] as $keyUsuario ){
                     foreach ($radicadosActivos as $keyRadicadoCrear) {
                        $this->gestionRadicacionOnlineRepository->crearGestion($keyRadicadoCrear->id,$keyUsuario,20,'Asignado');
                     }
                   }
                 break;
                   case 'Compartir':
                        $radicadosActivos = $this->radicacionOnlineRepository->radicadosActivados($request['delusuario_id']);
                        if(count($radicadosActivos) ==0){
                            return 'No se han encontrado radicados pendientes del usuario seleccionado';
                        }

                        foreach ($request['alusuario_id'] as $keyUsuario ) {
                            foreach ($radicadosActivos as $keyRadicadoCrear){
                                $existe = $this->gestionRadicacionOnlineRepository->obtenerRegistro($keyRadicadoCrear->id,$keyUsuario);
                                if(!$existe){
                                    $this->gestionRadicacionOnlineRepository->crearGestion($keyRadicadoCrear->id,$keyUsuario,20,'Asignado');
                                }
                            }

                     }
                  break;
                  case 'Devolver':
                    $radicadosActivos = $this->radicacionOnlineRepository->radicadosActivados($request['delusuario_id']);
                    if(count($radicadosActivos) ==0){
                        return 'No se han encontrado radicados pendientes del usuario seleccionado';
                    }
                    foreach ($radicadosActivos as $keyRadicado){
                        $this->gestionRadicacionOnlineRepository->quitarRegistro($keyRadicado->id);
                        $this->radicacionOnlineRepository->actualizarEstadoPendiente($keyRadicado->id);
                        $this->gestionRadicacionOnlineRepository->crearGestion($keyRadicado->id,Auth::user()->id,22,$request['motivo']);
                       }
                  break;
            }
        }
    }


}
