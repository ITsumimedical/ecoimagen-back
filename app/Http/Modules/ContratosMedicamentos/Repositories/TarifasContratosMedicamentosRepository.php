<?php

namespace App\Http\Modules\ContratosMedicamentos\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\ContratosMedicamentos\Models\TarifasContratosMedicamentos;
use Auth;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class TarifasContratosMedicamentosRepository extends RepositoryBase
{
    protected TarifasContratosMedicamentos $tarifasContratosMedicamentosModel;

    public function __construct()
    {
        $this->tarifasContratosMedicamentosModel = new TarifasContratosMedicamentos();
        parent::__construct($this->tarifasContratosMedicamentosModel);
    }

    /**
     * Crea una nueva tarifa
     * @param array $data
     * @return TarifasContratosMedicamentos
     * @author Thomas
     */
    public function crearTarifa(array $data): TarifasContratosMedicamentos
    {

        $datosTarifa = $data + [
            'estado_id' => 1,
            'creado_por' => Auth::id()
        ];
        return $this->tarifasContratosMedicamentosModel->create($datosTarifa);
    }

    /**
     * Lista las tarifas de un contrato de medicamentos
     * @param array $request
     * @return Collection
     * @author Thomas
     */
    public function listarTarifasContrato(array $request): Collection
    {
        $contratoId = $request['contrato'];

        return $this->tarifasContratosMedicamentosModel
            ->with([
                'contrato:id,estado_id',
                'rep:id,nombre',
                'manualTarifario:id,nombre',
                'estado:id,nombre',
            ])
            ->where('contrato_medicamentos_id', $contratoId)
            ->get();
    }

    /**
     * Listar detalles de una tarifa
     * @param int $tarifaId
     * @return Model|null
     * @author Thomas
     */
    public function listarDetallesTarifa(int $tarifaId): ?Model
    {
        return $this->tarifasContratosMedicamentosModel
            ->with(['rep:id,nombre',])
            ->where('id', $tarifaId)
            ->first();
    }

    /**
     * Actualiza una tarifa
     * @param int $tarifaId
     * @param array $data
     * @return bool
     * @author Thomas
     */
    public function editarTarifa(int $tarifaId, array $data): bool
    {
        $tarifa = $this->tarifasContratosMedicamentosModel->findOrFail($tarifaId);
        return $tarifa->update($data);
    }

    /**
     * Cambia el estado de una tarifa, si no se propociona se cambia al estado activo o inactivo dependiendo del estado actual
     * @param int $tarifaId
     * @param int|null $estadoId
     * @return bool
     * @author Thomas
     */
    public function cambiarEstadoTarifa(int $tarifaId, int|null $estadoId): bool
    {
        $tarifa = $this->tarifasContratosMedicamentosModel->findOrFail($tarifaId);

        $estadoActivo = 1;
        $estadoInactivo = 2;

        // Alternar estado si no se proporciona
        $estadoNuevo = $estadoId ?? ($tarifa->estado_id == $estadoActivo ? $estadoInactivo : $estadoActivo);

        return $tarifa->update(['estado_id' => $estadoNuevo]);
    }
}
