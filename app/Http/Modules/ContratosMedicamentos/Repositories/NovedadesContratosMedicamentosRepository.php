<?php

namespace App\Http\Modules\ContratosMedicamentos\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\ContratosMedicamentos\Models\NovedadesContratosMedicamentos;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class NovedadesContratosMedicamentosRepository extends RepositoryBase
{
    protected NovedadesContratosMedicamentos $novedadesContratosMedicamentosModel;

    public function __construct()
    {
        $this->novedadesContratosMedicamentosModel = new NovedadesContratosMedicamentos();
        parent::__construct($this->novedadesContratosMedicamentosModel);
    }

    /**
     * Lista las novedades de un contrato
     * @param array $request
     * @return LengthAwarePaginator
     * @author Thomas
     */
    public function listarNovedadesContrato(array $request): LengthAwarePaginator
    {
        $contratoId = $request['contrato'];
        return $this->novedadesContratosMedicamentosModel
            ->where('contrato_medicamentos_id', $contratoId)
            ->with(['adjuntos', 'tipo', 'user.operador'])
            ->paginate($request['cantidadRegistros'], ['*'], 'page', $request['pagina']);
    }

    public function listarAdjuntosNovedad(int $novedadId): Collection
    {
       $novedad = $this->novedadesContratosMedicamentosModel->findOrFail($novedadId);

       return $novedad->adjuntos;
    }
}
