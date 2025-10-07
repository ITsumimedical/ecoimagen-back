<?php

namespace App\Http\Modules\CobroFacturas\Services;

use App\Http\Modules\CobroFacturas\Models\CobroFacturas;
use Illuminate\Pagination\LengthAwarePaginator;

class CobroFacturasService
{

    public function __construct(
    ) {}

    /**
     * Lista el histórico de recibos de caja por el tipo y número de documento del afiliado
     * @param int $tipoDocumentoId
     * @param string $numeroDocumento
     * @param array $data
     * @return LengthAwarePaginator
     * @author kobatime
     */
    public function listarHistorico(int $tipoDocumentoId, string $numeroDocumento, array $data): LengthAwarePaginator
    {
        return CobroFacturas::select('cobro_facturas.id','valor',
        'medio_pago',
        'user_cobro_id',
        'cobro_facturas.afiliado_id',
        'cobro_facturas.created_at', 
        'operadores.nombre as operador_nombre', 
        'operadores.apellido as operador_apellido'
        
        )
        ->join('operadores','operadores.user_id','cobro_facturas.user_cobro_id')
        ->with('afiliado')
        ->whereHas('afiliado', function ($query) use ($tipoDocumentoId, $numeroDocumento) {
                $query
                    ->where('tipo_documento', $tipoDocumentoId)
                    ->where('numero_documento', $numeroDocumento);
            })
            ->paginate($data['cantidadRegistros'], ['*'], 'page', $data['pagina']);
    }
}
