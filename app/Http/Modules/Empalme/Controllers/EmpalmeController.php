<?php

namespace App\Http\Modules\Empalme\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Empalme\Requests\CrearEmpalmeRequest;
use App\Http\Modules\Empalme\Repositories\EmpalmeRepository;
use App\Http\Modules\Empalme\Services\EmpalmeService;

class EmpalmeController extends Controller
{
    public function __construct(
        private EmpalmeRepository $empalmeRepository,
        private EmpalmeService $empalmeService
    ) {
    }

    public function listarFerrocarriles(Request $request)
    {
        try {
            $empalmes = $this->empalmeRepository->listarEmpalmes($request);
            return response()->json($empalmes, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarporEntidades($cedula)
    {
        try {
            $response = $this->empalmeRepository->listarAfiliadosPorCedulaConEntidadEspecifica($cedula);

            return response()->json($response, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function crear(CrearEmpalmeRequest $request): JsonResponse
    {
        try {
            $this->empalmeService->crear($request->validated());
            return response()->json([
                'mensaje' => 'Se ha creado el empalme correctamente.',
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function existeEmpalme($cedula)
    {
        try {
            $afiliado = Afiliado::where('numero_documento', $cedula)->first();
            if (!$afiliado) {
                return response()->json(['existe' => 0], Response::HTTP_OK);
            }
            $existeEmpalme = DB::table('empalme')
                ->where('afiliado_id', $afiliado->id)
                ->exists();
            return response()->json(['existe' => (bool) $existeEmpalme], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
