<?php

namespace App\Http\Modules\Epidemiologia\Services;

use App\Http\Modules\Epidemiologia\Repositories\EventoRepository;

class EventoService
{
    public function __construct(private EventoRepository $eventoRepository) {}

    /**
     * Listar los eventos epidemiológicos, con o sin paginación
     * @param array $data
     * @return Array
     * @author Sofia O
     */
    public function listarEventos(array $data)
    {
        $eventos = $this->eventoRepository->buscarEventos();

        if (isset($data['page']) && isset($data['cant'])) {
            return $eventos->paginate($data['cant']);
        }

        return $eventos->get();
    }

    /**
     * Buscar el registro del evento y actualizarlo
     * @param array $data
     * @param int $id
     * @return Array
     * @author Sofia O
     */
    public function actualizarEvento(array $data, int $id)
    {
        $evento = $this->eventoRepository->buscarEventoPorId($id);
        return $this->eventoRepository->actualizarEvento($data, $evento);
    }

    /**
     * Buscar el registro del evento y cambiar su estado segun corresponda
     * @param int $id
     * @author Sofia O
     */
    public function actualizarEstado(int $id)
    {
        $evento = $this->eventoRepository->buscarEventoPorId($id);
        $estado = $evento->estado_id == 1 ? 2 : 1;
        return $this->eventoRepository->actualizarEvento(['estado_id' => $estado], $evento);
    }
}
