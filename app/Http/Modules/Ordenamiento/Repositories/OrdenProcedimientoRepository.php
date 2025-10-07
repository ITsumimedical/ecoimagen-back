<?php

namespace App\Http\Modules\Ordenamiento\Repositories;


use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\CodigoPropios\Models\CodigoPropio;
use App\Http\Modules\Consultas\Models\ConsultaOrdenProcedimientos;
use App\Http\Modules\Contratos\Models\CobroServicio;
use App\Http\Modules\Ordenamiento\Models\Orden;
use App\Http\Modules\Reps\Models\ParametrizacionCupPrestador;
use App\Http\Modules\Reps\Models\ParametrizacionCupPrestadoresCategoriasLineasBase;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\CambiosOrdenes\Models\CambiosOrdene;
use App\Http\Modules\Cie10\Models\Cie10;
use App\Http\Modules\Cie10Afiliado\Models\Cie10Afiliado;
use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Cups\Models\Cup;
use App\Http\Modules\Historia\Models\HistoriaClinica;
use App\Http\Modules\Operadores\Models\Operadore;
use App\Http\Modules\Ordenamiento\Models\DispensarPrestador;
use App\Http\Modules\Ordenamiento\Models\OrdenArticulo;
use App\Http\Modules\Ordenamiento\Models\OrdenCodigoPropio;
use App\Http\Modules\Ordenamiento\Models\OrdenProcedimiento;
use Error;
use Illuminate\Support\Facades\Auth;

class OrdenProcedimientoRepository extends RepositoryBase
{


    public function __construct(
        protected OrdenProcedimiento $ordenModel,
        protected OrdenCodigoPropio $codigoPropioModel,
        protected OrdenArticulo $articuloModel,
        protected HistoriaClinica $historiaClinica,
        protected Cie10Afiliado $cie10Afiliado,
        protected Cie10 $cie10,
        protected ConsultaOrdenProcedimientos $consultaOrdenProcedimientos,
        protected Orden $orden
    ) {
        parent::__construct($this->ordenModel);
        $this->codigoPropioModel = $codigoPropioModel;
        $this->articuloModel = $articuloModel;
    }

    public function calcularFecha($id)
    {
        $orden = $this->ordenModel->join('ordenes', 'orden_procedimientos.orden_id', 'ordenes.id')->where('orden_procedimientos.id', $id)->first();
        $fecha = Carbon::now();
        if ($orden->paginacion) {
            $paginacion = explode('/', $orden->paginacion);
            for ($i = intval($paginacion[0]); $i <= intval($paginacion[1]); $i++) {
                $anterior = $this->ordenModel->join('ordenes', 'orden_procedimientos.orden_id', 'ordenes.id')->where('ordenes.consulta_id', $orden->consulta_id)->where('ordenes.paginacion', ($i - 1) . "/" . $paginacion[1])->where('autorizacion', $orden->autorizacion)->first();
                $o = $this->ordenModel->join('ordenes', 'orden_procedimientos.orden_id', 'ordenes.id')->where('ordenes.consulta_id', $orden->consulta_id)->where('ordenes.paginacion', $i . "/" . $paginacion[1])->where('autorizacion', $orden->autorizacion)->first();
                if ($anterior) {
                    $fechaAnterior = Carbon::parse($anterior->fecha_vigencia);
                    $o->update([
                        'fecha_vigencia' => $fechaAnterior->addDays(28)
                    ]);
                } else {
                    $o->update([
                        'fecha_vigencia' => $fecha->addDays(0)
                    ]);
                }
            }
        } else {
            $orden->update(['fecha_vigencia' => $fecha->toDateTimeString()]);
        }
    }

    public function ordenServicioAutogestion($data)
    {
        $ordenNueva = [];
        $ordenes = $this->model->select(
            'orden_procedimientos.id',
            'orden_procedimientos.created_at',
            'orden_procedimientos.cantidad',
            'orden_procedimientos.estado_id',
            'ordenes.id as orden',
            'orden_procedimientos.fecha_vigencia',
            'reps.nombre as sede',
            'orden_procedimientos.observacion',
            'ordenes.tipo_orden_id',
            'orden_procedimientos.cup_id'
        )
            ->join('ordenes', 'ordenes.id', 'orden_procedimientos.orden_id')
            ->join('consultas', 'consultas.id', 'ordenes.consulta_id')
            ->join('afiliados', 'afiliados.id', 'consultas.afiliado_id')
            ->leftjoin('reps', 'reps.id', 'orden_procedimientos.rep_id')
            ->with(['cup', 'estado'])
            ->where('afiliados.numero_documento', $data['cedula'])
            ->where('ordenes.tipo_orden_id', 2)
            ->where('orden_procedimientos.estado_id', [1, 14])
            ->get();

        foreach ($ordenes as $key => $orden) {
            $fecha1 = Carbon::now()->format('Y-m-d');
            $fecha2 = Carbon::parse($orden->fecha_vigencia);
            $diasDiferencia = $fecha2->diffInDays($fecha1);
            if ($diasDiferencia < 0) {
                $diasDiferencia = 0;
            }
            $orden['dias'] = $diasDiferencia;
            if ($orden->tipo_orden_id == 2) {
                if (intval($orden->dias) <= 30) {
                    $ordenNueva[] = $orden;
                }
            } else {
                if (intval($orden->dias) <= 60) {
                    $ordenNueva[] = $orden;
                }
            }
        }

        return $ordenNueva;
    }

    public function imprimirServicio($orden_id)
    {
        return $this->model->select(
            'orden_procedimientos.id',
            'orden_procedimientos.created_at',
            'orden_procedimientos.cantidad',
            'orden_procedimientos.estado_id',
            'orden_procedimientos.fecha_vigencia',
            'reps.nombre as ubicacion',
            'reps.direccion',
            'reps.telefono1',
            'orden_procedimientos.observacion',
            'orden_procedimientos.cup_id',
            'afiliados.numero_documento',
            'orden_procedimientos.orden_id',
            'orden_procedimientos.anexo3',
            'reps.id as ubicacion_id'
        )
            ->join('ordenes', 'ordenes.id', 'orden_procedimientos.orden_id')
            ->join('consultas', 'consultas.id', 'ordenes.consulta_id')
            ->join('afiliados', 'afiliados.id', 'consultas.afiliado_id')
            ->leftjoin('reps', 'reps.id', 'orden_procedimientos.rep_id')
            ->with(['cup', 'estado'])
            ->where('orden_procedimientos.orden_id', $orden_id)
            ->where('orden_procedimientos.estado_id', [1, 14])
            ->get();
    }

    public function obtenerOrden($orden_id)
    {

        return $this->ordenModel->select('orden_procedimientos.cup_id', 'orden_procedimientos.fecha_vigencia', 'ordenes.estado_id')
            ->join('ordenes', 'ordenes.id', 'orden_procedimientos.orden_id')
            ->where('orden_procedimientos.orden_id', $orden_id)->first();
    }

    public function listarAuditoriaPrestador($data)
    {

        $usuario = auth()->id();
        $operadores = Operadore::select('prestador_id')->where('user_id', $usuario)->first();
        if (auth()->user()->hasPermissionTo('order.audit-all-orders') && !$operadores) {
            // $ordereds = Orden::select([
            //     'ordens.*',
            //     'to.Nombre as tipoOrden',
            //     'user.name as User_Name',
            //     'user.apellido as User_LastName',
            //     'user.Firma as Medico_Firma',
            //     'cita_paciente.id as citaPaciente_id',
            //     'p.id as Paciente_id',
            //     'p.Departamento',
            //     'p.Ut',
            //     'p.created_at as paciente_created',
            //     'p.Primer_Nom as Primer_Nom',
            //     'p.SegundoNom as Segundo_Nom',
            //     'p.Primer_Ape as Primer_Ape',
            //     'p.Segundo_Ape as Segundo_Ape',
            //     'p.Tipo_Doc as Tipo_Doc',
            //     'p.Num_Doc as Cedula',
            //     'p.Edad_Cumplida as Edad_Cumplida',
            //     'p.Sexo as Sexo',
            //     'p.IPS as IpsAtencion',
            //     'p.Direccion_Residencia as Direccion_Residencia',
            //     'p.Correo1 as Correo',
            //     'p.Telefono as Telefono',
            //     'p.Celular1 as Celular',
            //     'p.Tipo_Afiliado as Tipo_Afiliado',
            //     'p.Estado_Afiliado as Estado_Afiliado',
            //     'sa.Nombre as Prestadores',
            //     'm.Nombre as Municipio',
            //     'sede_paciente.Nombre as Nombre_IPS',
            //     'cie10.Codigo_CIE10 as Codigo_CIE10',
            //     'cie10.Descripcion as Descripcion_CIE10',
            //     'sp.Nombre as nombrePrestador',
            //     'sp.Direccion as direccionPrestador',
            //     'pr.Nit as nitPrestador',
            //     'sp.Telefono1 as telefono1Prestador',
            //     'sp.Telefono2 as telefono2Prestador',
            //     'sp.Codigo_habilitacion as codigoHabilitacion',
            //     'mp.Nombre as municipioPrestador',
            //     'dp.Nombre as departamentoPrestador'])
            //     ->join('Cupordens as co', 'ordens.id', 'co.Orden_id')
            //     ->join('Tipordens as to', 'to.id', 'ordens.Tiporden_id')
            //     ->join('Users as user', 'ordens.Usuario_id', 'user.id')
            //     ->join('cita_paciente as cita_paciente', 'ordens.Cita_id', 'cita_paciente.id')
            //     ->join('Pacientes as p', 'cita_paciente.Paciente_id', 'p.id')
            //     ->join('sedeproveedores as sa', 'sa.id', 'p.IPS')
            //     ->join('prestadores as pres', 'pres.id', 'sa.Prestador_id')
            //     ->join('Municipios as m', 'p.Mpio_Atencion', 'm.id')
            //     ->leftJoin('sedeproveedores as sede_paciente', 'p.IPS', DB::raw("CONVERT(VARCHAR, sede_paciente.id)"))
            //     ->leftJoin('cie10pacientes as cie10p', 'cie10p.Citapaciente_id', 'cita_paciente.id')
            //     ->leftJoin('cie10s as cie10', 'cie10.id', 'cie10p.Cie10_id')
            //     ->leftJoin('sedeproveedores as sp', 'co.Ubicacion_id', DB::raw("CONVERT(VARCHAR, sp.id)"))
            //     ->leftJoin('prestadores as pr', 'sp.Prestador_id', 'pr.id')
            //     ->leftJoin('Municipios as mp', 'sp.Municipio_id', DB::raw("CONVERT(VARCHAR, mp.id)"))
            //     ->leftJoin('departamentos as dp', 'mp.Departamento_id', 'dp.id')
            //     ->with(['cupordens' => function ($query) use ($data) {
            //         $query->select(
            //             'Cupordens.id as id',
            //             'Cupordens.created_at as FechaOrdenamiento',
            //             'Cupordens.Cup_id as Cup',
            //             'Cupordens.Cantidad as Cup_Cantidad',
            //             'Cupordens.Orden_id as Orden_id',
            //             'Cupordens.Observacionorden as observaciones',
            //             'Cupordens.Estado_id as Estado_id',
            //             'cupordens.fecha_solicitada',
            //             'cupordens.fecha_sugerida',
            //             'cupordens.fecha_cancelacion',
            //             'cupordens.cancelacion',
            //             'cupordens.observaciones',
            //             'cupordens.responsable',
            //             'cupordens.motivo',
            //             'cupordens.causa',
            //             'cupordens.soportes',
            //             'cupordens.cirujano',
            //             'cupordens.especialidad',
            //             'cupordens.fecha_Preanestesia',
            //             'cupordens.fecha_cirugia',
            //             'cupordens.fecha_ejecucion',
            //             'c.id as Cup_Id',
            //             'c.Nombre as Cup_Nombre',
            //             'c.Codigo as Cup_Codigo',
            //             'cp.Descripcion as Servicio_Nombre',
            //             'cp.Codigo as Servicio_Codigo',
            //             's.id as Sede_Id',
            //             's.Nombre as Sede_Nombre',
            //             's.Direccion as Sede_Direccion',
            //             's.Telefono1 as Sede_Telefono',
            //             's.Codigo_habilitacion as codigoHabilitacion',
            //             'pr.Nit as nitPrestador',
            //             'mp.Nombre as municipioPrestador',
            //             'dp.Nombre as departamentoPrestador',
            //             'a.Nota as Auth_Nota',
            //             'a.updated_at as FechaAutorizacion',
            //             'u.name as Auth_Name',
            //             'u.apellido as Auth_Apellido',
            //             'u.Firma as Auth_Firma'
            //         )
            //             ->leftJoin('Cups as c', 'Cupordens.Cup_id', 'c.id')
            //             ->leftJoin('codepropios as cp', 'Cupordens.Serviciopropio_id', 'cp.id')
            //             ->leftJoin('autorizacions as a', 'Cupordens.id', 'a.Cuporden_id')
            //             ->leftJoin('Users as u', 'a.Usuario_id', 'u.id')
            //             ->leftJoin('sedeproveedores as s', 'Cupordens.Ubicacion_id', DB::raw("CONVERT(VARCHAR, s.id)"))
            //             ->leftJoin('prestadores as pr', 's.Prestador_id', 'pr.id')
            //             ->leftJoin('Municipios as mp', 's.Municipio_id', DB::raw("CONVERT(VARCHAR, mp.id)"))
            //             ->leftJoin('departamentos as dp', 'mp.Departamento_id', 'dp.id')
            //             ->where('Cupordens.Estado_id', $request->status)
            //             ->get();
            //     }])
            //     ->where('co.Estado_id', $request->status)
            //     ->where('p.Num_Doc', $request->cedula)
            //     ->whereIn('ordens.Tiporden_id', [2, 4, 6])
            //     // ->where('cie10p.Esprimario', true)
            //     ->Where('ordens.Usuario_id', auth()->user()->id)
            //     ->distinct()
            //     ->get();
        } elseif (auth()->user()->hasPermissionTo('confirmar.datos.servicio') && $operadores) {

            $query = $this->ordenModel::select(
                'ordenes.*',
                'afiliados.id as afiliado_id',
                'departamentos.nombre as Departamento',
                'entidades.nombre as UT',
                'afiliados.created_at as afiliado_created',
                'afiliados.primer_nombre',
                'afiliados.segundo_nombre',
                'afiliados.primer_apellido',
                'afiliados.segundo_apellido',
                'tipo_documentos.nombre as Tipo_Doc',
                'afiliados.numero_documento',
                'afiliados.edad_cumplida',
                'afiliados.sexo',
                'afiliados.ips_id as IpsAtencion',
                'reps.nombre as Prestadores',
                'afiliados.direccion_Residencia_cargue',
                'afiliados.celular1',
                'afiliados.correo1',
                'afiliados.telefono',
                'tipo_afiliados.nombre as Tipo_Afiliado',
                'afiliados.estado_afiliacion_id',
                'municipios.nombre as Mpio_Afiliado',
                'orden_procedimientos.id as idServicio',
                'orden_procedimientos.created_at as fechaOrdenamiento',
                'orden_procedimientos.fecha_vigencia',
                'orden_procedimientos.cup_id',
                'orden_procedimientos.cantidad',
                'orden_procedimientos.orden_id',
                DB::raw("DATEDIFF(DAY,orden_procedimientos.fecha_vigencia,CONVERT(varchar,GETDATE(),23)) as diasVencido"),
                'orden_procedimientos.observacion',
                'orden_procedimientos.estado_id as estadoServicio',
                'orden_procedimientos.fecha_solicitada',
                'orden_procedimientos.fecha_sugerida',
                'orden_procedimientos.fecha_cancelacion',
                'orden_procedimientos.cancelacion',
                'orden_procedimientos.observaciones as observacionesPrestador',
                'orden_procedimientos.responsable',
                'orden_procedimientos.motivo',
                'orden_procedimientos.causa',
                'orden_procedimientos.soportes',
                'orden_procedimientos.fecha_Preanestesia',
                'orden_procedimientos.cirujano',
                'orden_procedimientos.especialidad',
                'orden_procedimientos.especialidad',
                'orden_procedimientos.fecha_cirugia',
                'orden_procedimientos.rep_id',
                'orden_procedimientos.fecha_ejecucion',
                'orden_procedimientos.fecha_resultado',
                'cups.id as Cup_id',
                'cups.nombre as Cup_nombre',
                'cups.codigo as Cup_codigo',
                'r.id as sede_id',
                'r.nombre as sede_nombre',
                'r.direccion as sede_direccion',
                'r.telefono1',
                'r.codigo_habilitacion as codigoHabilitacion',
                'prestadores.nit as nitPrestador',
                'mp.nombre as municipioPrestador',
                'dp.nombre as departamentoPrestador',
                'auditorias.observaciones as observacionAuditoria',
                'auditorias.updated_at as fechaAutorizacion',
                'empleados.primer_nombre as nombreEmpleado',
                'empleados.primer_apellido as apellidoEmpleado',
                'empleados.firma as firmaEmpleado',
                'cie10.codigo_cie10 as Codigo_CIE10',
                'e.nombre as Estado',
                'cie10.descripcion as Descripcion_CIE10'

            )
                ->selectRaw("CONCAT(afiliados.primer_nombre, ' ',afiliados.segundo_nombre, ' ',afiliados.primer_apellido, ' ',afiliados.segundo_apellido) as nombre_afiliado")
                ->join('ordenes', 'ordenes.id', 'orden_procedimientos.orden_id')
                ->join('consultas', 'consultas.id', 'ordenes.consulta_id')
                ->join('afiliados', 'afiliados.id', 'consultas.afiliado_id')
                ->leftJoin('departamentos', 'departamentos.id', 'afiliados.departamento_afiliacion_id')
                ->join('entidades', 'entidades.id', 'afiliados.entidad_id')
                ->join('tipo_documentos', 'tipo_documentos.id', 'afiliados.tipo_documento')
                ->join('reps', 'reps.id', 'afiliados.ips_id')
                ->join('tipo_afiliados', 'tipo_afiliados.id', 'afiliados.tipo_afiliado_id')
                ->join('municipios', 'municipios.id', 'afiliados.municipio_afiliacion_id')
                ->join('cups', 'cups.id', 'orden_procedimientos.cup_id')
                ->join('reps as r', 'r.id', 'orden_procedimientos.rep_id')
                ->join('prestadores', 'prestadores.id', 'r.prestador_id')
                ->join('municipios as mp', 'mp.id', 'r.municipio_id')
                ->join('departamentos as dp', 'dp.id', 'mp.departamento_id')
                ->join('estados as e', 'orden_procedimientos.estado_id', 'e.id')
                ->leftJoin('auditorias', 'auditorias.orden_procedimiento_id', 'orden_procedimientos.id')
                ->leftJoin('users', 'users.id', 'auditorias.user_id')
                ->leftJoin('empleados', 'empleados.user_id', 'users.id')
                ->leftJoin('cie10_afiliados as cie10p', function ($join) {
                    $join->on('cie10p.consulta_id', '=', 'consultas.id');
                    $join->on('cie10p.esprimario', '=', DB::raw("1"));
                })
                ->leftJoin('cie10s as cie10', 'cie10.id', 'cie10p.Cie10_id')
                ->where('orden_procedimientos.created_at', '>', '2020-10-01 00:00:00.000')
                ->where('cancelacion', $data['estadoPrestadores']);
            if ($data['numeroDocumento']) {
                $query->where('afiliados.numero_documento', $data['numeroDocumento']);
            } else {
                $query->whereMonth('orden_procedimientos.fecha_orden', $data['month'])
                    ->whereYear('orden_procedimientos.fecha_orden', $data['year']);
                $query->where('orden_procedimientos.fecha_orden', '>=', '2020-01-01 00:00:00.000');
            }
            $query->whereIn('ordenes.tipo_orden_id', [2])
                ->whereIn('orden_procedimientos.estado_id', [1, 14, 4])
                ->whereIn('orden_procedimientos.rep_id', [$data['sede']])
                ->whereIn('orden_procedimientos.rep_id', function ($q) use ($operadores) {
                    $q->select('s.id')
                        ->from('prestadores')
                        ->join('reps as s', 'prestadores.id', 's.prestador_id')
                        ->where('prestadores.id', $operadores->prestador_id)
                        ->distinct();
                })
                ->orderBy('orden_procedimientos.created_at', 'ASC');

            return $query->get();
        }
        // return $ordereds;

    }

    public function actualizarRep($data)
    {
        $model = $data['tipo'] == 3 ? $this->codigoPropioModel : $this->ordenModel;

        if (is_array($data['id'])) {
            foreach ($data['id'] as $id) {
                $orden = $model::find($id);
                if ($orden) {
                    if (is_array($data['rep_id'])) {
                        foreach ($data['rep_id'] as $repId) {
                            $orden->update(['rep_id' => $repId]);
                        }
                    } else {
                        $orden->update(['rep_id' => $data['rep_id']]);
                    }

                    $campo_id = '';
                    if ($data['tipo'] == 1) {
                        $campo_id = 'orden_articulo_id';
                    } elseif ($data['tipo'] == 2) {
                        $campo_id = 'orden_procedimiento_id';
                    } elseif ($data['tipo'] == 3) {
                        $campo_id = 'orden_codigo_propio_id';
                    }

                    CambiosOrdene::create([
                        $campo_id => $id,
                        'user_id' => Auth::id(),
                        'accion' => 'Actualización de direccionamiento',
                        'observacion' => 'Se realiza actualización de direccionamiento',
                        'rep_anterior_id' => $data->rep_anterior_id
                    ]);
                } else {
                    return response()->json([
                        'error' => "No se encontró la orden con ID $id",
                        'mensaje' => 'Error al consultar las órdenes'
                    ], 404);
                }
            }

            return response()->json([
                'mensaje' => 'Órdenes actualizadas exitosamente'
            ], 200);
        } else {
            $orden = $model::find($data['id']);
            if ($orden) {
                if (is_array($data['rep_id'])) {
                    foreach ($data['rep_id'] as $repId) {
                        $orden->update(['rep_id' => $repId]);
                    }
                } else {
                    $orden->update(['rep_id' => $data['rep_id']]);
                }

                $campo_id = '';
                if ($data['tipo'] == 1) {
                    $campo_id = 'orden_articulo_id';
                } elseif ($data['tipo'] == 2) {
                    $campo_id = 'orden_procedimiento_id';
                } elseif ($data['tipo'] == 3) {
                    $campo_id = 'orden_codigo_propio_id';
                }

                CambiosOrdene::create([
                    $campo_id => $data['id'],
                    'user_id' => Auth::id(),
                    'accion' => 'Actualización de direccionamiento',
                    'observacion' => 'Se realiza actualización de direccionamiento'
                ]);

                return response()->json([
                    'mensaje' => 'Orden actualizada exitosamente'
                ], 200);
            } else {
                return response()->json([
                    'error' => 'No se encontró la orden con ID ' . $data['id'],
                    'mensaje' => 'Error al consultar las órdenes'
                ], 404);
            }
        }
    }


    public function actualizarCantidad($request)
    {
        foreach ($request->id as $index => $id) {
            $cantidadAnterior = $this->ordenModel->where('orden_procedimientos.id', $id)->value('cantidad');
            $cupId = $this->ordenModel->where('orden_procedimientos.id', $id)->value('cup_id');
            $cantidadMaxOrdenamiento = DB::table('cups')->where('id', $cupId)->value('cantidad_max_ordenamiento');

            if ($request->cantidad[$index] > $cantidadMaxOrdenamiento) {
                return throw new Error('La nueva cantidad no puede superar el límite determinado del cup', 422);
            }

            $this->ordenModel->where('orden_procedimientos.id', $id)->update([
                'cantidad' => $request->cantidad[$index]
            ]);

            return DB::table('cambios_ordenes')->insert([
                'orden_procedimiento_id' => $id,
                'user_id' => Auth::user()->id,
                'observacion' => $request->observacion,
                'cantidad_anterior' => $cantidadAnterior,
                'created_at' => now(),
                'updated_at' => now(),
                'accion' => $request->accion
            ]);
        }
    }

    public function actualizarCup($request)
    {
        foreach ($request->id as $index => $id) {

            $cupAnterior = $this->ordenModel->where('orden_procedimientos.id', $id)->value('cup_id');

            $cantidadMaxOrdenamiento = DB::table('cups')->where('id', $cupAnterior)->value('cantidad_max_ordenamiento');

            if ($request->cantidad[$index] > $cantidadMaxOrdenamiento) {
                throw new Error('La nueva cantidad no puede superar el límite determinado del cup', 422);
            }

            $this->ordenModel->where('orden_procedimientos.id', $id)->update([
                'cup_id' => $request->cup_id[$index] ?? $cupAnterior
            ]);

            DB::table('cambios_ordenes')->insert([
                'orden_procedimiento_id' => $id,
                'user_id' => Auth::user()->id,
                'observacion' => $request->observacion,
                'cup_anterior' => $cupAnterior,
                'created_at' => now(),
                'updated_at' => now(),
                'accion' => $request->accion
            ]);
        }
    }


    public function actualizarVigencia($request)
    {
        if ($request->tipo == 2) {
            $model = $this->ordenModel;
            $field = 'orden_procedimiento_id';
        } else {
            $model = $this->articuloModel;
            $field = 'orden_articulo_id';
        }

        $model->where('id', $request->orden_procedimiento_id)->update([
            'fecha_vigencia' => $request->fecha_vigencia,
            'estado_id' => 1
        ]);

        $data = [
            'user_id' => Auth::id(),
            'observacion' => $request->observacion,
            'created_at' => now(),
            'updated_at' => now(),
            'accion' => $request->accion
        ];

        $data[$field] = $request->orden_procedimiento_id;

        return DB::table('cambios_ordenes')->insert($data);
    }


    public function notaAdicional($request)
    {
        foreach ($request->id as $index => $id) {

            return DB::table('cambios_ordenes')->insert([
                'orden_procedimiento_id' => $id,
                'user_id' => Auth::user()->id,
                'observacion' => $request->observacion,
                'created_at' => now(),
                'updated_at' => now(),
                'accion' => $request->accion
            ]);
        }
    }


    public function medicamentoPrestdor($request)
    {

        $registros = OrdenArticulo::select([
            'orden_articulos.*',
            'o.paginacion',
            'cs.codigo',
            'cs.nombre',
            'cs.via'
        ])->with([
            "estado",
            "orden",
            'rep',
            "cambioOrden" => function ($cambio) {
                $cambio->orderBy('id', 'desc');
            }
        ])
            ->join('ordenes as o', 'o.id', 'orden_articulos.orden_id')
            ->join('consultas as c', 'c.id', 'o.consulta_id')
            ->join('afiliados as a', 'a.id', 'c.afiliado_id')
            ->join('codesumis as cs', 'cs.id', 'orden_articulos.codesumi_id')
            ->where('orden_articulos.rep_id', auth()->user()->reps_id)
            ->orderBy('orden_articulos.created_at', 'desc');


        return $request->page ? $registros->paginate($request->cant) : $registros->get();
    }

    public function detalleMedicamentoPrestdor($orden_id)
    {

        $registros = OrdenArticulo::select([
            'orden_articulos.*',
            'o.paginacion',
            'cs.codigo',
            'cs.nombre',
            'cs.via'
        ])->with([
            "estado",
            "orden",
            "dispensado" => function ($orden) {
                $orden->orderBy('id', 'desc')->take(1);
            },
            'rep',
            "cambioOrden" => function ($cambio) {
                $cambio->orderBy('id', 'desc');
            }
        ])
            ->join('ordenes as o', 'o.id', 'orden_articulos.orden_id')
            ->join('consultas as c', 'c.id', 'o.consulta_id')
            ->join('afiliados as a', 'a.id', 'c.afiliado_id')
            ->join('codesumis as cs', 'cs.id', 'orden_articulos.codesumi_id')
            ->where('orden_articulos.orden_id', $orden_id)
            ->get();

        return $registros;
    }

    public function dispensarMedicamentoPrestdor($request)
    {

        $medicamento = OrdenArticulo::where('id', $request['id'])->first();
        if ($request['cantidad_mensual_disponible'] == $medicamento->cantidad_mensual_disponible) {
            $consulta = DispensarPrestador::create([
                'dispensar' => $request['cantidad_mensual_disponible'],
                'pendiente' => 0,
                'dispensado' => $request['cantidad_mensual_disponible'],
                'orden_articulo_id' => $request['id'],
                'user_id' => auth()->user()->id
            ]);

            $medicamento->update([
                'cantidad_mensual_disponible' => 0
            ]);
        } else {
            $resta = intVal($medicamento->cantidad_mensual_disponible) - intVal($request['cantidad_mensual_disponible']);
            $consulta = DispensarPrestador::create([
                'dispensar' => $medicamento->cantidad_mensual_disponible,
                'pendiente' => $resta,
                'dispensado' => $request['cantidad_mensual_disponible'],
                'orden_articulo_id' => $request['id'],
                'user_id' => auth()->user()->id
            ]);

            $medicamento->update([
                'cantidad_mensual_disponible' => $resta
            ]);
        }
        return $consulta;
    }


    /**
     * Obtiene una lista de órdenes de procedimientos filtradas por varios criterios.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function ordenProcedimientoSede($request)
    {
        $existenParametrizados = ParametrizacionCupPrestador::where('rep_id', $request['sede']['id'])
            ->when($request['servicioClinica'], fn($q) => $q->where('categoria', $request['servicioClinica']))
            ->exists();

        $queryOrdenes = $this->orden::query()
            ->select('ordenes.id', 'ordenes.consulta_id', 'ordenes.user_id', 'ordenes.estado_id','ordenes.created_at')
            ->join('orden_procedimientos as op', 'op.orden_id', '=', 'ordenes.id')
            ->whereHas('procedimientos', fn($q) => $q->FiltrarCupsPrestador($request, $existenParametrizados))
            ->when($request['documento'], function ($q, $documento) {
                $q->join('consultas as c', 'c.id', '=', 'ordenes.consulta_id')
                    ->join('afiliados as a', 'a.id', '=', 'c.afiliado_id')
                    ->where('a.numero_documento', $documento);
            })
            ->distinct()
            ->orderByDesc('ordenes.id')
            ->with([
                'procedimientos' => fn($q) => $q->select(
                    'orden_procedimientos.id',
                    'orden_procedimientos.cup_id',
                    'orden_procedimientos.estado_id',
                    'orden_procedimientos.rep_id',
                    'orden_procedimientos.cantidad',
                    'orden_procedimientos.observacion',
                    'orden_procedimientos.fecha_vigencia',
                    'orden_procedimientos.orden_id',
                    'orden_procedimientos.estado_id_gestion_prestador',
                    'orden_procedimientos.fecha_ejecucion',
                    'orden_procedimientos.created_at'
                )->FiltrarCupsPrestador($request, $existenParametrizados)->distinct(),
                'procedimientos.estadoGestionPrestador:id,nombre',
                'procedimientos.auditoria:id,orden_procedimiento_id,user_id',
                'procedimientos.auditoria.user:id',
                'procedimientos.auditoria.user.operador:id,user_id,nombre,apellido',
                'procedimientos.cup:id,codigo,nombre',
                'procedimientos.estado:id,nombre',
                'consulta:id,afiliado_id,cup_id,diagnostico_principal',
                'consulta.afiliado',
                'consulta.afiliado.ips:id,nombre',
                'consulta.afiliado.departamento_afiliacion',
                'consulta.afiliado.departamento_atencion',
                'consulta.afiliado.municipio_afiliacion',
                'consulta.afiliado.municipio_atencion',
                'consulta.afiliado.tipo_afiliacion',
                'consulta.afiliado.tipo_afiliado',
                'consulta.afiliado.EstadoAfiliado',
                'consulta.afiliado.tipoDocumento',
                'consulta.cie10Afiliado:id,consulta_id,cie10_id',
                'consulta.cie10Afiliado.cie10:id,nombre,codigo_cie10',
                'funcionario:id',
                'funcionario.operador:id,user_id,nombre,apellido',
                'consulta.afiliado.entidad:id,nombre',
            ]);

        // $query = ParametrizacionCupPrestador::where('rep_id', $request['sede']['id']);
        // if ($request['servicioClinica']) {
        //     $query->where('categoria', $request['servicioClinica']);
        // }
        // $parametrizacion = $query->get()->toArray();

        // $queryOrdenes = OrdenProcedimiento::with([
        //     'orden.consulta.afiliado.ips',
        //     'orden.consulta.afiliado.departamento_afiliacion',
        //     'orden.consulta.afiliado.departamento_atencion',
        //     'orden.consulta.afiliado.municipio_afiliacion',
        //     'orden.consulta.afiliado.municipio_atencion',
        //     'orden.consulta.cie10Afiliado.cie10',
        //     'orden.funcionario.operador',
        //     'estadoGestionPrestador',
        //     'auditoria.user.operador',
        //     'cup',
        //     'orden.consulta.afiliado.entidad',
        //     'orden.consulta.afiliado.tipo_afiliacion',
        //     'orden.consulta.afiliado.tipo_afiliado',
        //     'orden.consulta.afiliado.EstadoAfiliado',
        //     'orden.consulta.afiliado.tipoDocumento',
        //     'estado'
        // ])
        //     ->whereYear('fecha_vigencia', $request['anio'])
        //     ->whereMonth('fecha_vigencia', $request['mes'])
        //     ->where('rep_id', $request['sede']['id'])
        //     ->whereNotIn('estado_id', [5, 3])
        //     ->orderBy('id', 'desc');
        // if (!is_null($request['documento'])) {
        //     $queryOrdenes->whereHas('orden.consulta.afiliado', function ($query) use ($request) {
        //         $query->where('numero_documento', $request['documento']);
        //     });
        // } else {
        //     if (!is_null($request['estado'])) {
        //         $queryOrdenes->where('estado_id_gestion_prestador', $request['estado']);
        //     }
        // }
        // if (!is_null($request['orden_id'])) {
        //     $queryOrdenes->where('id', $request['orden_id']);
        // }
        // if (count($parametrizacion) > 0) {
        //     $queryOrdenes->whereIn('orden_procedimientos.cup_id', array_column($parametrizacion, 'cup_id'));
        // }
        return $queryOrdenes->paginate($request['perPage'],['*'],'page');
    }

    public function agregarCup($id, $request)
    {
        $cup = Cup::find($request->cup_id);

        if ($cup && $request->cantidad > $cup->cantidad_max_ordenamiento) {
            throw new Error('La cantidad supera la cantidad maxima de ordenamiento que tiene el cup predeterminada', 422);
        }

        if ($request->cirugia) {
            // Verificar si el cup tiene familias 8 o 9 a través de la relación
            $familiasPermitidas = $cup->familias()->whereIn('familia_id', [8, 9])->exists();

            if (!$familiasPermitidas) {
                throw new Error('El CUP seleccionado no pertenece a las familias permitidas para cirugía', 422);
            }
        }
        $nuevoProcedimiento = new OrdenProcedimiento();
        $nuevoProcedimiento->orden_id = $id;
        $nuevoProcedimiento->cup_id = $request->cup_id;
        $nuevoProcedimiento->estado_id = 3;
        $nuevoProcedimiento->cantidad = $request->cantidad;
        $nuevoProcedimiento->observacion = $request->observacion;
        $nuevoProcedimiento->estado_id_gestion_prestador = 50;
        $nuevoProcedimiento->fecha_vigencia = now();
        $nuevoProcedimiento->save();

        CambiosOrdene::create([
            'orden_procedimiento_id' => $nuevoProcedimiento->id,
            'user_id' => Auth::id(),
            'accion' => 'Creación de procedimiento',
            'observacion' => 'Se creó un nuevo procedimiento en la orden'
        ]);

        return true;
    }

    public function consultarLaboratorio($data)
    {
        return $this->ordenModel

            ->with([
                'cup:id,nombre,codigo,requiere_firma',
                'cup.consentimientoInformado:id,nombre,cup_id,estado,laboratorio',
                'rep:id,nombre',
            ])
            ->join('ordenes as o', 'o.id', 'orden_procedimientos.orden_id')
            ->join('consultas as c', 'c.id', 'o.consulta_id')
            ->join('afiliados as a', 'a.id', 'c.afiliado_id')
            ->select([
                'orden_procedimientos.id',
                'orden_procedimientos.orden_id',
                'orden_procedimientos.cup_id',
                'orden_procedimientos.observacion as observaciones',
                'orden_procedimientos.estado_id',
                'orden_procedimientos.rep_id',
                'orden_procedimientos.cantidad',
                'orden_procedimientos.cantidad_usada',
                'orden_procedimientos.cantidad_pendiente',
                'orden_procedimientos.created_at',
                'orden_procedimientos.aceptacion_consentimiento as firmado',
                'orden_procedimientos.firma_paciente as ingreso_sin_consentimiento',
                'orden_procedimientos.fecha_firma as fecha_firma'
            ])
            ->whereHas('cup', function ($query) {
                $query->where('requiere_firma', true);
            })
            ->whereIn('orden_procedimientos.estado_id', [1, 4])
            ->where('a.id', $data['afiliado'])
            ->whereNull('orden_procedimientos.firma_paciente')
            ->WhereNull('orden_procedimientos.aceptacion_consentimiento')
            ->orderBy('orden_procedimientos.id', 'DESC')
            ->get();
    }


    public function ordenMedicamentosLineaBase($request)
    {
        $lineasBasesCategorias = ParametrizacionCupPrestadoresCategoriasLineasBase::where('categoria', $request['servicioClinica'])
            ->get();
        $lineasBases = array_column($lineasBasesCategorias->toArray(), 'linea_base_id');
        $queryOrdenes = OrdenArticulo::with([
            'orden.consulta.afiliado.ips',
            'orden.consulta.afiliado.departamento_afiliacion',
            'orden.consulta.afiliado.departamento_atencion',
            'orden.consulta.afiliado.municipio_afiliacion',
            'orden.consulta.afiliado.municipio_atencion',
            'orden.consulta.cie10Afiliado.cie10',
            'orden.funcionario.operador',
            'orden.consulta.afiliado.entidad',
            'orden.consulta.afiliado.tipo_afiliacion',
            'orden.consulta.afiliado.tipo_afiliado',
            'orden.consulta.afiliado.EstadoAfiliado',
            'orden.consulta.afiliado.tipoDocumento',
            'estado',
            'codesumi',
            'auditorias',
            'movimientos',
            'movimientos.bodegaOrigen',
            'movimientos.user.operador'
        ])
            ->where('estado_id', '<>', 20)
            ->whereYear('fecha_vigencia', $request['anio'])
            ->whereMonth('fecha_vigencia', $request['mes'])
            ->whereHas('codesumi', function ($query) use ($lineasBases) {
                $query->where('linea_base_id', $lineasBases);
            })
            ->orderBy('id', 'desc');
        if(!is_null($request['orden_id'])){
            $queryOrdenes->where('id',$request['orden_id']);
        }
        if (!is_null($request['documento'])) {
            $queryOrdenes->whereHas('orden.consulta.afiliado', function ($query) use ($request) {
                $query->where('numero_documento', $request['documento']);
            });
        }
        return $queryOrdenes->paginate($request['perPage'],['*'],'page');
    }

    public function anexo3servicios($request)
    {

        $ordenProcedimiento = $this->ordenModel->where('id', $request['ordenamiento_id'])->first();
        $afiliado = $ordenProcedimiento->orden->consulta->afiliado;
        $consulta = $ordenProcedimiento->orden->consulta;

        $historiaClinica = $this->historiaClinica->where('consulta_id', $consulta->id)->first();

        $cie10DiagnosticoPpal = $this->cie10Afiliado->where('consulta_id', $consulta->id)
            ->where('esprimario', true)
            ->first();

        $cie10 = $cie10DiagnosticoPpal ? $this->cie10->find($cie10DiagnosticoPpal->cie10_id) : null;

        $cie10DiagnosticoRelacionado = $this->cie10Afiliado->where('consulta_id', $consulta->id)
            ->where('esprimario', false)
            ->first();

        $cie10Relacionado = $cie10DiagnosticoRelacionado ? $this->cie10->find($cie10DiagnosticoRelacionado->cie10_id) : null;

        return (object) [
            'ordenProcedimiento' => $ordenProcedimiento,
            'afiliado' => $afiliado,
            'consulta' => $consulta,
            'historiaClinica' => $historiaClinica,
            'cie10DiagnosticoPpal' => $cie10DiagnosticoPpal,
            'cie10' => $cie10,
            'cie10DiagnosticoRelacionado' => $cie10DiagnosticoRelacionado,
            'cie10Relacionado' => $cie10Relacionado,
        ];
    }

    public function formatoNegacion($tipo_orden, $detalle)
    {
        if ($tipo_orden === 'Servicio') {
            $ordenProcedimiento = $this->ordenModel->with('rep')->where('id', $detalle['id'])->first();
        }

        return $ordenProcedimiento;
    }

    public function certificadoAtencionLaboratorio($request)
    {
        $clase = $request['clase'];

        $ordenProcedimiento = $this->ordenModel->select([
            'orden_procedimientos.id',
            'orden_procedimientos.orden_id',
            'orden_procedimientos.cup_id',
            'orden_procedimientos.observacion as observaciones',
            'orden_procedimientos.estado_id',
            'orden_procedimientos.rep_id',
            'orden_procedimientos.cantidad',
            'orden_procedimientos.cantidad_usada',
            'orden_procedimientos.cantidad_pendiente',
            'orden_procedimientos.created_at',
            'a.entidad_id',
            'a.primer_nombre',
            'a.segundo_nombre',
            'a.primer_apellido',
            'a.segundo_apellido',
            'a.numero_documento',
            'entidades.nombre as nombreSede',
            'a.celular1',
            'orden_procedimientos.firma_paciente',
            'orden_procedimientos.fecha_firma'
        ])->with(['cup:id,nombre,codigo', 'rep:id,nombre'])
            ->join('ordenes as o', 'o.id', 'orden_procedimientos.orden_id')
            ->join('consultas as c', 'c.id', 'o.consulta_id')
            ->join('afiliados as a', 'a.id', 'c.afiliado_id')
            ->leftjoin('entidades', 'entidades.id', 'a.entidad_id')
            ->where('orden_procedimientos.id', $request['orden_procedimiento'])->first();


        return (object) [
            'ordenProcedimiento' => $ordenProcedimiento,
            'clase' => $clase,
        ];
    }

    /**
     * Lista los servicios de una orden pendientes de auditoria
     * @param int $afiliadoId
     * @param int $ordenId
     * @return Collection
     * @author Thomas
     */
    public function listarServiciosPorAuditar(int $afiliadoId, int $ordenId): Collection
    {
        $afiliado = Afiliado::findOrFail($afiliadoId);

        $servicios = $this->ordenModel
            ->with(['cup.tarifas', 'rep'])
            ->where('orden_id', $ordenId)
            ->where('estado_id', 3)
            ->get();

        return $servicios->map(function ($orden) use ($afiliado) {
            // Por defecto, todos son editables
            $orden->esEditable = true;

            // Si el afiliado es de FOMAG se evalúa si tiene una tarifa con manual "CAPITADO", de tenerla, es editable
            if ($afiliado->entidad_id == 1) {
                $esCapitado = $orden->cup
                    ? $orden->cup->tarifas->contains('manual_tarifario_id', 5)
                    : false;

                $orden->esEditable = $esCapitado;
            }

            return $orden;
        });
    }


    /**
     * Lista las notas adicionales de una orden de servicios
     * @param int $ordenProcedimientoId
     * @return Collection
     * @author Thomas
     */
    public function listarNotasAdicionalesOrdenServicio(int $ordenProcedimientoId): Collection
    {
        return CambiosOrdene::with(['user.operador'])
            ->where('orden_procedimiento_id', $ordenProcedimientoId)
            ->where('accion', 'Creación de nota adicional')
            ->get();
    }


    public function serviciosVigentes($idAfiliado)
    {
        $hoy = Carbon::now();
        $cambio = Carbon::now()->subDays(180);
        //
        return OrdenProcedimiento::select('id', 'fecha_vigencia', 'cup_id', 'rep_id')->with('cup', 'orden', 'orden.consulta', 'cobro', 'rep')->whereBetween('fecha_vigencia', [$cambio->format('Y-m-d') . ' 00:00:00.000', $hoy->format('Y-m-d') . ' 23:59:59.999'])
            ->whereHas('orden.consulta', function ($query) use ($idAfiliado) {
                $query->where('afiliado_id', $idAfiliado);
            })
            ->whereHas('cobro', function ($query) use ($idAfiliado) {
                $query->where('estado_id', 1);
            })
            ->orderBy('orden_procedimientos.created_at', 'desc')
            ->get();
    }

    public function serviciosVigentesAdmisiones($idAfiliado)
    {
        return Consulta::select(
            'afiliado_id',
            'id as consulta_id',
            'created_at',
            'estado_id',
            'fecha_hora_inicio',
            'agenda_id'
        )
            ->where('afiliado_id', $idAfiliado)
            //->where('estado_id', 9)
            ->whereHas('ordenes', function ($query) {
                $query->whereIn('estado_id', [1, 4, 3]);
            })
            ->whereHas('cobro')
            ->with(['agenda'])
            ->orderBy('consultas.id', 'desc')
            ->get();
    }

    /**
     * Retorna el procedimiento si existe en la orden con el CUP indicado, o null si no existe.
     * @param int $ordenId
     * @param int $cupId
     * @return OrdenProcedimiento|null
     * @author Thomas
     */
    public function validarExistenciaCupOrden(int $ordenId, int $cupId): ?OrdenProcedimiento
    {
        return $this->ordenModel->where('orden_id', $ordenId)
            ->where('cup_id', $cupId)
            ->first();
    }


    /**
     * Obtiene el registro de un orden procedimiento segun el id del procedimiento pasado por argumento
     * @param int $ordenProcedimientoId
     * @return Collection|OrdenProcedimiento|OrdenProcedimiento[]|\Illuminate\Database\Eloquent\Model|null
     */
    public function obtenerOrdenProcedimiento(int $ordenProcedimientoId)
    {
        return $this->ordenModel::find($ordenProcedimientoId);
    }

    /**
     * Consulta los procedimientos asociados a un numero de orden
     * @param int $ordenId
     * @return Collection|OrdenProcedimiento[]
     */
    public function obtenerProcedimientosOrden(int $ordenId)
    {
        return $this->ordenModel->where('orden_id', $ordenId)->get();
    }

    /**
     * Busca un procedimiento por su id de interoperabilidad
     * @param mixed $ordenProcedimientoInteroperabilidadId
     * @return OrdenProcedimiento
     * @author Thomas
     */
    public function buscarProcedimientoInteroperabilidad($ordenProcedimientoInteroperabilidadId): ?OrdenProcedimiento
    {
        return $this->ordenModel->where('orden_procedimiento_id_interoperabilidad', $ordenProcedimientoInteroperabilidadId)->first();
    }

    /**
     * Lista los detalles de una orden usada
     * @param int $ordenProcedimientoId
     * @return ConsultaOrdenProcedimientos
     * @throws \Throwable
     * @author Thomas
     */
    public function listarDetallesOrdenUsada(int $ordenProcedimientoId): ?ConsultaOrdenProcedimientos
    {
        return $this->consultaOrdenProcedimientos
            ->with(['user.operador', 'ordenProcedimiento.orden.consulta.especialidad'])
            ->where('orden_procedimiento_id', $ordenProcedimientoId)->firstOrFail();
    }

    /**
     * Obtiene la cantidad de procedimientos realizados en un rango de fechas para un afiliado y cup específico.
     * @param int $afiliado El ID del afiliado.
     * @param int $cupId El ID del CUP.
     * @param mixed $fechaInicio La fecha de inicio del rango.
     * @param mixed $fechaFin La fecha de fin del rango.
     * @return int La cantidad total de procedimientos realizados en el rango especificado.
     * @author kobatime
     */
    public function getCantidadProcedimientosEnRango( int $afiliado, int $cupId, $fechaInicio, $fechaFin) {
        $consulta = OrdenProcedimiento::join('ordenes as o', 'o.id', '=', 'orden_procedimientos.orden_id')
            ->join('consultas as c', 'c.id', '=', 'o.consulta_id')
            ->where('c.afiliado_id', $afiliado)
            ->where('orden_procedimientos.cup_id', $cupId)
            ->whereBetween('orden_procedimientos.fecha_vigencia', [$fechaInicio, $fechaFin])
            ->whereIn('orden_procedimientos.estado_id', [1, 4, 54])
            ->sum('orden_procedimientos.cantidad');

        return $consulta;
    }

    public function getOrdenProcedimientoById(int $id)
    {
        return OrdenProcedimiento::select('fecha_vigencia', 'cup_id as cup', 'rep_id as rep', 'orden_id')
            ->with('orden.consulta.cie10Afiliado.cie10', 'orden.consulta.HistoriaClinica.finalidadConsulta')
            ->find($id);
    }

   public function listarOrdenesCups($afiliado_id, $cup_id)
    {
        $ordenesCups = OrdenProcedimiento::select('orden_procedimientos.*')
            ->join('ordenes as o', 'orden_procedimientos.orden_id', '=', 'o.id')
            ->join('consultas as c', 'o.consulta_id', '=', 'c.id')
            ->where('c.afiliado_id', $afiliado_id)
            ->where('orden_procedimientos.cup_id', $cup_id)
            ->whereIn('orden_procedimientos.estado_id', [1,3,4])
            ->get();

        return $ordenesCups;
    }
    /**
     * Actualiza el estado de gestión de la orden
     * @param int $ordenProcedimientoId
     * @param int $estado
     * @return bool
     */
    public function actualizarEstadoGestionPrestador(int $ordenProcedimientoId,int $estado)
    {
        return $this->ordenModel->where('id',$ordenProcedimientoId)->update(['estado_id_gestion_prestador'=>$estado]);
    }
}
