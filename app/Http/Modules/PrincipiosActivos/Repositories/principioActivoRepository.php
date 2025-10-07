<?php

namespace App\Http\Modules\PrincipiosActivos\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Medicamentos\Models\Codesumi;
use App\Http\Modules\PrincipiosActivos\Model\principioActivo;

class principioActivoRepository extends RepositoryBase {

    protected $model;

    public function __construct(principioActivo $model)
    {
        $this->model = $model;
    }

    public function actualizarPrincipio($id, $request)
    {
        $resultado = $this->model->findOrFail($id);
        return $resultado->update($request);
    }
}
