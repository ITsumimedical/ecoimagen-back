<?php

namespace App\Http\Modules\Subcategorias\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Subcategorias\Models\Subcategorias;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class subcategoriasRepository extends RepositoryBase
{


    public function __construct(protected Subcategorias $subcategoriaModel)
    {
        parent::__construct($this->subcategoriaModel);
    }

    public function listarSubcategorias(Request $request)
    {
        $cantidad = $request->get('cantidad', 10);

        $subcategorias = $this->subcategoriaModel->select(
            'subcategorias.id',
            'subcategorias.categoria_id',
            'subcategorias.nombre',
            'subcategorias.descripcion',
            'subcategorias.estado_id',
            'estados.nombre as nombreEstado',
            $this->subcategoriaModel->raw('TRIM(categorias.nombre) as categoria')
        )->with(['derechos'])
            ->join('categorias', 'subcategorias.categoria_id', 'categorias.id')
            ->leftjoin('estados', 'subcategorias.estado_id', 'estados.id')
            ->where('subcategorias.estado_id', 1)
            ->orderBy('subcategorias.id', 'asc');
        if ($request->has('page')) {
            return $subcategorias->paginate($cantidad);
        } else {
            return $subcategorias->get();
        }
    }
    public function listarTodos(Request $request)
    {
        $cantidad = $request->get('cantidad', 10);

        $subcategorias = $this->subcategoriaModel->select(
            'subcategorias.id',
            'subcategorias.categoria_id',
            'subcategorias.nombre',
            'subcategorias.descripcion',
            'subcategorias.estado_id',
            'estados.nombre as nombreEstado',
            $this->subcategoriaModel->raw('TRIM(categorias.nombre) as categoria')
        )
            ->join('categorias', 'subcategorias.categoria_id', 'categorias.id')
            ->join('estados', 'subcategorias.estado_id', 'estados.id')
            ->orderBy('subcategorias.id', 'asc');
        if ($request->has('page')) {
            return $subcategorias->paginate($cantidad);
        } else {
            return $subcategorias->get();
        }
    }

    public function actualizarSubcategoria($id, array $datos)
    {
        try {
            $subcategoria = $this->subcategoriaModel->findOrFail($id);

            $subcategoria->update($datos);

            return $subcategoria;
        } catch (\Exception $e) {
            throw new \Exception("Error al actualizar la subcategoría: " . $e->getMessage());
        }
    }

    public function CambiarEstado($id)
    {
        $canal = $this->subcategoriaModel->find($id);
        if ($canal) {
            $canal->estado_id = $canal->estado_id == 1 ? 2 : 1;
            $canal->save();
            return $canal;
        } else {
            return null;
        }
    }


    /**
     * Obtiene una subcategoría por su ID
     * @param int $subcategoriaId
     * @return Model|null
     * @author Thomas
     */
    public function listarPorId($subcategoriaId)
    {
        return $this->subcategoriaModel->with(['derechos'])->where("id", $subcategoriaId)->first();
    }

    /**
     * Elimina los derechos asignados a una subcategoría
     * @param int $subcategoriaId
     * @param array $request array de IDs de derechos
     * @return JsonResponse
     * @author Thomas
     */
    public function eliminarDerechosAsignados($subcategoriaId, $request)
    {
        // Encuentra la subcategoría por su ID
        $subcategoria = $this->subcategoriaModel->findOrFail($subcategoriaId);

        // Elimina los derechos que se envían en el request (array de IDs de derechos)
        if (isset($request['derechos']) && is_array($request['derechos'])) {
            $subcategoria->derechos()->detach($request['derechos']);
        }

        return response()->json([
            'mensaje' => 'Derechos eliminados correctamente.'
        ]);
    }


    /**
     * Asigna los derechos a una subcategoría
     * @param int $subcategoriaId
     * @param array $request array de IDs de derechos
     * @return JsonResponse
     * @author Thomas
     */
    public function asignarDerechos($subcategoriaId, $request)
    {
        // Encuentra la subcategoría por su ID
        $subcategoria = $this->subcategoriaModel->findOrFail($subcategoriaId);

        // Asigna los nuevos derechos (array de IDs de derechos)
        if (isset($request['derechos']) && is_array($request['derechos'])) {
            $subcategoria->derechos()->syncWithoutDetaching($request['derechos']);
        }

        return response()->json([
            'mensaje' => 'Derechos asignados correctamente.'
        ]);
    }

    /**
     * Obtiene los derechos de una subcategoría por sus IDs, elimina duplicados
     * @param array $request array de IDs de subcategorías
     * @return Collection
     * @author Thomas
     */
    public function listarDerechosSubcategorias($request)
    {
        $subcategorias = $request['subcategorias'];

        $derechos = $this->subcategoriaModel->whereIn('id', $subcategorias)->with('derechos')->get()->pluck('derechos')->flatten()->unique('id');

        return $derechos;
    }
}
