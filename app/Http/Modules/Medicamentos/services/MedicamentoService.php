<?php

namespace App\Http\Modules\Medicamentos\Services;

use App\Formats\Medicamentos\AutorizacionOrdenMedicamentoFomag;
use Illuminate\Http\Response;
use App\Http\Modules\Medicamentos\Models\Codesumi;
use App\Http\Modules\Medicamentos\Models\Medicamento;
use App\Http\Modules\Ordenamiento\Models\OrdenArticulo;
use App\Http\Modules\Medicamentos\Repositories\MedicamentoRepository;

class MedicamentoService {

    public function __construct(protected MedicamentoRepository $medicamentoRepository) {
    }

    public function marcarMedicamento($request) {
        return Codesumi::find($request['codesumi_id'])->update(['codigo_lasa' => $request['codigo_lasa']]);
    }

   public function generarAutorizacionFomag(array $data): Response
    {
        $ordenArticulo = OrdenArticulo::with([
            'orden.consulta.afiliado',
            'orden.medico.especialidad'
        ])->findOrFail(data_get($data, 'detalles.id'));

        $formato = new AutorizacionOrdenMedicamentoFomag;

        return $formato->generar(
            $ordenArticulo,
            $data['filtro']
        );
    }

}
