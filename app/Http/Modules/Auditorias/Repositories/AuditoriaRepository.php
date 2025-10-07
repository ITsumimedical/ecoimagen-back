<?php

namespace App\Http\Modules\Auditorias\Repositories;

use App\Http\Modules\Auditorias\Models\Auditoria;
use App\Http\Modules\Bases\RepositoryBase;

class AuditoriaRepository extends RepositoryBase
{

    public function __construct(protected Auditoria $auditoriaModel) {
        parent::__construct($this->auditoriaModel);
    }

    public function crearAuditoria($orden_id,$observacion,$tipo){
        $this->auditoriaModel->create([
            'orden_articulo_id' => $orden_id,
            'user_id' => auth()->user()->id,
            'observaciones' =>$observacion,
            'tipo_id' => $tipo
        ]);
    }




}
