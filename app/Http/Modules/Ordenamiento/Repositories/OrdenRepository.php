<?php

namespace App\Http\Modules\Ordenamiento\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Ordenamiento\Models\Orden;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class OrdenRepository extends RepositoryBase
{
    protected Orden $ordenModel;

    public function __construct()
    {
        $this->ordenModel = new Orden();
        parent::__construct($this->ordenModel);
    }

    /**
     * Lista las órdenes de servicios por auditar
     * @param array $data
     * @return LengthAwarePaginator
     * @author Thomas
     */
    public function listarOrdenesServiciosPorAuditar(array $data): LengthAwarePaginator
    {
        $filtros = $data['filtros'];
        $paginacion = $data['paginacion'];

        return $this->ordenModel
            ->where(function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('tipo_orden_id', 2)
                        ->whereHas('procedimientos', function ($q) {
                            $q->where('estado_id', 3);
                        });
                })->orWhere(function ($subQuery) {
                    $subQuery->where('tipo_orden_id', 3)
                        ->whereHas('ordenesCodigoPropio', function ($q) {
                            $q->where('estado_id', 3);
                        });
                });
            })
            ->with([
                'consulta' => function ($query) {
                    $query->select('id', 'afiliado_id');
                },
                'consulta.afiliado' => function ($query) {
                    $query->select('id', 'numero_documento', 'primer_nombre', 'segundo_nombre', 'primer_apellido', 'segundo_apellido', 'ips_id', 'departamento_atencion_id');
                },
                'consulta.afiliado.ips' => function ($query) {
                    $query->select('id', 'nombre');
                },
                'consulta.afiliado.departamento_atencion' => function ($query) {
                    $query->select('id', 'nombre');
                },
                'funcionario.operador'
            ])
            ->when($filtros['orden_id'], function ($query) use ($filtros) {
                $query->where('id', $filtros['orden_id']);
            })
            ->when($filtros['numero_documento'], function ($query) use ($filtros) {
                $query->whereHas('consulta.afiliado', function ($query) use ($filtros) {
                    $query->where('numero_documento', $filtros['numero_documento']);
                });
            })
            ->when($filtros['ips_id'], function ($query) use ($filtros) {
                $query->whereHas('consulta.afiliado.ips', function ($query) use ($filtros) {
                    $query->where('id', $filtros['ips_id']);
                });
            })
            ->when($filtros['departamento_id'], function ($query) use ($filtros) {
                $query->whereHas('consulta.afiliado.departamento_atencion', function ($query) use ($filtros) {
                    $query->where('id', $filtros['departamento_id']);
                });
            })
            ->whereBetween('created_at', [$filtros['fecha_inicial'], $filtros['fecha_final']])
            ->paginate($paginacion['cantidadRegistros'], ['*'], 'page', $paginacion['pagina']);
    }

    public function listarOrdenesCodigosPropiosPorAuditar(array $data): LengthAwarePaginator
    {
        $filtros = $data['filtros'];
        $paginacion = $data['paginacion'];

        return $this->ordenModel
            ->where('tipo_orden_id', 3)
            ->whereHas('ordenesCodigoPropio', function ($query) {
                $query->where('estado_id', 3);
            })
            ->with([
                'consulta' => function ($query) {
                    $query->select('id', 'afiliado_id');
                },
                'consulta.afiliado' => function ($query) {
                    $query->select('id', 'numero_documento', 'primer_nombre', 'segundo_nombre', 'primer_apellido', 'segundo_apellido', 'ips_id', 'departamento_atencion_id');
                },
                'consulta.afiliado.ips' => function ($query) {
                    $query->select('id', 'nombre');
                },
                'consulta.afiliado.departamento_atencion' => function ($query) {
                    $query->select('id', 'nombre');
                },
                'funcionario.operador'
            ])
            ->when($filtros['orden_id'], function ($query) use ($filtros) {
                $query->where('id', $filtros['orden_id']);
            })
            ->when($filtros['numero_documento'], function ($query) use ($filtros) {
                $query->whereHas('consulta.afiliado', function ($query) use ($filtros) {
                    $query->where('numero_documento', $filtros['numero_documento']);
                });
            })
            ->when($filtros['ips_id'], function ($query) use ($filtros) {
                $query->whereHas('consulta.afiliado.ips', function ($query) use ($filtros) {
                    $query->where('id', $filtros['ips_id']);
                });
            })
            ->when($filtros['departamento_id'], function ($query) use ($filtros) {
                $query->whereHas('consulta.afiliado.departamento_atencion', function ($query) use ($filtros) {
                    $query->where('id', $filtros['departamento_id']);
                });
            })->whereBetween('created_at', [$filtros['fecha_inicial'], $filtros['fecha_final']])
            ->paginate($paginacion['cantidadRegistros'], ['*'], 'page', $paginacion['pagina']);
    }

    /**
     * Lista las órdenes de medicamentos por auditar
     * @param array $data
     * @return LengthAwarePaginator
     * @author Thomas
     */
    public function listarOrdenesMedicamentosPorAuditar(array $data): LengthAwarePaginator
    {
        $filtros = $data['filtros'];
        $paginacion = $data['paginacion'];

        return $this->ordenModel
            ->where('tipo_orden_id', 1)
            ->whereHas('articulos', function ($query) {
                $query->where('estado_id', 3);
            })
            ->with([
                'consulta' => function ($query) {
                    $query->select('id', 'afiliado_id');
                },
                'consulta.afiliado' => function ($query) {
                    $query->select('id', 'numero_documento', 'primer_nombre', 'segundo_nombre', 'primer_apellido', 'segundo_apellido', 'ips_id', 'departamento_atencion_id');
                },
                'consulta.afiliado.ips' => function ($query) {
                    $query->select('id', 'nombre');
                },
                'consulta.afiliado.departamento_atencion' => function ($query) {
                    $query->select('id', 'nombre');
                },
                'funcionario.operador'
            ])
            ->when($filtros['orden_id'], function ($query) use ($filtros) {
                $query->where('id', $filtros['orden_id']);
            })
            ->when($filtros['numero_documento'], function ($query) use ($filtros) {
                $query->whereHas('consulta.afiliado', function ($query) use ($filtros) {
                    $query->where('numero_documento', $filtros['numero_documento']);
                });
            })
            ->when($filtros['ips_id'], function ($query) use ($filtros) {
                $query->whereHas('consulta.afiliado.ips', function ($query) use ($filtros) {
                    $query->where('id', $filtros['ips_id']);
                });
            })
            ->when($filtros['departamento_id'], function ($query) use ($filtros) {
                $query->whereHas('consulta.afiliado.departamento_atencion', function ($query) use ($filtros) {
                    $query->where('id', $filtros['departamento_id']);
                });
            })->whereBetween('created_at', [$filtros['fecha_inicial'], $filtros['fecha_final']])
            ->paginate($paginacion['cantidadRegistros'], ['*'], 'page', $paginacion['pagina']);
    }

    /**
     * Busca una Orden por su ID de interoperabilidad
     * @param int $ordenInteroperabilidadId
     * @return Orden|null
     * @author Thomas
     */
    public function buscarOrdenInteroperabilidadId(int $ordenInteroperabilidadId): ?Orden
    {
        return $this->ordenModel->where('orden_id_interoperabilidad', $ordenInteroperabilidadId)->first();
    }

}
