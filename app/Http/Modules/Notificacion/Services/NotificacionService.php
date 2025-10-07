<?php

namespace App\Http\Modules\Notificacion\Services;

use App\Http\Modules\Notificacion\Repositories\NotificacionRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Redis;

class NotificacionService
{
    public function __construct(protected NotificacionRepository $notificacionRepository)
    {
    }

    /**
     * Lista las notificaciones del usuario que estan en el websocket redis o en la base de datos
     * @param int $usuarioId
     * @return array
     * @author jose vasquez 
     */
    public function listarNotificaciones(int $usuarioId): array
    {
        $key = 'usuario.' . $usuarioId;
        $items = Redis::lrange($key, 0, -1);
        $redis = array_map(fn($item) => json_decode($item, true), $items);
        $notificacionesGuardadas = $this->notificacionRepository->listarNotificacionesUsuario($usuarioId);

        if ($notificacionesGuardadas) {
            $this->validarTiempoExpiracion($usuarioId, $notificacionesGuardadas);
        }

        $mapeo = $notificacionesGuardadas->map(function ($n) {
            $json = json_decode($n->notificacion, true);

            return [
                'id' => $json['id'] ?? $n->redis_id,
                'titulo' => $json['titulo'] ?? null,
                'mensaje' => $json['mensaje'] ?? null,
                'icon' => $json['icon'] ?? 'mdi-bell-outline',
                'fecha' => $json['fecha'] ?? $n->created_at?->toDateTimeString(),
                'leido' => (bool) ($json['leido'] ?? $n->leido),
                'ruta' => $json['ruta'] ?? $n->ruta
            ];

        })->toArray();

        $todas = array_merge($redis, $mapeo);

        $unicas = array_values(array_reduce($todas, function ($carry, $item) {
            $carry[$item['id']] = $item;
            return $carry;
        }, []));

        usort($unicas, fn($a, $b) => strtotime($b['fecha']) <=> strtotime($a['fecha']));

        return $unicas;
    }

    /**
     * Valida si una notificacion es mayor a 10 días  si es asi se elimina
     * @param int $usuarioId
     * @param  $notificacionesGuardadas 
     * @return bool
     * @author  jose vasquez 
     */
    public function validarTiempoExpiracion(int $usuarioId, $notificacionesGuardadas): bool
    {
        foreach ($notificacionesGuardadas as $notificacion) {
            $creada = Carbon::parse($notificacion->created_at);

            if ($creada->diffInDays(now()) >= 10) {
                $this->eliminarEnRedisYBD($usuarioId, $notificacion->redis_id ?? null);
            }
        }

        return true;
    }

    /**
     * Función unificada para eliminar en Redis y en BD.
     * @param int $usuarioId
     * @param string $notificacionId
     * @return bool
     * @author jose vasquez 
     */
    public function eliminarEnRedisYBD(int $usuarioId, string $notificacionId): bool
    {
        $key = 'usuario.' . $usuarioId;
        $items = Redis::lrange($key, 0, -1);

        foreach ($items as $item) {
            $decoded = json_decode($item, true);
            
            if (isset($decoded['id']) && $decoded['id'] === $notificacionId) {
                Redis::lrem($key, 1, $item);
            }
        }

        $buscarNotificacion = $this->notificacionRepository->buscarNotificacionPorRedis($notificacionId);

        if ($buscarNotificacion) {
            $buscarNotificacion->delete();
        }

        Redis::publish("usuario.$usuarioId", json_encode([
            'accion' => 'eliminar',
            'id' => $notificacionId,
        ]));

        return true;
    }
}
