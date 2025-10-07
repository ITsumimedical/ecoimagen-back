<?php

namespace App\Http\Modules\Eventos\TipoEventos\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Eventos\TipoEventos\Models\TipoEvento;

class TipoEventoRepository extends RepositoryBase {

    protected $tipoEventoModel;

    public function __construct(){
       $tipoEventoModel = new TipoEvento();
       parent::__construct($tipoEventoModel);
       $this->tipoEventoModel = $tipoEventoModel;
    }

    public function listarClasificacion($pagina){
        $tipoEventoClasificacion = TipoEvento::select('tipo_eventos.nombre', 'tipo_eventos.id', 'tipo_eventos.clasificacion_area_id',
        'clasificacion_areas.nombre as nombreArea')
        ->join('clasificacion_areas', 'clasificacion_areas.id', 'tipo_eventos.clasificacion_area_id')
        ->orderBy('id','asc');

        return $pagina ? $tipoEventoClasificacion->paginate(10) : $tipoEventoClasificacion->get();
    }

    public function listarConClasiArea($data, $clasificacion_area_id)
    {
        /** Definimos el orden*/
        $orden = isset($data->orden) ? $data->orden : 'desc';
        if($data->page){
            $filas = $data->filas ? $data->filas : 10;
            return $this->model
                ->orderBy('created_at', $orden)
                ->paginate($filas)
                ->where('clasificacion_area_id', $clasificacion_area_id);
        }else{
            return $this->model
                ->orderBy('created_at', $orden)
                ->where('clasificacion_area_id', $clasificacion_area_id)
                ->get();
        }
    }
}
