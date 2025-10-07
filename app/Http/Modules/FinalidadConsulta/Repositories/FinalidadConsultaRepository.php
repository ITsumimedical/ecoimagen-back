<?php

namespace App\Http\Modules\FinalidadConsulta\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\FinalidadConsulta\Model\FinalidadConsulta;

class FinalidadConsultaRepository extends RepositoryBase {

    public function __construct(protected FinalidadConsulta $finalidadConsulta)
    {
        parent::__construct($this->finalidadConsulta);
    }

    public function listarFinalidades() {
        return $this->finalidadConsulta->select('finalidad_consultas.id', 'finalidad_consultas.codigo', 'finalidad_consultas.nombre', 'finalidad_consultas.estado_id', 'estados.nombre as estado')
        ->join('estados', 'finalidad_consultas.estado_id', 'estados.id')
        ->get();
    }

    public function listarActivas() {
        return $this->finalidadConsulta->where('estado_id', 1)->get();
    }


    public function cambiarEstado(int $id)
    {
        $finalidad = $this->finalidadConsulta->findOrFail($id);
        $nuevoEstado = $finalidad->estado_id === 1 ? 2 : 1; // Cambiar de 1 a 2 o de 2 a 1
        $finalidad->estado_id = $nuevoEstado;
        $finalidad->save();

        return $finalidad;
    }

}
