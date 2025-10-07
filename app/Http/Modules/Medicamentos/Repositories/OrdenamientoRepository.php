<?php

namespace App\Http\Modules\Medicamentos\Repositories;

use App\Formats\ServicioGestion;
use App\Formats\MedicamentoGestion;
use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Agendas\Models\Agenda;
use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Ordenamiento\Models\Orden;
use App\Http\Modules\Ordenamiento\Models\OrdenArticulo;
use App\Http\Modules\Auditorias\Repositories\AuditoriaRepository;
use App\Http\Modules\CambiosOrdenes\Models\CambiosOrdene;
use App\Http\Modules\Ordenamiento\Models\OrdenCodigoPropio;
use App\Http\Modules\Ordenamiento\Models\OrdenProcedimiento;
use App\Http\Modules\Ordenamiento\Repositories\OrdenArticuloRepository;
use App\Http\Modules\Ordenamiento\Repositories\OrdenProcedimientoRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Rap2hpoutre\FastExcel\FastExcel;

class OrdenamientoRepository
{
    protected $model;

    public function __construct(
        private OrdenArticuloRepository $ordenArticuloRepository,
        private OrdenProcedimientoRepository $ordenProcedimientoRepository,
        private AuditoriaRepository $auditoriaRepository
    ) {
        $this->model = new Orden();
    }

    public function ordenamientoMedicamento($consulta)
    {
        $arrIdMedicamentos = [];
        $ordenes = $this->model->where('consulta_id', $consulta)->where('tipo_orden_id', 1)->orderBy('id', 'ASC')->get(["id"])->toArray();
        foreach ($ordenes as $orden) {
            $arrIdMedicamentos[] = $orden["id"];
        }
        return $arrIdMedicamentos;
    }

    public function ordenamientoServicios($consulta)
    {
        $arrIdServicios = [];
        $ordenes = $this->model->where('consulta_id', $consulta)->where('tipo_orden_id', 2)->orderBy('id', 'ASC')->get(['id'])->toArray();
        foreach ($ordenes as $orden) {
            $arrIdServicios[] = $orden["id"];
        }
        return $arrIdServicios;
    }

    public function ordenamientoCodigosPropios($consulta)
    {
        $arrIdCodigosPropios = [];
        $ordenes = $this->model->where('consulta_id', $consulta)->where('tipo_orden_id', 3)->orderBy('id', 'ASC')->get(['id'])->toArray();
        foreach ($ordenes as $orden) {
            $arrIdCodigosPropios[] = $orden["id"];
        }
        return $arrIdCodigosPropios;
    }

    public function ordenMedicamnetosAutogestion($data)
    {
        $orden = $this->model->select(
            'ordenes.id',
            'ordenes.consulta_id',
            'ordenes.paginacion',
            'ordenes.estado_id',
            'tipo_ordenes.nombre as tipo',
            'orden_articulos.fecha_vigencia'
        )
            ->selectRaw("COUNT(orden_articulos.id) as cantidad")
            ->join('consultas', 'consultas.id', 'ordenes.consulta_id')
            ->join('afiliados', 'afiliados.id', 'consultas.afiliado_id')
            ->join('tipo_ordenes', 'tipo_ordenes.id', 'ordenes.tipo_orden_id')
            ->join('orden_articulos', 'orden_articulos.orden_id', 'ordenes.id')
            ->whereBetween('orden_articulos.fecha_vigencia', [date('Y-m-d', strtotime(date("d-m-y") . "-1 month")), date('Y-m-d')])
            ->where('afiliados.numero_documento', $data['cedula'])
            ->where('afiliados.entidad_id', 1)
            ->whereIn('orden_articulos.estado_id', [1, 14])
            ->groupBy(
                'ordenes.id',
                'ordenes.consulta_id',
                'ordenes.paginacion',
                'ordenes.estado_id',
                'tipo_ordenes.nombre',
                'orden_articulos.fecha_vigencia'
            )
            ->havingRaw('COUNT(orden_articulos.id) > 0');

        return  $data['page'] ? $orden->paginate($data['cantidad']) : $orden->get();
    }

    public function pdf($data)
    {
        if ($data['tipo'] == 'otros') {
            $fecha_estimada = date("Y-m-d", strtotime("+" . 1 . " months"));
            $orden = $this->ordenProcedimientoRepository->obtenerOrden($data['orden_id']);
        } elseif ($data['tipo'] == 'formula') {
            $orden = $this->ordenArticuloRepository->obtenerOrden($data['orden_id']);
            if ($orden) {
                if ($orden->estado_id == 10) {
                    $fecha_estimada = date("Y-m-d", strtotime("+" . 2 . " months", strtotime($orden->fecha_vigencia)));
                } else {
                    $fecha_estimada = date("Y-m-d", strtotime("+" . 28 . " days", strtotime($orden->fecha_vigencia)));
                }
            }
        } else {
            if (isset($data['numero'])) {
                if (empty($data['numero'])) {
                    $data['numero'] = 1;
                }
                $fecha_estimada = date("Y-m-d", strtotime("+" . strval(intval($data['numero']) * 28) . " day"));
            }
        }

        $datos = [
            'sexo'                    => (isset($data['Sexo']) ? $data['Sexo'] : ''),
            'edad_Cumplida'           => (isset($data['Edad_Cumplida']) ? $data['Edad_Cumplida'] : ''),
            'primer_nombre'           => (isset($data['Primer_Nom']) ? $data['Primer_Nom'] : ''),
            'segundo_nombre'          => (isset($data['Segundo_Nom']) ? $data['Segundo_Nom'] : ''),
            'primer_apellido'         => (isset($data['Primer_Ape']) ? $data['Primer_Ape'] : ''),
            'segundo_apellido'        => (isset($data['Segundo_Ape']) ? $data['Segundo_Ape'] : ''),
            'numero_documento'        => (isset($data['Num_Doc']) ? $data['Num_Doc'] : ''),
            'ips'                     => (isset($data['ips']) ? $data['ips'] : ''),
            'direccion'               => (isset($data['Direccion_Residencia']) ? $data['Direccion_Residencia'] : ''),
            'correo'                  => (isset($data['Correo']) ? $data['Correo'] : ''),
            'telefono'                => (isset($data['Telefono']) ? $data['Telefono'] : ''),
            'estado_afiliado'         => (isset($data['Estado_Afiliado']) ? $data['Estado_Afiliado'] : ''),
            'medicamentos'            => (isset($data['medicamentos']) ? $data['medicamentos'] : ''),
            'servicios'               => (isset($data['servicios']) ? $data['servicios'] : ''),
            'orden_id'                => (isset($data['orden_id']) ? $data['orden_id'] : ''),
            'Fecha_actual'            => date("Y-m-d H:i:s"),
            'Fecha_estimada'          => $fecha_estimada,
            'mensaje'                 => (isset($data['mensaje']) ? $data['mensaje'] : ''),
            'fecha_orden' => $orden->fecha_vigencia

            // 'FechaInicio'             => $request->FechaInicio,
            // 'CantidadDias'            => $request->CantidadDias,
            // 'FechaFinal'              => $request->FechaFinal,
            // 'Prorroga'                => $request->Prorroga,
            // 'Contingencia'            => $request->Contingencia,
            // 'Descripcion'             => $request->Descripcion,
            // 'Firma'                   => $request->Firma,
            // 'TextCie10'               => $request->TextCie10,
            // 'Especialidad'            => $request->Especialidad,
        ];



        if ($data['tipo'] == 'formula') {
            $pdf = new MedicamentoGestion();
            return  $pdf->generar($datos, "F O R M U L A  M E D I C A");
        } elseif ($data['tipo'] == 'otros') {
            $pdf = new ServicioGestion();
            return  $pdf->generar($datos);
        }
    }

    public function ordenamientoOncologia($afiliado)
    {

        return $this->model->join('consultas', 'consultas.id', 'ordenes.consulta_id')->join('afiliados', 'afiliados.id', 'consultas.afiliado_id')->where('afiliados.id', $afiliado)->where('tipo_orden_id', 3)->orderBy('ordenes.id', 'Desc')->first();
    }

    public function cancelarEsquema($orden_id)
    {
        $orden = $this->model::find($orden_id)->update([
            'estado_id' => 30
        ]);
        OrdenArticulo::where('orden_id', $orden_id)->update(['estado_id' => 30]);

        return 'Exito';
    }

    public function actualizarOrden($orden_id, $fecha, $consulta)
    {

        $orden = $this->model::find($orden_id)->update([
            'fecha_agendamiento' => $fecha,
            'consulta_aplicacion_id' => $consulta
        ]);

        return 'Exito';
    }

    public function aplicacionesAgendadas($data)
    {
        $orden = $this->model->select([
            'ordenes.id',
            'ordenes.consulta_id',
            'ordenes.nombre_esquema',
            'ordenes.paginacion',
            'ordenes.dia',
            'ordenes.estado_id',
            'e.Nombre as estado',
            'ordenes.fecha_agendamiento',
        ])->with([
            'articulos' => function ($query) {
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
                    // ->leftjoin('auditorias','auditorias.orden_articulo_id','orden_articulos.id')
                    // ->where('auditorias.tipo_id',44)
                    ->with(['auditorias' => function ($query) {
                        $query->select('created_at as fechaAutorizacion', 'observaciones as nota_autorizacion', 'orden_articulo_id', 'id')
                            ->where('tipo_id', 44)
                            ->get();
                    }])
                    ->get();
            },
            'consulta'
        ])
            ->join('estados as e', 'e.id', 'ordenes.estado_id')
            // ->where('ordenes.estado_id', 1)
            ->whereNotNull('ordenes.nombre_esquema')
            ->where('ordenes.tipo_orden_id', 3)
            ->where('ordenes.fecha_agendamiento', $data['fecha_agendamiento']);
        return $data->page ? $orden->paginate($data->cant) : $orden->get();
    }


    public function finalizarAplicacion($data)
    {
        $orden = $this->model::find($data['orden_id'])->update(['estado_id' => 49]);
        foreach ($data['orden_articulo'] as $articulo) {
            OrdenArticulo::find($articulo['id'])->update(['estado_id' => 49, 'estado_enfermeria' => true]);
        }
        $ordenArticulo = OrdenArticulo::where('estado_id', '!=', 49)->where('orden_id', $data['orden_id'])->get();
        foreach ($ordenArticulo as $articulo) {
            $articulo->update(['estado_id' => 30, 'estado_enfermeria' => true]);
        }
        return 'Exito';
    }

    public function consultaEsquemaPaciente($data)
    {
        $orden = $this->model->select([
            'ordenes.id',
            'ordenes.consulta_id',
            'ordenes.nombre_esquema',
            'ordenes.paginacion',
            'ordenes.dia',
            'ordenes.estado_id',
            'e.Nombre as estado',
            'ordenes.fecha_agendamiento',
            'ordenes.consulta_aplicacion_id'
        ])->with([
            'articulos' => function ($query) {
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
                    // ->leftjoin('auditorias','auditorias.orden_articulo_id','orden_articulos.id')
                    ->get();
            },
            'consulta'
        ])
            ->join('estados as e', 'e.id', 'ordenes.estado_id')
            ->join('consultas', 'consultas.id', 'ordenes.consulta_id')
            ->where('ordenes.estado_id', '!=', 30)
            ->whereNotNull('ordenes.nombre_esquema')
            ->where('ordenes.tipo_orden_id', 3)
            ->where('consultas.afiliado_id', $data['afiliado_id']);
        return $data->page ? $orden->paginate($data->cant) : $orden->get();
    }

    public function suspenderEsquema($data)
    {
        foreach ($data['orden'] as $orden) {
            if ($orden['consulta_aplicacion_id'] && $orden['estado_id'] == 1) {
                $consulta = Consulta::find($orden['consulta_aplicacion_id']);
                Agenda::find($consulta->agenda_id)->update(['estado_id' => 11]);
                $consulta->update(['estado_id' => 30]);
                // return $agenda;
            }
            // return $orden;
            $this->model::find($orden['id'])->update(['estado_id' => 50]);

            foreach ($orden['articulos'] as $articulo) {
                OrdenArticulo::find($articulo['id'])->update(['estado_id' => 50]);
                $this->auditoriaRepository->crearAuditoria($articulo['id'], $data['observacion'], 44);
            }
        }
        return 'exito';
    }

    public function suspender($data)
    {
        $consultaId = $this->model->where('id', $data['orden'])->value('consulta_id');

        $ordenes = Orden::where('consulta_id', $consultaId)->get();

        $ordenArticuloIds = [];

        foreach ($ordenes as $orden) {
            $ordenArticulos = OrdenArticulo::where('orden_id', $orden->id)
                ->where('codesumi_id', $data['codesumi'])
                ->whereIn('estado_id', [1, 4])
                ->get();

            foreach ($ordenArticulos as $ordenArticulo) {
                $ordenArticulo->motivo_suspension = $data['motivo'];
                $ordenArticulo->fecha_suspension = Carbon::now();
                $ordenArticulo->funcionario_suspende = auth()->user()->id;
                $ordenArticulo->estado_id = 44;
                $ordenArticulo->save();

                $ordenArticuloIds[] = $ordenArticulo->id;
            }
        }

        return $ordenArticuloIds;
    }


    public function exportarServicios($data)
    {
        // if($data->servicio == null){
        //     $data->servicio = '';
        // }else{
        //     $data->servicio = $data->servicio;
        // }
        $appointments = Collect(DB::select("SET NOCOUNT ON exec dbo.SP_ServiciosPendientes ?,?,?", [$data['fecha_inicial'], $data['fecha_final'], $data->estado_id]));
        $array = json_decode($appointments, true);
        return (new FastExcel($array))->download('servicios.xls');
    }

    public function exportarMedicamentos($data)
    {
        $appointments = Collect(DB::select("SET NOCOUNT ON exec dbo.SP_MedicamentosPendientes ?,?,?", [$data['fecha_inicial'], $data['fecha_final'], $data->estado_id]));
        $array = json_decode($appointments, true);
        return (new FastExcel($array))->download('servicios.xls');
    }

    /**
     * Lista las ordenes de procedimientos y codigos propios activas y autorizadas del afiliado
     *
     * @param number $afiliado_id
     * @return Collection
     * @author Thomas Restrepo
     */
    public function listarOrdenesAfiliado($afiliado_id)
    {
        $urlProyecto = config('services.app_name.nombre_app');
        // Determinar el código del prestador según la URL del proyecto
        $codigoPrestador = match ($urlProyecto) {
            "https://horus-health.com",
            "https://ecoimagenes.horus-health.com" => [2389],
            default => [41903, 61744, 61743],
        };
        // Consultar órdenes de procedimientos
        $ordenesProcedimientos = OrdenProcedimiento::select([
            'orden_procedimientos.id',
            'orden_procedimientos.orden_id',
            'orden_procedimientos.cup_id',
            'orden_procedimientos.observacion as observaciones',
            'orden_procedimientos.estado_id',
            'orden_procedimientos.rep_id',
            'orden_procedimientos.cantidad',
            'orden_procedimientos.cantidad_usada',
            'orden_procedimientos.cantidad_pendiente',
        ])->with(['cup', 'rep'])
            ->join('ordenes as o', 'o.id', 'orden_procedimientos.orden_id')
            ->join('consultas as c', 'c.id', 'o.consulta_id')
            ->join('afiliados as a', 'a.id', 'c.afiliado_id')
            ->leftjoin('cobro_servicios as cs', 'orden_procedimientos.id', 'cs.orden_procedimiento_id')
            ->whereIn('orden_procedimientos.estado_id', [1, 4])
            ->whereHas('rep', function ($query) use ($codigoPrestador) {
                $query->whereIn('prestador_id', $codigoPrestador);
            })
            ->where('a.id', $afiliado_id)
            ->where(function ($query) {
                //Incluir órdenes con cobros de tipo copago o cuota que estén en estado 14
                $query->where(function ($q) {
                    $q->where('cs.estado_id', 14)
                        ->whereIn('cs.tipo', ['copago', 'cuota']);
                })
                    //O incluir órdenes con cobros de tipo Exento en estado 1
                    ->orWhere(function ($q) {
                        $q->where('cs.estado_id', 1)
                            ->where('cs.tipo', 'Exento');
                    })
                    //O incluir órdenes que no tienen cobro registrado
                    ->orWhereNull('cs.id');
            })
            ->get()
            ->map(function ($orden) {
                return [
                    'id' => $orden->id,
                    'orden_id' => $orden->orden_id,
                    'cup_id' => $orden->cup_id,
                    'cup_nombre' => $orden->cup->nombre ?? null,
                    'cup_codigo' => $orden->cup->codigo ?? null,
                    'observaciones' => $orden->observaciones,
                    'estado_id' => $orden->estado_id,
                    'tipo' => 'procedimiento',
                    'rep' => $orden->rep,
                    'cantidad' => $orden->cantidad,
                    'cantidad_pendiente' => $orden->cantidad_pendiente,
                    'cantidad_usada' => $orden->cantidad_usada
                ];
            });

        // Consultar órdenes de códigos propios
        $ordenesCodigoPropios = OrdenCodigoPropio::select([
            'orden_codigo_propios.id',
            'orden_codigo_propios.orden_id',
            'orden_codigo_propios.codigo_propio_id',
            'orden_codigo_propios.observaciones',
            'orden_codigo_propios.estado_id',
            'orden_codigo_propios.rep_id',
            'orden_codigo_propios.cantidad',
            'orden_codigo_propios.cantidad_usada',
            'orden_codigo_propios.cantidad_pendiente',
        ])->with(['codigoPropio.cup', 'rep'])
            ->join('ordenes as o', 'o.id', 'orden_codigo_propios.orden_id')
            ->join('consultas as c', 'c.id', 'o.consulta_id')
            ->join('afiliados as a', 'a.id', 'c.afiliado_id')
            ->leftjoin('cobro_servicios as cs', 'orden_codigo_propios.id', 'cs.orden_codigo_propio_id')
            ->whereIn('orden_codigo_propios.estado_id', [1, 4])
            ->whereHas('rep', function ($query) use ($codigoPrestador) {
                $query->whereIn('prestador_id', $codigoPrestador); // Ordenes direccionadas a
            })
            ->where('a.id', $afiliado_id)
            ->where(function ($query) {
                //Incluir órdenes con cobros de tipo copago o cuota que estén en estado 14
                $query->where(function ($q) {
                    $q->where('cs.estado_id', 14)
                        ->whereIn('cs.tipo', ['copago', 'cuota']);
                })
                    //O incluir órdenes con cobros de tipo Exento en estado 1
                    ->orWhere(function ($q) {
                        $q->where('cs.estado_id', 1)
                            ->where('cs.tipo', 'Exento');
                    })
                    //O incluir órdenes que no tienen cobro registrado
                    ->orWhereNull('cs.id');
            })
            ->get()
            ->map(function ($orden) {
                return [
                    'id' => $orden->id,
                    'orden_id' => $orden->orden_id,
                    'cup_id' => $orden->codigoPropio->cup->id ?? null,
                    'cup_nombre' => $orden->codigoPropio->cup->nombre ?? null,
                    'cup_codigo' => $orden->codigoPropio->cup->codigo ?? null,
                    'observaciones' => $orden->observaciones,
                    'estado_id' => $orden->estado_id,
                    'tipo' => 'codigo_propio',
                    'rep' => $orden->rep,
                    'cantidad' => $orden->cantidad,
                    'cantidad_pendiente' => $orden->cantidad_pendiente,
                    'cantidad_usada' => $orden->cantidad_usada
                ];
            });

        // Combinar ambas colecciones sin `merge()`, por ejemplo, concatenando los resultados
        $ordenesUnificadas = collect($ordenesProcedimientos)->concat($ordenesCodigoPropios);

        return $ordenesUnificadas->values(); // Retornar la colección unificada con los índices reordenados
    }
    public function guardarAuditoriaDireccionamiento(array $ordenes)
    {
        if ($ordenes['tipo'] == 1) {
            $reps = OrdenArticulo::whereIn('id', $ordenes['seleccionados'])->pluck('rep_id', 'id')->toArray();
            $ordenId = 'orden_articulo_id';
        }

        if ($ordenes['tipo'] == 2) {
            $reps = OrdenProcedimiento::whereIn('id', $ordenes['seleccionados'])->pluck('rep_id', 'id')->toArray();
            $ordenId = 'orden_procedimiento_id';
        }

        if ($ordenes['tipo'] == 3) {
            $reps = OrdenCodigoPropio::whereIn('id', $ordenes['seleccionados'])->pluck('rep_id', 'id')->toArray();
            $ordenId = 'orden_codigo_propio_id';
        }

        $resultado = [];
        foreach ($reps as $id => $rep_id) {
            $resultado[] = [
                $ordenId => $id,
                'rep_anterior_id' => $rep_id,
                'user_id' => Auth::id(),
                'estado' => 5,
                'accion' => 'Actualizacion de Direccionamiento',
                'observacion' => 'Cambio en el direccionamiento Masivo ',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        };

        return CambiosOrdene::insert($resultado);
    }

    public function auditoriaOrdenArticulo(array $data)
    {
        $consulta = [
            'orden_articulo_id' => $data['id'],
            'user_id' => Auth::id(),
            'estado' => $data['estado_id'],
            'accion' => 'Autorización de medicamento',
            'observacion' => $data['observaciones'],
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        return CambiosOrdene::insert($consulta);
    }

    public function ordenesMedicamentosAfiliado($request)
    {
        $usuarioLoggeado = auth()->user()->id;

        $afiliadoId = Afiliado::where('user_id', $usuarioLoggeado)->first()->id;

        $ordenArticulos = OrdenArticulo::with(['orden', 'estado'])
            ->whereIn('estado_id', [1, 4])
            ->whereHas('orden.consulta', function ($query) use ($afiliadoId) {
                $query->where('afiliado_id', $afiliadoId);
            })
            ->when($request['numeroOrden'], function ($query) use ($request) {
                $query->where('orden_id', $request['numeroOrden']);
            })

            ->orderBy('created_at', 'desc');

        return $ordenArticulos->paginate($request['cant']);
    }

    public function ordenesProcedimientosAfiliado($request)
    {
        $usuarioLoggeado = auth()->user()->id;
        $afiliadoId = Afiliado::where('user_id', $usuarioLoggeado)->first()->id;

        $ordenProcedimientos = OrdenProcedimiento::with(['orden', 'estado', 'cup'])
            ->whereIn('estado_id', [1, 4])
            ->whereHas('orden.consulta', function ($query) use ($afiliadoId) {
                $query->where('afiliado_id', $afiliadoId);
            })

            ->when($request['numeroOrden'], function ($query) use ($request) {
                $query->where('orden_id', $request['numeroOrden']);
            })

            ->orderBy('created_at', 'desc');

        return $ordenProcedimientos->paginate($request['cant']);
    }

    /**
     * lista las ordenes por su fecha de ultimo movimiento
     * @param string $fecha
     * @param bool $withs si quiere que vaya con los withs
     * @param array $estados estos son los estados de los orden articulos
     * @return Collection
     * @author David Peláez
     */
    public function listarOrdenesPorFechaUltimoMovimiento(string $fecha, array $ids = [], bool $withs = false, array $estados = [18, 34])
    {

        $ordenes = Orden::whereIn('id', $ids)
            ->whereHas('articulos', function ($query) use ($fecha) {
                return $query->whereIn('estado_id', [18, 34])
                    ->whereHas('ultimoMovimiento', function ($query) use ($fecha) {
                        return $query->whereDate('created_at', $fecha);
                    });
            });

        if ($withs) {
            $ordenes->with([
                'consulta:id,afiliado_id,tipo_consulta_id',
                'consulta.afiliado',
                'consulta.afiliado.departamento_atencion:id,nombre',
                'consulta.afiliado.municipio_atencion:id,nombre',
                'consulta.afiliado.tipoDocumento:id,sigla',
                'consulta.afiliado.ips:id,nombre',
                'consulta.cie10Afiliado:id,cie10_id,consulta_id',
                'consulta.cie10Afiliado.cie10:id,codigo_cie10',
                'articulos' => function ($query) {
                    $query->whereIn('estado_id', [18, 34]);
                },
                'articulos.repOrDefault',
                'articulos.codesumi:id,nombre,codigo',
                'articulos.ultimoMovimiento' => function ($query) use ($fecha) {
                    $query->whereDate('created_at', $fecha);
                }
            ]);
        }

        return $ordenes->get();
    }

    /**
     * obtiene una orden dispensada o parcial por su id y ultimo movimiento
     * @param int $id
     * @param string $fecha
     * @param bool $withs si quiere que vaya con los withs
     * @return Orden|null
     * @author David Peláez
     */
    public function getOrdenByUltimomovimiento(int $id, string $fecha, bool $withs = false)
    {
        $orden = Orden::where('id', $id)
            ->whereHas('articulos', function ($query) use ($fecha) {
                return $query->whereIn('estado_id', [18, 34])
                    ->whereHas('ultimoMovimiento', function ($query) use ($fecha) {
                        return $query->whereDate('created_at', $fecha);
                    });
            });

        if ($withs) {
            $orden->with([
                'consulta:id,afiliado_id,tipo_consulta_id',
                'consulta.afiliado',
                'consulta.afiliado.departamento_atencion:id,nombre',
                'consulta.afiliado.municipio_atencion:id,nombre',
                'consulta.afiliado.tipoDocumento:id,sigla',
                'consulta.afiliado.ips:id,nombre',
                'consulta.cie10Afiliado:id,cie10_id,consulta_id',
                'consulta.cie10Afiliado.cie10:id,codigo_cie10',
                'articulos' => function ($query) {
                    $query->whereIn('estado_id', [18, 34]);
                },
                'articulos.repOrDefault',
                'articulos.codesumi:id,nombre,codigo',
                'articulos.ultimoMovimiento' => function ($query) use ($fecha) {
                    $query->whereDate('created_at', $fecha);
                }
            ]);
        }

        return $orden->first();
    }
}
