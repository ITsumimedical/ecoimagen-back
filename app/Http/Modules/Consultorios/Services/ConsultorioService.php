<?php

namespace App\Http\Modules\Consultorios\Services;

use App\Http\Modules\Consultorios\Models\Consultorio;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ConsultorioService
{
    protected Consultorio $consultorioModel;

    public function __construct(Consultorio $consultorioModel)
    {
        $this->consultorioModel = $consultorioModel;
    }

    public function consultorios(array $filtros): Collection|LengthAwarePaginator
    {
        try {
            $consulta = $this->consultorioModel->select([
                    'consultorios.id',
                    'consultorios.nombre',
                    'consultorios.cantidad_paciente',
                    'consultorios.rep_id',
                    'reps.id as repsId',
                    'reps.nombre as nombreReps',
                    'estados.id as estadoId',
                    'estados.nombre as nombreEstado'
                ])
                ->join('reps', 'consultorios.rep_id', '=', 'reps.id')
                ->join('estados', 'consultorios.estado_id', '=', 'estados.id')
                ->orderBy('consultorios.id', 'asc');

            if (!empty($filtros['nombre'])) {
                $consulta->where('consultorios.nombre', 'ILIKE', "%{$filtros['nombre']}%");
            }

            if (!empty($filtros['nombre_reps'])) {
                $consulta->where('reps.nombre', 'ILIKE', "%{$filtros['nombre_reps']}%");
            }

            return !empty($filtros['page']) && $filtros['page']
                ? $consulta->paginate((int) ($filtros['cant'] ?? 15))
                : $consulta->get();

        } catch (\Throwable $e) {
            throw new \Exception('Error al consultar los consultorios: ' . $e->getMessage());
        }
    }
}
