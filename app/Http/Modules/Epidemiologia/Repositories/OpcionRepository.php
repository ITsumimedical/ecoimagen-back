<?php

namespace App\Http\Modules\Epidemiologia\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Epidemiologia\Models\OpcionesCampoSivigila;

class OpcionRepository extends RepositoryBase
{
    public function __construct(private OpcionesCampoSivigila $opcionesCampoSivigila) {}

    /**
     * listar todad las Opcion y filtros
     * @param array $data
     * @author Sofia O
     */
    public function buscarOpciones(array $data)
    {
        return $this->opcionesCampoSivigila
            ->with('campoSivigila.cabeceraSivigila.eventoSivigila:id,nombre_evento')
            ->whereOpcionId($data['opcion_id'] ?? null)
            ->whereNombreOpcion($data['opcion'] ?? null)
            ->whereCampoId($data['campo_id'] ?? null)
            ->whereCabeceraId($data['cabecera_id'] ?? null)
            ->whereEventoNombre($data['evento'] ?? null)
            ->orderBy('id', 'asc');
    }

    /**
     * Crear Opcion
     * @param array $data
     * @return Array
     * @author Sofia O
     */
    public function crearOpcion(array $data)
    {
        return $this->opcionesCampoSivigila->create($data);
    }

    /**
     * Buscar opcion por el id, encutra o falla
     * @param int $id
     * @return Model
     * @author Sofia O
     */
    public function buscarOpcionPorId(int $id)
    {
        return $this->opcionesCampoSivigila->findOrFail($id);
    }

    /**
     * Actualizar opcion
     * @param $data
     * @param $opcion
     * @author Sofia O
     */
    public function actualizarOpcion($data, $opcion)
    {
        $opcion->update($data);
        return $opcion;
    }

    /**
     * cambiar solo la columna de estado_id y gusdar el cambio
     * @param $opcion
     * @param $estado
     * @author Sofia O
     */
    // public function cambiarEstado($opcion, $estado)
    // {
    //     $opcion->estado_id = $estado;
    //     $opcion->save();
    //     return $opcion;
    // }

    /**
     * listar las Opcion por evento
     * @param $data
     * @author Sofia O
     */
    public function buscarOpcionesPorEventoId($data)
    {
        return $this->opcionesCampoSivigila
            ->with('campoSivigila.cabeceraSivigila.eventoSivigila:id,nombre_evento')
            ->whereHas('campoSivigila.cabeceraSivigila.eventoSivigila', function ($query) use ($data) {
                $query->where('id', $data['id']);
            })
            ->orderBy('id', 'asc')
            ->get();
    }
}
