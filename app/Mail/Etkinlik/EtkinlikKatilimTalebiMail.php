<?php

namespace App\Mail\Etkinlik;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class EtkinlikKatilimTalebiMail extends Mailable
{
    use Queueable, SerializesModels;

    public $etkinlik;
    public $kullanici;
    public $user;
    public $aciklama;
    /**
     * Create a new message instance.
     */
    public function __construct($etkinlik, $kullanici, $aciklama)
    {
        $this->etkinlik = $etkinlik;
        $this->kullanici = $kullanici;
        $this->user = Auth::user();
        $this->aciklama = $aciklama;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Etkinlik Katilim Talebi Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.etkinlik.etkinlik-katilim-talebi',
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
