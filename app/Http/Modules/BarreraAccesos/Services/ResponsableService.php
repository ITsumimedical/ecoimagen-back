<?php

namespace App\Http\Modules\BarreraAccesos\Services;

use App\Http\Modules\BarreraAccesos\Repositories\ResponsableRepository;

class ResponsableService {
    public function __construct(protected ResponsableRepository $responsableRepository)
    {}

     /**
     * Listar responsables paginadas o todo
     * @author Sofia O
     */
    public function listar(array $data)
    {
        $responsables = $this->responsableRepository->listarResponsables();

        if (isset($data['page']) && isset($data['cant'])) {
            return $responsables->paginate($data['cant']);
        }

        return $responsables->get();
    }

    /**
     * Buscar y actualizar responsable
     * @author Sofia O
     */
    public function actualizar(array $data, int $id) {
        $responsable = $this->responsableRepository->buscarResponsableBarreraAccesoId($id);
        return $this->responsableRepository->actualizarresponsable($data, $responsable);
    }

    /**
     * Bucar y cambiar estado del responsable
     * @author Sofia O
     */
    public function cambiarEstado(int $id) {
        $responsable = $this->responsableRepository->buscarResponsableBarreraAccesoId($id);
        $estado = $responsable->estado_id == 1 ? 2 : 1;
        return $this->responsableRepository->actualizarresponsable(['estado_id' => $estado], $responsable);
    }
}
