<?php

namespace App\Http\Controllers\Toplanti;

use App\Http\Controllers\Controller;
use App\Models\Etkinlik;
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

        $ziyaretler = Etkinlik::where('isletmeler_id', $isletmeler_id)->where('etkinlik_turleri_id', 13)->get();

        $data = [];

        foreach ($ziyaretler as $ziyaret) {
            $row = [];

            $row[] = '<p class="w-48 text-wrap">' . $ziyaret->baslik . '</p>';
            $row[] = "2";
            $row[] = Carbon::parse($ziyaret->etkinlikBaslamaTarihi)->translatedFormat('d F Y H:i');
            $row[] = "Ziyaret sohbet odası";
            $row[] = "4";

            $data[] = $row;
        }

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
