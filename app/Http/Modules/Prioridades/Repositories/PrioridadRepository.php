<?php

namespace App\Http\Modules\Prioridades\Repositories;


use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Prioridades\Models\Prioridad;

class PrioridadRepository extends RepositoryBase
{
    protected $prioridadeModel;

    public function __construct(Prioridad $prioridadeModel) {
        parent::__construct($prioridadeModel);
        $this->prioridadeModel = $prioridadeModel;
    }

    public function listarPrioridad()
    {
        return $this->prioridadeModel->select(
            'prioridades.id',
            'prioridades.nombre',
            'prioridades.descripcion',
            'prioridades.tiempo',
            'prioridades.estado_id',
        )
        ->join('estados', 'prioridades.estado_id', 'estados.id')
        ->orderBy('prioridades.id', 'asc')
        ->get();
    }
}
