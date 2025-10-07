<?php

namespace App\Http\Modules\Agendas\Controllers;

use App\Formats\CertificadoCitas;
use App\Http\Controllers\Controller;
use App\Http\Modules\Agendas\Models\Agenda;
use App\Http\Modules\Agendas\Models\AgendamientoCirugia;
use App\Http\Modules\Agendas\Models\AgendaUser;
use App\Http\Modules\Agendas\Repositories\AgendaRepository;
use App\Http\Modules\Agendas\Requests\ActualizarCitaAgendaRequest;
use App\Http\Modules\Agendas\Requests\ConsultarAgendaCirugiaRequest;
use App\Http\Modules\Agendas\Requests\GuardarAgendaCirugiaRequest;
use App\Http\Modules\Agendas\Requests\GuardarAgendaRequest;
use App\Http\Modules\Agendas\Requests\AgendaDisponibleRequest;
use App\Http\Modules\Agendas\Requests\ListarAgendaConsultorioRequest;
use App\Http\Modules\Agendas\Requests\TrasladarConsultorioAgendaRequest;
use App\Http\Modules\Agendas\Services\AgendaService;
use App\Http\Modules\Usuarios\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Rap2hpoutre\FastExcel\FastExcel;


class AgendaController extends Controller
{
    protected $agendaRepository;
    protected $agendaService;

    public function __construct()
    {
        $this->agendaRepository = new AgendaRepository();
        $this->agendaService = new AgendaService();
    }

    public function guardar(GuardarAgendaRequest $request)
    {
        //        try {
        $agenda = $this->agendaService->guardar($request->all());
        return Response()->json(["mensaje" => $agenda["mensaje"]], $agenda["status"]);
        //        }catch (\Throwable $th){
        //            return  response()->json([
        //                'error' => $th->getMessage(),
        //                'mensaje' => 'Error al crear la agenda',
        //            ], 400);
        //        }
    }

    public function agendaDisponible(AgendaDisponibleRequest $request)
    {
        try {
            $agendas = $this->agendaRepository->agendaDisponible($request);
            return response()->json($agendas, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al recuperar agendas disponibles!.'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function reasignarAgendas(Request $request)
    {
        try {
            $agenda = $this->agendaService->reasignarAgendaMedico($request->all());
            return response()->json(['mensaje' => $agenda["mensaje"]], $agenda["status"]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al reasiganar las agendas agendas!.'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function agendaDisponibleAutogestion(Request $request)
    {
        try {
            $agenda = $this->agendaRepository->agendaDisponibleAutogestion($request->cita, $request->rep);
            return response()->json($agenda, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al reasiganar las agendas agendas!.'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function generarPdf(Request $request)
    {

        $pdf = new CertificadoCitas();
        return  $pdf->generar($request->all());
    }

    public function auditoriaAgendas(Request $request)
    {
        $auditoria = Collect(DB::select('exec dbo.AuditoriaAgendas ?,?,?', [$request->fechaDesde, $request->fechaHasta, $request->medico]));
        $array = json_decode($auditoria, true);
        return (new FastExcel($array))->download('AuditoriaAgendas.xls');
    }

    public function agendaSede($consultorio_id)
    {
        return Agenda::select('agendas.*')->with('consultas')->whereIn('agendas.estado_id', [11, 12])->where('agendas.consultorio_id', $consultorio_id)->get();
    }

    public function sede(Request $request)
    {
        try {
            $agenda = $this->agendaRepository->sede($request->cita);
            return response()->json($agenda, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al reasiganar las agendas agendas!.'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function medicos(Request $request)
    {
        try {
            $agenda = $this->agendaRepository->medicos($request);
            return response()->json($agenda, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al reasiganar las agendas agendas!.'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function exportar(Request $request)
    {
        try {
            $agenda = $this->agendaRepository->exportar($request);
            return $agenda;
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error!.'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function exportarDemanda(Request $request)
    {
        try {
            $agenda = $this->agendaRepository->exportarDemanda($request);
            return $agenda;
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error!.'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizarCita(ActualizarCitaAgendaRequest $request): JsonResponse
    {
        try {
            $actualizarCita = $this->agendaService->actualizarCita($request->validated());
            return response()->json($actualizarCita, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al intentar actualizar la cita de la agenda'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function consultarCitas(Request $request)
    {
        try {
            if ($request->tipo === 'telemedicina') {
                $consulta = $this->agendaService->listarCitas('telemedicina');
            }
            $data = $this->agendaService->formatoParaMeet($consulta);
            //Storage::append('consulta_citas.txt', 'Se consulto: ' . Carbon::now() . ' resultaron ' . $consulta->count() . ' registros.');
            return response()->json([
                "code" => "200",
                "description" => "ok",
                "data" => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json('Error: ' . $th->getMessage());
        }
    }

    /**
     * consulta una agenda con los withs
     */
    public function getAgenda(Request $request, $agenda_id)
    {
        try {
            $agenda = $this->agendaService->getAgenda($agenda_id);
            return response()->json($agenda);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al recuperar la agenda'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function agendasActivasCirugia(Request $request)
    {

        try {
            $agendamiento = AgendamientoCirugia::with('afiliado', 'consultorio', 'cirujano', 'anestesiologo', 'sede', 'cup', 'afiliado.tipoDocumento', 'cirujano.operador', 'anestesiologo.operador')
                ->where('fecha', $request->fecha_cirugia)
                ->where('consultorio_id', $request->quirofano_id['id'])->get();
            return response()->json($agendamiento);
        } catch (\Throwable $th) {
            return response()->json('Error: ' . $th->getMessage());
        }
    }

    public function guardarAgendaCirugia(GuardarAgendaCirugiaRequest $request)
    {
        try {
            $this->agendaService->guardarAgendaCirugia($request->validated());
            return response()->json(['mensaje' => 'Agenda creada!']);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al guardar la agenda'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function consultaAgendaCirugia(ConsultarAgendaCirugiaRequest $request)
    {
        try {
            $historico = $this->agendaService->historicoPorCategorias($request->validated());
            return response()->json($historico);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar las agendas'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function reporteCirugiaProgramada(ConsultarAgendaCirugiaRequest $request)
    {
        try {
            $reporte = $this->agendaRepository->reporteCirugiasProgramadas($request->validated());
            return (new FastExcel($reporte))->download('ReporteAsistencias.xls');
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }
    
    /**
     * listarPorConsultorio - lista las agendas de un consultorio por mes y año
     *
     * @param  mixed $request
     * @return void
     */
    public function listarPorConsultorio(ListarAgendaConsultorioRequest $request)
    {
        try {
            $historico = $this->agendaRepository->listarPorConsultorio($request->validated());
            return response()->json($historico, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar las agendas'
            ], 500);
        }
    }

    /**
     * trasladarConsultorio - reealiza el traslado de las agendas seleccionadas a otro consultorio
     *
     * @param  mixed $request
     * @return void
     */
    public function trasladarConsultorio(TrasladarConsultorioAgendaRequest $request)
    {
        try {
            $historico = $this->agendaService->trasladarConsultorios($request->validated());
            return response()->json($historico, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al consultar las agendas'
            ], 500);
        }
    }
}
