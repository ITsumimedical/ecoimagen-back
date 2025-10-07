<?php

namespace App\Mail;

use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ZipFormulasGenerado extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public string $url;
    public string $fecha;

    /**
     * Create a new message instance.
     */
    public function __construct(string $url, string $fecha)
    {
        $this->url = $url;
        $this->fecha = $fecha;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Zip Fórmulas Generado',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.historias.formulas',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
