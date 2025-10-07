<?php

namespace App\Http\Modules\Facturacion;

class FacturaDetalleItemRepository
{

    /**
     * lista los registros de cups y medicamentos
     * @param array $filters
     * @author David Pelaez
     */
    public function listar(array $filters = [])
    {
        return FacturaDetalleItem::select([
            'registrofacturasumimedicals.id',
            'registrofacturasumimedicals.sede_atencion_id',
            'registrofacturasumimedicals.afiliado_id',
            'registrofacturasumimedicals.consulta_id',
            'registrofacturasumimedicals.codigo_empresa',
            'registrofacturasumimedicals.codigo_clasificacion',
            'registrofacturasumimedicals.fecha_ingreso',
            'registrofacturasumimedicals.hora_ingreso',
            'registrofacturasumimedicals.medico_atiende_id',
            'registrofacturasumimedicals.contrato',
            'registrofacturasumimedicals.codigo_diagnostico',
            'registrofacturasumimedicals.codigo_cup',
            'registrofacturasumimedicals.descripcion_cup',
            'registrofacturasumimedicals.cantidad_cup',
            'registrofacturasumimedicals.valor_cup',
            'registrofacturasumimedicals.estado',
            'registrofacturasumimedicals.factura_detalle_id',
            'reps.nombre as sede_atencion',
            'afiliados.numero_documento',
            'operadores.nombre as medico_atiende',
            'facturas.numero as factura_numero',
            'facturas.unique as factura_unique',
        ])
            ->leftjoin('factura_detalles', 'registrofacturasumimedicals.factura_detalle_id', 'factura_detalles.id')
            ->leftjoin('facturas', 'factura_detalles.factura_id', 'facturas.id')
            ->leftjoin('reps', 'registrofacturasumimedicals.sede_atencion_id', 'reps.id')
            ->join('afiliados', 'registrofacturasumimedicals.afiliado_id', 'afiliados.id')
            ->leftjoin('operadores', 'registrofacturasumimedicals.medico_atiende_id', 'operadores.user_id')
            ->whereEstado($filters['estado'] ?? null)
            ->whereFechaInicio($filters['fecha_inicio'] ?? '')
            ->whereFechaFin($filters['fecha_fin'] ?? '')
            ->whereDocumento($filters['documento'] ?? '')
            ->whereCup($filters['cup'] ?? '')
            ->orderBy('registrofacturasumimedicals.fecha_ingreso', 'desc')
            ->get();
    }
}
