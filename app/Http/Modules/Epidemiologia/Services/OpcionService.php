<?php

namespace App\Http\Modules\Epidemiologia\Services;

use App\Http\Modules\Epidemiologia\Repositories\OpcionRepository;

class OpcionService
{
    public function __construct(private OpcionRepository $opcionRepository) {}

    /**
     * Listar las opciones de cada campo de la ficha, con o sin paginación
     * @param array $data
     * @return Array
     * @author Sofia O
     */
    public function listarOpciones(array $data)
    {
        $opciones = $this->opcionRepository->buscarOpciones($data);

        if (isset($data['page']) && isset($data['cant'])) {
            return $opciones->paginate($data['cant']);
        }

        return $opciones->get();
    }

    /**
     * Buscar el registro del opcion y actualizarlo
     * @param array $data
     * @param int $id
     * @return Array
     * @author Sofia O
     */
    public function actualizarOpcion(array $data, int $id)
    {
        $opcion = $this->opcionRepository->buscarOpcionPorId($id);
        return $this->opcionRepository->actualizarOpcion($data, $opcion);
    }

    /**
     * Buscar el registro del opcion y ca,biar su estado segun corresponda
     * @param int $id
     * @author Sofia O
     */
    public function actualizarEstado(int $id)
    {
        $opcion = $this->opcionRepository->buscarOpcionPorId($id);
        $estado = $opcion->estado_id == 1 ? 2 : 1;
        return $this->opcionRepository->actualizarOpcion(['estado_id' => $estado], $opcion);
    }
}
