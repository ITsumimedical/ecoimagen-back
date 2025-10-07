<?php

namespace App\Http\Modules\Facturacion;

use App\Events\FacturaCreadaEvent;
use App\Http\Modules\Facturacion\Factura;
use App\Http\Services\CodePymeService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class FacturaService
{
    public function __construct(
        public FacturaDetalleService $facturaDetalleService,
    ) {}

    /**
     * lista las facturas
     * @return Collection
     * @author David Pelaez
     */
    public function listar(): Collection
    {
        return Factura::all('id', 'unique', 'numero', 'fecha', 'total', 'multiusuario', 'emitida');
    }

    /**
     * lista las facturas
     * @return Factura
     * @author David Pelaez
     */
    public function crear(array $data)
    {
        # consultamos el cliente
        $cliente = FacturaCliente::findOrFail(1); // en principio solo habra un cliente
        try {
            DB::beginTransaction();
            # buscamos la resolucion
            $resolucion = FacturaResolucion::lockForUpdate()->find(1);
            # creamos la cabecera de la factura
            $facturaData = [
                'resolucion_id' => $resolucion->id,
                'cliente_id' => $cliente->id,
                'numero' => $resolucion->prefijo . $resolucion->actual,
                'consecutivo' => $resolucion->actual,
                'nota' => $data['nota'] ?? null,
                'subtotal' => $data['subtotal'],
                'total' => $data['total'],
                'multiusuario' => $data['multiusuario'] ?? false,
                'fecha' => $data['fecha'] ?? now(),
                'created_by' => auth()->id(),
            ];
            $factura = Factura::create($facturaData);
            # incrementamos el consecutivo de la resolucion
            $resolucion->increment('actual');
            $factura = $this->facturaDetalleService->crear($factura, $data['detalles']);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
        event(new FacturaCreadaEvent($factura));
        return $factura;
    }

    /**
     * actualiza una factura
     * @param Factura|int $factura
     * @param array $data
     * @return Factura
     * @author David Pelaez
     */
    public function actualizar(Factura|int $factura, array $data): Factura
    {
        if (is_int($factura)) {
            $factura = Factura::findOrFail($factura);
        }
        $factura->update($data);
        return $factura;
    }

    /**
     * consulta una factura
     * @param string $unique
     * @return Factura
     */
    public function consultar(string $unique)
    {
        return Cache::remember('facturas:' . $unique, Carbon::now()->addDay(),function () use ($unique) {
            return Factura::where('unique', $unique)->with(['cliente', 'resolucion', 'detalles'])->firstOrFail();
        });
    }

    /**
     * genera un soporte de facturacion
     * @param int|string|Factura $factura
     * @return string
     * @author David Pelaez
     */
    public function generarSoporte(int|string|Factura $factura): string {
        if (is_int($factura)) {
            $factura = Factura::findOrFail($factura);
        } elseif (is_string($factura)) {
            $factura = $this->consultar($factura);
        }

        try {
            # generamos una carpera nueva
            $carpetaPath = storage_path('app/tmp/' . $factura->numero);
            # verificamos que la carpeta no exista y luego la creamos
            if(!file_exists($carpetaPath)){
                mkdir($carpetaPath);
            }



        } catch (\Throwable $th) {
            dd($th);
        }

        return ';';
    }
}
