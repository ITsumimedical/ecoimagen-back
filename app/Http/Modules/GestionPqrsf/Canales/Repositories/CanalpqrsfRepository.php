<?php

namespace App\Http\Modules\GestionPqrsf\Canales\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\GestionPqrsf\Canales\Models\Canalpqrsf;

class CanalpqrsfRepository extends RepositoryBase {

    protected $pqrsfModel;

    public function __construct() {
        $this->pqrsfModel = new Canalpqrsf();
        parent::__construct($this->pqrsfModel);
    }

    public function listarCanal($request)
    {
        $consulta = $this->model->select([
            'canalpqrsfs.id',
            'canalpqrsfs.nombre',
            'canalpqrsfs.estado_id',
            'estados.nombre as nombreEstado'
        ])
        ->leftjoin('estados', 'canalpqrsfs.estado_id', 'estados.id')
        ->where('estado_id', 1)
        ->orderBy('canalpqrsfs.id', 'asc');
        if($request->nombre){
            $consulta->where('canalpqrsfs.nombre','ILIKE',"%{$request->nombre}%");
        }

        return $request->page ? $consulta->paginate($request->cant) : $consulta->get();
    }

    public function listarTodos($request)
    {
        $consulta = $this->model->select([
            'canalpqrsfs.id',
            'canalpqrsfs.nombre',
            'canalpqrsfs.estado_id',
            'estados.nombre as nombreEstado'
        ])
        ->leftjoin('estados', 'canalpqrsfs.estado_id', 'estados.id')
        ->orderBy('canalpqrsfs.id', 'asc');
        if($request->nombre){
            $consulta->where('canalpqrsfs.nombre','ILIKE',"%{$request->nombre}%");
        }

        return $request->page ? $consulta->paginate($request->cant) : $consulta->get();
    }

    public function CambiarEstado($id)
    {
        $canal = $this->pqrsfModel->find($id);
        if ($canal) {
            $canal->estado_id = $canal->estado_id == 1 ? 2 : 1;
            $canal->save();
            return $canal;
        } else {
            return null;
        }
    }
}

