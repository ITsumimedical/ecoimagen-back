<?php

namespace App\Http\Modules\Caracterizacion\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Caracterizacion\Models\IntegrantesFamiliaCaracterizacionEcis;
use Illuminate\Support\Collection;

class IntegrantesFamiliaCaracterizacionEcisRepository extends RepositoryBase
{
    protected IntegrantesFamiliaCaracterizacionEcis $integrantesFamiliaCaracterizacionEcisModel;

    public function __construct()
    {
        parent::__construct($this->integrantesFamiliaCaracterizacionEcisModel = new IntegrantesFamiliaCaracterizacionEcis());
    }

    /**
     * Listar los integrantes de familia de un afiliado
     * @param int $afiliado_id
     * @return Collection
     * @author Thomas
     */
    public function listarIntegrantesFamilia(int $afiliado_id): Collection
    {
        return $this->integrantesFamiliaCaracterizacionEcisModel
            ->with(['tipo_documento', 'tipo_afiliacion', 'entidad'])
            ->whereHas('afiliados', function ($query) use ($afiliado_id) {
                $query->where('afiliado_id', $afiliado_id);
            })
            ->get();
    }

    /**
     * Eliminar un integrante de familia de un afiliado
     * @param int $integrante_id
     * @param int $afiliado_id
     * @return bool
     * @author Thomas
     */
    public function eliminarIntegranteFamiliaAfiliado(int $integrante_id, int $afiliado_id): bool
    {
        $integrante = $this->integrantesFamiliaCaracterizacionEcisModel->findOrFail($integrante_id);

        // Detach con relación inversa
        return $integrante->afiliados()->detach($afiliado_id) > 0;
    }

}