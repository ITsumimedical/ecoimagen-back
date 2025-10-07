<?php

namespace App\Http\Modules\Solicitudes\TipoSolicitudEntidad\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Solicitudes\TipoSolicitudEntidad\Models\TipoSolicitudEntidad;

class TipoSolicitudEntidadRepository extends RepositoryBase
{

    public function __construct(protected TipoSolicitudEntidad $tipoSolicitudEntidadModel)
    {
        parent::__construct($this->tipoSolicitudEntidadModel);
    }

    public function listarTipo($request)
    {
        $tipo = $this->tipoSolicitudEntidadModel
            ->select('entidades.id', 'entidades.nombre')
            ->join('entidades', 'tipo_solicitud_entidads.entidad_id', '=', 'entidades.id')
            ->where('tipo_solicitud_entidads.tipo_solicitud_id', $request['id']);

        return $request['page'] ? $tipo->paginate($request['cantidad']) : $tipo->get();
    }
}
