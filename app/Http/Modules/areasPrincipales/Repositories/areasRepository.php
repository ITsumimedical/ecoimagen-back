<?php

namespace App\Http\Modules\areasPrincipales\Repositories;

use App\Http\Modules\areasPrincipales\Models\areas;
use App\Http\Modules\Bases\RepositoryBase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class areasRepository extends RepositoryBase
{

    protected $areas;

    public function __construct()
    {
        $this->areas = new areas();
        parent::__construct($this->areas);
    }

    public function listarArea(Request $request)
    {

        $cantidad = $request->get('cantidad', 10);

        $area = $this->areas->select(
            'areas.id',
            'areas.nombre',
            'areas.descripcion',
            'areas.estado_id',
            'estados.nombre as estadoNombre'
        )
            ->join('estados', 'areas.estado_id', 'estados.id')
            ->where('areas.estado_id', 1)
            ->orderBy('areas.id', 'asc');

        if ($request->has('page')) {
            return $area->paginate($cantidad);
        } else {
            return $area->get();
        }
    }
    public function listarTodos(Request $request)
    {

        $cantidad = $request->get('cantidad', 10);

        $area = $this->areas->select(
            'areas.id',
            'areas.nombre',
            'areas.descripcion',
            'areas.estado_id',
            'estados.nombre as estadoNombre'
        )
            ->join('estados', 'areas.estado_id', 'estados.id')
            ->orderBy('areas.id', 'asc');

        if ($request->has('page')) {
            return $area->paginate($cantidad);
        } else {
            return $area->get();
        }
    }

    public function actualizarArea($id, array $datos)
    {
        try {
            $subcategoria = $this->areas->findOrFail($id);

            $subcategoria->update($datos);

            return $subcategoria;
        } catch (\Exception $e) {
            throw new \Exception("Error al actualizar la subcategoría: " . $e->getMessage());
        }
    }

    public function CambiarEstado($id)
    {
        $canal = $this->areas->find($id);
        if ($canal) {
            $canal->estado_id = $canal->estado_id == 1 ? 2 : 1;
            $canal->save();
            return $canal;
        } else {
            return null;
        }
    }

    /**
     * Metodo para buscar por nombre del area
     * @param string $request
     * @return areas[]|Collection
     * @author Thomas
     */
    public function buscarPorNombre($request)
    {
        return $this->areas
        /** */
            ->where('nombre', 'ILIKE', "%" . $request . "%")
            ->where('estado_id', '1')->get();
    }
}
