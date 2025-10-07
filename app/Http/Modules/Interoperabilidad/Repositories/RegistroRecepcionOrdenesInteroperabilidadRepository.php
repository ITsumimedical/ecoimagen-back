<?php

namespace App\Http\Modules\Interoperabilidad\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Interoperabilidad\Models\RegistroRecepcionOrdenesInteroperabilidad;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class RegistroRecepcionOrdenesInteroperabilidadRepository extends RepositoryBase
{
    protected RegistroRecepcionOrdenesInteroperabilidad $registroRecepcionOrdenesInteroperabilidadModel;
    public function __construct()
    {
        parent::__construct($this->registroRecepcionOrdenesInteroperabilidadModel = new RegistroRecepcionOrdenesInteroperabilidad());
    }

    /**
     * lista los registros de recepcion de ordenes de interoperabilidad
     * @param array $data
     * @return LengthAwarePaginator
     * @author Thomas
     */
    public function listarSeguimiento(array $data): LengthAwarePaginator
    {
        $pagina = max(1, (int) ($data['pagina'] ?? 1));
        $cantidadRegistros = max(1, (int) ($data['cantidadRegistros'] ?? 10));
        $estado = $data['estado'] ?? null;
        $ordenInteroperabilidadId = $data['orden_interoperabilidad_id'] ?? null;

        return $this->registroRecepcionOrdenesInteroperabilidadModel
            ->whereEstado($estado)
            ->whereOrdenInteroperabilidadId($ordenInteroperabilidadId)
            ->paginate($cantidadRegistros, ['*'], 'page', $pagina);
    }
}