<?php

namespace App\Mail\Etkinlik;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EtkinlikKatilimMail extends Mailable
{
    use Queueable, SerializesModels;

    public $etkinlik;
    public $kullanici;
    /**
     * Create a new message instance.
     */
    public function __construct($etkinlik, $kullanici)
    {
        $this->etkinlik = $etkinlik;
        $this->kullanici = $kullanici;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Etkinlik Katilim Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.etkinlik.etkinlik-katilim',
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
