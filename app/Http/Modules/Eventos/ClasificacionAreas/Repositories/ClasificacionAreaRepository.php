<?php

namespace App\Http\Modules\Eventos\ClasificacionAreas\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Eventos\ClasificacionAreas\Models\ClasificacionArea;

class ClasificacionAreaRepository extends RepositoryBase {

    protected $clasificacionAreaModel;

    public function __construct(){
       $clasificacionAreaModel = new ClasificacionArea();
       parent::__construct($clasificacionAreaModel);
       $this->clasificacionAreaModel = $clasificacionAreaModel;
    }

    public function listarArea($pagina){
        $clasificacionArea = ClasificacionArea::select('clasificacion_areas.nombre', 'clasificacion_areas.id', 'clasificacion_areas.suceso_id',
        'sucesos.nombre as nombreSuceso')
        ->join('sucesos', 'sucesos.id', 'clasificacion_areas.suceso_id')
        ->orderBy('id', 'asc');

        return $pagina ? $clasificacionArea->paginate(10) : $clasificacionArea->get();
    }

    public function listarConSuceso($data, $suceso_id)
    {
        /** Definimos el orden*/
        $orden = isset($data->orden) ? $data->orden : 'desc';
        if($data->page){
            $filas = $data->filas ? $data->filas : 10;
            return $this->model
                ->orderBy('created_at', $orden)
                ->paginate($filas)
                ->where('suceso_id', $suceso_id);
        }else{
            return $this->model
                ->orderBy('created_at', $orden)
                ->where('suceso_id', $suceso_id)
                ->get();
        }
    }
}
