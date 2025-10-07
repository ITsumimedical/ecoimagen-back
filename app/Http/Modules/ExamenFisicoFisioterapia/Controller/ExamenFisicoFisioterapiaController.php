<?php

namespace App\Http\Modules\ExamenFisicoFisioterapia\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\ExamenFisicoFisioterapia\Repositories\ExamenFisicoFisioterapiaRepository;
use Illuminate\Http\Request;

class ExamenFisicoFisioterapiaController extends Controller
{
    public function __construct(
        protected ExamenFisicoFisioterapiaRepository $examenFisicoFisioterapiaRepository,
    ) {}

    public function crear(Request $request)
    {
        try {
            $examen = $this->examenFisicoFisioterapiaRepository->crearExamen($request->all());
            return response()->json($examen);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }
}
