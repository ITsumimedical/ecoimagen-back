<?php

namespace App\Http\Modules\BarreraAccesos\Services;

use App\Http\Modules\BarreraAccesos\Repositories\AreaResponsableRepository;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class AreaResponsableService
{
    public function __construct(protected AreaResponsableRepository $areaResponsableRepository) {}

    /**
     * Listar areas paginadas o todo
     * @author Sofia O
     */
    public function listar(array $data)
    {
        $areaResponsables = $this->areaResponsableRepository->listarAreaResponsables();

        if (isset($data['page']) && isset($data['cant'])) {
            return $areaResponsables->paginate($data['cant']);
        }

        return $areaResponsables->get();
    }

    /**
     * Crear area
     * @author Sofia O
     */
    public function crear(array $data)
    {
        return $this->areaResponsableRepository->crearAreaResponsable($data);
    }

    /**
     * Buscar y actualizar area
     * @author Sofia O
     */
    public function actualizar(array $data, int $id)
    {
        $areaResponsable = $this->areaResponsableRepository->buscarAreaResponsableBarreraAccesoId($id);
        return $this->areaResponsableRepository->actualizarAreaResponsable($data, $areaResponsable);
    }

    /**
     * Buscar y cambiar estado area
     * @author Sofia O
     */
    public function cambiarEstado(int $id)
    {
        $areaResponsable = $this->areaResponsableRepository->buscarAreaResponsableBarreraAccesoId($id);
        $estado = $areaResponsable->estado_id == 1 ? 2 : 1;
        return $this->areaResponsableRepository->actualizarAreaResponsable(['estado_id' => $estado], $areaResponsable);
    }
}
