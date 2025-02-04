<?php

namespace App\Mail\Ziyaret;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ZiyaretEkibiMail extends Mailable
{
    use Queueable, SerializesModels;

    public $kullanici;
    public $davetEdilenKullanicilar;
    public $gidenKullanicilar;
    public $etkinlik;
    public $kurum;

    /**
     * Create a new message instance.
     */
    public function __construct($etkinlik, $kullanici, $kurum, $davetEdilenKullanicilar, $gidenKullanicilar)
    {
        $this->etkinlik = $etkinlik;
        $this->kullanici = $kullanici;
        $this->kurum = $kurum;
        $this->davetEdilenKullanicilar = $davetEdilenKullanicilar;
        $this->gidenKullanicilar = $gidenKullanicilar;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "{$this->kurum->baslik} Ziyareti Hakkında Bilgilendirme",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.ziyaret.ziyaret-ekibi-mail',
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
