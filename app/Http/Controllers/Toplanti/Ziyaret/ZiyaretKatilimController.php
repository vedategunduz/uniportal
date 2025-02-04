<?php

namespace App\Http\Controllers\Toplanti\Ziyaret;

use App\Http\Controllers\Controller;
use App\Mail\Ziyaret\KatilimDurumMail;
use App\Models\Etkinlik;
use App\Models\EtkinlikKatilim;
use App\Models\Kullanici;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class ZiyaretKatilimController extends Controller
{
    public function onay(string $parametre)
    {
        $decryptedParam = decrypt($parametre);
        [$etkinlik_id, $kullanici_id] = explode('-', $decryptedParam);

        // Etkinlik katılımını bul ve güncelle
        $etkinlikKatilim = EtkinlikKatilim::where('etkinlikler_id', $etkinlik_id)
            ->where('kullanicilar_id', $kullanici_id)
            ->firstOrFail(); // İlk kaydı bulamazsa 404 hatası verir

        $etkinlikKatilim->durum = 'onaylandi';
        $etkinlikKatilim->save();

        // Etkinliği bul
        $etkinlik = Etkinlik::findOrFail($etkinlik_id);

        // Google Takvim URL'sini oluştur
        $googleCalendarUrl = $this->createGoogleCalendarUrl($etkinlik);

        $this->sendInfoMail(true, $etkinlik_id, $kullanici_id);

        // Başarı mesajını döndür
        return view('mail.yanit.index')->with([
            'success' => true,
            'message' => 'Davet Kabul Edildi',
            'etkinlik' => $etkinlik,
            'googleCalendarUrl' => $googleCalendarUrl,
        ]);
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

        $this->sendInfoMail(false, $etkinlik_id, $kullanici_id);

        return view('mail.yanit.index')->with([
            'success' => false,
            'message' => 'Davet reddedildi',
            'parametre' => $parametre,
        ]);
    }

    public function sendInfoMail($durum, $etkinlikler_id, $kullanicilar_id)
    {
        $cevaplayanKullanici = Kullanici::findOrFail($kullanicilar_id);
        $etkinlik = Etkinlik::findOrFail($etkinlikler_id);

        $katilanKullanicilar = EtkinlikKatilim::where('etkinlikler_id', $etkinlikler_id)
            ->whereNot('kullanicilar_id', $kullanicilar_id)
            ->pluck('kullanicilar_id')
            ->toArray();

        $katilanKullaniciListesi = Kullanici::whereIn('kullanicilar_id', $katilanKullanicilar)->get();

        foreach ($katilanKullaniciListesi as $katilanKullanici) {
            Mail::to($katilanKullanici->email)
                ->send(new KatilimDurumMail($durum, $etkinlik, $cevaplayanKullanici, $katilanKullanici));
        }
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
}
