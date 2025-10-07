<?php

namespace App\Http\Modules\Citas\Controllers;

use Error;
use App\Http\Modules\CampoHistorias\Models\CampoHistoria;
use App\Http\Modules\CategoriaHistorias\Models\CategoriaHistoria;
use App\Http\Modules\Citas\Requests\GuardarFirmaConsentimientoRequest;
use App\Http\Modules\Citas\Services\CitaService;
use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\PlantillaHistoria\Models\PlantillaCampo;
use App\Http\Modules\PlantillaHistoria\Models\PlantillaCategoria;
use App\Http\Modules\PlantillaHistoria\Models\PlantillaHistoria;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Modules\Citas\Repositories\CitaRepository;
use App\Http\Modules\Citas\Models\Cita;
use App\Http\Modules\Citas\Requests\ActualizarCitaRequest;
use App\Http\Modules\Citas\Requests\AsignarRepCitaRequest;
use App\Http\Modules\Citas\Requests\CrearCitaRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Return_;
use PhpParser\Node\Stmt\TryCatch;

class CitaController extends Controller
{
    private $citaRepository;
    private $citaService;

    public function __construct(CitaRepository $citaRepository, CitaService $citaService)
    {
        $this->citaRepository = $citaRepository;
        $this->citaService = $citaService;
    }
    /**
     * lista las citas deacuerdo a las entidades del usuario logueado
     *
     * @return void
     * @author Manuela
     */
    public function listar(Request $request)
    {
        try {
            $user_id = auth()->id();
            $cita = $this->citaRepository->citas($request, $user_id);
            return response()->json($cita, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * crear una cita
     * @param mixed $request
     * @return JsonResponse
     * @author Calvarez
     */
    public function crear(CrearCitaRequest $request): JsonResponse
    {
        try {
            $request['requiere_orden'] = '' ? false : $request['requiere_orden'];
            $nuevaCita = new Cita($request->all());
            $this->citaRepository->guardar($nuevaCita);
            return response()->json(['mensaje' => 'Cita creada con exito!'], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al guardar la cita!.'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function historiaClinicaCita(Request $request)
    {
        try {
            $citas = Cita::with(explode(",", $request->with))->get();
            return response()->json($citas, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al recuperar las citas!.'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function plantillaHistoriaCita()
    {
        try {
            $plantilla = [];
            $plantillaHistorias = PlantillaHistoria::all();
            foreach ($plantillaHistorias as $plantillaHistoria) {
                //                $campos = PlantillaCampo::select([
                //                    'plantilla_campos.*',
                //                    'pc.nombre as categoria'
                //                ])->join('plantilla_categorias as pc','plantilla_campos.plantilla_categoria_id','pc.id')
                //                    ->where('pc.plantilla_historia_id',$plantillaHistoria->id)
                //                    ->get();

                $campos = PlantillaCategoria::select([
                    'pc.*',
                    'plantilla_categorias.nombre as categoria'
                ])
                    ->leftjoin('plantilla_campos as pc', 'pc.plantilla_categoria_id', 'plantilla_categorias.id')
                    ->where('plantilla_categorias.plantilla_historia_id', $plantillaHistoria->id)
                    ->get();
                $arrPlantilla = $plantillaHistoria->toArray();
                $arrPlantilla['campos'] = $campos;
                $plantilla[] = $arrPlantilla;
            }
            return response()->json($plantilla, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al recuperar las plantillas!.'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function aplicarPlantilla(Request $request)
    {
        try {
            $this->citaService->aplicarPlantillas($request->all());
            $cita = Cita::with(['categorias', 'categorias.campos', 'especialidad', 'tipoCita'])->where('id', $request->cita)->first();
            return response()->json($cita, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al recuperar las plantillas!.'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function actualizar(ActualizarCitaRequest $request, int $id)
    {
        try {
            $citas = $this->citaRepository->buscar($id);
            $citas->fill($request->validated());
            $this->citaRepository->guardar($citas);
            return response()->json(Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'error' => $th->getMessage(),
                'mensaje' => 'Error al actualizar la plantilla.'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function cupsDisponibles(Request $request)
    {
        switch (intval($request->tipo)) {
            case 1:
                $cita = Cita::find($request->cita);
                $cita->cups()->attach($request->cup);
                break;
            case 2:
                $cita = Cita::find($request->cita);
                $cita->cups()->detach($request->cup);
                break;
        }

        return response()->json('Cups Actualizados!');
    }

    public function consultarCitas(Request $request)
    {
        try {
            //            $cita_service = new CitasService;
            if ($request->tipo === 'telemedicina') {
                $consulta = $this->citaRepository->listarCitas();
            }
            $data = $this->citaRepository->formatoMeet($consulta);
            return response()->json([
                "code" => "200",
                "description" => "ok",
                "data" => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json('Error: ' . $th->getMessage());
        }
    }

    public function firmarConsentimiento(GuardarFirmaConsentimientoRequest $request, Consulta $consulta, $documento)
    {
        try {
            /** En primer lugar validamos que la cita pertenezca al documento enviado */
            if (!$consulta->validarPaciente($documento)) {
                throw new Error('La cita no pertenece a este paciente.', 422);
            }
            /** almacenamos la firma */
            return response()->json($consulta->guardarFirma($request->firma));
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        } catch (\Error $e) {
            return response()->json($e->getMessage(), $e->getCode());
        }
    }

    public function consultar(Request $request, $consulta)
    {
        try {
            $cita = Consulta::select([
                'a.primer_nombre',
                'a.segundo_nombre',
                'a.primer_apellido',
                'a.segundo_apellido',
                'a.numero_documento',
                'a.edad_cumplida',
                'c.numero_documento as docRepresentante',
                'e.nombre as especialidad',
                DB::raw("CONCAT(a.primer_nombre,' ',a.segundo_nombre,' ',a.primer_apellido,' ',a.segundo_apellido) as nombrePaciente"),
                DB::raw("CONCAT(c.primer_nombre,' ',c.segundo_nombre,' ',c.primer_apellido,' ',c.segundo_apellido) as nombreRepresentante"),
                'consultas.firma_consentimiento_time'
            ])->join('afiliados as a', 'a.id', 'consultas.afiliado_id')
                ->leftjoin('afiliados as c', 'a.numero_documento_cotizante', 'c.numero_documento')
                ->join('agendas as a2', 'consultas.agenda_id', 'a2.id')
                ->join('citas as c2', 'a2.cita_id', 'c2.id')
                ->join('especialidades as e', 'c2.especialidade_id', 'e.id')
                ->where('consultas.id', $consulta)->first();

            return response()->json($cita);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 400);
        }
    }

    public function historiaDisponibles($especilidad)
    {
        $citas = Cita::where('especialidade_id', $especilidad)
            ->where('citas.estado_id', 1)
            ->with('tipoHistoria:id,nombre')
            ->get();
        return response()->json($citas);
    }

    public function consultarPorEspecialidad(Request $request)
    {
        try {
            $cita = $this->citaRepository->consultarPorEspecialidad($request);
            return response()->json($cita, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function consultarPorEspecialidadTodas(Request $request)
    {
        try {
            $cita = $this->citaRepository->consultarPorEspecialidadTodas($request);
            return response()->json($cita, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function citaOrdenPaciente(Request $request)
    {
        try {
            $cita = $this->citaRepository->citaOrdenPaciente($request->all());
            return response()->json($cita, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function listarCitasAutogestion()
    {
        try {
            $citas = $this->citaRepository->listarCitasAutogestion();
            return response()->json($citas, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function cambiarEstadoCita(Request $request, int $id)
    {
        try {
            $cita = $this->citaRepository->cambiarEstadoCita($request->all(), $id);
            return response()->json($cita, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }

    }

    public function filtrarCitas(Request $request)
    {
        try {
            $citas = $this->citaRepository->filtrarCitas($request->all());
            return response()->json($citas, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'mensaje' => 'Error al filtrar las citas',
            ]);
        }
    }

    public function cambiarFirma(Request $request, int $id)
    {
        try {
            $cita = $this->citaRepository->cambiarFirma($request->all(), $id);
            return response()->json($cita, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }

    }

    public function asignarCitaReps(AsignarRepCitaRequest $request)
    {
        try {
            $cita = $this->citaService->agregarRepsPorCita($request->validated());
            return response()->json($cita, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function listarRepsPorCita(int $id)
    {
        try {
            $cita = $this->citaRepository->listarRepPorCita($id);
            return response()->json($cita, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    /**
     * Listar logs de Keiron
     * @param Request $request
     * @return JsonResponse
     * @author kobatiem
     */
    public function listarLogKeiron(Request $request)
    {
        try {
            $logs = $this->citaRepository->listarLogKeiron($request->all());
            return response()->json($logs, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    /**
     * Listar citas no enviadas a Keiron
     * @param Request $request
     * @return JsonResponse
     * @author kobatiem
     */
    public function listarFaltantesKeiron(Request $request)
    {
        try {
            $logs = $this->citaRepository->listarFaltantesKeiron($request->all());
            return response()->json($logs, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    /**
     * Contador de citas no enviadas a Keiron
     * @param Request $request
     * @return JsonResponse
     * @author kobatiem
     */
    public function contadorFaltantesKeiron()
    {
        try {
            $contador = $this->citaRepository->contadorFaltantesKeiron();
            return response()->json($contador, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function listarCanceladasFaltantes(Request $request)
    {
        try {
            $logs = $this->citaRepository->listarCanceladasFaltantesKeiron($request->all());
            return response()->json($logs, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Ha ocurrido un error al Buscar las Canceladas'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * activa para que salga en autogestion
     * @param int $id
     * @return JsonResponse
     * @throws \Throwable
     * @author jose vasquez
     */
    public function activarAutogestion(int $id): JsonResponse
    {
        try {
            $cita = $this->citaService->activarAutogestion($id);
            return response()->json($cita, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'ha ocurrido un error al activar la cita para autogestion'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
