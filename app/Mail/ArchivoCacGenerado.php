<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ArchivoCacGenerado extends Mailable
{
    use Queueable, SerializesModels;

    public string $archivoPath;

    public function __construct(string $archivoPath)
    {
        $this->archivoPath = $archivoPath;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'CAC - Generado',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.cac.archivo_cac_generado',
        );
    }

    public function attachments(): array
    {
        return [
            Attachment::fromPath($this->archivoPath)
                ->as(basename($this->archivoPath))
                ->withMime('text/plain'),
        ];
    }
}
