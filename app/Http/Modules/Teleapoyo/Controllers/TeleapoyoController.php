<?php

namespace App\Http\Modules\Teleapoyo\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Modules\Usuarios\Models\User;
use App\Http\Modules\Teleapoyo\Services\TeleapoyoService;
use App\Http\Modules\Teleapoyo\Repositories\TeleapoyoRepository;
use App\Http\Modules\Teleapoyo\Requests\CrearTeleapoyoRequest;

class TeleapoyoController extends Controller
{
    private $teleapoyoRepository;
    private $teleapoyoService;

    public function __construct(TeleapoyoRepository $teleapoyoRepository, TeleapoyoService $teleapoyoService)
    {
        $this->teleapoyoRepository = $teleapoyoRepository;
        $this->teleapoyoService = $teleapoyoService;
    }

    /**
     * Guarda un teleapoyo
     * @param Request $request
     * @return Response $teleapoyo
     * @author JDSS
     */
    public function crear(CrearTeleapoyoRequest $request): JsonResponse
    {
        try {
            $teleapoyo = $this->teleapoyoService->guardarTeleapoyo($request->validated());
            return response()->json($teleapoyo, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al crear !',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * lista los teleapoyos pendientes segun unos filtros
     * @param Request $request
     * @return Response $teleapoyo
     * @author JDSS
     */

    public function teleconceptosPendientes(Request $request)
    {
        try {
            $teleapoyo = $this->teleapoyoRepository->listarTeleapoyosPendientes($request->all());

            return response()->json($teleapoyo, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar la información.',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * Actualiza la especialidad.
     *
     * @param  mixed $request especialidad_id
     * @param  int $id id del teleapoyo.
     *
     * @return JsonResponse
     * @throws Exception
     * @author JDSS
     */
    public function actualizarEspecialidad(Request $request, int $id)
    {
        try {
            $teleapoyo = $this->teleapoyoRepository->buscar($id);
            $this->teleapoyoRepository->actualizar($teleapoyo, $request->all());
            return response()->json([
                $teleapoyo,
                'mensaje' => 'Especialidad actualizada con exito!'
            ], Response::HTTP_ACCEPTED);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje'   => 'Error al actualizar la especialidad!',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Responde el teleapoyo.
     *
     * @param  mixed $request observacion_reasignacion_girs,girs_auditor,pertinencia_prioridad,pertinencia_evaluacion,respuesta
     * @param  int $id id del teleapoyo.
     *
     * @return JsonResponse
     * @throws Exception
     * @author JDSS
     */
    public function responder(Request $request, int $id)
    {
        try {
            $teleapoyo = $this->teleapoyoRepository->responder($id, $request->all());
            return response()->json([
                $teleapoyo,
                'mensaje' => 'Especialidad actualizada con exito!'
            ], Response::HTTP_ACCEPTED);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al actualizar la especialidad!',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * lista los teleapoyos que requieren junta girs
     * @param Request $request
     * @return Response $teleapoyo
     * @author JDSS
     */

    public function teleconceptosGirs(Request $request)
    {
        try {
            $teleapoyo = $this->teleapoyoRepository->listarTeleapoyosGirs($request);
            return response()->json($teleapoyo, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['mensaje' => 'Error al recuperar la información.'], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * lista los teleapoyos que requieren junta girs
     * @param Request $request
     * @return Response $teleapoyo
     * @author JDSS
     */

    public function actualizar(Request $request, $teleapoyo)
    {
        try {
            $teleapoyos = $this->teleapoyoRepository->buscar($teleapoyo);
            $teleapoyos->fill($request->all());
            $actualizarTeleapoyo = $this->teleapoyoRepository->guardar($teleapoyos);
            return response()->json($actualizarTeleapoyo, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al recuperar la información.',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * lista los teleapoyos que requieren junta girs
     * @param Request $request
     * @return Response $teleapoyo
     * @author JDSS
     */

    public function listarTeleapoyosSolucionados(Request $request)
    {
        try {
            $teleapoyo = $this->teleapoyoRepository->listarSolucionados($request->all());
            return response()->json($teleapoyo, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al recuperar la información.',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * cuenta los telepoyos segun su estado
     * @param
     * @return Response $teleapoyo
     * @author JDSS
     */

    public function contador()
    {
        try {
            $teleapoyo = $this->teleapoyoRepository->contador();
            return response()->json($teleapoyo, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al recuperar la información.',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * genera reporte de los teleapoyos segun rango de fechas
     * @param Request $request
     * @return Response $teleapoyo
     * @author JDSS
     */

    public function reporte(Request $request)
    {
        try {
            $teleapoyo = $this->teleapoyoRepository->reporte($request);
            return $teleapoyo;
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar la información.',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function imprimirpdf() {}

    /**
     * lista los teleapoyos que requieren junta girs
     * @param Request $request
     * @return Response $teleapoyo
     * @author JDSS
     */

    public function teleconceptosJuntaProfesionales(Request $request)
    {
        try {
            $teleapoyo = $this->teleapoyoRepository->listarTeleapoyoJuntaProfesional($request);
            return response()->json($teleapoyo, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['mensaje' => 'Error al recuperar la información.'], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Busca un teleapoyo tomando el id
     * @param mixed $teleapoyoId
     * @return JsonResponse|mixed
     * @author Thomas Restrepo
     */
    public function buscarTeleapoyo($teleapoyoId)
    {
        try {
            $teleapoyo = $this->teleapoyoRepository->buscarTeleapoyo($teleapoyoId);
            return response()->json($teleapoyo, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['mensaje' => '
            Error al recuperar la información.', 'error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
