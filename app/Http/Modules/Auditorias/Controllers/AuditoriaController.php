<?php

namespace App\Http\Modules\Auditorias\Controllers;

use App\Http\Modules\Auditorias\Requests\GestionarAuditoriaCodigosPropiosRequest;
use App\Http\Modules\Auditorias\Requests\GestionarAuditoriaMedicamentosRequest;
use App\Http\Modules\Auditorias\Requests\GestionarAuditoriaServiciosRequest;
use App\Http\Modules\Auditorias\Services\AuditoriaService;
use App\Http\Modules\Ordenamiento\Repositories\OrdenRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Http\Modules\Ordenamiento\Models\Orden;
use App\Http\Modules\Auditorias\Models\Auditoria;
use App\Http\Modules\CambiosOrdenes\Models\CambiosOrdene;
use App\Http\Modules\Ordenamiento\Models\OrdenArticulo;
use App\Http\Modules\Ordenamiento\Models\OrdenCodigoPropio;
use App\Http\Modules\Ordenamiento\Models\OrdenProcedimiento;
use App\Http\Modules\Ordenamiento\Repositories\OrdenArticuloRepository;
use App\Http\Modules\Ordenamiento\Repositories\OrdenCodigoPropioRepository;
use App\Http\Modules\Ordenamiento\Repositories\OrdenProcedimientoRepository;

class AuditoriaController extends Controller
{

    public function __construct(
        private readonly OrdenProcedimientoRepository $ordenProcedimientoRepository,
        private readonly OrdenArticuloRepository      $ordenArticuloRepository,
        private readonly OrdenCodigoPropioRepository  $ordenCodigoPropioRepository,
        private readonly OrdenRepository              $ordenRepository,
        private readonly AuditoriaService             $auditoriaService
    )
    {
    }


    public function auditoria(Request $request)
    {
        try {
            $query = null;

            switch (intval($request->tipo)) {
                case 1:
                    // Código del caso 1 permanece igual
                    $query = Orden::with([
                        'consulta.afiliado' => function ($query) {
                            $query->with([
                                'departamento_afiliacion',
                                'tipoDocumento',
                                'ips'
                            ]);
                        },
                        'funcionario.operador',
                        'articulos' => function ($query) {
                            $query->with('rep')
                                ->where('estado_id', 3);
                        }
                    ])
                        ->select(['ordenes.id', DB::raw("TO_CHAR(ordenes.created_at, 'yyyy-MM-dd') as fecha_creacion"), 'ordenes.consulta_id', 'ordenes.user_id'])
                        ->where('ordenes.tipo_orden_id', 1)
                        ->whereHas('articulos', function ($query) {
                            $query->where('estado_id', 3);
                        });

                    if ($request->documento) {
                        $query->whereHas('consulta.afiliado', function ($q) use ($request) {
                            $q->where('numero_documento', $request->documento);
                        });
                    }

                    if ($request->departamento) {
                        $query->whereHas('consulta.afiliado', function ($q) use ($request) {
                            $q->where('departamento_atencion_id', $request->departamento);
                        });
                    }

                    if ($request->orden_id) {
                        $query->where('ordenes.id', $request->orden_id);
                    }

                    if ($request->fecha_inicio && $request->fecha_final) {
                        $query->whereBetween('ordenes.created_at', [$request->fecha_inicio, $request->fecha_final]);
                    }

                    break;
                case 2:
                    $query = Orden::with([
                        'consulta.afiliado' => function ($query) {
                            $query->with([
                                'departamento_afiliacion',
                                'tipoDocumento:id,nombre',
                                'ips:id,nombre'
                            ]);
                        },
                        'funcionario.operador',
                        'procedimientos' => function ($query) use ($request) {
                            $query->where('estado_id', 3)
                                ->with([
                                    'rep:id,nombre,telefono1,direccion',
                                    'cup.familias:id,nombre',
                                    'cambioOrden' => function ($query) {
                                        $query->where('accion', 'Creación de nota adicional')
                                            ->with(['user' => function ($query) {
                                                $query->select('id')->with('operador:nombre,user_id');
                                            }]);
                                    }
                                ]);

                            if (isset($request->cirugia) && $request->cirugia) {
                                $query->whereHas('cup.familias', function ($query) {
                                    $query->whereIn('familias.id', [8, 9]);
                                });
                            } else {
                                $query->whereDoesntHave('cup.familias', function ($query) {
                                    $query->whereIn('familias.id', [8, 9]);
                                });
                            }
                        },
                        'ordenesCodigoPropio' => function ($query) {
                            $query->with('rep', 'codigoPropio')
                                ->where('estado_id', 3);
                        }
                    ])
                        ->select(['ordenes.id', DB::raw("TO_CHAR(ordenes.created_at, 'yyyy-MM-dd') as fecha_creacion"), 'ordenes.consulta_id', 'ordenes.user_id'])
                        ->whereIn('ordenes.tipo_orden_id', [2, 3])
                        ->where(function ($query) use ($request) {
                            $query->whereHas('procedimientos', function ($query) use ($request) {
                                $query->where('estado_id', 3);
                                if (isset($request->cirugia) && $request->cirugia) {
                                    $query->whereHas('cup.familias', function ($query) {
                                        $query->whereIn('familias.id', [8, 9]);
                                    });
                                } else {
                                    $query->whereDoesntHave('cup.familias', function ($query) {
                                        $query->whereIn('familias.id', [8, 9]);
                                    });
                                }
                            })
                                ->orWhereHas('ordenesCodigoPropio', function ($query) {
                                    $query->where('estado_id', 3);
                                });
                        })
                        ->whereHas('consulta.afiliado', function ($query) use ($request) {
                            if ($request->documento) {
                                $query->where('numero_documento', $request->documento);
                            }
                            if ($request->departamento) {
                                $query->where('departamento_atencion_id', $request->departamento);
                            }
                        });

                    if ($request->orden_id) {
                        $query->where('ordenes.id', $request->orden_id);
                    }

                    if ($request->fecha_inicio && $request->fecha_final) {
                        $query->whereBetween('ordenes.created_at', [$request->fecha_inicio, $request->fecha_final]);
                    }


                    break;
            }

            $ordenes = $request->page ? $query->paginate($request->cant) : $query->get();
            return response()->json($ordenes, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'res' => false,
                'mensaje' => $th->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    public function detalleAuditoria($consulta)
    {
        //        switch (intval($tipo)) {
        //            case 1:
        $articulos = OrdenArticulo::select([
            "o.consulta_id",
            "orden_articulos.codesumi_id",
            "orden_articulos.estado_id",
            "orden_articulos.meses",
            "orden_articulos.dosis",
            "orden_articulos.frecuencia",
            "orden_articulos.unidad_tiempo",
            "orden_articulos.duracion",
            "orden_articulos.meses",
            "orden_articulos.cantidad_medico",
            "orden_articulos.observacion",
            "o.id as orden_id",
        ])->join('ordenes as o', 'o.id', 'orden_articulos.orden_id')
            ->where('o.consulta_id', $consulta)
            ->where('orden_articulos.estado_id', 3)->distinct()->get();

        $procedimientos = OrdenProcedimiento::select([
            "o.consulta_id",
            "orden_procedimientos.cup_id",
            "orden_procedimientos.estado_id",
            "orden_procedimientos.fecha_vigencia",
            "orden_procedimientos.cantidad"
        ])->join('ordenes as o', 'o.id', 'orden_procedimientos.orden_id')
            ->where('o.consulta_id', $consulta)
            ->where('orden_procedimientos.estado_id', 3)->distinct()->get();

        //                break;
        //        }
        return response()->json(["articulos" => $articulos, "procedimientos" => $procedimientos], Response::HTTP_OK);
    }

    public function auditoriaEstado(Request $request)
    {

        //        try {
        if (isset($request->articulos) && count($request->articulos) > 0) {

            foreach ($request->articulos as $detalle) {
                $articulos = OrdenArticulo::select([
                    'orden_articulos.*'
                ])->join('ordenes as o', 'orden_articulos.orden_id', 'o.id')
                    ->where('orden_articulos.codesumi_id', $detalle["codesumi_id"])
                    ->where('o.id', $detalle['orden_id'])
                    ->where('orden_articulos.estado_id', 3)->get();
                foreach ($articulos as $articulo) {
                    $auditoria = new Auditoria();
                    $auditoria->orden_articulo_id = $articulo->id;
                    $auditoria->user_id = auth()->id();
                    $auditoria->observaciones = $request->observacion;
                    $auditoria->fundamento_legal = $request->fundamento_legal;
                    $auditoria->alternativas_acceso_salud = $request->alternativas_acceso_salud;
                    $auditoria->tipo_plan_usuario = $request->tipo_plan_usuario;
                    $auditoria->save();
                    $articulo->estado_id = $request->estado;
                    $articulo->save();
                }
                if ($request->estado == 1) {
                    $this->ordenArticuloRepository->calcularFecha($detalle["id"]);
                }
            }
        }

        if (isset($request->procedimientos) && count($request->procedimientos) > 0) {
            foreach ($request->procedimientos as $detalle) {
                $procedimientos = OrdenProcedimiento::select([
                    'orden_procedimientos.*'
                ])->join('ordenes as o', 'orden_procedimientos.orden_id', 'o.id')
                    ->where('orden_procedimientos.cup_id', $detalle["cup_id"])
                    ->where('o.consulta_id', $request->consulta)
                    ->where('orden_procedimientos.estado_id', 3)->get();

                foreach ($procedimientos as $procedimiento) {
                    $auditoria = new Auditoria();
                    $auditoria->orden_procedimiento_id = $procedimiento->id;
                    $auditoria->user_id = auth()->id();
                    $auditoria->observaciones = $request->observacion;
                    $auditoria->fundamento_legal = $request->fundamento_legal;
                    $auditoria->alternativas_acceso_salud = $request->alternativas_acceso_salud;
                    $auditoria->tipo_plan_usuario = $request->tipo_plan_usuario;
                    $auditoria->save();
                    $procedimiento->estado_id = $request->estado;
                    $procedimiento->fecha_vigencia = isset($request->fecha_vigencia) ? $request->fecha_vigencia : $procedimiento->fecha_vigencia;
                    $procedimiento->save();
                }
                if ($request->estado == 1) {
                    $this->ordenProcedimientoRepository->calcularFecha($detalle["id"]);
                }
            }
        }

        if (isset($request->codigosPropios) && count($request->codigosPropios) > 0) {
            foreach ($request->codigosPropios as $detalle) {
                $codigosPropios = OrdenCodigoPropio::select([
                    'orden_codigo_propios.*'
                ])->join('ordenes as o', 'orden_codigo_propios.orden_id', 'o.id')
                    ->where('orden_codigo_propios.codigo_propio_id', $detalle["codigo_propio_id"])
                    ->where('o.consulta_id', $request->consulta)
                    ->where('orden_codigo_propios.estado_id', 3)->get();

                foreach ($codigosPropios as $codigo) {
                    $auditoria = new Auditoria();
                    $auditoria->orden_codigo_propio_id = $codigo->id;
                    $auditoria->user_id = auth()->id();
                    $auditoria->observaciones = $request->observacion;
                    $auditoria->fundamento_legal = $request->fundamento_legal;
                    $auditoria->alternativas_acceso_salud = $request->alternativas_acceso_salud;
                    $auditoria->tipo_plan_usuario = $request->tipo_plan_usuario;
                    $auditoria->save();
                    $codigo->estado_id = $request->estado;
                    $codigo->fecha_vigencia = isset($request->fecha_vigencia) ? $request->fecha_vigencia : $codigo->fecha_vigencia;
                    $codigo->save();
                }
                if ($request->estado == 1) {
                    $this->ordenCodigoPropioRepository->calcularFecha($detalle["id"]);
                }
            }
        }


        return response()->json("Datos Actualizados!", Response::HTTP_OK);
        //        } catch (\Throwable $th) {
        //            return response()->json([
        //                'res' => false,
        //                'mensaje' => 'Error al actualizar las ordenes',
        //            ], Response::HTTP_BAD_REQUEST);
        //        }

    }

    public function listarAuditoriaPrestador(Request $request)
    {
        try {
            $auditoria = $this->ordenProcedimientoRepository->listarAuditoriaPrestador($request->all());
            return response()->json($auditoria, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function visionTotal(Request $request)
    {
        $result = [];
        $appointments = Collect(DB::select("SET NOCOUNT ON exec dbo.SP_Ordenamientos_Vision_Total ?,?,?", [$request->fechaDesde, $request->fechaHasta, $request->entidad]));
        $result = json_decode($appointments, true);
        return (new FastExcel($result))->download('file.xls');
    }

    public function exportar(Request $request)
    {
        // return $request->all();

        $excel = array_map(
            function ($data) {
                // return $data['idServicio'];
                $array = [
                    "NUMERO" => $data['idServicio'],
                    "NUMERO ORDEN" => $data["id"],
                    "NUMERO IDENTIFICACION" => $data["numero_documento"],
                    "CONTRATO" => $data["UT"],
                    "NOMBRES" => $data["primer_nombre"] . " " . $data["segundo_nombre"],
                    "APELLIDOS" => $data["primer_apellido"] . " " . $data["segundo_apellido"],
                    "IPS PRIMARIA" => $data["Prestadores"],
                    "DIRECCION" => $data["direccion_Residencia_cargue"],
                    "CORREO" => $data["correo1"],
                    "TELEFONO" => $data["telefono"],
                    "CELULAR" => $data["celular1"],
                    "DIAGNOSTICO" => $data["Codigo_CIE10"],
                    "CUP" => $data["Cup_codigo"],
                    "ESTADO AUDITORIA" => $data['Estado'],
                    "NOTA AUDITORIA" => $data['observacionAuditoria'],
                    "DESCRIPCION CUP" => $data["Cup_nombre"],
                    "FECHA ORDEN" => $data["fechaOrdenamiento"],
                    "FECHA TOMA" => "",
                    "FECHA RESULTADO" => ""
                ];
                return $array;
            },
            $request->all()
        );
        // return $excel;
        return (new FastExcel($excel))->download('file.xls');
    }

    public function oncologia(Request $request)
    {
        //        try {
        $query = [];
        //        switch (intval($tipo)) {
        $query = Orden::select([
            DB::raw("FORMAT(created_at,'yyyy-MM-dd') as fecha_creacion"),
            'consulta_id',
            'user_id'
        ])->with(['consulta', 'consulta.afiliado', 'funcionario', 'articulos' => function ($query) {
            $query->select(
                'orden_articulos.id',
                'orden_articulos.orden_id',
                'orden_articulos.codesumi_id',
                // 'auditorias.created_at as fechaAutorizacion',
                // 'auditorias.observaciones as nota_autorizacion',
                'orden_articulos.created_at as FechaOrdenamiento',
                'orden_articulos.dosis',
                'orden_articulos.frecuencia',
                'orden_articulos.unidad_tiempo',
                'orden_articulos.duracion',
                'orden_articulos.cantidad_mensual',
                'orden_articulos.meses',
                'orden_articulos.observacion',
                'orden_articulos.cantidad_medico',
                'orden_articulos.fecha_vigencia',
                'orden_articulos.estado_id',
                'orden_articulos.estado_enfermeria',
            //         'detaarticulordens.notaFarmacia',
            )
                ->where('estado_id', '=', 3)
                ->get();
        }])
            ->whereYear('created_at', $request->anio)
            ->whereMonth('created_at', $request->mes)
            ->whereHas('articulos', function ($query) {
                $query->where('estado_id', 3);
            })
            ->where('tipo_orden_id', 3);
        //
        if ($request->documento) {
            $query->whereHas('consulta.afiliado', function ($q) use ($request) {
                $q->where('numero_documento', $request->documento);
            });
        }
        $ordenes = $query->distinct()->get();
        return response()->json($ordenes, Response::HTTP_OK);
        //        } catch (\Throwable $th) {
        //            return response()->json([
        //                'res' => false,
        //                'mensaje' => 'Error al recuperar las ordenes',
        //            ], Response::HTTP_BAD_REQUEST);
        //        }
    }


    public function cambiarAuditoriaEstado(Request $request)
    {

        if ($request->tipo == 1) {
            OrdenArticulo::find($request->id)->update(['estado_id' => $request->estado]);
            $auditoria = new CambiosOrdene();
            $auditoria->orden_articulo_id = $request->id;
            $auditoria->user_id = auth()->id();
            $auditoria->observacion = $request->observacion;
            $auditoria->estado = $request->estado;
            $auditoria->save();
            if ($request->estado == 1) {
                $this->ordenArticuloRepository->calcularFecha($request["id"]);
            }
        }

        if ($request->tipo == 2) {
            OrdenProcedimiento::where('id', $request['id'])->update(['estado_id' => $request['estado']]);

            $auditoria = new CambiosOrdene();
            $auditoria->orden_procedimiento_id = $request->id;
            $auditoria->user_id = auth()->id();
            $auditoria->observacion = $request->observacion;
            $auditoria->estado = $request->estado;
            $auditoria->save();
            // if($request->estado ==1){
            //     $this->ordenProcedimientoRepository->calcularFecha($request->id);
            // }

        }


        if ($request->tipo == 3) {
            OrdenCodigoPropio::find($request->id)->update(['estado_id' => $request['estado']]);

            $auditoria = new CambiosOrdene();
            $auditoria->orden_codigo_propio_id = $request->id;
            $auditoria->user_id = auth()->id();
            $auditoria->observacion = $request->observacion;
            $auditoria->estado = $request->estado;
            $auditoria->save();

        }

        return response()->json("Datos Actualizados!", Response::HTTP_OK);
    }

    /**
     * Lista las órdenes de serivicios por auditar
     * @param Request $request
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function listarOrdenesServiciosPorAuditar(Request $request): JsonResponse
    {
        try {
            $ordenes = $this->ordenRepository->listarOrdenesServiciosPorAuditar($request->all());
            return response()->json($ordenes, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Gestiona la auditoría de servicios
     * @param GestionarAuditoriaServiciosRequest $request
     * @return JsonResponse
     * @throws Throwable
     * @author Thomas
     */
    public function gestionarAuditoriaServicios(GestionarAuditoriaServiciosRequest $request): JsonResponse
    {
        try {
            $response = $this->auditoriaService->gestionarAuditoriaServicios($request->validated());
            return response()->json($response, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Lista las ordenes de codigos propios con elementos pendientes por auditar
     * @param Request $request
     * @return JsonResponse
     * @throws \Throwable
     * @author Thomas
     */
    public function listarOrdenesCodigosPropiosPorAuditar(Request $request): JsonResponse
    {
        try {
            $ordenes = $this->ordenRepository->listarOrdenesCodigosPropiosPorAuditar($request->all());
            return response()->json($ordenes, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Gestiona la auditoría de codigos propios
     * @param GestionarAuditoriaCodigosPropiosRequest $request
     * @return JsonResponse
     * @throws Throwable
     * @author Thomas
     */
    public function gestionarAuditoriaCodigosPropios(GestionarAuditoriaCodigosPropiosRequest $request): JsonResponse
    {
        try {
            $response = $this->auditoriaService->gestionarAuditoriaCodigosPropios($request->validated());
            return response()->json($response, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Lista las órdenes de medicamentos por auditar
     * @param Request $request
     * @return JsonResponse
     * @throws Throwable
     * @author Thomas
     */
    public function listarOrdenesMedicamentosPorAuditar(Request $request): JsonResponse
    {
        try {
            $ordenes = $this->ordenRepository->listarOrdenesMedicamentosPorAuditar($request->all());
            return response()->json($ordenes, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Gestiona la auditoría de medicamentos
     * @param GestionarAuditoriaMedicamentosRequest $request
     * @return JsonResponse
     * @throws Throwable
     * @author Thomas
     */
    public function gestionarAuditoriaMedicamentos(GestionarAuditoriaMedicamentosRequest $request): JsonResponse
    {
        try {
            $response = $this->auditoriaService->gestionarAuditoriaMedicamentos($request->validated());
            return response()->json($response, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


}
