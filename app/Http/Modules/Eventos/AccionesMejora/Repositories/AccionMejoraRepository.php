<?php

namespace App\Http\Modules\Eventos\AccionesMejora\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Eventos\AccionesMejora\Models\AccionesMejoraEvento;

class AccionMejoraRepository extends RepositoryBase {

    protected $accionMejoraModel;

    public function __construct() {
        $this->accionMejoraModel = new AccionesMejoraEvento();
        parent::__construct($this->accionMejoraModel);
    }

    // public function listarAccionMejora($data, $id)
    // {
    //     /** Definimos el orden*/
    //     $orden = isset($data->orden) ? $data->orden : 'desc';
    //     if($data->page){
    //         $filas = $data->filas ? $data->filas : 10;
    //         return $this->model
    //             ->orderBy('created_at', $orden)
    //             ->paginate($filas)
    //             ->where('analisis_evento_id', $id)
    //             ->whereNull('deleted_at')
    //             ->with('adjuntos');
    //     }else{
    //         return $this->model
    //             ->orderBy('created_at', $orden)
    //             ->where('analisis_evento_id', $id)
    //             ->with('adjuntos')
    //             ->whereNull('deleted_at')
    //             ->get();
    //     }
    // }

    public function listarAccionesMejora($id) {
        return $this->accionMejoraModel::where('analisis_evento_id', $id)->with(['adjuntos', 'eventosAsignados.user:id','eventosAsignados.user.operador:user_id,nombre,apellido'])->orderBy('created_at', 'desc')->get();
    }
}
