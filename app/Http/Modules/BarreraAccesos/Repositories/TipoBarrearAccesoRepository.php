<?php

namespace App\Http\Modules\BarreraAccesos\Repositories;

use App\Http\Modules\BarreraAccesos\Models\TipoBarreraAcceso;
use App\Http\Modules\Bases\RepositoryBase;

class TipoBarrearAccesoRepository extends RepositoryBase
{
    public function __construct(protected TipoBarreraAcceso $tipoBarreraAcceso) {}

    /**
     * Listar todos los tipos de barrera acceso
     * @author Sofia O
     */
    public function listarTipos()
    {
        return $this->tipoBarreraAcceso->orderBy('id', 'asc');
    }

    /**
     * Listar solo los tipos de barrera acceso activos
     * @author Sofia O
     */
    public function listarActivos()
    {
        return $this->tipoBarreraAcceso
            ->where('estado_id', 1)
            ->orderBy('id', 'asc')
            ->get();
    }

    /**
     * Crear tipo de barrera acceso
     * @param array $data
     * @return Array
     * @author Sofia O
     */
    public function crearTipo($data)
    {
        return $this->tipoBarreraAcceso->create($data);
    }

    /**
     * Buscar tipo de barrera acceso
     * @param int $id
     * @return Model
     * @author Sofia O
     */
    public function buscarTipoBarreraAccesoId(int $id)
    {
        return $this->tipoBarreraAcceso->findOrFail($id);
    }

     /**
     * Actualizar tipo de barrera acceso
     * @param $data
     * @param $tipo
     * @return $tipo
     * @author Sofia O
     */
    public function actualizarTipo($data, $tipo)
    {
        return $tipo->update($data);
    }

}
