<?php

namespace App\Http\Modules\Epidemiologia\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Epidemiologia\Repositories\OficioRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Symfony\Contracts\Service\Attribute\Required;

class OficioController extends Controller
{

    public function __construct(private OficioRepository $oficioRepository){}

    /**
     * Lista los oficios por nombre y se alamcena en cache por 7 días
     * @param Request $request
     * @author Sofia O
     */
    public function listarOficiosNombre(Request $request){
        try {
            $oficios = Cache::remember('oficios', 604800, function () use ($request) {
                return $this->oficioRepository->listarOficiosNombre($request);
            });
            return response()->json($oficios, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
