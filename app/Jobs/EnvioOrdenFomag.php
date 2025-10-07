<?php

namespace App\Jobs;

use App\Exceptions\NoDetallesFueraDeCapitaException;
use App\Http\Modules\Ordenamiento\Models\Orden;
use App\Http\Modules\Ordenamiento\Models\SeguimientoEnvioOrden;
use App\Http\Modules\Ordenamiento\Services\OrdenInteroperabilidadService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class EnvioOrdenFomag implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $orden;
    private $user_id;

    /**
     * Create a new job instance.
     */
    public function __construct(Orden|int $orden, int $user_id)
    {
        if (!$orden instanceof Orden) {
            $orden = Orden::where('id', $orden)->firstOrFail();
        }

        $this->orden = $orden;
        $this->user_id = $user_id;
    }

    /**
     * Execute the job.
     */
    public function handle(OrdenInteroperabilidadService $ordenInteroperabilidadService): void
    {
        try {
            $response = $ordenInteroperabilidadService->enviar($this->orden);
            $detalles = [];
            #creamos un array con los detalles de la respuesta
            $detalles = array_merge(
                $this->mapDetalles($response['noCapitadosNiPGP'], 'Enviado correctamente.', true),
                $this->mapDetalles($response['capitadosOPGP'], 'procedimiento capitados o por pgp.')
            );

            $this->orden->update([
                'enviado' => true
            ]);

            SeguimientoEnvioOrden::create([
                'orden_id' => $this->orden->id,
                'descripcion' => 'Enviado Correctamente',
                'code' => 200,
                'user_id' => $this->user_id,
                'detalles' => $detalles
            ]);
        } catch (NoDetallesFueraDeCapitaException $e) {
            SeguimientoEnvioOrden::create([
                'orden_id' => $this->orden->id,
                'descripcion' => $e->getMessage(),
                'code' => $e->getCode(),
                'user_id' => $this->user_id,
                'estado' => false,
                'detalles' => $this->mapDetalles($e->getDatos(), 'procedimiento capitados o por pgp.'),
            ]);
        } catch (\Throwable $th) {
            $descripcion = $th->getMessage();
            $codigo = $th->getCode();

            if ($codigo === 0) {
                $descripcion = 'Saturación del software';
                $codigo = 500;
            }

            SeguimientoEnvioOrden::create([
                'orden_id' => $this->orden->id,
                'descripcion' => $descripcion,
                'code' => $codigo,
                'estado' => false,
                'user_id' => $this->user_id,
            ]);
        }
    }

    private function mapDetalles(array $datos, string $observacion, bool $estado = false): array
    {
        return array_map(fn($detalle) => [
            'procedimiento_id' => $detalle['interoperabilidad_id'],
            'cup_codigo' => $detalle['cup_codigo'],
            'observacion' => $observacion,
            'estado' => $estado,
        ], $datos);
    }
}
