<?php

namespace App\Http\Modules\Ordenamiento\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Ordenamiento\Models\PaqueteOrdenamiento;

class PaqueteOrdenamientoRepository extends RepositoryBase
{

    public function __construct(protected PaqueteOrdenamiento $paqueteOrdenamientoModel)
    {
        parent::__construct($this->paqueteOrdenamientoModel);
    }

    public function listarPaquete($data)
    {
        return $this->paqueteOrdenamientoModel::select('nombre', 'activo', 'id')
            ->when(!empty($data['activo']), function ($query) use ($data) {
                return $query->where('activo', $data['activo']);
            })
            ->get();
    }

    public function actualizarPaquete(int $id, array $data)
    {
        return $this->paqueteOrdenamientoModel::where('id', $id)->update($data);
    }
}
