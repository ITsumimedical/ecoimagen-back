<?php

namespace App\Http\Modules\ContratosMedicamentos\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\ContratosMedicamentos\Models\TarifasCums;
use App\Http\Modules\Medicamentos\Models\Cum;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class TarifasCumsRepository extends RepositoryBase
{
    protected TarifasCums $tarifasCumsModel;
    protected Cum $cumModel;

    public function __construct()
    {
        $this->tarifasCumsModel = new TarifasCums();
        $this->cumModel = new Cum();
        parent::__construct($this->tarifasCumsModel);
    }


    /**
     * Lista los cums de una tarifa
     * @param array $request
     * @return LengthAwarePaginator
     * @author Thomas
     */
    public function listarCumsTarifa(array $request): LengthAwarePaginator
    {
        $tarifaId = $request['tarifa'];

        return $this->tarifasCumsModel
            ->with([
                'creado_por.operador'
            ])
            ->where('tarifa_id', $tarifaId)
            ->paginate($request['cantidadRegistros'], ['*'], 'page', $request['pagina']);
    }

    /**
     * Aplica Soft Delete a un cum de tarifa
     * @param int $cumTarifaId
     * @return bool
     * @author Thomas
     */
    public function eliminarCumTarifa(int $cumTarifaId): bool
    {
        $cumTarifa = $this->tarifasCumsModel->findOrFail($cumTarifaId);
        return $cumTarifa->delete();
    }

    /**
     * Cambia el precio de un cum de tarifa
     * @param int $cumTarifaId
     * @param array $data
     * @return bool
     * @author Thomas
     */
    public function cambiarPrecioCumTarifa(int $cumTarifaId, array $data): bool
    {
        $cumTarifa = $this->tarifasCumsModel->findOrFail($cumTarifaId);

        return $cumTarifa->update($data);
    }

    /**
     * Busca un cum de tarifa por su cum_validacion
     * @param string $cumValidacion
     * @return TarifasCums|null
     * @author Thomas
     */
    public function buscarPorCumValidacion(string $cumValidacion): ?TarifasCums
    {
        return $this->tarifasCumsModel->where('cum_validacion', $cumValidacion)->first();
    }

    /**
     * @param array $cums
     * @param $tarifaId
     * @return array
     * @author Thomas
     */
    public function validarExistencias(array $cums, $tarifaId): array
    {
        return $this->tarifasCumsModel
            ->whereIn('cum_validacion', $cums)
            ->where('tarifa_id', $tarifaId)
            ->pluck('cum_validacion')
            ->toArray();
    }

    /**
     * Valida si los CUMs existen en la tabla `cums` y están activos
     * @param array $cums
     * @return array
     * @author Thomas
     */
    public function validarCumsActivos(array $cums): array
    {
        return $this->cumModel
            ->whereIn('cum_validacion', $cums)
            ->where('estado_registro', 'Vigente')
            ->pluck('cum_validacion')
            ->toArray();
    }

    /**
     * Inserta múltiples registros en la tabla tarifas_cums
     * @param array $registros
     * @return void
     * @author Thomas
     */
    public function insertarRegistros(array $registros): void
    {
        $this->tarifasCumsModel->insert($registros);
    }

    /**
     * Lista todos los registros por el Cum Validacion
     * @param array $cumsValidacion
     * @return Collection
     * @author Thomas
     */
    public function listarTodosPorCum(array $cumsValidacion): Collection
    {
        return $this->tarifasCumsModel->whereIn('cum_validacion', $cumsValidacion)->get();
    }

}
