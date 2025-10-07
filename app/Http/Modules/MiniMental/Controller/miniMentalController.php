<?php

namespace App\Http\Modules\MiniMental\Controller;

use App\Http\Controllers\Controller;
use App\Http\Modules\MiniMental\Repositories\miniMentalRepository;
use App\Http\Modules\MiniMental\Services\MiniMentalService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class miniMentalController extends Controller
{
    public function __construct(
        private miniMentalRepository $miniMentalRepository,
        private MiniMentalService $miniMentalService,
    ) {}

    public function crear(Request $request)
    {
        try {
            $data = $request->all();
            $this->miniMentalService->updateOrCreate(['consulta_id' => $data['consulta_id']], $data);

            return response()->json('Registro actualizado o creado con éxito', Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(['Error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function obtenerDatos($afiliadoId)
    {
        try {
            $mental = $this->miniMentalRepository->obtenerDatosporAfiliado($afiliadoId);
            return response()->json($mental, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * descargarGuia
     * Descarga la guía de para la realizacion del minimental
     *
     * @return void
     */

    public function descargarGuia()
    {
        $filePath = public_path('documentosHistoriaClinica/MiniMental.pdf');

        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
