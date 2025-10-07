<?php

namespace App\Http\Modules\Facturacion;

class FacturaDetalleService
{
    /**
     * almacena los detalles de una factura
     * @param Factura|int $factura
     * @param array $detalles
     * @return Factura
     * @author David Pelaez
     */
    public function crear(Factura|int $factura, array $detalles): Factura
    {
        if (is_int($factura)) {
            $factura = Factura::findOrFail($factura);
        }
        # verificamos si es multiusuario
        if ($factura->multiusuario) {
            foreach ($detalles as &$detalle) {
                $items = $detalle['items'] ?? [];
                unset($detalle['items']);
                $detalleCreado = $factura->detalles()->create($detalle);
                # asignamos el detalle al registro de facturacion
                FacturaDetalleItem::whereIn('id', $items)->update([
                    'factura_detalle_id' => $detalleCreado->id,
                    'estado' => true
                ]);
            }
        } else {
            foreach ($detalles as &$detalle) {
                $item = $detalle['id'];
                unset($detalle['id']);
                $detalleCreado = $factura->detalles()->create($detalle);
                # asignamos el detalle al registro de facturacion
                FacturaDetalleItem::where('id', $item)->update([
                    'factura_detalle_id' => $detalleCreado->id,
                    'estado' => true
                ]);
            }
        }
        return $factura;
    }
}
