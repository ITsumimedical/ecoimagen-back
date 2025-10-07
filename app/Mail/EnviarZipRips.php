<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EnviarZipRips extends Mailable
{
    use Queueable, SerializesModels;

    public string $urlTemporal;
    /**
     * Create a new message instance.
     */
    public function __construct(string $urlTemporal)
    {
        $this->urlTemporal = $urlTemporal;
    }

    /**
     * Get the message envelope.
     */
    public function build()
    {
        return $this->subject('Descarga de RIPS')
        ->view('zipRips');
    }
}
