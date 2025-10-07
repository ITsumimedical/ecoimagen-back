<?php

namespace App\Http\Modules\Ordenamiento\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Ordenamiento\Models\OrdenArticuloIntrahospitalario;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class OrdenArticuloIntrahospitalarioRepository extends RepositoryBase
{
    protected OrdenArticuloIntrahospitalario $ordenArticuloIntrahospitalarioModel;

    public function __construct()
    {
        parent::__construct($this->ordenArticuloIntrahospitalarioModel = new OrdenArticuloIntrahospitalario());
    }

    /**
     * Lista los artículos intrahospitalarios ordenados en una consulta
     * @param int $consultaId
     * @return Collection
     * @author Thomas
     */
    public function listarArticulosIntrahospitalariosOrdenadosConsulta(int $consultaId): Collection
    {
        return $this->ordenArticuloIntrahospitalarioModel
            ->with(['codesumi', 'estado', 'viaAdministracion'])
            ->whereHas('orden', function ($query) use ($consultaId) {
                $query->where('consulta_id', $consultaId);
            })->get();
    }

    /**
     * Lista el histórico de órdenes intrahospitalarias por el ID del afiliado
     * @param int $afiliadoId
     * @param array $data
     * @return LengthAwarePaginator
     * @author Thomas
     */
    public function listarHistoricoOrdenesIntrahospitalariasAfiliado(int $afiliadoId, array $data): LengthAwarePaginator
    {
        return $this->ordenArticuloIntrahospitalarioModel
            ->with(['codesumi', 'estado', 'viaAdministracion'])
            ->whereHas('orden.consulta', function ($query) use ($afiliadoId) {
                $query->where('afiliado_id', $afiliadoId);
            })->paginate($data['cantidadRegistros'], ['*'], 'page', $data['pagina']);
    }

    /**
     * Lista el histórico de órdenes intrahospitalarias por el tipo y número de documento del afiliado
     * @param int $tipoDocumentoId
     * @param string $numeroDocumento
     * @param array $data
     * @return LengthAwarePaginator
     * @author Thomas
     */
    public function listarHistoricoOrdenesIntrahospitalarias(int $tipoDocumentoId, string $numeroDocumento, array $data): LengthAwarePaginator
    {
        return $this->ordenArticuloIntrahospitalarioModel
            ->with(['codesumi', 'estado', 'viaAdministracion', 'userCrea.operador'])
            ->whereHas('orden.consulta.afiliado', function ($query) use ($tipoDocumentoId, $numeroDocumento) {
                $query
                    ->where('tipo_documento', $tipoDocumentoId)
                    ->where('numero_documento', $numeroDocumento);
            })
            ->paginate($data['cantidadRegistros'], ['*'], 'page', $data['pagina']);
    }
}
