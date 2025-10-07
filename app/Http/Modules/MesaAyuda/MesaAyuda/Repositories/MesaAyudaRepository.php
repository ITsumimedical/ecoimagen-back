<?php

namespace App\Http\Modules\MesaAyuda\MesaAyuda\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\MesaAyuda\MesaAyuda\Models\MesaAyuda;
use App\Http\Modules\AdjuntoMesaAyuda\Models\AdjuntosMesaAyuda;
use App\Http\Modules\CategoriaMesaAyuda\Models\categoriaMesaAyuda;
use App\Http\Modules\ClienteMesaAyuda\Models\Clientemesaayuda;
use App\Http\Modules\MesaAyuda\AsignadosMesaAyuda\Repositories\AsignadosMesaAyudaRepository;
use App\Http\Modules\MesaAyuda\SeguimientoActividades\Models\SeguimientoActividades;
use App\Http\Modules\MesaAyuda\MesaAyuda\Services\MesaAyudaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MesaAyudaRepository extends RepositoryBase
{
    protected $mesaAyudamodel;
    public function __construct(MesaAyuda $mesaAyudamodel, protected AsignadosMesaAyudaRepository $asignadosMesaAyudaRepository)
    {
        parent::__construct($mesaAyudamodel);
        $this->mesaAyudamodel = $mesaAyudamodel;
    }

    /**
     *metodo para listar todos los casos pendientes de mesa de ayuda
     *
     * @return void
     */
    public function listarTodos(Request $request)
    {
        $cantidad = $request->get('cantidad', 10);
        $areaFiltro = $request->get('area_filtro');
        $prioridadFiltro = $request->get('prioridad_filtro');

        $casos = $this->mesaAyudamodel->select(
            'mesa_ayudas.id',
            'mesa_ayudas.asunto',
            'mesa_ayudas.descripcion',
            'mesa_ayudas.categoria_mesa_ayuda_id',
            'prioridades.nombre as nombrePrioridad',
            'estados.nombre as nombreEstado',
            DB::raw("SUBSTRING(TO_CHAR(mesa_ayudas.created_at, 'YYYY-MM-DD'), 1, 10) as fechaCreacion"),
            'mesa_ayudas.usuario_registra_id',
            'users.email',
            'areas_mesa_ayudas.nombre as area'
        )
            ->join('users', 'mesa_ayudas.usuario_registra_id', 'users.id')
            ->join('categoria_mesa_ayudas as cma', 'mesa_ayudas.categoria_mesa_ayuda_id', 'cma.id')
            ->join('areas_mesa_ayudas', 'cma.areas_mesa_ayuda_id', 'areas_mesa_ayudas.id')
            ->join('prioridades', 'mesa_ayudas.prioridad_id', 'prioridades.id')
            ->join('estados', 'mesa_ayudas.estado_id', 'estados.id')
            ->leftjoin('operadores', 'operadores.user_id', 'users.id')
            ->selectRaw("CONCAT(operadores.nombre, ' ', operadores.apellido)as NombreOperador")
            ->where('mesa_ayudas.estado_id', 10)
            ->with('AdjuntosMesaAyuda', 'categoriaMesaAyuda', 'categoriaMesaAyuda.user')
            ->orderBy('mesa_ayudas.id', 'Asc');

        if ($request->has('radicado_filtro')) {
            $casos->where('mesa_ayudas.id', 'ILIKE', '%' . $request->input('radicado_filtro') . '%');
        }

        if ($areaFiltro) {
            $casos->where('areas_mesa_ayudas.nombre', 'ILIKE', '%' . $areaFiltro . '%');
        }

        if ($prioridadFiltro) {
            $casos->where('prioridades.nombre', 'ILIKE', '%' . $prioridadFiltro . '%');
        }

        if ($request->has('page')) {
            return $casos->paginate($cantidad);
        } else {
            return $casos->get();
        }
    }


    public function listarMisCasos(Request $request)
    {
        $cantidad = $request->get('cantidad', 10);
        $estadoFiltro = $request->get('estado_filtro');
        $sedeFiltro = $request->get('sede_filtro');
        $fechaFiltro = $request->get('fechaFiltro');

        $casos = $this->mesaAyudamodel->select(
            'mesa_ayudas.id',
            'mesa_ayudas.asunto',
            'mesa_ayudas.descripcion',
            'mesa_ayudas.sede_id',
            'mesa_ayudas.estado_id',
            'cma.nombre as nombreCategoria',
            'prioridades.nombre as nombrePrioridad',
            'estados.nombre as nombreEstado',
            DB::raw("TO_CHAR(mesa_ayudas.created_at, 'YYYY-MM-DD') as fechaCreacion"),
            'mesa_ayudas.usuario_registra_id',
            'users.email',
            'areas_mesa_ayudas.nombre as area',
            'sedes.nombre as sedeNombre',
            'mesa_ayudas.calficacion'
        )
            ->join('users', 'mesa_ayudas.usuario_registra_id', 'users.id')
            ->join('categoria_mesa_ayudas as cma', 'mesa_ayudas.categoria_mesa_ayuda_id', 'cma.id')
            ->join('areas_mesa_ayudas', 'cma.areas_mesa_ayuda_id', 'areas_mesa_ayudas.id')
            ->join('sedes', 'mesa_ayudas.sede_id', 'sedes.id')
            ->leftjoin('prioridades', 'mesa_ayudas.prioridad_id', 'prioridades.id')
            ->join('estados', 'mesa_ayudas.estado_id', 'estados.id')
            ->leftjoin('operadores', 'operadores.user_id', 'users.id')
            ->selectRaw("CONCAT(operadores.nombre, ' ', operadores.apellido)as NombreOperador")
            ->where('users.id', Auth::id())
            ->with('AdjuntosMesaAyuda', 'seguimientoActividades.user.operador', 'estado:id,nombre')
            ->orderBy('mesa_ayudas.id', 'desc');

        $casos->with(['seguimientoActividades' => function ($query) {
            $query->orderBy('id', 'asc');
        }]);

        if ($request->has('radicado_filtro')) {
            $casos->where('mesa_ayudas.id', 'ILIKE', '%' . $request->input('radicado_filtro') . '%');
        }

        if ($estadoFiltro) {
            $casos->where('estados.nombre', 'ILIKE', '%' . $estadoFiltro . '%');
        }
        if ($fechaFiltro) {
            $casos->where('mesa_ayudas.created_at', 'ILIKE', '%' . $fechaFiltro . '%');
        }

        if ($sedeFiltro) {
            $casos->where('sedes.nombre', 'ILIKE', '%' . $sedeFiltro . '%');
        }

        if ($request->has('page')) {
            return $casos->paginate($cantidad);
        } else {
            return $casos->get();
        }
    }

    /**
     * listar Casos Pendientes del Area
     *
     * @param  mixed $request->area_id int
     * @return void
     */
    public function listarCasosPendientesArea($request)
    {

        return categoriaMesaAyuda::select(
            'categoria_mesa_ayudas.nombre as nombreCategoria',
            'mesa_ayudas.asunto',
            'mesa_ayudas.descripcion',
            'empleados.nombre_completo',
            'empleados.documento',
            DB::raw("TO_CHAR(mesa_ayudas.created_at,'yyyy-MM-dd') as fecha_radicacion"),
            'mesa_ayudas.created_at',
            'mesa_ayudas.id',
            'empleados.genero',
            'empleados.email_corporativo',
            'empleados.email_personal',
            'empleados.email_personal',
            'empleados.celular'
        )
            ->join('mesa_ayudas', 'categoria_mesa_ayudas.id', 'mesa_ayudas.categoria_mesa_ayuda_id')
            ->join('users', 'mesa_ayudas.user_id', 'users.id')
            ->join('empleados', 'users.id', 'empleados.user_id')
            // ->where('categoria_mesa_ayudas.area_th_id', $request->area_id)
            ->where('mesa_ayudas.estado_id', 10)
            ->get();
    }

    /**
     * contador de casos pendientes
     *
     * @param  mixed $data
     * @return void
     * @author Calvarez
     */
    public function contadorCasosPendientesHorus()
    {
        return MesaAyuda::where('plataforma', 'sumimedical')->count();
    }

    /**
     * contador de casos pendientes para FPS
     *
     * @param  mixed $data
     * @return void
     * @author Calvarez
     */
    public function contadorCasosPendientesFPS()
    {
        return MesaAyuda::where('plataforma', 'fps')->count();
        // return DB::connection('sqlsrvFPS')->table('helpdesks')->whereIn('state_id', [3,7])->count();
    }

    /**
     * contador de casos pendientes para NORTE
     *
     * @param  mixed $data
     * @return void
     * @author Calvarez
     */
    public function contadorCasosPendientesNORTE()
    {
        return MesaAyuda::where('plataforma', 'norte')->count();
        // return DB::connection('sqlsrvNORTE')->table('helpdesks')->whereIn('state_id', [3,7])->count();;
    }

    /**
     * contador de casos pendientes para PAStO
     *
     * @param  mixed $data
     * @return void
     * @author Calvarez
     */
    public function contadorCasosPendientesPASTO()
    {
        return MesaAyuda::where('plataforma', 'pasto')->count();
        // return DB::connection('sqlsrvPASTO')->table('helpdesks')->whereIn('state_id', [3,7])->count();;
    }

    /**
     * contador de todos los pendientes del usuario logueado
     *
     * @return void
     * @author Calvarez
     */
    public function contadorMisPendientes()
    {
        return SeguimientoActividades::where('user_id', auth()->user()->id)->count();
    }

    /**
     * contador de solicitudes solucionadas
     *
     * @return void
     * @author Calvarez
     */
    public function contadorSolucionados()
    {
        return MesaAyuda::where('estado_id', 22)->count();
    }

    /**
     * consultar los adjuntos de la solicitud
     *
     * @return void
     * @author Calvarez
     */
    public function consultarAdjuntos($request)
    {
        return AdjuntosMesaAyuda::where('mesa_ayuda_id', $request->mesa_id)->get();
    }

    /**
     * reasignar solicitid
     *
     * @return void
     */
    public function reasignarSolicitud($request)
    {
        $solicitud = SeguimientoActividades::find($request->id);
        $solicitud->update('');
        return $solicitud;
    }

    public function solucionarSolicitud(Request $request, int $mesaAyudaId)
    {
        $user = auth()->user();

        $seguimiento = SeguimientoActividades::create([
            'user_id' => $user->id,
            'respuesta' => $request->respuesta,
            'mesa_ayuda_id' => $mesaAyudaId,
            'estado_id' => 17,
        ]);

        $mesaAyuda = MesaAyuda::findOrFail($mesaAyudaId);

        // // Guardar adjuntos si los hay
        // if ($request->hasFile('adjuntos')) {
        //     $adjuntos = $this->mesaAyudaService->guardarAdjuntos($mesaAyuda, $request->file('adjuntos'));

        //     // Asociar adjunto(s) al seguimiento
        //     foreach ($adjuntos as $adjunto) {
        //         $seguimiento->update([
        //             'adjunto' => $adjunto->id ?? null,
        //         ]);
        //     }
        // }

        // Actualizar estado del caso
        $mesaAyuda->estado_id = 17;
        $mesaAyuda->save();

        return response()->json([
            'message' => 'Solicitud solucionada con éxito',
            'seguimiento' => $seguimiento,
        ]);
    }


    public function anularSolicitud(Request $request, int $mesaAyudaId)
    {
        $user = auth()->user();
        $caso = SeguimientoActividades::create([
            'user_id' => $user->id,
            'respuesta' => $request->respuesta,
            'mesa_ayuda_id' => $mesaAyudaId
        ]);
        if ($request->hasFile('adjuntos')) {
            foreach ($request->file('adjuntos') as $archivo) {
                $nombreOriginal = $archivo->getClientOriginalName();
                $ruta = 'adjuntosMesaAyuda/' . $mesaAyudaId . '/' . time() . '_' . $nombreOriginal;
                $archivo->move(public_path('adjuntosMesaAyuda/' . $mesaAyudaId), $ruta);
                AdjuntosMesaAyuda::create([
                    'mesa_ayuda_id' => $mesaAyudaId,
                    'nombre' => $nombreOriginal,
                    'ruta' => $ruta,
                ]);
            }
        }
        $mesaAyuda = MesaAyuda::findOrFail($mesaAyudaId);
        $mesaAyuda->estado_id = 5;
        $mesaAyuda->save();
    }

    public function actualizarEstadoAsignado($data)
    {
        $this->mesaAyudamodel->where('id', $data['mesa_ayuda_id'])->update(['estado_id' => 6, 'categoria_mesa_ayuda_id' => $data['categoria']['id']]);
    }

    public function asignar($request)
    {


        foreach ($request['categoria']['user'] as $operador) {
            $this->asignadosMesaAyudaRepository->crearAsignado($request['mesa_ayuda_id'], $operador['id'], $request['categoria']['id']);
        }

        return '¡Ha asignado la solicitud con exito!';
    }


    public function listarAsignados(Request $request)
    {
        $cantidad = $request->get('cantidad', 10);
        $areaFiltro = $request->get('area_filtro');
        $sede_filtro = $request->get('sede_filtro');

        $casos = $this->mesaAyudamodel
            ->select(
                'mesa_ayudas.id',
                'mesa_ayudas.asunto',
                'mesa_ayudas.contacto',
                'mesa_ayudas.descripcion',
                'mesa_ayudas.categoria_mesa_ayuda_id',
                'mesa_ayudas.fecha_meta_solucion',
                'prioridades.nombre as nombrePrioridad',
                'estados.nombre as nombreEstado',
                DB::raw("TO_CHAR(mesa_ayudas.created_at, 'YYYY-MM-DD') as fechaCreacion"),
                'mesa_ayudas.usuario_registra_id',
                'users.email',
                'areas_mesa_ayudas.nombre as area',
                'sedes.nombre as SedeNombre'
            )->with('AdjuntosMesaAyuda', 'categoriaMesaAyuda', 'seguimientoActividades.user.operador')
            ->join('users', 'mesa_ayudas.usuario_registra_id', 'users.id')
            ->join('categoria_mesa_ayudas as cma', 'mesa_ayudas.categoria_mesa_ayuda_id', 'cma.id')
            ->join('areas_mesa_ayudas', 'cma.areas_mesa_ayuda_id', 'areas_mesa_ayudas.id')
            ->join('sedes', 'mesa_ayudas.sede_id', 'sedes.id')
            ->leftjoin('prioridades', 'mesa_ayudas.prioridad_id', 'prioridades.id')
            ->join('estados', 'mesa_ayudas.estado_id', 'estados.id')
            ->leftjoin('operadores', 'operadores.user_id', 'users.id')
            ->selectRaw("CONCAT(operadores.nombre, ' ', operadores.apellido)as NombreOperador")
            ->whereIn('mesa_ayudas.estado_id', [6, 15, 18, 19])
            ->whereHas('asignadosMesaAyuda', function ($query) {
                $query->where('user_id', auth()->user()->id)->where('estado_id', 1);
            })
            ->orderBy('mesa_ayudas.id', 'Asc');

        if ($request->has('radicado_filtro')) {
            $casos->where('mesa_ayudas.id', 'ILIKE', '%' . $request->input('radicado_filtro') . '%');
        }

        if ($areaFiltro) {
            $casos->where('areas_mesa_ayudas.nombre', 'ILIKE', '%' . $areaFiltro . '%');
        }

        if ($sede_filtro) {
            $casos->where('sedes.nombre', 'ILIKE', '%' . $sede_filtro . '%');
        }
        $total = $casos->count();

        // 🔹 datos paginados o no
        if ($request->has('page')) {
            $data = $casos->paginate($cantidad);
        } else {
            $data = $casos->get();
        }

        return [
            'data'  => $data,
            'total' => $total
        ];
    }

    public function actualizarEstadoPendiente($id)
    {
        $this->mesaAyudamodel->where('id', $id)->update(['estado_id' => 10]);
    }

    public function crearSeguimiento($mesaAyudaId, $user, $respuesta)
    {
        SeguimientoActividades::create([
            'user_id' => $user,
            'respuesta' => $respuesta,
            'mesa_ayuda_id' => $mesaAyudaId
        ]);
    }

    public function listarSolucionados(Request $request)
    {
        $userId = Auth::id();
        $cantidad = $request->get('cantidad', 10);
        $sedeFiltro = $request->get('sede_filtro');

        $categoriasUsuario = DB::table('categoria_mesa_ayuda_user')
            ->where('user_id', $userId)
            ->pluck('categoria_mesa_ayuda_id');

        $casos = $this->mesaAyudamodel
            ->select(
                'mesa_ayudas.id',
                'mesa_ayudas.asunto',
                'mesa_ayudas.descripcion',
                'mesa_ayudas.categoria_mesa_ayuda_id',
                'prioridades.nombre as nombrePrioridad',
                'estados.nombre as nombreEstado',
                DB::raw("TO_CHAR(mesa_ayudas.created_at, 'YYYY-MM-DD') as fechaCreacion"),
                'mesa_ayudas.usuario_registra_id',
                'users.email',
                'areas_mesa_ayudas.nombre as area',
                'sedes.nombre as sedeNombre'
            )->with('AdjuntosMesaAyuda', 'categoriaMesaAyuda', 'seguimientoActividades.user.operador')
            ->join('users', 'mesa_ayudas.usuario_registra_id', 'users.id')
            ->join('categoria_mesa_ayudas as cma', 'mesa_ayudas.categoria_mesa_ayuda_id', 'cma.id')
            ->join('areas_mesa_ayudas', 'cma.areas_mesa_ayuda_id', 'areas_mesa_ayudas.id')
            ->leftjoin('prioridades', 'mesa_ayudas.prioridad_id', 'prioridades.id')
            ->join('estados', 'mesa_ayudas.estado_id', 'estados.id')
            ->join('sedes', 'mesa_ayudas.sede_id', 'sedes.id')
            ->leftjoin('operadores', 'operadores.user_id', 'users.id')
            ->selectRaw("CONCAT(operadores.nombre, ' ', operadores.apellido) as NombreOperador")
            ->where('mesa_ayudas.estado_id', 17)
            ->whereIn('mesa_ayudas.categoria_mesa_ayuda_id', $categoriasUsuario)
            ->orderBy('mesa_ayudas.id', 'Asc');

        if ($request->has('radicado_filtro')) {
            $casos->where('mesa_ayudas.id', 'ILIKE', '%' . $request->input('radicado_filtro') . '%');
        }

        if ($sedeFiltro) {
            $casos->where('sedes.nombre', 'ILIKE', '%' . $sedeFiltro . '%');
        }

        if ($request->has('categoria')) {
            $casos->where('cma.nombre', 'ILIKE', '%' . $request->input('categoria') . '%');
        }

        if ($request->has('page')) {
            return $casos->paginate($cantidad);
        } else {
            return $casos->get();
        }
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function update($id, array $data)
    {
        $mesaAyuda = $this->model->find($id);
        if ($mesaAyuda) {
            $mesaAyuda->update($data);
            return $mesaAyuda;
        }
        return null;
    }

    public function buscarClientePorId(int $id)
    {
        return Clientemesaayuda::find($id);
    }


    public function buscarMesaPorId(int $id)
    {
        return $this->mesaAyudamodel->where('id', $id)->with('seguimientoActividades', 'categoriaMesaAyuda', 'asignadosMesaAyuda', 'AdjuntosMesaAyuda')->first();
    }

    public function consultarAdjuntosConUrl($request)
    {
        $adjuntos = AdjuntosMesaAyuda::where('mesa_ayuda_id', $request->mesa_id)->get();

        return $adjuntos->map(function ($adjunto) {
            return [
                'id' => $adjunto->id,
                'nombre' => $adjunto->nombre,
                'fecha' => $adjunto->created_at,
                'url' => Storage::disk('digital')->temporaryUrl($adjunto->ruta, now()->addMinutes(5))
            ];
        });
    }
}
