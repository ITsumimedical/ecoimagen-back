<?php

namespace App\Http\Modules\Pqrsf\SubcategoriasPqrsf\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\GestionPqrsf\Formulario\Models\Formulariopqrsf;
use App\Http\Modules\Pqrsf\SubcategoriasPqrsf\Models\subcategoriasPqrsf;
use Illuminate\Http\JsonResponse;

class SubcategoriaPqrsfRepository extends RepositoryBase
{

    public function __construct(protected subcategoriasPqrsf $subcategoriasPqrsftModel)
    {
        parent::__construct($this->subcategoriasPqrsftModel);
    }

    public function crearSub($subcategoria, $pqr)
    {

        $this->subcategoriasPqrsftModel::create(['subcategoria_id' => $subcategoria, 'formulariopqrsf_id' => $pqr]);
    }


    public function listarSub($data)
    {
        return $this->subcategoriasPqrsftModel::where('formulariopqrsf_id', $data['pqr_id'])
            ->with('subcategoria')
            ->get();
    }


    public function eliminar($data)
    {
        return   $this->subcategoriasPqrsftModel::find($data['sub'])->delete();
    }


    public function actualizarSub($data)
    {
        foreach ($data['subcategoria_id'] as $sub) {
            $this->subcategoriasPqrsftModel::updateOrCreate(
                [
                    'subcategoria_id' => $sub,
                    'formulariopqrsf_id' => $data['pqr_id']
                ],
                []
            );
        }
    }

    /**
     * Actualiza las subcategorías de un PQRSF
     * 
     * @param int $pqrsfId
     * @param array<array<int>> $request  // Array de IDs de subcategorías
     * @return JsonResponse
     * @author Thomas
     */
    public function actualizarSubcategorias($pqrsfId, $request)
    {

        $pqrsf = Formulariopqrsf::findOrFail($pqrsfId);

        $pqrsf->subcategoriaPqrsf()->sync($request['subcategorias']);

        return response()->json(['message' => 'Subcategorias actualizadas correctamente.']);
    }
}
