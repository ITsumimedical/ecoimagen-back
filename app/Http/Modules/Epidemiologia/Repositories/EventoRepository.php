<?php

namespace App\Http\Modules\Epidemiologia\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Epidemiologia\Models\EventoSivigila;

class EventoRepository extends RepositoryBase
{
    public function __construct(private EventoSivigila $eventoModel) {}

    /**
     * Consulta para obtener los eventos sivigila
     * @author Sofia O
     */
    public function buscarEventos()
    {
        return $this->eventoModel->orderBy('id', 'asc');
    }

    /**
     * Se crea el evento
     * @param array $data
     * @return Array
     * @author Sofia O
     */
    public function crearEvento(array $data)
    {
        return $this->eventoModel->create($data);
    }

    /**
     * Buscar evento por el id, encutra o falla
     * @param int $id
     * @return Model
     * @author Sofia O
     */
    public function buscarEventoPorId(int $id)
    {
        return $this->eventoModel->findOrFail($id);
    }

    /**
     * Actualizar evento
     * @param $data
     * @param $evento
     * @author Sofia O
     */
    public function actualizarEvento($data, $evento)
    {
        $evento->update($data);
        return $evento;
    }

    /**
     * cambiar solo la columna de estado_id y gusdar el cambio
     * @param $evento
     * @param $estado
     * @author Sofia O
     */
    // public function cambiarEstado($evento, $estado)
    // {
    //     $evento->estado_id = $estado;
    //     $evento->save();
    //     return $evento;
    // }
}
