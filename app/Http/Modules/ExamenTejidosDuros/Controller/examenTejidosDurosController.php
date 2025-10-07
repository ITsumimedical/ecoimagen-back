<?php

namespace App\Http\Modules\ExamenTejidosDuros\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\ExamenTejidosDuros\Repositories\examenTejidosDurosRepository;
use Illuminate\Http\Request;

class examenTejidosDurosController extends Controller
{
    public function __construct(
        private examenTejidosDurosRepository $examenTejidosDurosRepository,
    ) {
    }

    public function crear(Request $request)
    {
        try {
            $this->examenTejidosDurosRepository->crear($request->all());
            return response()->json([
                'mensaje' => 'Examen tejidos duros guardado con éxito'
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }
}
