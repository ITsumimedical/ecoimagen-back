<?php

namespace App\Http\Modules\ProgramasFarmacia\Repositories;


use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\ProgramasFarmacia\Models\ProgramasFarmacia;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ProgramasFarmaciaRepository extends RepositoryBase
{
    protected $programaFarmaciaModel;

    public function __construct()
    {

        $this->programaFarmaciaModel = new ProgramasFarmacia();
        parent::__construct($this->programaFarmaciaModel);
    }

    public function actualizar($data, $id)
    {
        $programa = $this->programaFarmaciaModel::find($id);
        if ($programa) {
            $programa->update($data);
            return $programa;
        } else {
            throw new Exception('programa no encontrado');
        }
    }

    public function cambiarEstado($id)
    {
        $programa = $this->programaFarmaciaModel::find($id);
        if ($programa) {
            $programa->activo = $programa->activo == 1 ? 0 : 1;
            $programa->save();
            return $programa;
        } else {
            throw new Exception('programa no encontrado');
        }
    }

    /**
     * Asocia los diagnósticos al programa, si ya esté asociado a otro programa, lanzar excepción
     * @param $programaId
     * @param $diagnosticos
     * @return array
     * @throws Exception
     * @author Thomas
     */
    public function asociarDiagnosticos($programaId, $diagnosticos): array
    {
        $programa = $this->programaFarmaciaModel->findOrFail($programaId);

        // Obtener IDs de diagnósticos que se desean asociar
        $diagnosticosIds = $diagnosticos['diagnosticos'];

        // Buscar si alguno de los diagnósticos ya está asociado a otro programa
        $diagnosticosExistentes = $this->programaFarmaciaModel
            ->whereHas('diagnosticos', function ($query) use ($diagnosticosIds, $programaId) {
                $query->whereIn('cie10_id', $diagnosticosIds)
                    ->where('programa_farmacia_id', '!=', $programaId);
            })->exists();

        // Si ya están asociados a otro programa, lanzar excepción
        if ($diagnosticosExistentes) {
            throw new Exception("Uno o más de los diagnósticos selecionados ya están asociados a otro programa.");
        }

        // Asociar diagnósticos al programa actual
        return $programa->diagnosticos()->syncWithoutDetaching($diagnosticosIds);
    }

    /**
     * Listar los diagnósticos de un programa
     * @param int $programaId
     * @return Collection
     * @author Thomas
     */
    public function listarDiagnosticosPrograma(int $programaId): Collection
    {
        return $this->programaFarmaciaModel->find($programaId)->diagnosticos()->get();
    }

    /**
     * Remover los diagnósticos de un programa
     * @param $programaId
     * @param $diagnosticos
     * @return int
     * @author Thomas
     */
    public function removerDiagnosticos($programaId, $diagnosticos): int
    {
        $programa = $this->programaFarmaciaModel->findOrFail($programaId);

        return $programa->diagnosticos()->detach($diagnosticos['diagnosticos']);
    }
}
