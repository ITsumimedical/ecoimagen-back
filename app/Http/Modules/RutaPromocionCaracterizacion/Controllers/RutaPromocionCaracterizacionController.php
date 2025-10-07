<?php

namespace App\Http\Modules\RutaPromocionCaracterizacion\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\RutaPromocionCaracterizacion\Repositories\RutaPromocionCaracterizacionRepository;
use Illuminate\Http\Response;

class RutaPromocionCaracterizacionController extends Controller
{
    private $rutaPromocionCaracterizacionRepository;

    public function __construct()
    {
        $this->rutaPromocionCaracterizacionRepository = new RutaPromocionCaracterizacionRepository();
    }

    public function listarTodas()
    {
        try {
            $rutaPromocionCaracterizacion = $this->rutaPromocionCaracterizacionRepository->listarTodas();
            return response()->json($rutaPromocionCaracterizacion, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}