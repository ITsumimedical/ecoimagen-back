<?php

namespace App\Http\Modules\Telesalud\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Telesalud\Models\Telesalud;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class TelesaludRepository extends RepositoryBase
{
    protected $telesaludModel;

    public function __construct()
    {
        $this->telesaludModel = new Telesalud();
        parent::__construct($this->telesaludModel);
    }

    /**
     * Funcion para Crear un registro de Telesalud
     * @param array $request
     * @return Telesalud
     * @author Thomas
     */
    public function crearTelesalud($request)
    {
        $telesalud = $this->telesaludModel->create([
            'tipo_estrategia_id' => $request['tipo_estrategia_id'],
            'tipo_solicitud_id' => $request['tipo_solicitud_id'],
            'especialidad_id' => $request['especialidad_id'],
            'motivo' => $request['motivo'],
            'resumen_hc' => $request['resumen_hc'],
            'cup_id' => $request['cup_id'],
            'afiliado_id' => $request['afiliado_id'],
            'funcionario_crea_id' => auth()->user()->id,
            'estado_id' => 10,
            'consulta_id' => $request['consulta_id'],
        ]);

        return $telesalud;
    }

    /**
     * Funcion para Listar Telesalud Pendientes, excluyendo Junta Aseguramiento y Junta Profesionales
     * @param array $request
     * @return LengthAwarePaginator
     * @author Thomas
     */
    public function listarPendientes($request)
    {
        $paginacion = $request['paginacion'];
        $filtros = $request['filtros'];

        $usuario = User::findOrFail(Auth::id());

        $especialidadesUsuario = $usuario->especialidades()->pluck('especialidades.id')->toArray();

        $telesalud = $this->telesaludModel->with(['afiliado.ips', 'especialidad', 'tipoEstrategia', 'tipoSolicitud', 'funcionarioCrea.operador'])
            ->where('estado_id', 10)
            ->whereIn('especialidad_id', $especialidadesUsuario)
            ->whereNotIn('tipo_estrategia_id', [1, 2])

            // Filtros
            ->when($filtros['tipo_solicitud_id'], function ($query) use ($filtros) {
                $query->where('tipo_solicitud_id', $filtros['tipo_solicitud_id']);
            })
            ->when($filtros['fecha_inicio'] && $filtros['fecha_fin'], function ($query) use ($filtros) {
                $query->whereBetween('created_at', [$filtros['fecha_inicio'], $filtros['fecha_fin']]);
            })
            ->when($filtros['ips_id'], function ($query) use ($filtros) {
                $query->whereHas('afiliado', function ($query) use ($filtros) {
                    $query->where('ips_id', $filtros['ips_id']);
                });
            })
            ->when($filtros['numero_documento'], function ($query) use ($filtros) {
                $query->whereHas('afiliado', function ($query) use ($filtros) {
                    $query->where('numero_documento', $filtros['numero_documento']);
                });
            })

            ->paginate($paginacion['cantidadRegistros'], ['*'], 'page', $paginacion['pagina']);

        return $telesalud;
    }

    /**
     * Funcion para Listar los detalles de una Telesalud
     * @param int $telesaludId
     * @return Telesalud
     * @author Thomas
     */
    public function listarDetallesTelesalud($telesaludId)
    {
        $telesalud = $this->telesaludModel->with(['afiliado.ips', 'afiliado.tipoDocumento', 'afiliado.entidad', 'afiliado.tipo_afiliacion', 'afiliado.tipo_afiliado', 'afiliado.departamento_atencion', 'afiliado.municipio_atencion', 'afiliado.EstadoAfiliado', 'afiliado.colegios', 'afiliado.medico.operador', 'afiliado.medico2.operador', 'especialidad', 'tipoEstrategia', 'tipoSolicitud', 'funcionarioCrea.operador', 'consulta.cie10Afiliado.cie10', 'gestiones.adjuntos', 'integrantes.operador', 'gestiones.institucionPrestadora', 'gestiones.eapb', 'gestiones.causas', 'gestiones.finalidad'])
            ->where('id', $telesaludId)
            ->first();

        return $telesalud;
    }

    /**
     * Retorna una telesalud por su id
     * @param int $telesaludId
     * @return Telesalud
     * @author Thomas
     */
    public function obtenerTelesaludPorId($telesaludId)
    {
        return $this->telesaludModel->findOrFail($telesaludId);
    }

    /**
     * Funcion para Listar Telesalud Solucionadas, excluyendo Junta Aseguramiento y Junta Profesionales
     * @param array $request
     * @return LengthAwarePaginator
     * @author Thomas
     */
    public function listarSolucionadas($request)
    {
        $paginacion = $request['paginacion'];
        $filtros = $request['filtros'];

        $usuario = User::findOrFail(Auth::id());

        $especialidadesUsuario = $usuario->especialidades()->pluck('especialidades.id')->toArray();

        $telesalud = $this->telesaludModel->select('*')->with(['afiliado.ips', 'especialidad', 'tipoEstrategia', 'tipoSolicitud', 'funcionarioCrea.operador'])
            ->where('estado_id', 9)
            // ->whereIn('especialidad_id', $especialidadesUsuario) Se deben listar todas las especialidades
            ->whereNotIn('tipo_estrategia_id', [1, 2])

            // Filtros
            ->when($filtros['tipo_solicitud_id'], function ($query) use ($filtros) {
                $query->where('tipo_solicitud_id', $filtros['tipo_solicitud_id']);
            })
            ->when($filtros['fecha_inicio'] && $filtros['fecha_fin'], function ($query) use ($filtros) {
                $query->whereBetween('created_at', [$filtros['fecha_inicio'], $filtros['fecha_fin']]);
            })
            ->when($filtros['ips_id'], function ($query) use ($filtros) {
                $query->whereHas('afiliado', function ($query) use ($filtros) {
                    $query->where('ips_id', $filtros['ips_id']);
                });
            })
            ->when($filtros['numero_documento'], function ($query) use ($filtros) {
                $query->whereHas('afiliado', function ($query) use ($filtros) {
                    $query->where('numero_documento', $filtros['numero_documento']);
                });
            })

            ->paginate($paginacion['cantidadRegistros'], ['*'], 'page', $paginacion['pagina']);

        return $telesalud;
    }

    /**
     * Funcion para Listar Telesalud Pendientes solo de Junta Profesionales
     * @param array $request
     * @return LengthAwarePaginator
     * @author Thomas
     */
    public function listarJuntaPendientes($request)
    {
        $paginacion = $request['paginacion'];
        $filtros = $request['filtros'];

        $usuario = User::findOrFail(Auth::id());

        $especialidadesUsuario = $usuario->especialidades()->pluck('especialidades.id')->toArray();

        $telesalud = $this->telesaludModel->with(['afiliado.ips', 'especialidad', 'tipoEstrategia', 'tipoSolicitud', 'funcionarioCrea.operador'])
            ->where('estado_id', 10)
            // ->whereIn('especialidad_id', $especialidadesUsuario) Se deben listar todas las especialidades
            ->whereIn('tipo_estrategia_id', [1, 2])

            // Filtros
            ->when($filtros['tipo_solicitud_id'], function ($query) use ($filtros) {
                $query->where('tipo_solicitud_id', $filtros['tipo_solicitud_id']);
            })
            ->when($filtros['fecha_inicio'] && $filtros['fecha_fin'], function ($query) use ($filtros) {
                $query->whereBetween('created_at', [$filtros['fecha_inicio'], $filtros['fecha_fin']]);
            })
            ->when($filtros['ips_id'], function ($query) use ($filtros) {
                $query->whereHas('afiliado', function ($query) use ($filtros) {
                    $query->where('ips_id', $filtros['ips_id']);
                });
            })
            ->when($filtros['numero_documento'], function ($query) use ($filtros) {
                $query->whereHas('afiliado', function ($query) use ($filtros) {
                    $query->where('numero_documento', $filtros['numero_documento']);
                });
            })

            ->paginate($paginacion['cantidadRegistros'], ['*'], 'page', $paginacion['pagina']);

        return $telesalud;
    }

    /**
     * Funcion para Listar Telesalud Pendientes solo de Junta Profesionales
     * @param array $request
     * @return LengthAwarePaginator
     * @author Thomas
     */
    public function listarJuntaSolucionadas($request)
    {
        $paginacion = $request['paginacion'];
        $filtros = $request['filtros'];

        $usuario = User::findOrFail(Auth::id());

        $especialidadesUsuario = $usuario->especialidades()->pluck('especialidades.id')->toArray();

        $telesalud = $this->telesaludModel->with(['afiliado.ips', 'especialidad', 'tipoEstrategia', 'tipoSolicitud', 'funcionarioCrea.operador', 'integrantes'])
            ->where('estado_id', operator: 9)
            // ->whereIn('especialidad_id', $especialidadesUsuario) Se deben listar todas las especialidades
            ->whereIn('tipo_estrategia_id', [1, 2])

            // Filtros
            ->when($filtros['tipo_solicitud_id'], function ($query) use ($filtros) {
                $query->where('tipo_solicitud_id', $filtros['tipo_solicitud_id']);
            })
            ->when($filtros['fecha_inicio'] && $filtros['fecha_fin'], function ($query) use ($filtros) {
                $query->whereBetween('created_at', [$filtros['fecha_inicio'], $filtros['fecha_fin']]);
            })
            ->when($filtros['ips_id'], function ($query) use ($filtros) {
                $query->whereHas('afiliado', function ($query) use ($filtros) {
                    $query->where('ips_id', $filtros['ips_id']);
                });
            })
            ->when($filtros['numero_documento'], function ($query) use ($filtros) {
                $query->whereHas('afiliado', function ($query) use ($filtros) {
                    $query->where('numero_documento', $filtros['numero_documento']);
                });
            })

            ->paginate($paginacion['cantidadRegistros'], ['*'], 'page', $paginacion['pagina']);

        return $telesalud;
    }

    public function formatoTelesalud($telesaludId)
    {
        $telesalud  = $this->telesaludModel->where('id', $telesaludId)
            ->with([
                'afiliado.tipoDocumento',
                'afiliado.ips',
                'tipoEstrategia',
                'especialidad',
                'servicio',
                'integrantes',
                'consulta.cie10Afiliado.cie10',
                'gestiones' => function ($query) {
                    $query->where('tipo_id', 47)->with('funcionarioGestiona.operador')->limit(1);
                }
            ])
            ->first();

        return $telesalud;
    }
}
