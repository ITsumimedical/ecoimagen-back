<?php

namespace App\Http\Modules\Pqrsf\AreasPqrsf\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\GestionPqrsf\Formulario\Models\Formulariopqrsf;
use App\Http\Modules\Pqrsf\AreasPqrsf\Model\AreasPqrsf;
use Illuminate\Http\JsonResponse;

class AreasPqrsfRepository extends RepositoryBase
{

    protected $areas;

    public function __construct()
    {
        $this->areas = new AreasPqrsf();
        parent::__construct($this->areas);
    }

    public function listarAreas($data)
    {
        return   $this->areas::where('formulario_pqrsf_id', $data['pqr_id'])->with('area')->get();
    }

    public function crearArea($cup, $pqr)
    {
        $this->areas::create(['area_id' => $cup, 'formulario_pqrsf_id' => $pqr]);
    }

    public function eliminar($data)
    {
        return   $this->areas::find($data['area'])->delete();
    }

    public function actualizarArea($data)
    {
        foreach ($data['area_id'] as $area) {
            $this->areas::updateOrCreate(
                [
                    'area_id' => $area,
                    'formulario_pqrsf_id' => $data['pqr_id']
                ],
                []
            );
        }
    }

    /**
     * Actualiza las areas de un PQRSF
     * @param int $pqrsfId
     * @param array<array<int>> $request
     * @return JsonResponse
     * @author Thomas
     */
    public function actualizarAreas($pqrsfId, $request)
    {
        $pqrsf = Formulariopqrsf::findOrFail($pqrsfId);

        $pqrsf->areaPqrsf()->syncWithoutDetaching($request['areas']);

        return response()->json(['message' => 'Areas actualizadas correctamente.']);
    }

    /**
     * Elimina una area de un PQRSF
     * @param int $pqrsfId
     * @param array<int> $request
     * @return JsonResponse
     * @author Thomas
     */
    public function removerArea($pqrsfId, $request)
    {
        $pqrsf = Formulariopqrsf::findOrFail($pqrsfId);

        // Eliminar la relación en la tabla intermedia
        $pqrsf->areaPqrsf()->detach($request['area']);

        return response()->json(['message' => 'Área removida correctamente.']);
    }
}
