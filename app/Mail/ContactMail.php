<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     *
     * @param  array  $data
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Utiliza la dirección de correo electrónico definida en la variable de entorno MAIL_FROM_ADDRESS
        return $this->from(config('mail.from.address'), config('mail.from.name'))
                    ->subject('Contacto') // Puedes personalizar el asunto aquí
                    ->view('emails.contact'); // Reemplaza 'emails.contact' con la vista de tu correo
    }
}