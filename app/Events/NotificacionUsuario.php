<?php

namespace App\Events;

use App\Http\Modules\Notificacion\Models\Notificacion;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redis;

class NotificacionUsuario implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $mensaje; // mensaje que le va llegar 
    public $usuarioId; // id del usuario a notificar
    public $titulo; // encabezado principal del mensaje
    public $channel; // se debe mandar el canal como parametro , si se quiere ver la notificaciones tiene que crear un canal unico al usuario y su user_id asi {'usuario.' . $this->usuarioId}
    public $id; // id registro redis
    public $ruta; // redireccionamiento en el front a una page
    /**
     * Create a new event instance.
     */
    public function __construct($usuarioId, $mensaje, $channel, $ruta, $titulo = null)
    {
        $this->usuarioId = $usuarioId;
        $this->mensaje = $mensaje;
        $this->titulo = $titulo ?: 'Nueva notificación';
        $this->channel = $channel;
        $this->id = Str::uuid();
        $this->ruta = $ruta;

        // Guardar en Redis al momento de crear el evento
        $key = 'usuario.' . $usuarioId;


        $data = [
            'id' => $this->id,
            'titulo' => $titulo,
            'mensaje' => $mensaje,
            'icon' => 'mdi-bell-outline',
            'fecha' => now()->toDateTimeString(),
            'leido' => false,
            'ruta' => $this->ruta
        ];

        Notificacion::create([
            'notificacion' => json_encode($data),
            'leido' => false,
            'redis_id' => $this->id,
            'user_id' => $usuarioId
        ]);

        Redis::lpush($key, json_encode($data));
        Redis::ltrim($key, 0, 99); // máximo 100 notificaciones
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        /**
         *  El web socket de nest tiene una validacion para que se envien los parametros que estan en el data
         *  se tiene que pasar un canal para que se pueda tomar en el front el (on) de socket.io 
         *  el canal para notificar al usuario seria asi ..'usuario.' . $usuarioId ---> la key usuario y su valor el id del usuario que
         *  se le quiere mostrar la notificacion en bandeja, si no se quiere mostrar asi solo se manda otro canal
         */

        return new Channel($this->channel);
    }

    public function broadcastAs()
    {
        return 'message';
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->id,
            'titulo' => $this->titulo,
            'mensaje' => $this->mensaje,
            'usuarioId' => $this->usuarioId,
            'icon' => 'mdi-bell-outline',
            'fecha' => now()->toDateTimeString(),
            'leido' => false,
            'ruta' => $this->ruta,
        ];
    }

}
