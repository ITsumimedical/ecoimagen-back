<?php

namespace App\Http\Modules\ResultadoAyudasDiagnosticos\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\ResultadoAyudasDiagnosticos\Model\ResultadoAyudasDiagnosticas;

class  ResultadoAyudasDiagnosticasRepository extends RepositoryBase
{
    public function __construct(protected ResultadoAyudasDiagnosticas $resultadoAyudasDiagnosticas)
    {
        parent::__construct($this->resultadoAyudasDiagnosticas);
    }

    public function listarAyudasDiagnosticasAfiliado($afiliado_id)
    {
        return $this->resultadoAyudasDiagnosticas::with(['cups:id,nombre', 'user.operador:id,nombre,apellido,user_id', 'adjuntos'])
            ->whereHas('consulta', function ($query) use ($afiliado_id) {
                $query->where('afiliado_id', $afiliado_id);
            })
            ->orderBy('id','desc')
            ->get();
    }

    public function eliminarAyudaDiagnostica($id)
    {
        $resultado = $this->resultadoAyudasDiagnosticas->findOrFail($id);
        return $resultado->delete();
    }

    public function historiaClinicaMedicinaGeneral($afiliadoId)
    {
        $ayudasDiagnosticas = $this->resultadoAyudasDiagnosticas->with(['cups:id,nombre', 'user.operador:id,nombre,apellido,user_id'])
            ->whereHas('consulta', function ($query) use ($afiliadoId) {
                $query->where('afiliado_id', $afiliadoId);
            })
            ->orderBy('id', 'desc')
            ->get();

        return $ayudasDiagnosticas;
    }
}
