<?php

namespace App\Http\Modules\Historia\Vacunacion\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Historia\Vacunacion\Models\Vacuna;

class VacunacionRepository extends RepositoryBase
{

    public function __construct(protected Vacuna $vacunacionModel)
    {
    }

    public function listarAntecedentes($data)
    {
        return $this->vacunacionModel::with('consulta', 'user.operador')->whereHas('consulta.afiliado', function ($q) use ($data) {
            $q->where('afiliados.id', $data->afiliado);
        })->get();
    }

    public function eliminarVacuna($data)
    {
        return $this->vacunacionModel->where('id', $data->id)->delete();
    }

    public function crear($data)
    {
        return $this->vacunacionModel->create($data);
    }
}
