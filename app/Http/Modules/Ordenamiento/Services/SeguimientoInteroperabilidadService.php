<?php

namespace App\Http\Modules\Ordenamiento\Services;

use App\Http\Modules\Cie10Afiliado\Models\Cie10Afiliado;
use App\Http\Modules\Ordenamiento\Models\SeguimientoEnvioOrden;

class SeguimientoInteroperabilidadService
{

    public function __construct() {}

    /**
     * lista los logs de la interoperabilidad
     * @param array $data
     * @return Collection
     * @author David Peláez
     */
    public function listar(array $data)
    {
        return SeguimientoEnvioOrden::orderBy('created_at', 'desc')
            ->with([
                'orden:id,consulta_id',
                'orden.consulta:id,afiliado_id',
                'orden.consulta.afiliado:id,numero_documento,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido',
                'user.operador'
            ])
            ->whereFiltro($data['filtro'])
            ->whereEstado($data['estado'])
            ->paginate(10);
    }

    /**
     * asignar diagnostico a una consulta
     * @param array $data
     * @return Consulta
     * @author David Peláez
     */
    public function asignarDiagnostico(array $data){
        return Cie10Afiliado::create($data);
    }
}
