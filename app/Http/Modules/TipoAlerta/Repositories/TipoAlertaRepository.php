<?php

namespace App\Http\Modules\TipoAlerta\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\TipoAlerta\Models\TipoAlerta;

class TipoAlertaRepository extends RepositoryBase
{



    public function __construct(protected TipoAlerta $tipoAlertaModel)
    {
        parent::__construct($this->tipoAlertaModel);
    }

    public function listarTipo($data)
    {
        $consulta = $this->tipoAlertaModel
            ->with(['user.operador', 'estado'])
            ->WhereNombre($data->nombre);

        return $data->page ? $consulta->paginate($data->cant) : $consulta->get();
    }


    public function cambiarEstado($tipo_id)
    {
        $consulta = $this->tipoAlertaModel->find($tipo_id);
        if ($consulta->estado_id == 1) {
            $consulta->update([
                'estado_id' => 2
            ]);
        } else {
            $consulta->update([
                'estado_id' => 1
            ]);
        }
        return true;
    }
}
