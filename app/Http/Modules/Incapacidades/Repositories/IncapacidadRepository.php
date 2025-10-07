<?php

namespace App\Http\Modules\Incapacidades\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Incapacidades\Models\Incapacidade;

class IncapacidadRepository extends RepositoryBase
{
    private $incapacidadModel;

    public function __construct()
    {
        $this->incapacidadModel = new Incapacidade();
        parent::__construct($this->incapacidadModel);
    }


    public function historico($request)
    {
        $pagina = $request->input('pagina', 1);
        $cantidad = $request->input('cantidad', 10);

        $query = Incapacidade::select(
            'incapacidades.id',
            'incapacidades.contingencia',
            'incapacidades.fecha_inicio',
            'incapacidades.dias',
            'incapacidades.fecha_final',
            'incapacidades.prorroga',
            'incapacidades.descripcion_incapacidad',
            'cie10s.nombre as cie10',
            'colegios.nombre as colegio',
            'afiliados.numero_documento',
            'afiliados.edad_cumplida',
            'estados.nombre as estado',
            'consultas.id as consulta_id',
        )
            ->selectRaw("CONCAT(
            COALESCE(afiliados.primer_nombre, ''), ' ',
            COALESCE(afiliados.primer_apellido, ''), ' ',
            COALESCE(afiliados.segundo_nombre, ''), ' ',
            COALESCE(afiliados.segundo_apellido, '')
        ) as afiliado")
            // ->selectRaw("CONCAT(empleados.primer_nombre,' ',empleados.primer_apellido,' ',empleados.segundo_nombre,' ',empleados.segundo_apellido) as realizado_por")
            ->join('consultas', 'incapacidades.consulta_id', '=', 'consultas.id')
            ->leftJoin('cie10s', 'incapacidades.diagnostico_id', '=', 'cie10s.id')
            ->leftJoin('colegios', 'incapacidades.colegio_id', '=', 'colegios.id')
            ->leftJoin('users', 'incapacidades.usuario_realiza_id', '=', 'users.id')
            ->leftJoin('operadores', 'operadores.user_id', '=', 'users.id')
            ->selectRaw("CONCAT(
            COALESCE(operadores.nombre, ''), ' ',
            COALESCE(operadores.apellido, '')
        ) as operadorNombre")
            ->join('afiliados', 'consultas.afiliado_id', '=', 'afiliados.id')
            ->join('estados', 'incapacidades.estado_id', '=', 'estados.id')
            ->orderBy('incapacidades.id', 'asc')
            ->where('afiliados.numero_documento', $request->input('documento'))
            ->with('cambioOrden.user.operador');

        return $query->paginate($cantidad, ['*'], 'pagina', $pagina);
    }

    public function ordenesIncapacidadAfiliado($request)
    {
        $usuarioLoggeado = auth()->user()->id;
        $afiliadoId = Afiliado::where('user_id', $usuarioLoggeado)->first()->id;

        $incapacidades = Incapacidade::with(['estado','colegio'])
            ->where('estado_id', 1)
            ->whereHas('consulta', function ($query) use ($afiliadoId) {
                $query->where('afiliado_id', $afiliadoId);
            })

            ->when($request['numeroOrden'], function ($query) use ($request) {
                $query->where('id', $request['numeroOrden']);
            })

            ->orderBy('created_at', 'desc');

        return $incapacidades->paginate($request['cant']);
    }

    public function formatoIncapacidad($request)
    {
        $incapacidad = $this->incapacidadModel->with(['consulta', 'users', 'cie10', 'colegio'])->where('id', $request->incapacidad_id)->first();

        $entidad = $incapacidad->consulta->afiliado->entidad_id;

        return (object)[
            'incapacidad' => $incapacidad,
            'entidad' => $entidad,
        ];
    }

}
