<?php

namespace App\Http\Modules\ExamenFisicoOdontologia\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\ExamenFisicoOdontologia\Repositories\examenFisicoOdontologiaRepository;
use Illuminate\Http\Request;

class examenFisicoOdontologiaController extends Controller
{
    public function __construct(
        private examenFisicoOdontologiaRepository $examenFisicoOdontologiaRepository,
    ) {
    }

    public function crear(Request $request)
    {
        try {
            $data = $this->examenFisicoOdontologiaRepository->crearFisico($request->all());
            return response()->json([
                'data' => $data,
                'mensaje' => 'Examen fisico guardado con éxito'
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }
}
