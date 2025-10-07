<?php

namespace App\Http\Modules\BarreraAccesos\Repositories;

use App\Http\Modules\BarreraAccesos\Models\ResponsableBarreraAcceso;
use App\Http\Modules\Bases\RepositoryBase;

class ResponsableRepository extends RepositoryBase
{
    public function __construct(protected ResponsableBarreraAcceso $responsableBarreraAcceso) {}

    /**
     * Listar todos los responsables
     * @author Sofia O
     */
    public function listarResponsables()
    {
        return $this->responsableBarreraAcceso
            ->with('areaResponsable:id,nombre')
            ->orderBy('id', 'asc');
    }

    /**
     * Listar solo los responsables activos
     * @param array $data
     * @return Array
     * @author Sofia O
     */
    public function listarActivos(array $data)
    {
        return $this->responsableBarreraAcceso
            ->with('areaResponsable')
            ->whereResponsableNombre($data['nombre'] ?? null)
            ->where('estado_id', 1)
            ->orderBy('id', 'asc')
            ->get();
    }

    /**
     * Crear responsable
     * @param array $data
     * @return Array
     * @author Sofia O
     */
    public function crearResponsable(array $data)
    {
        return $this->responsableBarreraAcceso->create($data);
    }

    /**
     * Buscar responsable
     * @param int $id
     * @return Model
     * @author Sofia O
     */
    public function buscarResponsableBarreraAccesoId(int $id)
    {
        return $this->responsableBarreraAcceso->findOrFail($id);
    }

    /**
     * Actualizar responsable
     * @param $data
     * @param $responsable
     * @return $responsable
     * @author Sofia O
     */
    public function actualizarresponsable($data, $responsable)
    {
        return $responsable->update($data);
    }

    /**
     * listar y bucar los responsables corespondienteas a cada area
     * @param int $id
     * @return Collection
     * @author Sofia O
     */
    public function buscarResponsableArea(int $id)
    {
        return $this->responsableBarreraAcceso
            ->whereAreaResponsables($id)
            ->get();
    }

    /**
     * listar y bucar los responsables corespondienteas a cada barrera de acceso
     * @param int $id
     * @return Collection
     * @author Sofia O
     */
    public function buscarResponsablesBarrera(int $id)
    {
        return $this->responsableBarreraAcceso
            ->whereBarreraId($id)
            ->get();
    }
}
