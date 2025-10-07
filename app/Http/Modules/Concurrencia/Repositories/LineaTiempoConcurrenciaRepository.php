<?php

namespace App\Http\Modules\Concurrencia\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Concurrencia\Models\CambiosConcurrencias;
use App\Http\Modules\Concurrencia\Models\Concurrencia;

class LineaTiempoConcurrenciaRepository extends RepositoryBase {

    public function __construct(protected Concurrencia $concurrenciaModel) {
        parent::__construct($this->concurrenciaModel);
    }

    public function listarLinea($request)
    {
        $concurrencia = $this->concurrenciaModel->select('ingreso_concurrencia_id')
            ->where('id', $request->concurrencia_id)
            ->first();

        $consulta = $this->concurrenciaModel->with([
                'dxEgreso',
                'cie10',
                'user.operador',
                'ingresoConcurrencia' => function($query) {
                    $query->with([
                        'afiliado',
                        'rep',
                        'especialidad',
                        'cie10',
                        'ordenConcurrencias' => function($query) {
                            $query->with([
                                'user.operador',
                                'cup'
                            ]);
                        },
                        'evento.user.operador',
                        'costoEvitado.user.operador',
                        'costoEvitable.user.operador',
                        'user.operador'
                    ]);
                },
                'seguimientos' => function($query) {
                    $query->with([
                        'usuarioCrea.operador',
                        'usuarioDss.operador',
                        'usuarioAac.operador'
                    ]);
                }
            ])
            ->where('concurrencias.id', $request->concurrencia_id)
            ->first();

        $cambiosConcurrenciaConcurrenciaId = CambiosConcurrencias::where('concurrencia_id', $request->concurrencia_id)
            ->with('user.operador')
            ->get();

        $cambiosConcurrenciaIngresoId = CambiosConcurrencias::where('ingreso_concurrencia_id', $concurrencia->ingreso_concurrencia_id)
            ->with('user.operador')
            ->get();

        $todosLosCambiosConcurrencias = $cambiosConcurrenciaConcurrenciaId->merge($cambiosConcurrenciaIngresoId);

        $consulta->setRelation('cambiosConcurrencias', $todosLosCambiosConcurrencias);

        return $consulta;
    }


}
