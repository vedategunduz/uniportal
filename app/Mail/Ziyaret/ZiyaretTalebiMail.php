<?php

namespace App\Mail\Ziyaret;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ZiyaretTalebiMail extends Mailable
{
    use Queueable, SerializesModels;

    // Kullanici::class
    public $kullanici;
    // Isletme::class
    public $kurum;
    // Kullanici::class array
    public $gidenKullanicilar;
    // Etkinlik::class
    public $etkinlik;
    /**
     * Create a new message instance.
     */
    public function __construct($kullanici, $kurum, $gidenKullanicilar, $etkinlik)
    {
        $this->kullanici         = $kullanici;
        $this->kurum             = $kurum;
        $this->gidenKullanicilar = $gidenKullanicilar;
        $this->etkinlik          = $etkinlik;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "{$this->kurum->baslik} Ziyaret Talebi",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.ziyaret.ziyaret-talebi-mail',
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
