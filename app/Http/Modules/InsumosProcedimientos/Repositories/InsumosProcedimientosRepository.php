<?php

namespace App\Http\Modules\InsumosProcedimientos\Repositories;

use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Historia\Models\HistoriaClinica;
use App\Http\Modules\InsumosProcedimientos\Models\InsumosProcedimientosModel;
use Illuminate\Http\Request;

class InsumosProcedimientosRepository
{
    protected $insumosModel;

    public function __construct(InsumosProcedimientosModel $insumosModel)
    {
        $this->insumosModel = $insumosModel;
    }

    public function crear(array $data)
    {
        return $this->insumosModel->create($data);
    }

    public function insumoProcedimiento($consulta_id)
    {
        $insumo = $this->insumosModel->select('insumos_procedimientos.id', 'insumos_procedimientos.cantidad', 'codesumis.nombre as codesumis')
        ->join('codesumis', 'insumos_procedimientos.codesumi_id', 'codesumis.id')
        ->where('insumos_procedimientos.consulta_id', $consulta_id)
        ->get();

        return $insumo;
    }

    public function eliminarInsumo($id)
    {
        $insumo = $this->insumosModel->findOrFail($id);
        $insumo->delete();
    }

   
    public function actualizarProcedimiento(Request $request)
    {
        return HistoriaClinica::where('consulta_id', $request->consulta)
        ->update([
            'procedimiento_menor' => $request->procedimiento_menor,
            'cup_id' => $request->cup_id
        ]);
    }
}
