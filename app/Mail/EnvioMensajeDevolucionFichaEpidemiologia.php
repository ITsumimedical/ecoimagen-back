<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnvioMensajeDevolucionFichaEpidemiologia extends Mailable
{
    use Queueable, SerializesModels;

    public $observacion;
    public $id;
    public $nombre_evento;
    public $numero_documento;

    /**
     * Create a new message instance.
     */
    public function __construct($observacion, $id, $nombre_evento, $numero_documento)
    {
        $this->observacion = $observacion;
        $this->id = $id;
        $this->nombre_evento = $nombre_evento;
        $this->numero_documento = $numero_documento;
    }

    public function build()
    {
        return $this->subject('Devolución de Ficha Epidemiológica')
                    ->view('email_devolucion_ficha_epidemiologia')
                    ->with([
                        'observacion' => $this->observacion,
                        'id' => $this->id,
                        'nombre_evento' => $this->nombre_evento,
                        'numero_documento' => $this->numero_documento,
                    ]);
    }
}
