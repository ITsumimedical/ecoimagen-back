<?php

namespace App\Http\Modules\Indicadores\Controllers;

use App\Http\Modules\Indicadores\Models\DatosIndicadorFomagOncologico;
use App\Http\Modules\Indicadores\Repositories\IndicadorRepository;
use App\Http\Modules\Indicadores\Requests\ActualizarDatosIndicadorRequest;
use App\Http\Modules\Indicadores\Requests\FiltroHistoricoDatosRequest;
use App\Http\Modules\Indicadores\Services\IndicadorService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class IndicadorController extends Controller
{

    public function __construct(private IndicadorService $indicadoreService, private IndicadorRepository $indicadorRepository)
    {

    }

    public function guardar(Request $request)
    {
        $datos = $request->all();
        DatosIndicadorFomagOncologico::create($datos);
        return response()->json(['mensaje' => 'Datos Guardados!',]);
    }

    public function listar()
    {
        return response()->json(DatosIndicadorFomagOncologico::all());
    }

    public function exportatIndicador($tipo, Request $request)
    {
        $indicador = $this->indicadoreService->generarPlantilla($tipo, $request->all());
        return response()->download($indicador)->deleteFileAfterSend();
    }

    public function registroAfiliado(FiltroHistoricoDatosRequest $request)
    {
        try {
            $datos = $this->indicadorRepository->historicoDatos($request->validated());
            return response()->json($datos);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function actualizar(DatosIndicadorFomagOncologico $id, ActualizarDatosIndicadorRequest $request)
    {
        try {
            $this->indicadorRepository->actualizar($id, $request->validated());
            return response()->json(['mensaje' => 'Datos Actualizados!',]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function eliminar(DatosIndicadorFomagOncologico $id){
        try {
            $this->indicadorRepository->eliminar($id);
            return response()->json(['mensaje' => 'Dato Eliminado!',]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }
}
