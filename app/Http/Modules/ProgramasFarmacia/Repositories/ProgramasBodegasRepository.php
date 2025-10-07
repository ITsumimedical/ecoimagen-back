<?php

namespace App\Http\Modules\ProgramasFarmacia\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Bodegas\Models\Bodega;
use App\Http\Modules\ProgramasFarmacia\Models\ProgramasFarmacia;
use App\Http\Modules\ProgramasFarmacia\Models\ProgramasFarmaciaBodegas;
use Illuminate\Database\Eloquent\Collection;

class ProgramasBodegasRepository extends RepositoryBase
{

    protected $programaFarmaciaModel;

    public function __construct()
    {

        $this->programaFarmaciaModel = new ProgramasFarmaciaBodegas();
        parent::__construct($this->programaFarmaciaModel);
    }

    public function AñadirBodegaPrograma(int $programaFarmaciaId, array $bodegaIds): bool
    {
        // Encontrar el programa de farmacia por su ID
        $programaFarmacia = ProgramasFarmacia::find($programaFarmaciaId);
        if (!$programaFarmacia) {
            return false;
        }

        // Encontrar las bodegas por sus IDs
        $bodegas = Bodega::findMany($bodegaIds);
        if ($bodegas->isEmpty()) {
            return false;
        }

        // Obtener las bodegas ya asignadas al programa
        $bodegasAsignadas = $programaFarmacia->bodegas()->pluck('bodega_id')->toArray();

        // Verificar si alguna de las bodegas ya está asignada al programa
        foreach ($bodegaIds as $bodegaId) {
            if (in_array($bodegaId, $bodegasAsignadas)) {
                return false;
            }
        }

        // Asignar las nuevas bodegas al programa
        $programaFarmacia->bodegas()->attach($bodegaIds);
        return true;
    }


    public function listarBodegasPorPrograma(int $programaFarmaciaId): ?Collection
    {
        $programaFarmacia = ProgramasFarmacia::find($programaFarmaciaId);
        if (!$programaFarmacia) {
            return null;
        }

        return $programaFarmacia->bodegas;
    }

    public function eliminarBodegasPrograma(int $programaFarmaciaId, array $bodegaIds): bool
    {
        // Encontrar el programa de farmacia por su ID
        $programaFarmacia = ProgramasFarmacia::find($programaFarmaciaId);
        if (!$programaFarmacia) {
            return false;
        }

        // Eliminar la relación entre el programa y las bodegas
        $programaFarmacia->bodegas()->detach($bodegaIds);
        return true;
    }
}
