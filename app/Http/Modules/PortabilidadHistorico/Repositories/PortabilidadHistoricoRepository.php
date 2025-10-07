<?php

namespace App\Http\Modules\PortabilidadHistorico\Repositories;

use Illuminate\Support\Facades\DB;
use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\NovedadesAfiliados\Models\novedadAfiliado;
use App\Http\Modules\PortabilidadSalida\Models\portabilidadSalida;
use App\Http\Modules\PortabilidadEntrada\Models\portabilidadEntrada;
use Illuminate\Http\Request;

class PortabilidadHistoricoRepository extends RepositoryBase
{
    protected $novedadAfiliado;

    public function __construct(novedadAfiliado $novedadAfiliado)
    {
        $this->novedadAfiliado = $novedadAfiliado;
    }

    public function listarHistorico(Request $request)
    {
        $cantidad = $request->get('cantidad', 10);

        $historico = novedadAfiliado::select(
            'novedad_afiliados.id',
            'novedad_afiliados.portabilidad_salida_id',
            'novedad_afiliados.portabilidad_entrada_id',
            'novedad_afiliados.tipo_novedad_afiliados_id',
            'novedad_afiliados.fecha_novedad',
            'novedad_afiliados.motivo',
            'tipo_novedad_afiliados.nombre as tipo_novedad',
            'tipo_documentos.nombre as tipo_documento',
            'afiliados.numero_documento',
            'afiliados.sexo',
            'afiliados.edad_cumplida',
            'afiliados.fecha_nacimiento',
            'afiliados.estado_afiliacion_id',
            'afiliados.region',
            'entidades.nombre as entidad',
            'reps.nombre as IpsPrimaria',
            'estados.nombre as estado_afiliacion',
            'departamentos1.nombre as departamentoAfiliacion',
            'departamentos1.codigo_dane as DaneDepartamento',
            'municipios1.nombre as municipioAfiliacion',
            'municipios1.codigo_dane as DaneMunicipio',
            'portabilidad_salidas.fecha_inicio as fecha_ps',
            'portabilidad_entradas.fecha_inicio as fecha_pe',
            'portabilidad_salidas.cantidad',
            'portabilidad_entradas.cantidad_dias',
            'portabilidad_salidas.fecha_final as fecha_final_ps',
            'portabilidad_entradas.fecha_final as fecha_final_pe',
            'portabilidad_salidas.destino_ips',
            'portabilidad_entradas.origen_ips',
            'departamentos2.nombre as departamentoReceptor',
            'municipios2.nombre as municipioReceptor',
            'portabilidad_entradas.telefono_ips',
            'portabilidad_entradas.correo_ips',
            DB::raw("CONCAT(afiliados.primer_nombre,' ',afiliados.segundo_nombre,' ',afiliados.primer_apellido,' ',afiliados.segundo_apellido) as nombre_completo"),
            DB::raw("CONCAT(empleados.primer_nombre,' ',empleados.segundo_nombre,' ',empleados.primer_apellido,' ',empleados.segundo_apellido) as nombre_empleado")
        )
            ->with([
                'portabilidadSalida' => function ($query) {
                    $query->with(['novedadAfiliado' => function ($query) {
                        $query->whereIn('tipo_novedad_afiliados_id', [5, 8])->latest();
                    }]);
                },
                'portabilidadEntrada' => function ($query) {
                    $query->with(['novedadAfiliado' => function ($query) {
                        $query->whereIn('tipo_novedad_afiliados_id', [5, 8])->latest();
                    }]);
                }
            ])
            ->leftJoin('portabilidad_salidas', 'novedad_afiliados.portabilidad_salida_id', 'portabilidad_salidas.id')
            ->leftJoin('portabilidad_entradas', 'novedad_afiliados.portabilidad_entrada_id', 'portabilidad_entradas.id')
            ->leftJoin('afiliados', 'novedad_afiliados.afiliado_id', 'afiliados.id')
            ->leftJoin('empleados', 'novedad_afiliados.user_id', 'empleados.id')
            ->leftJoin('tipo_novedad_afiliados', 'novedad_afiliados.tipo_novedad_afiliados_id', 'tipo_novedad_afiliados.id')
            ->leftJoin('tipo_documentos', 'afiliados.tipo_documento', 'tipo_documentos.id')
            ->join('estados', 'afiliados.estado_afiliacion_id', 'estados.id')
            ->join('entidades', 'afiliados.entidad_id', 'entidades.id')
            ->join('reps', 'afiliados.ips_id', 'reps.id')
            ->leftjoin('municipios as municipios1', 'afiliados.municipio_afiliacion_id', 'municipios1.id')
            ->leftjoin('departamentos as departamentos1', 'municipios1.departamento_id', 'departamentos1.id')
            ->leftjoin('municipios as municipios2', 'portabilidad_salidas.municipio_receptor', 'municipios2.id')
            ->leftjoin('departamentos as departamentos2', 'municipios2.departamento_id', 'departamentos2.id')
            ->whereIn('novedad_afiliados.tipo_novedad_afiliados_id', [5, 8])
            ->orderBy('novedad_afiliados.created_at', 'desc');

            if ($request->numero_documento) {
                $historico->where('afiliados.numero_documento', 'ILIKE', '%' . $request->numero_documento . '%');
            }

            if ($request->nombre_completo) {
                $historico->orwhere('afiliados.primer_nombre', 'ILIKE', '%' . $request->nombre_completo . '%');
                $historico->orwhere('afiliados.segundo_nombre', 'ILIKE', '%' . $request->nombre_completo . '%');
                $historico->orwhere('afiliados.primer_apellido', 'ILIKE', '%' . $request->nombre_completo . '%');
                $historico->orwhere('afiliados.segundo_apellido', 'ILIKE', '%' . $request->nombre_completo . '%');
            }

            if ($request->fecha_desde && $request->fecha_hasta) {
                $historico->whereBetween('novedad_afiliados.fecha_novedad', [$request->fecha_desde, $request->fecha_hasta]);
            }

            if ($request->has('page')) {
                return $historico->paginate($cantidad);
            } else {
                return $historico->first();
            }
        }
    }

