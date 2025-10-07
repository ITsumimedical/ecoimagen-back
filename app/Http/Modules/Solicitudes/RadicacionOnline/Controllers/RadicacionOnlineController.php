<?php

namespace App\Http\Modules\Solicitudes\RadicacionOnline\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\Solicitudes\RadicacionOnline\Repositories\RadicacionOnlineRepository;
use App\Http\Modules\Solicitudes\RadicacionOnline\Requests\AsignarRequest;
use App\Http\Modules\Solicitudes\RadicacionOnline\Requests\ComentarioRequest;
use App\Http\Modules\Solicitudes\RadicacionOnline\Services\RadicacionOnlineService;
use App\Http\Modules\Solicitudes\RadicacionOnline\Requests\FiltroRadicacionOnlineRequest;
use App\Http\Modules\Solicitudes\RadicacionOnline\Requests\FiltroSolucionadasRequest;
use App\Http\Modules\Solicitudes\RadicacionOnline\Requests\ResponderRequest;

class RadicacionOnlineController extends Controller
{

    public function __construct(
        private RadicacionOnlineService $radicacionOnlineService,
        private RadicacionOnlineRepository $radicacionOnlineRepository
    ) {
    }

    public function crearRadicacion(Request $request)
    {
        try {
            $radicacion = $this->radicacionOnlineService->radicacion($request->all());
            return response()->json($radicacion, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function buscarPorFiltro(Request $request)
    {
        try {
            $radicacion = $this->radicacionOnlineRepository->filtro($request);
            return response()->json($radicacion, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function comentar(ComentarioRequest $request)
    {
        try {
            $comentar = $this->radicacionOnlineService->comentar($request->validated());
            return response()->json($comentar, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function respuesta(ResponderRequest $request)
    {
        try {
            $comentar = $this->radicacionOnlineService->responder($request->validated());
            return response()->json($comentar, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function asignar(AsignarRequest $request)
    {
        try {
            $comentar = $this->radicacionOnlineService->asignar($request->validated());
            return response()->json($comentar, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function buscarPorFiltroSolucioandas(FiltroSolucionadasRequest $request)
    {
        try {
            $radicacion = $this->radicacionOnlineRepository->filtroSolucionadas($request->validated());
            return response()->json($radicacion, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function buscarPendientesAsignadas(FiltroRadicacionOnlineRequest $request)
    {
        try {
            $radicacion = $this->radicacionOnlineRepository->filtroPendientesAsignados($request->validated());
            return response()->json($radicacion, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function devolver(Request $request)
    {
        try {
            $comentar = $this->radicacionOnlineService->devolver($request->all());
            return response()->json($comentar, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function solucionadasAsignadas(Request $request)
    {
        try {
            $radicacion = $this->radicacionOnlineRepository->solucionadasAsignadas($request->all());
            return response()->json($radicacion, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function buscarPendientes(FiltroRadicacionOnlineRequest $request)
    {
        try {
            $radicacion = $this->radicacionOnlineRepository->buscarPendientes($request->validated());
            return response()->json($radicacion, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function solucionadasAdmin(FiltroSolucionadasRequest $request)
    {
        try {
            $radicacion = $this->radicacionOnlineRepository->solucionadasAdmin($request->validated());
            return response()->json($radicacion, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function informe(Request $request)
    {
        try {
            return  $this->radicacionOnlineRepository->informe($request->all());
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function obtenerRadicadosPaciente(Request $request)
    {
        try {
            $radicacion = $this->radicacionOnlineRepository->obtenerRadicadosPaciente($request->all());
            return response()->json($radicacion, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function comentarAutogestion(Request $request)
    {
        try {
            $comentar = $this->radicacionOnlineService->comentarAutogestion($request->all());
            return response()->json($comentar, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function cantidadPendientesTipo()
    {
        try {
            return  $this->radicacionOnlineRepository->cantidadPendientesTipo();
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
    public function cantidadSolucionadasTipo()
    {
        try {
            return  $this->radicacionOnlineRepository->cantidadSolucionadasTipo();
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarSolicitudes(Request $request)
    {
        try {
            $radicacion = $this->radicacionOnlineRepository->listarSolicitudes($request->all());
            return response()->json($radicacion, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function obtenerCantidadSolicitudesTipo(Request $request)
    {
        try {
            return  $this->radicacionOnlineRepository->obtenerCantidadSolicitudesTipo($request->all());
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarSolicitudesAsignadas(Request $request)
    {
        try {
            $radicacion = $this->radicacionOnlineRepository->listarSolicitudesAsignadas($request->all());
            return response()->json($radicacion, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
