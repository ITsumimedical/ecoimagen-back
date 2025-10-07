<?php

namespace App\Http\Modules\BodegasReps\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Bodegas\Models\Bodega;
use App\Http\Modules\BodegasReps\Model\BodegasReps;
use App\Http\Modules\Reps\Models\Rep;
use Illuminate\Database\Eloquent\Collection;

class BodegaRepRepository extends RepositoryBase
{
    protected $bodegaRepModel;

    public function __construct()
    {
        $this->bodegaRepModel = new BodegasReps();
        parent::__construct($this->bodegaRepModel);
    }

    /**
     * Asigna reps a una bodega asegurando que ya no estén registrados.
     *
     * @param array $data Contiene 'bodega_id' y 'idsReps' (array de rep_id a asignar).
     * @return bool Devuelve true si la inserción fue exitosa.
     * @throws \Exception Si uno o más reps ya están asignados.
     * @author Thomas
     */

    public function añadirRepsABodega(array $data): bool
    {
        $bodegaId = $data['bodega_id'];
        $idsReps = $data['idsReps'];

        // Verificar si alguno de los reps ya está asignado a cualquier bodega
        $repsExistentes = $this->bodegaRepModel
            ->whereIn('rep_id', $idsReps)
            ->exists();

        if ($repsExistentes) {
            throw new \Exception("Una o más Sedes ya están asignadas a esta u otra bodega.");
        }

        $createdAt = now();
        $updatedAt = now();

        $dataInsert = array_map(fn($repId) => [
            'bodega_id' => $bodegaId,
            'rep_id' => $repId,
            'created_at' => $createdAt,
            'updated_at' => $updatedAt
        ], $idsReps);

        $this->bodegaRepModel->insert($dataInsert);

        return true;
    }


    public function listarRepsPorBodega(int $bodegaId): ?Collection
    {
        $bodega = Bodega::find($bodegaId);
        if (!$bodega) {
            return null;
        }

        return $bodega->reps;
    }

    public function eliminarRepsBodega(int $bodegaId, array $repIds): bool
    {
        // Encontrar la bodega por su ID
        $bodega = Bodega::find($bodegaId);
        if (!$bodega) {
            return false;
        }

        // Eliminar la relación entre la bodega y los reps
        $bodega->reps()->detach($repIds);
        return true;
    }

    /**
     * Busca un BodegasReps por su rep_id
     * @param int $repId
     * @return BodegasReps|null
     * @author Thomas
     */
    public function buscarPorRepId(int $repId): ?BodegasReps
    {
        return $this->bodegaRepModel->where('rep_id', $repId)->first();
    }
}
