<?php

namespace App\Http\Modules\ResponsableTutela\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\ResponsableTutela\Models\ResponsableTutela;

class ResponsableTutelaRespository extends RepositoryBase{

    protected $ModelResponsable;

    public function __construct(ResponsableTutela $ModelResponsable) {
        $this->ModelResponsable = $ModelResponsable;
        parent::__construct($this->ModelResponsable);
    }

    public function listarReponsable($request) {
        $consulta =  $this->model::with('proceso:id,nombre')
            ->WhereUser($request->user_id)
            ->WhereProceso($request->proceso_id)
            ->WhereCorreo($request->correo);

        return $request->page ? $consulta->paginate() : $consulta->get();
    }

    /**
     * Obtiene el correo del usuario responsable segun el id del proceso
     * @param int $id_proceso
     * @author AlejoSR
     */
    public function obtenerCorreo($id_proceso): string {
        $consulta = $this->ModelResponsable->whereProceso($id_proceso)->first();
        $correo = $consulta->correo;

        return $correo;
        
    }
}
