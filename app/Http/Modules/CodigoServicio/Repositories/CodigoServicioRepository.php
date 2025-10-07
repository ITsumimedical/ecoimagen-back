<?php

namespace App\Http\Modules\CodigoServicio\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\CodigoServicio\Model\CodigoServicio;

class CodigoServicioRepository extends RepositoryBase {


    public function __construct(protected CodigoServicio $codigoServicio)
    {
        parent::__construct($this->codigoServicio);
    }

    public function listarCodigos()
    {
       return $codigos = $this->codigoServicio->select('codigo_servicios.id', 'codigo_servicios.codigo', 'codigo_servicios.nombre', 'codigo_servicios.descripcion', 'codigo_servicios.estado_id', 'estados.nombre as estadoNombre')
        ->join('estados', 'codigo_servicios.estado_id', 'estados.id')
        ->get();
    }

    public function update(int $id, array $data)
    {
        $codigo = $this->codigoServicio->findOrFail($id);
        $codigo->update($data);
    }

    public function cambiarEstado(int $id)
    {
        $codigo = $this->codigoServicio->findOrFail($id);
        $nuevoEstado = $codigo->estado_id === 1 ? 2 : 1; // Cambiar de 1 a 2 o de 2 a 1
        $codigo->estado_id = $nuevoEstado;
        $codigo->save();

        return $codigo;
    }
}
