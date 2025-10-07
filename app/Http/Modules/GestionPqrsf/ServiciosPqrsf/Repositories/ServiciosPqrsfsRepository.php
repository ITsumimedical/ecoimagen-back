<?php

namespace App\Http\Modules\GestionPqrsf\ServiciosPqrsf\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\GestionPqrsf\Formulario\Models\Formulariopqrsf;
use App\Http\Modules\GestionPqrsf\ServiciosPqrsf\Models\ServiciosPqrsfs;
use Illuminate\Http\JsonResponse;

class ServiciosPqrsfsRepository extends RepositoryBase
{

    protected $ServiciosModel;

    public function __construct()
    {
        $this->ServiciosModel = new ServiciosPqrsfs();
        parent::__construct($this->ServiciosModel);
    }

    public function listarServicios($data)
    {
        return   $this->ServiciosModel::where('formulario_pqrsf_id', $data['pqr_id'])->with('cup')->get();
    }

    public function crearServicio($cup, $pqr)
    {
        $this->ServiciosModel::create(['cup_id' => $cup, 'formulario_pqrsf_id' => $pqr]);
    }

    public function eliminar($data)
    {
        return   $this->ServiciosModel::find($data['servicio'])->delete();
    }

    /**
     * Actualiza los servicios de un PQRSF
     * @param int $pqrsfId
     * @param array<array<int>> $request
     * @return JsonResponse
     * @author Thomas
     */
    public function actualizarServicios($pqrsfId, $request)
    {
        $pqrsf = Formulariopqrsf::findOrFail($pqrsfId);

        $pqrsf->servicioPqrsf()->syncWithoutDetaching($request['servicios']);

        return response()->json(['message' => 'Servicios actualizadas correctamente.']);
    }

    /**
     * Elimina un servicio de un PQRSF
     * @param int $pqrsfId
     * @param array<int> $request
     * @return JsonResponse
     */
    public function removerServicio($pqrsfId, $request)
    {
        $pqrsf = Formulariopqrsf::findOrFail($pqrsfId);

        // Eliminar la relación en la tabla intermedia
        $pqrsf->servicioPqrsf()->detach($request['servicio']);

        return response()->json(['message' => 'Servicio removido correctamente.']);
    }
}
