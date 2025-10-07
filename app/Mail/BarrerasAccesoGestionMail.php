<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BarrerasAccesoGestionMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $mensaje;
    public $id;
    public $tipo;
    public $observacion;
    public $observacion_cierre;
    public $observacion_solucion;

    /**
     * Create a new message instance.
     */
    public function __construct($mensaje, $id, $tipo, $observacion, $observacion_cierre, $observacion_solucion)
    {
        $this->mensaje = $mensaje;
        $this->id = $id;
        $this->tipo = $tipo;
        $this->observacion = $observacion;
        $this->observacion_cierre = $observacion_cierre;
        $this->observacion_solucion = $observacion_solucion;
    }

    public function build()
    {
        return $this->subject('Notificación Barrera Acceso')
                    ->view('email_barrera_acceso')
                    ->with([
                        'mensaje' => $this->mensaje,
                        'id' => $this->id,
                        'tipo' => $this->tipo,
                        'observacion' => $this->observacion,
                        'observacion_cierre' => $this->observacion_cierre,
                        'observacion_solucion' => $this->observacion_solucion
                    ]);
    }
}
