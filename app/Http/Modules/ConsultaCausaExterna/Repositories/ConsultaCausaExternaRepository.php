<?php

namespace App\Http\Modules\ConsultaCausaExterna\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\ConsultaCausaExterna\Model\ConsultaCausaExterna;

class ConsultaCausaExternaRepository extends RepositoryBase
{


    public function __construct(protected ConsultaCausaExterna $consultaCausaExterna)
    {
        parent::__construct($this->consultaCausaExterna);
    }


    public function listarConsultaExterna()
    {
        return $this->consultaCausaExterna->select('consulta_causa_externas.id', 'consulta_causa_externas.codigo', 'consulta_causa_externas.nombre', 'consulta_causa_externas.estado_id', 'estados.nombre as estado')
            ->join('estados', 'consulta_causa_externas.estado_id', 'estados.id')
            ->get();
    }

    public function listarActivos()
    {
        return $this->consultaCausaExterna->where('estado_id', 1)->get();
    }

    public function cambiarEstado(int $id)
    {
        $consulta = $this->consultaCausaExterna->findOrFail($id);
        $nuevoEstado = $consulta->estado_id === 1 ? 2 : 1; // Cambiar de 1 a 2 o de 2 a 1
        $consulta->estado_id = $nuevoEstado;
        $consulta->save();

        return $consulta;
    }

}
