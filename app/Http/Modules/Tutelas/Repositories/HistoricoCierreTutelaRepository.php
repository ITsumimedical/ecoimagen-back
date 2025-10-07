<?php

namespace App\Http\Modules\Tutelas\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Tutelas\Models\HistoricoCierreTutela;

class HistoricoCierreTutelaRepository extends RepositoryBase
{

    public function __construct(protected HistoricoCierreTutela $cierreTutelas)
    {
        parent::__construct($this->cierreTutelas);
    }

    public function crearCierre($request)
    {
        return $this->cierreTutelas->create([
            'tipo_cierre' => $request['tipo_cierre'],
            'motivo' => $request['motivo'],
            'user_id' => $request['user_id'],
            'tutela_id' => $request['tutela_id'],
        ]);
    }

    public function crearCierreTemporal($request)
    {
        return $this->cierreTutelas->create([
            'tipo_cierre' => $request['tipo_cierre'],
            'motivo' => $request['motivo'],
            'user_id' => $request['user_id'],
            'tutela_id' => $request['tutela_id'],
        ]);
    }
}
