<?php

namespace App\Http\Modules\Cups\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Cups\Models\CupEntidad;
use Illuminate\Database\Eloquent\Collection;

class CupEntidadRepository extends RepositoryBase
{
    protected CupEntidad $cupEntidadModel;

    public function __construct()
    {
        $this->cupEntidadModel = new CupEntidad();
        parent::__construct($this->cupEntidadModel);
    }

    /**
     * Listar las relaciones entre cup y entidad
     * @param int $cupId
     * @return Collection
     * @author Thomas
     */
    public function listarCupEntidadPorCup(int $cupId): Collection
    {
        $cupsEntidad = $this->cupEntidadModel
            ->with(['entidad'])
            ->where('cup_id', $cupId)
            ->get();

        return $cupsEntidad;
    }

    /**
     * Edita los detalles de una relación entre cup y entidad
     * @param int $cupEntidadId
     * @param array $data
     * @return bool
     */
    public function editarCupEntidad(int $cupEntidadId, array $data): bool
    {
        $cupEntidad = $this->cupEntidadModel->findOrFail($cupEntidadId);

        return $cupEntidad->update($data);
    }

    public function getCupEntidadByAfiliadoAndCup($entidad_id, $cup_id){
      return CupEntidad::where('entidad_id', $entidad_id)
            ->where('cup_id', $cup_id)
            ->first();
    }
}
