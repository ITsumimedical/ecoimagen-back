<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RadicacionPqrfsMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;
    protected $paciente;
    protected $path;
    protected $nombreArchivo;

    /**
     * Create a new message instance.
     */
    public function __construct($data, $paciente, $path, $nombreArchivo)
    {
        $this->data = $data;
        $this->paciente = $paciente;
        $this->path = $path;
        $this->nombreArchivo = $nombreArchivo;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Notificación Solución caso '.$this->data['pqrsf_id'],
            to: [$this->data['email']]
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'radicacion_pqr_email',
            with: [
                'radicado_id' => $this->data['pqrsf_id'],
                'descripcion' => $this->data['motivo'],
                'tipo' => 'Solucionar',
                'name' => $this->paciente->primer_nombre,
                'apellido' => $this->paciente->primer_apellido,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return collect($this->path)
        ->map(function($ruta, $index) {
            $nombreArchivo = $this->nombreArchivo[$index];
            return Attachment::fromStorageDisk('server37', $ruta)->as($nombreArchivo);
        })
        ->toArray();
    }

}
