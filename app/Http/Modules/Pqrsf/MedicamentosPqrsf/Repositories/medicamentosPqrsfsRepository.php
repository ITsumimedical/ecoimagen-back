<?php

namespace App\Http\Modules\Pqrsf\MedicamentosPqrsf\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\GestionPqrsf\Formulario\Models\Formulariopqrsf;
use App\Http\Modules\Pqrsf\MedicamentosPqrsf\Model\medicamentosPqrsfs;
use Illuminate\Http\JsonResponse;

class medicamentosPqrsfsRepository extends RepositoryBase
{

    protected $medicamentos;

    public function __construct()
    {
        $this->medicamentos = new medicamentosPqrsfs();
        parent::__construct($this->medicamentos);
    }

    public function listarMedicamentos($data)
    {
        return   $this->medicamentos::where('formulario_pqrsf_id', $data['pqr_id'])->with('medicamento.codesumi')->get();
    }

    public function crearMedicamento($medicamento, $pqr)
    {
        $this->medicamentos::create(['medicamento_id' => $medicamento, 'formulario_pqrsf_id' => $pqr]);
    }

    public function eliminar($data)
    {
        return   $this->medicamentos::find($data['medicamento'])->delete();
    }

    /**
     * Actualiza los codesumis de un PQRSF
     * @param int $pqrsfId
     * @param array<array<int>> $request  // Array de IDs de codesumis
     * @return JsonResponse
     * @author Thomas
     */
    public function actualizarCodesumi($pqrsfId, $request)
    {
        $pqrsf = Formulariopqrsf::findOrFail($pqrsfId);

        $pqrsf->codesumiPqrsf()->syncWithoutDetaching($request['codesumis']);

        return response()->json(['message' => 'Medicamentos actualizados correctamente.']);
    }

    /**
     * Elimina un codesumi de un PQRSF
     * 
     * @param int $pqrsfId
     * @param array<int> $request  // ID del codesumi a remover
     * @return JsonResponse
     * @author Thomas
     */
    public function removerCodesumi($pqrsfId, $request)
    {
        $pqrsf = Formulariopqrsf::findOrFail($pqrsfId);

        // Eliminar la relación en la tabla intermedia
        $pqrsf->codesumiPqrsf()->detach($request['codesumi']);

        return response()->json(['message' => 'Medicamento removido correctamente.']);
    }
}
