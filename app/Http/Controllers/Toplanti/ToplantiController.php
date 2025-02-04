<?php

namespace App\Http\Controllers\Toplanti;

use App\Http\Controllers\Controller;
use App\Models\Etkinlik;
use App\Models\EtkinlikKatilim;
use App\Models\Isletme;
use Carbon\Carbon;

class ToplantiController extends Controller
{
    public function index()
    {
        return view('yonetim.toplantilar.index');
    }

    public function getDataTableDatas($isletmeler_id)
    {
        $isletmeler_id = decrypt($isletmeler_id);

        $etkinlikler = Etkinlik::where('isletmeler_id', $isletmeler_id)
            ->where('etkinlik_turleri_id', 13)
            ->get();


        $data = [];

        foreach ($etkinlikler as $etkinlik) {
            $gidenKullanicilar = EtkinlikKatilim::where('etkinlikler_id', $etkinlik->etkinlikler_id)
                ->where('katilimciTipi', 'giden')
                ->get();
            $gidilenKullanicilar = EtkinlikKatilim::where('etkinlikler_id', $etkinlik->etkinlikler_id)
                ->where('katilimciTipi', 'davetli')
                ->get();

            $gidilenIsletme = EtkinlikKatilim::where('etkinlikler_id', $etkinlik->etkinlikler_id)
                ->first();

            $isletme = Isletme::where('isletmeler_id', $gidilenIsletme->gidilen_isletmeler_id)->first();

            $row = [];
            $row[] = "<p class='w-48 text-wrap'>{$isletme->baslik}</p>";
            $row[] = "<p class='w-48 text-wrap'>{$etkinlik->baslik}</p>";
            $row[] = Carbon::parse($etkinlik->etkinlikBaslamaTarihi)->translatedFormat('d F Y H:i');
            $row[] = view('components.yonetim.toplantilar.ziyaret.ekipler', ['kullanicilar' => $gidenKullanicilar])->render();
            $row[] = view('components.yonetim.toplantilar.ziyaret.ekipler', ['kullanicilar' => $gidilenKullanicilar])->render();
            $row[] = view('components.yonetim.toplantilar.ziyaret.mesaj-buton')->render();
            $row[] = view('components.yonetim.toplantilar.ziyaret.duzenle-buton', ['etkinlikler_id' => $etkinlik->etkinlikler_id])->render();
            $data[] = $row;
        }

        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }
}
