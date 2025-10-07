<?php

namespace App\Http\Modules\Cums\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\Medicamentos\Models\Cum;
use App\Http\Modules\Cums\Repositories\CumRepository;

class CumController extends Controller
{
    private $repository;

    public function __construct(
        private CumRepository $cumRepository,
    ) {}


    /**
     * Lista los cums
     * @param Request $request
     * @return ResponseJson
     * @author David Peláez
     */
    public function listar(Request $request)
    {
        try {
            ini_set('memory_limit', '-1');

            $orden = $request->orden ? $request->orden : 'desc';
            $filas = $request->filas ? $request->filas : 10;
            $searchTerm = $request->input('searchTerm');

            $consulta = Cum::orderBy('created_at', $orden);

            if ($searchTerm && strlen($searchTerm) >= 4) {
                $consulta->where('producto', 'ILIKE', '%' . $searchTerm . '%');
            }
            return $request->page ? $consulta->paginate($filas) : $consulta->get();
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function BuscarCum($expediente)
    {
        try {
            $cum = $this->cumRepository->getCums($expediente);
            if ($cum === null) {
                return response()->json('No se encontraron CUMs con el expediente proporcionado', Response::HTTP_NOT_FOUND);
            } else {
                return response()->json($cum, Response::HTTP_OK);
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
    public function Cums($cumValidacion)
    {
        try {
            $medicamento = $this->cumRepository->EncontrarCum($cumValidacion);
            if ($medicamento) {
                return response()->json($medicamento, Response::HTTP_OK);
            } else {
                return response()->json("No se encontró el medicamento con la validación de CUM proporcionada", Response::HTTP_NOT_FOUND);
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function principioActivo(Request $request)
    {
        try {
            $principio_activo = $request->input('principio_activo');
            $atc = $this->cumRepository->listarPrincipios($principio_activo);
            return response()->json(['mensaje' => 'Principio Activo', $atc, 200]);
        } catch (\Throwable $th) {
            return response()->json(['Error' => $th->getMessage()], 400);
        }
    }

    public function crearCum(Request $request)
    {
        try {
            $cum = $this->cumRepository->crearCum($request);
            return response()->json($cum, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Busca un medicamento por su expediente
     *
     * @param string $expediente
     * @return \Illuminate\Http\JsonResponse
     */
    public function BuscarMedicamento($expediente)
    {
        try {
            $cum = $this->cumRepository->getmedicamentos($expediente);
            if ($cum === null) {
                return response()->json('No se encontraron CUMs con el expediente proporcionado', Response::HTTP_NOT_FOUND);
            } else {
                return response()->json($cum, Response::HTTP_OK);
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
