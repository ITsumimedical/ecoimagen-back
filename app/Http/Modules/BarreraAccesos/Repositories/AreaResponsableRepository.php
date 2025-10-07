<?php

namespace App\Http\Modules\BarreraAccesos\Repositories;

use App\Http\Modules\BarreraAccesos\Models\AreaResponsableBarreraAcceso;
use App\Http\Modules\Bases\RepositoryBase;

class AreaResponsableRepository extends RepositoryBase {
    public function __construct(protected AreaResponsableBarreraAcceso $areaResponsableBarreraAcceso)
    {}

    /**
     * Listar todas las areas responsables
     * @author Sofia O
     */
    public function listarAreaResponsables()
    {
        return $this->areaResponsableBarreraAcceso
            ->with('responsables')
            ->orderBy('id', 'asc');
    }


    /**
     * Listar solo las areas responsables activas
     * @param array $data
     * @return Array
     * @author Sofia O
     */
    public function listarActivas(array $data)
    {
        return $this->areaResponsableBarreraAcceso
            ->with('responsables')
            ->whereNombreArea($data['nombre'])
            ->where('estado_id', 1)
            ->orderBy('id', 'asc')
            ->get();
    }


    /**
     * Crear area responsable
     * @param array $data
     * @return Array
     * @author Sofia O
     */
    public function crearAreaResponsable(array $data)
    {
        return $this->areaResponsableBarreraAcceso->create($data);
    }


    /**
     * Buscar area responsable
     * @param int $id
     * @return Model
     * @author Sofia O
     */
    public function buscarAreaResponsableBarreraAccesoId(int $id)
    {
        return $this->areaResponsableBarreraAcceso->findOrFail($id);
    }


    /**
     * Actualizar area responsable
     * @param $data
     * @param $areaResponsable
     * @return $areaResponsable
     * @author Sofia O
     */
    public function actualizarAreaResponsable($data, $areaResponsable)
    {
        return $areaResponsable->update($data);
    }
}
