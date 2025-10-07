<?php

namespace App\Http\Modules\GestionPqrsf\TipoSolicitudes\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\GestionPqrsf\TipoSolicitudes\Models\TipoSolicitudpqrsf;

class TipoSolicitudpqrsfRepository extends RepositoryBase
{

    protected $tipoSolicitudModel;

    public function __construct()
    {
        $this->tipoSolicitudModel = new TipoSolicitudpqrsf();
        parent::__construct($this->tipoSolicitudModel);
    }

    public function listarTipoSolicitudes()
    {
        return $this->tipoSolicitudModel->select([
            'tipo_solicitudpqrsfs.id',
            'tipo_solicitudpqrsfs.nombre',
            'tipo_solicitudpqrsfs.descripcion',
            'tipo_solicitudpqrsfs.estado_id',
            'estados.nombre as nombreEstado'
        ])
            ->leftjoin('estados', 'tipo_solicitudpqrsfs.estado_id', 'estados.id')
            ->orderBy('tipo_solicitudpqrsfs.id', 'asc')
            ->where('tipo_solicitudpqrsfs.estado_id', 1)
            ->get();
    }

    public function listarTodos()
    {
        return $this->tipoSolicitudModel->select([
            'tipo_solicitudpqrsfs.id',
            'tipo_solicitudpqrsfs.nombre',
            'tipo_solicitudpqrsfs.descripcion',
            'tipo_solicitudpqrsfs.estado_id',
            'estados.nombre as nombreEstado'
        ])
            ->leftjoin('estados', 'tipo_solicitudpqrsfs.estado_id', 'estados.id')
            ->orderBy('tipo_solicitudpqrsfs.id', 'asc')
            ->get();
    }

    public function CambiarEstado($id)
    {
        $canal = $this->tipoSolicitudModel->find($id);
        if ($canal) {
            $canal->estado_id = $canal->estado_id == 1 ? 2 : 1;
            $canal->save();
            return $canal;
        } else {
            return null;
        }
    }

}
