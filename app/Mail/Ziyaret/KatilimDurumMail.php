<?php

namespace App\Mail\Ziyaret;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class KatilimDurumMail extends Mailable
{
    use Queueable, SerializesModels;

    public $etkinlik;
    public $durum;
    public $cevaplayanKullanici;
    public $katilanKullanici;

    /**
     * Create a new message instance.
     */
    public function __construct($durum, $etkinlik, $cevaplayanKullanici, $katilanKullanici)
    {
        $this->etkinlik = $etkinlik;
        $this->durum = $durum;
        $this->cevaplayanKullanici = $cevaplayanKullanici;
        $this->katilanKullanici = $katilanKullanici;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Katilim Durum Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.ziyaret.katilim-durum-mail',
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
