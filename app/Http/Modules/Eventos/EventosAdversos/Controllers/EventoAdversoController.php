<?php

namespace App\Http\Modules\Eventos\EventosAdversos\Controllers;

use App\Formats\AnalisisCasos;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\Eventos\EventosAdversos\Models\EventoAdverso;
use App\Http\Modules\Eventos\EventosAdversos\Repositories\EventoAdversoRepository;
use App\Http\Modules\Eventos\EventosAdversos\Requests\ActualizarEventoAdversoRequest;
use App\Http\Modules\Eventos\EventosAdversos\Requests\AsignarEventoAdversoRequest;
use App\Http\Modules\Eventos\EventosAdversos\Requests\CambiarEstadoEventoAdversoRequest;
use App\Http\Modules\Eventos\EventosAdversos\Requests\CerrarEventoRequest;
use App\Http\Modules\Eventos\EventosAdversos\Requests\CrearEventoAdversoRequest;
use App\Http\Modules\Eventos\EventosAdversos\Requests\listarSeguimientoIAASRequest;
use App\Http\Modules\Eventos\EventosAdversos\Requests\ReasignarEventoAdversoRequest;
use App\Http\Modules\Eventos\EventosAdversos\Services\EventoAdversoService;
use App\Http\Modules\Eventos\EventosAsignados\Repositories\EventoAsignadoRepository;
use Illuminate\Support\Facades\Auth;

class EventoAdversoController extends Controller
{

    public function __construct(
        private EventoAdversoRepository $eventoAdversoRepository,
        private EventoAdversoService $eventoAdversoService,
        private EventoAsignadoRepository $eventoAsignadoRepository
    ) {}

    /**
     * lista los eventos adversos
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function listar(Request $request): JsonResponse
    {
        $eventoAdverso = $this->eventoAdversoService->listarEventos($request->all());
        try {
            return response()->json($eventoAdverso);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'err' => $th->getMessage(),
                'mensaje' => 'Error al listar los eventos adversos',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Guarda un evento adverso
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function crear(CrearEventoAdversoRequest $request): JsonResponse
    {
        try {
            $evento = $this->eventoAdversoService->guardarEvento($request->validated());
            return response()->json([$evento], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al crear el evento adverso!',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Actualiza un evento adverso
     * @param Request $request
     * @return Response
     * @author leon
     */
    public function actualizar(ActualizarEventoAdversoRequest $request, EventoAdverso $id)
    {
        try {
            $this->eventoAdversoService->actualizar($id, $request->validated());
            return response()->json([]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function contadoresEventosAdversos()
    {
        $usuario = Auth::id();

        $eventoCerrado = EventoAdverso::join('evento_asignados', 'evento_adversos.id', '=', 'evento_asignados.evento_adverso_id')
            ->where('evento_asignados.user_id', $usuario)
            ->whereIn('estado_id', [17, 5])
            ->distinct('evento_adversos.id')
            ->count('evento_adversos.id');

        $eventosPendientes = EventoAdverso::join('evento_asignados', 'evento_adversos.id', '=', 'evento_asignados.evento_adverso_id')
            ->where('evento_asignados.user_id', $usuario)
            ->where('evento_adversos.estado_id', 10)
            ->distinct('evento_adversos.id')
            ->count('evento_adversos.id');

        $eventosAsignados = EventoAdverso::join('evento_asignados', 'evento_adversos.id', '=', 'evento_asignados.evento_adverso_id')
            ->where('evento_asignados.user_id', $usuario)
            ->where(function ($query) {
                $query->where('estado_id', 6)
                    ->orWhere('estado_id', 15);
            })
            ->distinct('evento_adversos.id')
            ->count('evento_adversos.id');

        $eventosSeguimientoPlan = EventoAdverso::join('evento_asignados', 'evento_adversos.id', '=', 'evento_asignados.evento_adverso_id')
            ->where('evento_asignados.user_id', $usuario)
            ->where('estado_id', 38)
            ->distinct('evento_adversos.id')
            ->count('evento_adversos.id');

        $eventosPlanMejoraCumpido = EventoAdverso::join('evento_asignados', 'evento_adversos.id', '=', 'evento_asignados.evento_adverso_id')
            ->where('evento_asignados.user_id', $usuario)
            ->where('estado_id', 39)
            ->distinct('evento_adversos.id')
            ->count('evento_adversos.id');

        $eventosAnalizado = EventoAdverso::join('evento_asignados', 'evento_adversos.id', '=', 'evento_asignados.evento_adverso_id')
            ->where('evento_asignados.user_id', $usuario)
            ->where('estado_id', 16)
            ->distinct('evento_adversos.id')
            ->count('evento_adversos.id');

        $eventosCerradoParcial = EventoAdverso::join('evento_asignados', 'evento_adversos.id', '=', 'evento_asignados.evento_adverso_id')
            ->where('evento_asignados.user_id', $usuario)
            ->where('estado_id', 18)
            ->distinct('evento_adversos.id')
            ->count('evento_adversos.id');

        return response()->json([
            $eventoCerrado,
            $eventosPendientes,
            $eventosAsignados,
            $eventosSeguimientoPlan,
            $eventosPlanMejoraCumpido,
            $eventosAnalizado,
            $eventosCerradoParcial,
        ], Response::HTTP_OK);
    }

    /**
     * reporte descarga procedimiento almacenado de la base de datos
     *
     * @param  mixed $request
     * @return void
     */
    public function reporte(Request $request)
    {
        try {
            $evento = $this->eventoAdversoRepository->reporte($request);
            return $evento;
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al recuperar la información.',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function listarEventosAfiliado(Request $request, $id)
    {
        try {
            $evento = $this->eventoAdversoRepository->listarEventosAfiliado($request, $id);
            return response()->json($evento, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al recuperar los eventos adversos del empleado',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function printfpdf($data)
    {
        $pdf = new AnalisisCasos();
        $pdf->generar($data);
    }

    public function cerrarEventoAdverso(CerrarEventoRequest $request)
    {
        try {
            $evento = $this->eventoAdversoService->cerrarEventoAdverso($request->validated());
            return response()->json($evento, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al cerrar el evento adverso',
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    public function devolverEvento(ReasignarEventoAdversoRequest $request)
    {
        try {
            $reasignacion = $this->eventoAdversoService->devolver($request->validated());
            return response()->json($reasignacion);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function asignarEvento(AsignarEventoAdversoRequest $request)
    {
        try {
            $asignacion = $this->eventoAdversoService->asignarEvento($request->validated());
            return response()->json($asignacion);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function listarEventosId($id)
    {
        try {
            $evento = $this->eventoAdversoRepository->listarEventosPorId($id);
            return response()->json($evento);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    /**
     * Actualiza el campo estado_id de un evento adverso
     */
    public function actualizarEstado(CambiarEstadoEventoAdversoRequest $request)
    {
        try {
            $cambioEvento = $this->eventoAdversoService->actualizarEstado($request->validated());
            return response()->json($cambioEvento);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    /**
     * lista los seguimientos IAAS acorde a un mes y un anio
     * @param Request $request
     * @return Response
     */
    public function listarSeguimientoIAAS(listarSeguimientoIAASRequest $request): JsonResponse
    {
        try {
            $consulta = $this->eventoAdversoRepository->listarSeguimientoIAAS($request->validated());
            return response()->json($consulta, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al consultar el seguimiento!',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * descarga los seguimientos IAAS acorde a un mes y un anio
     * @param Request $request
     * @return Response
     */
    public function descargarSeguimientoIAAS(listarSeguimientoIAASRequest $request)
    {
        try {
            return $this->eventoAdversoService->descargarSeguimientoIAAS($request->validated());
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => 'Error al generar el reporte!',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
