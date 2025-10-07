<?php

namespace App\Http\Modules\Codesumis\codesumis\Services;

use App\Http\Modules\Afiliados\Repositories\AfiliadoRepository;
use App\Http\Modules\ContratosMedicamentos\Repositories\TarifasCumsRepository;
use App\Http\Modules\Medicamentos\Models\Codesumi;
use App\Http\Modules\Medicamentos\Repositories\MedicamentoRepository;
use App\Http\Modules\Tarifas\Repositories\TarifaRepository;

class CodesumiService
{

    public function __construct(
        private readonly MedicamentoRepository $medicamentoRepository,
        private readonly TarifasCumsRepository $tarifasCumsRepository,
        private readonly TarifaRepository $tarifaRepository,
        private readonly AfiliadoRepository $afiliadoRepository
    ) {
    }

    public function agregarViasAdministracionCodesumi($request)
    {
        $codesumi = Codesumi::where('id', $request['codesumi_id'])->first();
        $codesumi->viasAdministracion()->sync($request['vias_administracion_id']);
        return $codesumi->viasAdministracion;
    }

    /**
     * Valida si un medicamento tiene contrato con la IPS del afiliado
     * @param int $afiliadoId
     * @param int $codesumiId
     * @return bool
     * @author Thomas
     */
    public function validarContratacionCodesumi($afiliadoId, $codesumiId): bool
    {
        // Obtener los medicamentos
        $medicamentos = $this->medicamentoRepository->obtenerMedicamentosPorCodesumi($codesumiId);
        $medicamentosCum = $medicamentos->pluck('cum')->toArray();

        // Obtener los registros de Tarifas asociados a esos cums
        $tarifasCums = $this->tarifasCumsRepository->listarTodosPorCum($medicamentosCum);
        $idsTarifas = $tarifasCums->pluck('tarifa_id')->toArray();

        // Listar las tarifas
        $tarifas = $this->tarifaRepository->listarTarifasPorIds($idsTarifas);

        // Buscar afiliado
        $afiliado = $this->afiliadoRepository->buscarAfiliadoPorId($afiliadoId);

        $ipsId = $afiliado->ips_id;

        // Verificar si alguna tarifa tiene el mismo rep_id que el ips_id del afiliado
        $contratado = $tarifas->contains(function ($tarifa) use ($ipsId) {
            return $tarifa->rep_id === $ipsId;
        });

        return $contratado;
    }

}
