<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TestUserEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $personalidad;

    /**
     * Create a new message instance.
     *
     * @param nombre $nombre
     */
    public function __construct($test)
    {
        $this->email = $test->email;
        $this->personalidad = $test->personalidad;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Resultados Test de Personalidad Financiera')
            ->view('emails.test_user');
    }
}