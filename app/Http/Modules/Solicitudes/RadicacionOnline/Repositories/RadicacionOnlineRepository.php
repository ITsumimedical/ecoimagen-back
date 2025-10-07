<?php

namespace App\Http\Modules\Solicitudes\RadicacionOnline\Repositories;

use Illuminate\Support\Facades\Auth;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Solicitudes\RadicacionOnline\Models\RadicacionOnline;
use App\Http\Modules\Solicitudes\GestionRadicacionOnline\Models\GestionRadicacionOnline;
use Illuminate\Support\Facades\DB;

class RadicacionOnlineRepository extends RepositoryBase
{

    public function __construct(protected RadicacionOnline $radicacionOnlineModel)
    {
        parent::__construct($this->radicacionOnlineModel);
    }

    public function crearRadicacion($request)
    {
        if ($request['fecha_inicio'] == "null") {
            $fecha_inicio = null;
            $fecha_final = null;
        } else {
            $fecha_inicio = $request['fecha_inicio'];
            $fecha_final = $request['fecha_final'];
        }

        return  $this->radicacionOnlineModel->create([
            'ruta' => isset(Auth::user()->id) ? 'Interna' : 'Web',
            'descripcion' => $request['descripcion'],
            'afiliado_id' => $request['afiliado_id'],
            'tipo_solicitud_red_vital_id' => $request['solicitud_id'],
            'telefono' => $request['telefono'],
            'correo' => $request['correo'],
            'estado_id' => 10,
            'fecha_inicio' => $fecha_inicio,
            'fecha_final' => $fecha_final,
        ]);
    }

    public function filtro($request)
    {
        $pendientes = $this->radicacionOnlineModel->select(
            'radicacion_onlines.ruta',
            'radicacion_onlines.descripcion',
            'radicacion_onlines.afiliado_id',
            'radicacion_onlines.tipo_solicitud_red_vital_id',
            'radicacion_onlines.estado_id',
            'ts.nombre as nombreTipo',
            'afiliados.numero_documento',
            'afiliados.departamento_afiliacion_id',
            'afiliados.municipio_afiliacion_id',
            'reps.nombre as ips',
            'estados.nombre as estado',
            'afiliados.primer_nombre',
            'afiliados.primer_apellido',
            'radicacion_onlines.updated_at',
            'afiliados.segundo_nombre',
            'afiliados.segundo_apellido',
            'afiliados.tipo_documento',
            'afiliados.telefono',
            'departamentos.nombre as departamento',
            'afiliados.celular1',
            'afiliados.direccion_residencia_cargue',
            'radicacion_onlines.id',
            'radicacion_onlines.created_at',
            'municipios.nombre as municipio'
        )
            ->selectRaw("CONCAT(afiliados.primer_nombre, ' ',afiliados.primer_apellido) as nombreafiliado ")
            ->join('tipo_solicitud_red_vitals as ts', 'radicacion_onlines.tipo_solicitud_red_vital_id', 'ts.id')
            ->join('afiliados', 'radicacion_onlines.afiliado_id', 'afiliados.id')
            ->join('estados', 'radicacion_onlines.estado_id', 'estados.id')
            ->join('departamentos', 'afiliados.departamento_afiliacion_id', 'departamentos.id')
            ->join('municipios', 'afiliados.municipio_afiliacion_id', 'municipios.id')
            ->leftjoin('reps', 'afiliados.ips_id', 'reps.id')
            ->with(['adjuntoRadicado' => function ($query) {
                $query->select('radicacion_online_id', 'ruta', 'nombre')->get();
            }])
            ->where('radicacion_onlines.estado_id', $request['estado'])
            ->whereNotIn('radicacion_onlines.id', function ($query) {
                $query->select('radicacion_online_id')
                    ->where('tipo_id', 20)
                    ->from('gestion_radicacion_onlines');
            });

        // Aplicar filtro por estado si está presente en la solicitud
        if (isset($request['estado']) && $request['estado']) {
            $pendientes->where('radicacion_onlines.estado_id', $request['estado']);
        }

        // Aplicar filtro por fecha si están presentes en la solicitud
        if (isset($request['desde']) && $request['desde']) {
            $pendientes->where('radicacion_onlines.created_at', '>=', $request['desde'] . ' 00:00:00');
        }

        if (isset($request['hasta']) && $request['hasta']) {
            $pendientes->where('radicacion_onlines.created_at', '<=', $request['hasta'] . ' 23:59:59');
        }

        // Aplicar filtro por documento si está presente en la solicitud
        if (isset($request['documento']) && $request['documento']) {
            $afiliado = Afiliado::where('numero_documento', $request['documento'])->first();
            if ($afiliado) {
                $pendientes->where('radicacion_onlines.afiliado_id', $afiliado->id);
            }
        }

        // Aplicar filtro por radicado si está presente en la solicitud
        if (isset($request['radicado']) && $request['radicado']) {
            $pendientes->where('radicacion_onlines.id', $request['radicado']);
        }

        // Aplicar filtro por tipo de solicitud si está presente en la solicitud
        if (isset($request['tipoSolicitud']) && $request['tipoSolicitud']) {
            $pendientes->where('ts.nombre', $request['tipoSolicitud']);
        }

        // Aplicar filtro por departamento si está presente en la solicitud
        if (isset($request['departamento']) && $request['departamento']) {
            $pendientes->where('departamentos.nombre', 'ILIKE', '%' . $request['departamento'] . '%');
        }

        // Aplicar filtro por municipio si está presente en la solicitud
        if (isset($request['municipio']) && $request['municipio']) {
            $pendientes->where('municipios.nombre', 'ILIKE', '%' . $request['municipio'] . '%');
        }

        // Aplicar filtro por IPS si está presente en la solicitud
        if (isset($request['ips']) && $request['ips']) {
            $pendientes->where('reps.nombre', 'ILIKE', '%' . $request['ips'] . '%');
        }

        // Obtener los resultados y agregar el colaborador
        $resultados = $pendientes->get();

        foreach ($resultados as $key) {
            $userColaborar = GestionRadicacionOnline::select(['operadores.nombre', 'operadores.apellido'])
                ->join('users', 'gestion_radicacion_onlines.user_id', 'users.id')
                ->join('operadores', 'users.id', 'operadores.user_id')
                ->where('gestion_radicacion_onlines.radicacion_online_id', $key->id)
                ->where('gestion_radicacion_onlines.tipo_id', 3)
                ->first();

            if ($userColaborar) {
                $key['colaborador'] = $userColaborar->nombre . ' ' . $userColaborar->apellido;
            }
        }


        return  $request['page'] ? $pendientes->paginate($request['cantidad']) : $pendientes->get();
    }

    public function actualizarEstado($id)
    {
        $this->radicacionOnlineModel->where('id', $id)->update(['estado_id' => 18]);
    }

    public function datosparaEmail($id)
    {
        return $this->radicacionOnlineModel->select('afiliados.primer_nombre', 'afiliados.correo1')
            ->join('afiliados', 'radicacion_onlines.afiliado_id', 'afiliados.id')
            ->where('radicacion_onlines.id', $id)->first();
    }

    public function actualizarEstadoCerrado($id)
    {
        $this->radicacionOnlineModel->where('id', $id)->update(['estado_id' => 17]);
    }

    public function actualizarEstadoPendiente($id)
    {
        $this->radicacionOnlineModel->where('id', $id)->where('estado_id', 18)->update(['estado_id' => 10]);
    }

    public function filtroSolucionadas($request)
    {
        $solucionadas = $this->radicacionOnlineModel->select(
            'radicacion_onlines.ruta',
            'radicacion_onlines.descripcion',
            'radicacion_onlines.afiliado_id',
            'radicacion_onlines.tipo_solicitud_red_vital_id',
            'radicacion_onlines.estado_id',
            'ts.nombre as nombreTipo',
            'afiliados.numero_documento',
            'afiliados.departamento_afiliacion_id',
            'afiliados.municipio_afiliacion_id',
            'reps.nombre as ips',
            'estados.nombre as estado',
            'afiliados.primer_nombre',
            'afiliados.primer_apellido',
            'radicacion_onlines.updated_at',
            'afiliados.segundo_nombre',
            'afiliados.segundo_apellido',
            'afiliados.tipo_documento',
            'afiliados.telefono',
            'departamentos.nombre as departamento',
            'afiliados.celular1',
            'afiliados.direccion_residencia_cargue',
            'radicacion_onlines.id',
            'radicacion_onlines.created_at',
            'municipios.nombre as municipio'
        )
            ->selectRaw("CONCAT(afiliados.primer_nombre, ' ',afiliados.primer_apellido) as nombreAfiliado")
            ->join('tipo_solicitud_red_vitals as ts', 'radicacion_onlines.tipo_solicitud_red_vital_id', 'ts.id')
            ->join('afiliados', 'radicacion_onlines.afiliado_id', 'afiliados.id')
            ->join('estados', 'radicacion_onlines.estado_id', 'estados.id')
            ->join('departamentos', 'afiliados.departamento_afiliacion_id', 'departamentos.id')
            ->join('municipios', 'afiliados.municipio_afiliacion_id', 'municipios.id')
            ->leftJoin('reps', 'afiliados.ips_id', 'reps.id')
            ->with(['adjuntoRadicado' => function ($query) {
                $query->select('radicacion_online_id', 'ruta', 'nombre');
            }])
            ->with(['gestion' => function ($query) {
                $query->select(
                    'radicacion_online_id',
                    'motivo',
                    'gestion_radicacion_onlines.created_at',
                    'gestion_radicacion_onlines.id',
                    'operadores.nombre',
                    'operadores.apellido'
                )
                    ->join('users', 'gestion_radicacion_onlines.user_id', 'users.id')
                    ->join('operadores', 'users.id', 'operadores.user_id')
                    ->with(['adjuntosGestion' => function ($query) {
                        $query->select('gestion_radicacion_online_id', 'ruta', 'nombre');
                    }])
                    ->where('gestion_radicacion_onlines.tipo_id', 21);
            }])
            ->where('radicacion_onlines.estado_id', 17)
            ->whereNotIn('radicacion_onlines.id', function ($query) {
                $query->select('radicacion_online_id')
                    ->where('tipo_id', 20)
                    ->from('gestion_radicacion_onlines');
            });

        if (isset($request['fechaDesde']) && isset($request['fechaHasta'])) {
            $solucionadas->whereBetween('radicacion_onlines.created_at', [
                $request['fechaDesde'] . ' 00:00:00',
                $request['fechaHasta'] . ' 23:59:59'
            ]);
        }

        // Filtrar por documento si se proporciona
        if (isset($request['documento'])) {
            $afiliado = Afiliado::where('numero_documento', $request['documento'])->first();
            if ($afiliado) {
                $solucionadas->where('radicacion_onlines.afiliado_id', $afiliado->id);
            }
        }

        // Filtrar por departamento si se proporciona
        if (isset($request['departamento'])) {
            $solucionadas->where('afiliados.departamento_afiliacion_id', $request['departamento']);
        }

        // Filtrar por municipio si se proporciona
        if (isset($request['municipio'])) {
            $solucionadas->where('afiliados.municipio_afiliacion_id', $request['municipio']);
        }

        // Filtrar por tipo de solicitud si se proporciona
        if (isset($request['tipoSolicitud'])) {
            $solucionadas->where('ts.nombre', $request['tipoSolicitud']);
        }

        // Obtener los resultados
        return $request['page'] ? $solucionadas->paginate($request['cantidad']) : $solucionadas->get();
    }


    public function filtroPendientesAsignados($request)
    {
        $pendientes = $this->radicacionOnlineModel->select(
            'radicacion_onlines.ruta',
            'radicacion_onlines.descripcion',
            'radicacion_onlines.afiliado_id',
            'radicacion_onlines.tipo_solicitud_red_vital_id',
            'radicacion_onlines.estado_id',
            'ts.nombre as nombreTipo',
            'afiliados.numero_documento',
            'afiliados.departamento_afiliacion_id',
            'afiliados.municipio_afiliacion_id',
            'reps.nombre as ips',
            'estados.nombre as estado',
            'afiliados.primer_nombre',
            'afiliados.primer_apellido',
            'radicacion_onlines.updated_at',
            'afiliados.segundo_nombre',
            'afiliados.segundo_apellido',
            'afiliados.tipo_documento',
            'afiliados.telefono',
            'departamentos.nombre as departamento',
            'afiliados.celular1',
            'afiliados.direccion_residencia_cargue',
            'radicacion_onlines.id',
            'radicacion_onlines.created_at',
            'municipios.nombre as municipio'
        )
            ->selectRaw("CONCAT(afiliados.primer_nombre, ' ',afiliados.primer_apellido) as nombreAfiliado ")
            ->join('tipo_solicitud_red_vitals as ts', 'radicacion_onlines.tipo_solicitud_red_vital_id', 'ts.id')
            ->join('afiliados', 'radicacion_onlines.afiliado_id', 'afiliados.id')
            ->join('estados', 'radicacion_onlines.estado_id', 'estados.id')
            ->join('departamentos', 'afiliados.departamento_afiliacion_id', 'departamentos.id')
            ->join('municipios', 'afiliados.municipio_afiliacion_id', 'municipios.id')
            ->leftjoin('reps', 'afiliados.ips_id', 'reps.id')
            ->with(['adjuntoRadicado' => function ($query) {
                $query->select('radicacion_online_id', 'ruta', 'nombre')->get();
            }])
            ->where('radicacion_onlines.estado_id', $request['estado'])
            ->whereIn('radicacion_onlines.id', function ($query) {
                $query->select('radicacion_online_id')
                    ->where('user_id', Auth::user()->id)
                    ->where('tipo_id', 20)
                    ->from('gestion_radicacion_onlines');
            });

        if ($request['desde'] && $request['hasta']) {
            $pendientes->whereBetween('radicacion_onlines.created_at', [$request['desde'] . ' 00:00:00.000', $request['hasta'] . ' 23:59:00.000']);
        }

        if ($request['documento']) {
            $afiliado = Afiliado::where('numero_documento', $request['documento'])->first();
            $pendientes->where('radicacion_onlines.afiliado_id', $afiliado->id);
        }

        if ($request['radicado']) {
            $pendientes->where('radicacion_onlines.id', $request['radicado']);
        }

        if ($request['tipoSolicitud']) {
            $pendientes->where('ts.nombre', $request['tipoSolicitud']);
        }

        if ($request['departamento']) {
            $pendientes->where('departamentos.nombre', 'ILIKE', '%' . $request['departamento'] . '%');
        }

        if ($request['municipio']) {
            $pendientes->where('municipios.nombre', 'ILIKE', '%' . $request['municipio'] . '%');
        }

        if ($request['ips']) {
            $pendientes->where('reps.nombre', 'ILIKE', '%' . $request['ips'] . '%');
        }

        foreach ($pendientes as $key) {
            $userColaborar = GestionRadicacionOnline::select(['operadores.nombre', 'operadores.apellido'])
                ->join('users', 'gestion_radicacion_onlines.user_id', 'users.id')
                ->join('operadores', 'users.id', 'operadores.user_id')
                ->where('gestion_radicacion_onlines.radicacion_online_id', $key->id)
                ->where('gestion_radicacion_onlines.tipo_id', 3)
                ->first();

            if ($userColaborar) {
                $key['colaborador'] = $userColaborar->primer_nombre . ' ' . $userColaborar->primer_apellido;
            }
        }


        return $request['page'] ? $pendientes->paginate($request['cantidad']) : $pendientes->get();
    }

    public function solucionadasAsignadas($request)
    {
        $solucionados = $this->radicacionOnlineModel->select(
            'radicacion_onlines.ruta',
            'radicacion_onlines.descripcion',
            'radicacion_onlines.afiliado_id',
            'radicacion_onlines.tipo_solicitud_red_vital_id',
            'radicacion_onlines.estado_id',
            'ts.nombre as nombreTipo',
            'afiliados.numero_documento',
            'afiliados.departamento_afiliacion_id',
            'afiliados.municipio_afiliacion_id',
            'reps.nombre as ips',
            'estados.nombre as estado',
            'afiliados.primer_nombre',
            'afiliados.primer_apellido',
            'radicacion_onlines.updated_at',
            'afiliados.segundo_nombre',
            'afiliados.segundo_apellido',
            'afiliados.tipo_documento',
            'afiliados.telefono',
            'departamentos.nombre as departamento',
            'afiliados.celular1',
            'afiliados.direccion_residencia_cargue',
            'radicacion_onlines.id',
            'radicacion_onlines.created_at',
            'municipios.nombre as municipio'
        )
            ->selectRaw("CONCAT(afiliados.primer_nombre, ' ',afiliados.primer_apellido) as nombreAfiliado ")
            ->join('tipo_solicitud_red_vitals as ts', 'radicacion_onlines.tipo_solicitud_red_vital_id', 'ts.id')
            ->join('afiliados', 'radicacion_onlines.afiliado_id', 'afiliados.id')
            ->join('estados', 'radicacion_onlines.estado_id', 'estados.id')
            ->join('departamentos', 'afiliados.departamento_afiliacion_id', 'departamentos.id')
            ->join('municipios', 'afiliados.municipio_afiliacion_id', 'municipios.id')
            ->leftjoin('reps', 'afiliados.ips_id', 'reps.id')
            ->with(['adjuntoRadicado' => function ($query) {
                $query->select('radicacion_online_id', 'ruta', 'nombre')->get();
            }])
            ->with(['gestion' => function ($query) {
                $query->select(
                    'radicacion_online_id',
                    'motivo',
                    'gestion_radicacion_onlines.created_at',
                    'gestion_radicacion_onlines.id',
                    'operadores.nombre',
                    'operadores.apellido'
                )
                    ->join('users', 'gestion_radicacion_onlines.user_id', 'users.id')
                    ->join('operadores', 'users.id', 'operadores.user_id')
                    ->with(['adjuntosGestion' => function ($query) {
                        $query->select('gestion_radicacion_online_id', 'ruta', 'nombre')
                            ->get();
                    }])
                    ->where('gestion_radicacion_onlines.tipo_id', 21)
                    ->get();
            }])
            ->where('radicacion_onlines.estado_id', 17)
            ->whereIn('radicacion_onlines.id', function ($query) {
                $query->select('radicacion_online_id')
                    ->where('user_id', Auth::user()->id)
                    ->where('tipo_id', 20)
                    ->from('gestion_radicacion_onlines');
            });



        foreach ($solucionados as $key) {
            $userColaborar = GestionRadicacionOnline::select(['operadores.nombre', 'operadores.apellido'])
                ->join('users', 'gestion_radicacion_onlines.user_id', 'users.id')
                ->join('operadores', 'users.id', 'operadores.user_id')
                ->where('gestion_radicacion_onlines.radicacion_online_id', $key->id)
                ->where('gestion_radicacion_onlines.tipo_id', 3)
                ->first();

            if ($userColaborar) {
                $key['colaborador'] = $userColaborar->primer_nombre . ' ' . $userColaborar->primer_apellido;
            }
        }


        return $request['page'] ? $solucionados->paginate($request['cantidad']) : $solucionados->get();
    }

    public function buscarPendientes($request)
    {
        $pendientes = $this->radicacionOnlineModel->select(
            'radicacion_onlines.ruta',
            'radicacion_onlines.descripcion',
            'radicacion_onlines.afiliado_id',
            'radicacion_onlines.tipo_solicitud_red_vital_id',
            'radicacion_onlines.estado_id',
            'ts.nombre as nombreTipo',
            'afiliados.numero_documento',
            'afiliados.departamento_afiliacion_id',
            'afiliados.municipio_afiliacion_id',
            'reps.nombre as ips',
            'estados.nombre as estado',
            'afiliados.primer_nombre',
            'afiliados.primer_apellido',
            'radicacion_onlines.updated_at',
            'afiliados.segundo_nombre',
            'afiliados.segundo_apellido',
            'afiliados.tipo_documento',
            'afiliados.telefono',
            'departamentos.nombre as departamento',
            'afiliados.celular1',
            'afiliados.direccion_residencia_cargue',
            'radicacion_onlines.id',
            'radicacion_onlines.created_at',
            'municipios.nombre as municipio'
        )
            ->selectRaw("CONCAT(afiliados.primer_nombre, ' ',afiliados.primer_apellido) as nombreAfiliado ")
            ->join('tipo_solicitud_red_vitals as ts', 'radicacion_onlines.tipo_solicitud_red_vital_id', 'ts.id')
            ->join('afiliados', 'radicacion_onlines.afiliado_id', 'afiliados.id')
            ->join('estados', 'radicacion_onlines.estado_id', 'estados.id')
            ->join('departamentos', 'afiliados.departamento_afiliacion_id', 'departamentos.id')
            ->join('municipios', 'afiliados.municipio_afiliacion_id', 'municipios.id')
            ->leftjoin('reps', 'afiliados.ips_id', 'reps.id')
            ->with(['adjuntoRadicado' => function ($query) {
                $query->select('radicacion_online_id', 'ruta', 'nombre')->get();
            }])
            ->with(['gestion' => function ($query) {
                $query->select(
                    'radicacion_online_id',
                    'gestion_radicacion_onlines.id',
                    'operadores.nombre',
                    'operadores.apellido'
                )
                    ->join('users', 'gestion_radicacion_onlines.user_id', 'users.id')
                    ->join('operadores', 'users.id', 'operadores.user_id')
                    ->where('gestion_radicacion_onlines.tipo_id', 20)
                    ->get();
            }])
            ->where('radicacion_onlines.estado_id', $request['estado']);


        if ($request['desde'] && $request['hasta']) {
            $pendientes->whereBetween('radicacion_onlines.created_at', [$request['desde'] . ' 00:00:00.000', $request['hasta'] . ' 23:59:00.000']);
        }

        if ($request['documento']) {
            $afiliado = Afiliado::where('numero_documento', $request['documento'])->first();
            $pendientes->where('radicacion_onlines.afiliado_id', $afiliado->id);
        }

        if ($request['radicado']) {
            $pendientes->where('radicacion_onlines.id', $request['radicado']);
        }

        if ($request['tipoSolicitud']) {
            $pendientes->where('ts.nombre', $request['tipoSolicitud']);
        }

        foreach ($pendientes as $key) {
            $userColaborar = GestionRadicacionOnline::select(['operadores.nombre', 'operadores.apellido'])
                ->join('users', 'gestion_radicacion_onlines.user_id', 'users.id')
                ->join('operadores', 'users.id', 'operadores.user_id')
                ->where('gestion_radicacion_onlines.radicacion_online_id', $key->id)
                ->where('gestion_radicacion_onlines.tipo_id', 3)
                ->first();

            if ($userColaborar) {
                $key['colaborador'] = $userColaborar->primer_nombre . ' ' . $userColaborar->primer_apellido;
            }
        }


        return $pendientes->get();
    }

    public function radicadosActivados($id_user)
    {
        return  $this->radicacionOnlineModel->where('estado_id', '!=', 17)
            ->whereIn('radicacion_onlines.id', function ($query) use ($id_user) {
                $query->select('radicacion_online_id')
                    ->where('user_id', $id_user)
                    ->where('tipo_id', 20)
                    ->from('gestion_radicacion_onlines');
            })->get();
    }

    public function solucionadasAdmin($request)
    {
        $solucionados = $this->radicacionOnlineModel->select(
            'radicacion_onlines.ruta',
            'radicacion_onlines.descripcion',
            'radicacion_onlines.afiliado_id',
            'radicacion_onlines.tipo_solicitud_red_vital_id',
            'radicacion_onlines.estado_id',
            'ts.nombre as nombreTipo',
            'afiliados.numero_documento',
            'afiliados.departamento_afiliacion_id',
            'afiliados.municipio_afiliacion_id',
            'reps.nombre as ips',
            'estados.nombre as estado',
            'afiliados.primer_nombre',
            'afiliados.primer_apellido',
            'radicacion_onlines.updated_at',
            'afiliados.segundo_nombre',
            'afiliados.segundo_apellido',
            'afiliados.tipo_documento',
            'afiliados.telefono',
            'departamentos.nombre as departamento',
            'afiliados.celular1',
            'afiliados.direccion_residencia_cargue',
            'radicacion_onlines.id',
            'radicacion_onlines.created_at',
            'municipios.nombre as municipio'
        )
            ->selectRaw("CONCAT(afiliados.primer_nombre, ' ',afiliados.primer_apellido) as nombreAfiliado ")
            ->join('tipo_solicitud_red_vitals as ts', 'radicacion_onlines.tipo_solicitud_red_vital_id', 'ts.id')
            ->join('afiliados', 'radicacion_onlines.afiliado_id', 'afiliados.id')
            ->join('estados', 'radicacion_onlines.estado_id', 'estados.id')
            ->join('departamentos', 'afiliados.departamento_afiliacion_id', 'departamentos.id')
            ->join('municipios', 'afiliados.municipio_afiliacion_id', 'municipios.id')
            ->leftjoin('reps', 'afiliados.ips_id', 'reps.id')
            ->with(['adjuntoRadicado' => function ($query) {
                $query->select('radicacion_online_id', 'ruta', 'nombre')->get();
            }])
            ->with(['gestion' => function ($query) {
                $query->select(
                    'radicacion_online_id',
                    'motivo',
                    'gestion_radicacion_onlines.created_at',
                    'gestion_radicacion_onlines.id',
                    'operadores.nombre',
                    'operadores.apellido'
                )
                    ->join('users', 'gestion_radicacion_onlines.user_id', 'users.id')
                    ->join('operadores', 'users.id', 'operadores.user_id')
                    ->with(['adjuntosGestion' => function ($query) {
                        $query->select('gestion_radicacion_online_id', 'ruta', 'nombre')
                            ->get();
                    }])
                    ->where('gestion_radicacion_onlines.tipo_id', 21)
                    ->get();
            }])
            ->where('radicacion_onlines.estado_id', 17)
            ->whereBetween('radicacion_onlines.created_at', [$request['fechaDesde'], $request['fechaHasta']]);

        if ($request['documento']) {
            $solucionados->where('afiliados.numero_documento', $request['documento']);
        }

        if ($request['departamento']) {
            $solucionados->where('afiliados.departamento_afiliacion_id', $request['departamento']);
        }

        if ($request['municipio']) {
            $solucionados->where('afiliados.municipio_afiliacion_id', $request['municipio']);
        }


        if ($request['tipoSolicitud']) {
            $solucionados->where('ts.nombre', $request['tipoSolicitud']);
        }


        foreach ($solucionados as $key) {
            $userColaborar = GestionRadicacionOnline::select(['operadores.nombre', 'operadores.apellido'])
                ->join('users', 'gestion_radicacion_onlines.user_id', 'users.id')
                ->join('operadores', 'users.id', 'operadores.user_id')
                ->where('gestion_radicacion_onlines.radicacion_online_id', $key->id)
                ->where('gestion_radicacion_onlines.tipo_id', 3)
                ->first();

            if ($userColaborar) {
                $key['colaborador'] = $userColaborar->primer_nombre . ' ' . $userColaborar->primer_apellido;
            }
        }


        return $request['page'] ? $solucionados->paginate($request['cantidad']) : $solucionados->get();
    }

    public function informe($request)
    {
        $informe = $this->radicacionOnlineModel->select(
            'radicacion_onlines.id as Radicado',
            'radicacion_onlines.created_at as Fecha creado',
            'radicacion_onlines.updated_at as Fecha Actualizado',
            'estados.nombre as Estado',
            'afiliados.tipo_documento as Tipo documento',
            'afiliados.numero_documento',
            'afiliados.telefono as Telefono',
            'afiliados.celular1 as Celular',
            'afiliados.direccion_residencia_cargue as Direccion',
            'departamentos.nombre as Departamento',
            'municipios.nombre as Municipio',
            'reps.nombre as IPS primaria',
            'radicacion_onlines.ruta as Ruta',
            'ts.nombre as Tipo solicitud',
            'radicacion_onlines.descripcion as Descripcion'
        )
            ->selectRaw("CONCAT(afiliados.primer_nombre, ' ',afiliados.segundo_nombre, ' ',afiliados.primer_apellido, ' ',afiliados.segundo_apellido) as Nombre ")
            ->join('tipo_solicitud_red_vitals as ts', 'radicacion_onlines.tipo_solicitud_red_vital_id', 'ts.id')
            ->join('estados', 'radicacion_onlines.estado_id', 'estados.id')
            ->join('afiliados', 'radicacion_onlines.afiliado_id', 'afiliados.id')
            ->join('departamentos', 'afiliados.departamento_afiliacion_id', 'departamentos.id')
            ->join('municipios', 'afiliados.municipio_afiliacion_id', 'municipios.id')
            ->leftjoin('reps', 'afiliados.ips_id', 'reps.id')
            ->whereBetween('radicacion_onlines.created_at', [$request['fechaDesde'], $request['fechaHasta']]);

        if ($request['documento']) {
            $informe->where('afiliados.numero_documento', $request['documento']);
        }

        if ($request['departamento']) {
            $informe->where('afiliados.departamento_afiliacion_id', $request['departamento']);
        }

        if ($request['municipio']) {
            $informe->where('afiliados.municipio_afiliacion_id', $request['municipio']);
        }


        if ($request['tipoSolicitud']) {
            $informe->where('ts.nombre', $request['tipoSolicitud']);
        }

        $info = $informe->get();
        foreach ($info as $key) {
            $userColaborar = GestionRadicacionOnline::select(['operadores.nombre', 'operadores.apellido'])
                ->join('users', 'gestion_radicacion_onlines.user_id', 'users.id')
                ->join('operadores', 'users.id', 'operadores.user_id')
                ->where('gestion_radicacion_onlines.radicacion_online_id', $key->Radicado)
                ->first();

            if ($userColaborar) {
                $key['colaborador'] = $userColaborar->primer_nombre . ' ' . $userColaborar->primer_apellido;
            }
        }


        return (new FastExcel($info))->download('file.xls');
    }


    public function obtenerRadicadosPaciente($request)
    {
        $query = $this->radicacionOnlineModel::with(['estado', 'tipo_solicitud_red_vital', 'gestion', 'adjuntoRadicado'])
            ->where('radicacion_onlines.afiliado_id', $request['afiliado_id']);

        if (!empty($request['numero_radicado'])) {
            $query->where('radicacion_onlines.id', $request['numero_radicado']);
        }

        $fechaInicio = date('Y-m-d H:i:s', strtotime($request['fecha'] . ' 00:00:00'));

        return $query->where('radicacion_onlines.created_at', '>=', $fechaInicio)->get();
    }

    // Funcion para obtener la cantidad de solicitudes pendientes por tipo
    public function cantidadPendientesTipo()
    {
        // Definimos los tipos de solicitudes que queremos contar
        $tiposSolicitudes = [1, 10, 12, 13, 26, 27, 28, 29, 30, 11];

        // Realizamos una consulta para obtener las cantidades por cada tipo
        $result = $this->radicacionOnlineModel
            ->select('tipo_solicitud_red_vital_id', DB::raw('count(1) as cantidad'))
            ->where('estado_id', 10)
            ->whereIn('tipo_solicitud_red_vital_id', $tiposSolicitudes)
            ->groupBy('tipo_solicitud_red_vital_id')
            ->get();

        // Convertimos el resultado a un array asociativo con el formato [tipo_solicitud_id => cantidad]
        $cantidadPendientes = $result->pluck('cantidad', 'tipo_solicitud_red_vital_id')->toArray();

        // Aseguramos que todos los tipos de solicitudes tengan una cantidad, incluso si es 0
        foreach ($tiposSolicitudes as $tipo) {
            if (!isset($cantidadPendientes[$tipo])) {
                $cantidadPendientes[$tipo] = 0;
            }
        }

        return $cantidadPendientes;
    }
    public function cantidadSolucionadasTipo()
    {
        // Definimos los tipos de solicitudes que queremos contar
        $tiposSolicitudes = [1, 10, 12, 13, 26, 27, 28, 29, 30, 11];

        // Realizamos una consulta para obtener las cantidades por cada tipo
        $result = $this->radicacionOnlineModel
            ->select('tipo_solicitud_red_vital_id', DB::raw('count(1) as cantidad'))
            ->where('estado_id', 17)
            ->whereIn('tipo_solicitud_red_vital_id', $tiposSolicitudes)
            ->groupBy('tipo_solicitud_red_vital_id')
            ->get();

        // Convertimos el resultado a un array asociativo con el formato [tipo_solicitud_id => cantidad]
        $cantidadPendientes = $result->pluck('cantidad', 'tipo_solicitud_red_vital_id')->toArray();

        // Aseguramos que todos los tipos de solicitudes tengan una cantidad, incluso si es 0
        foreach ($tiposSolicitudes as $tipo) {
            if (!isset($cantidadPendientes[$tipo])) {
                $cantidadPendientes[$tipo] = 0;
            }
        }

        return $cantidadPendientes;
    }

    public function listarSolicitudes($request)
    {
        $query = $this->radicacionOnlineModel::with(['afiliado.ips', 'afiliado.departamento_afiliacion', 'afiliado.municipio_afiliacion', 'tipo_solicitud_red_vital', 'estado', 'adjuntoRadicado', 'gestion.user.operador', 'beneficiarioRadicacion.tipoDocumento', 'beneficiarioRadicacion.nacionalidad', 'beneficiarioRadicacion.departamentoAfiliacion', 'beneficiarioRadicacion.municipioAfiliacion', 'beneficiarioRadicacion.tipoAfiliado', 'beneficiarioRadicacion.tipoAfiliacion', 'beneficiarioRadicacion.entidad', 'beneficiarioRadicacion.tipoBeneficiario'])
            ->where('tipo_solicitud_red_vital_id', $request['tipo_solicitud_id'])
            ->where('estado_id', $request['estado_id']);

        if ($request['numero_radicado']) {
            $query->where('id', $request['numero_radicado']);
        }

        if ($request['documento_afiliado']) {
            $query->whereHas('afiliado', function ($q) use ($request) {
                $q->where('numero_documento', $request['documento_afiliado']);
            });
        }

        if ($request['fecha_desde'] && $request['fecha_hasta']) {
            $query->whereBetween('created_at', [$request['fecha_desde'], $request['fecha_hasta']]);
        }

        if ($request['departamento']) {
            $query->whereHas('afiliado.departamento_afiliacion', function ($q) use ($request) {
                $q->where('nombre', 'LIKE', '%' . $request['departamento'] . '%');
            });
        }

        if ($request['municipio']) {
            $query->whereHas('afiliado.municipio_afiliacion', function ($q) use ($request) {
                $q->where('nombre', 'LIKE', '%' . $request['municipio'] . '%');
            });
        }

        return $query->paginate($request['per_page']);
    }

    public function obtenerCantidadSolicitudesTipo($request)
    {
        // Definimos los tipos de solicitudes que queremos contar
        $tiposSolicitudes = [1, 10, 12, 13, 26, 27, 28, 29, 30, 11];

        // Obtenemos el ID del usuario logueado
        $userId = auth()->user()->id;

        // Realizamos la consulta para obtener las cantidades por cada tipo
        $result = $this->radicacionOnlineModel
            ->join('gestion_radicacion_onlines as gro', 'gro.radicacion_online_id', '=', 'radicacion_onlines.id')
            ->join('area_solicitudes_user as asu', 'asu.area_solicitudes_id', '=', 'gro.area_solicitudes_id')
            ->select('radicacion_onlines.tipo_solicitud_red_vital_id', DB::raw('count(*) as cantidad'))
            ->where('gro.tipo_id', 20) // tipo_id = 20 significa asignada
            ->where('radicacion_onlines.estado_id', $request['estado_id'])
            ->where('asu.user_id', $userId) // Área del usuario logueado
            ->whereIn('radicacion_onlines.tipo_solicitud_red_vital_id', $tiposSolicitudes)
            ->groupBy('radicacion_onlines.tipo_solicitud_red_vital_id')
            ->get();

        // dd($result);
        // Convertimos el resultado a un array asociativo con el formato [tipo_solicitud_id => cantidad]
        $cantidadSolicitudes = $result->pluck('cantidad', 'tipo_solicitud_red_vital_id')->toArray();

        // Aseguramos que todos los tipos de solicitudes tengan una cantidad, incluso si es 0
        foreach ($tiposSolicitudes as $tipo) {
            if (!isset($cantidadSolicitudes[$tipo])) {
                $cantidadSolicitudes[$tipo] = 0;
            }
        }

        return $cantidadSolicitudes;
    }

    public function listarSolicitudesAsignadas($request)
    {
        $userId = auth()->user()->id;


        $query = $this->radicacionOnlineModel
            ->select('radicacion_onlines.*')->with(['afiliado.ips', 'afiliado.departamento_afiliacion', 'afiliado.municipio_afiliacion', 'tipo_solicitud_red_vital', 'estado', 'adjuntoRadicado', 'gestion.user.operador', 'beneficiarioRadicacion.tipoDocumento', 'beneficiarioRadicacion.nacionalidad', 'beneficiarioRadicacion.departamentoAfiliacion', 'beneficiarioRadicacion.municipioAfiliacion', 'beneficiarioRadicacion.tipoAfiliado', 'beneficiarioRadicacion.tipoAfiliacion', 'beneficiarioRadicacion.entidad', 'beneficiarioRadicacion.tipoBeneficiario'])
            ->join('gestion_radicacion_onlines as gro', 'gro.radicacion_online_id', '=', 'radicacion_onlines.id')
            ->join('area_solicitudes_user as asu', 'asu.area_solicitudes_id', '=', 'gro.area_solicitudes_id')
            ->where('gro.tipo_id', 20)
            ->where('radicacion_onlines.estado_id', $request['estado_id'])
            ->where('asu.user_id', $userId)
            ->where('radicacion_onlines.tipo_solicitud_red_vital_id', $request['tipo_solicitud_id'],)
            ->orderBy('radicacion_onlines.id', 'asc');

        if ($request['numero_radicado']) {
            $query->where('id', $request['numero_radicado']);
        }

        if ($request['documento_afiliado']) {
            $query->whereHas('afiliado', function ($q) use ($request) {
                $q->where('numero_documento', $request['documento_afiliado']);
            });
        }

        if ($request['fecha_desde'] && $request['fecha_hasta']) {
            $query->whereBetween('created_at', [$request['fecha_desde'], $request['fecha_hasta']]);
        }

        if ($request['departamento']) {
            $query->whereHas('afiliado.departamento_afiliacion', function ($q) use ($request) {
                $q->where('nombre', 'LIKE', '%' . $request['departamento'] . '%');
            });
        }

        if ($request['municipio']) {
            $query->whereHas('afiliado.municipio_afiliacion', function ($q) use ($request) {
                $q->where('nombre', 'LIKE', '%' . $request['municipio'] . '%');
            });
        }

        return $query->paginate($request['per_page']);
    }
}
