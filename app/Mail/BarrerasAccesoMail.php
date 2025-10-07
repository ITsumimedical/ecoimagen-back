<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BarrerasAccesoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $id;
    public $tipo;
    public $observacion;

    /**
     * Create a new message instance.
     */
    public function __construct($id, $tipo, $observacion)
    {
        $this->id = $id;
        $this->tipo = $tipo;
        $this->observacion = $observacion;
    }

    public function build()
    {
        return $this->subject('Notificación Nueva Barrera Acceso')
                    ->view('email_creacion_barrera_acceso')
                    ->with([
                        'id' => $this->id,
                        'tipo' => $this->tipo,
                        'observacion' => $this->observacion,
                    ]);
    }
}
