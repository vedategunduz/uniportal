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

    public $kurumBaslik;
    public $baslik;
    public $etkinlikler_id;
    public $kullanicilar;
    public $etkinlikBaslamaTarihi;
    public $etkinlikBitisTarihi;
    public $aciklama;
    /**
     * Create a new message instance.
     */
    public function __construct($kurumBaslik, $baslik, $etkinlikler_id, $kullanicilar, $etkinlikBaslamaTarihi, $etkinlikBitisTarihi, $aciklama)
    {
        $this->kurumBaslik = $kurumBaslik;
        $this->baslik = $baslik;
        $this->etkinlikler_id = $etkinlikler_id;
        $this->kullanicilar = $kullanicilar;
        $this->etkinlikBaslamaTarihi = $etkinlikBaslamaTarihi;
        $this->etkinlikBitisTarihi = $etkinlikBitisTarihi;
        $this->aciklama = $aciklama;
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
