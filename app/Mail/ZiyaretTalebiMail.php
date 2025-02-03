<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ZiyaretTalebiMail extends Mailable
{
    use Queueable, SerializesModels;

    public $kullanici;
    public $giden_isletme;
    public $gidenKullanicilar;
    public $etkinlik;
    /**
     * Create a new message instance.
     */
    public function __construct($kullanici, $giden_isletme, $gidenKullanicilar, $etkinlik)
    {
        $this->kullanici = $kullanici;
        $this->giden_isletme = $giden_isletme;
        $this->gidenKullanicilar = $gidenKullanicilar;
        $this->etkinlik = $etkinlik;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Ziyaret Talebi Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.ziyaret-talebi-mail',
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
