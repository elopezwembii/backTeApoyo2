<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TestEmail extends Mailable
{
    use Queueable, SerializesModels;

    
    public $gastosTotal;
    public $itemsTotalPresupuestos;
    public $nombre;
    public $mensaje;

    /**
     * Create a new message instance.
     */
    public function __construct($gastosTotal, $itemsTotalPresupuestos, $nombre,$mensaje)
    {
        $this->gastosTotal = $gastosTotal;
        $this->itemsTotalPresupuestos = $itemsTotalPresupuestos;
        $this->nombre = $nombre;
        $this->mensaje = $mensaje;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Aviso Importante: Control de Gastos',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.test_email',
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
