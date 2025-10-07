<?php

namespace App\Http\Modules\BarreraAccesos\Services;

use App\Http\Modules\BarreraAccesos\Repositories\TipoBarrearAccesoRepository;

class TipoBarreraAccesoService
{
    public function __construct(protected TipoBarrearAccesoRepository $tipoBarrearAccesoRepository) {}

    /**
     * Listar tipos de barreras paginados o todo
     * @author Sofia O
     */
    public function listar(array $data)
    {
        $tipos = $this->tipoBarrearAccesoRepository->listarTipos();

        if (isset($data['page']) && isset($data['cant'])) {
            return $tipos->paginate($data['cant']);
        }

        return $tipos->get();
    }

    /**
     * Buscar y actualizar tipo de barrera
     * @author Sofia O
     */
    public function actualizar(array $data, int $id)
    {
        $tipo = $this->tipoBarrearAccesoRepository->buscarTipoBarreraAccesoId($id);
        return $this->tipoBarrearAccesoRepository->actualizarTipo($data, $tipo);
    }

    /**
     * Buscar y cambiar tipo de barrera
     * @author Sofia O
     */
    public function cambiarEstado(int $id)
    {
        $tipo = $this->tipoBarrearAccesoRepository->buscarTipoBarreraAccesoId($id);
        $estado = $tipo->estado_id == 1 ? 2 : 1;
        return $this->tipoBarrearAccesoRepository->actualizarTipo(['estado_id' => $estado], $tipo);
    }
}
