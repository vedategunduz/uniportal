<?php

namespace App\Http\Controllers\Katilim;

use App\Http\Controllers\Controller;
use App\Models\Etkinlik;
use App\Models\EtkinlikKatilim;
use Carbon\Carbon;

class ZiyaretKatilimController extends Controller
{
    public function onay(string $parametre)
    {
        $decryptedParam = decrypt($parametre);
        [$etkinlikId, $kullaniciId] = explode('-', $decryptedParam);

        // Etkinlik katılımını bul ve güncelle
        $etkinlikKatilim = EtkinlikKatilim::where('etkinlikler_id', $etkinlikId)
            ->where('kullanicilar_id', $kullaniciId)
            ->firstOrFail(); // İlk kaydı bulamazsa 404 hatası verir

        $this->onaylaEtkinlikKatilim($etkinlikKatilim);

        // Etkinliği bul
        $etkinlik = Etkinlik::findOrFail($etkinlikId);

        // Google Takvim URL'sini oluştur
        $googleCalendarUrl = $this->createGoogleCalendarUrl($etkinlik);

        // Başarı mesajını döndür
        return view('mail.yanit.index')->with([
            'success' => true,
            'message' => 'Davet Kabul Edildi',
            'etkinlik' => $etkinlik,
            'googleCalendarUrl' => $googleCalendarUrl,
        ]);
    }

    /**
     * Etkinlik katılımını onayla ve kaydet.
     *
     * @param EtkinlikKatilim $etkinlikKatilim
     * @return void
     */
    protected function onaylaEtkinlikKatilim(EtkinlikKatilim $etkinlikKatilim)
    {
        $etkinlikKatilim->durum = 'onaylandi';
        $etkinlikKatilim->save();
    }

    /**
     * Google Calendar URL'sini oluştur.
     *
     * @param Etkinlik $etkinlik
     * @return string
     */
    protected function createGoogleCalendarUrl(Etkinlik $etkinlik): string
    {
        // Tarihleri Google Takvim formatına dönüştür
        $baslamaTarihiFormatted = $this->formatForCalendar($etkinlik->etkinlikBaslamaTarihi);
        $bitisTarihiFormatted = $this->formatForCalendar($etkinlik->etkinlikBitisTarihi);

        // Google Calendar URL'sini oluştur
        return 'https://www.google.com/calendar/render?action=TEMPLATE' .
            '&text=' . urlencode($etkinlik->baslik) .
            '&dates=' . $baslamaTarihiFormatted . '/' . $bitisTarihiFormatted .
            '&details=' . urlencode($etkinlik->aciklama) .
            '&sf=true&output=xml';
    }

    /**
     * Tarihi Google Takvim formatına dönüştür.
     *
     * @param string $tarih
     * @return string
     */
    protected function formatForCalendar(string $tarih): string
    {
        return Carbon::parse($tarih)->utc()->format('Ymd\THis\Z');
    }

    /**
     * ICS dosyasını oluştur.
     *
     * @param Etkinlik $etkinlik
     * @param string $link
     * @return string
     */
    protected function createIcsFile(Etkinlik $etkinlik): string
    {
        $uid         = uniqid();
        $dtstamp     = gmdate('Ymd') . 'T' . gmdate('His') . 'Z';
        $dtstart     = $this->formatForCalendar($etkinlik->etkinlikBaslamaTarihi);
        $dtend       = $this->formatForCalendar($etkinlik->etkinlikBitisTarihi);
        $summary     = addslashes($etkinlik->baslik);
        $description = addslashes($etkinlik->aciklama);
        $location    = addslashes('');

        $icsContent = "
            BEGIN:VCALENDAR
            VERSION:2.0
            PRODID:-//uniportal//Etkinlik//TR
            BEGIN:VEVENT
            UID:{$uid}
            DTSTAMP:{$dtstamp}
            DTSTART:{$dtstart}
            DTEND:{$dtend}
            SUMMARY:{$summary}
            DESCRIPTION:{$description}
            LOCATION:{$location}
            END:VEVENT
            END:VCALENDAR";

        return $icsContent;
    }

    public function downloadIcs($id)
    {
        $id = decrypt($id);

        $etkinlik = Etkinlik::findOrFail($id);

        $icsContent = $this->createIcsFile($etkinlik);

        $fileName = "{$etkinlik->baslik}.ics";

        return response($icsContent)
            ->header('Content-Type', 'text/calendar; charset=utf-8')
            ->header('Content-Disposition', "attachment; filename={$fileName}");
    }

    public function red(string $parametre)
    {
        $decryptedParam = decrypt($parametre);

        [$etkinlik_id, $kullanici_id] = explode('-', $decryptedParam);

        $etkinlik = EtkinlikKatilim::where('etkinlikler_id', $etkinlik_id)
            ->where('kullanicilar_id', $kullanici_id)
            ->first();

        $etkinlik->durum = 'reddedildi';

        $etkinlik->save();

        return view('mail.yanit.index')->with([
            'success' => false,
            'message' => 'Davet reddedildi',
            'parametre' => $parametre,
        ]);
    }
}
