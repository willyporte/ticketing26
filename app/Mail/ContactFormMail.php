<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public readonly array $data) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[TicketFlow] Nuova richiesta da ' . $this->data['nome'] . ' ' . $this->data['cognome'],
            replyTo: [
                new \Illuminate\Mail\Mailables\Address($this->data['email'], $this->data['nome'] . ' ' . $this->data['cognome']),
            ],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.contact-form',
        );
    }
}
