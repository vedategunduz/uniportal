<?php

namespace App\Http\Controllers\Katilim;

use App\Http\Controllers\Controller;
use App\Models\EtkinlikKatilim;

class ZiyaretKatilimController extends Controller
{
    public function onay(string $parametre)
    {
        $parametre = decrypt($parametre);

        [$etkinlik_id, $kullanici_id] = explode('-', $parametre);

        $etkinlik = EtkinlikKatilim::where('etkinlikler_id', $etkinlik_id)
            ->where('kullanicilar_id', $kullanici_id)
            ->first();

        $etkinlik->durum = 'onaylandi';

        $etkinlik->save();

        return view('mail.yanit.index')->with([
            'success' => true,
            'message' => 'Katılım onaylandı'
        ]);
    }

    public function red(string $parametre)
    {
        $parametre = decrypt($parametre);

        [$etkinlik_id, $kullanici_id] = explode('-', $parametre);

        $etkinlik = EtkinlikKatilim::where('etkinlikler_id', $etkinlik_id)
            ->where('kullanicilar_id', $kullanici_id)
            ->first();

        $etkinlik->durum = 'reddedildi';

        $etkinlik->save();

        return view('mail.yanit.index')->with([
            'success' => false,
            'message' => 'Katılım reddedildi'
        ]);
    }
}
