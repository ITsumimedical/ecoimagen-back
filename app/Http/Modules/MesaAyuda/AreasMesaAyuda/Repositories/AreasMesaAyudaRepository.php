<?php

namespace App\Http\Modules\MesaAyuda\AreasMesaAyuda\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\MesaAyuda\AreasMesaAyuda\Models\AreasMesaAyuda;

class AreasMesaAyudaRepository extends RepositoryBase
{

    public function __construct(private AreasMesaAyuda $areasMesaAyudaModel) {
        parent::__construct($this->areasMesaAyudaModel);

    }

    public function listarArea($request) {
        $area =  $this->areasMesaAyudaModel::select('nombre','descripcion','id','visible', 'activo')
        ->orderBy('areas_mesa_ayudas.id', 'asc')
        ->whereEstado($request->estado);
        return $request->page ? $area->paginate() : $area->get();
    }

    public function cambiarEstado(int $id) {
        $area = $this->areasMesaAyudaModel->findOrFail($id);
        $area->activo = !$area->activo;
        $area->save();
        return $area;
    }
}
