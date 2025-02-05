<?php

namespace App\Mail\Ziyaret;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ZiyaretKatilimIptal extends Mailable
{
    use Queueable, SerializesModels;

    public $kullanici;
    public $etkinlik;
    /**
     * Create a new message instance.
     */
    public function __construct($kullanici, $etkinlik)
    {
        $this->kullanici = $kullanici;
        $this->etkinlik = $etkinlik;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Ziyaret Katilim Iptal',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.ziyaret.ziyaret-katilim-iptal',
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
