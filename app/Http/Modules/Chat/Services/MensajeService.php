<?php

namespace App\Http\Modules\Chat\Services;

use App\Http\Modules\Chat\Models\mensaje;
use App\Http\Modules\Chat\Repositories\MensajeRepository;
use Illuminate\Support\Facades\Auth;
use App\Traits\ArchivosTrait;
use Carbon\Carbon;

class MensajeService
{

    protected $Reposotory;
    use ArchivosTrait;

    public function __construct()
    {
        $this->Reposotory = new MensajeRepository();
    }

    public function guardarAdjuntos($data)
    {
        $archivos = $data->file('adjuntos');
        $ruta = 'adjuntos_chat_horus';
        if (sizeof($archivos) >= 1) {
            foreach ($archivos as $archivo) {
                $nombre = $archivo->getClientOriginalName();
                $subirArchivo = $this->subirArchivoNombre($ruta, $archivo, $nombre, 'server37');
                $mensaje = $this->Reposotory->crear(
                    [
                        'mensaje' => null,
                        'adjunto' => $subirArchivo,
                        'user_id' => Auth::id(),
                        'canal_id' => $data['canal_id'],
                        'estado_id' => 1
                    ]
                );
            }
        }
        $response = mensaje::where('id', $mensaje->id)->first();
        return $response;
    }

    /**
     * marca los mensajes no propios como vistos
     * @param int $data
     * @return boolean
     * @author David Peláez
     */
    public function marcarVisto(int $id): bool
    {
        return mensaje::where('canal_id', $id)
            ->where('user_id', '!=',  Auth::id())
            ->update([
                'visto' => true,
                'visto_at' => Carbon::now()
            ]);
    }

    public function exportarChat($canal_id)
    {
        return mensaje::where('canal_id', $canal_id)->with(['user:email,id'])->get();
    }
}
