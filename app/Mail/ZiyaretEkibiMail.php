<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ZiyaretEkibiMail extends Mailable
{
    use Queueable, SerializesModels;

    public $kullanici;
    public $davetEdilenKullanici;
    public $kurumBaslik;
    public $baslik;
    public $etkinlikler_id;
    public $gidenKullanicilar;
    public $etkinlikBaslamaTarihi;
    public $etkinlikBitisTarihi;
    public $aciklama;

    /**
     * Create a new message instance.
     */
    public function __construct($kullanici, $davetEdilenKullanici, $kurumBaslik, $baslik, $etkinlikler_id, $gidenKullanicilar, $etkinlikBaslamaTarihi, $etkinlikBitisTarihi, $aciklama)
    {
        $this->kullanici = $kullanici;
        $this->davetEdilenKullanici = $davetEdilenKullanici;
        $this->kurumBaslik = $kurumBaslik;
        $this->baslik = $baslik;
        $this->etkinlikler_id = $etkinlikler_id;
        $this->gidenKullanicilar = $gidenKullanicilar;
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
            subject: 'Ziyaret Ekibi Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.ziyaret-ekibi-mail',
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
