<?php

namespace App\Http\Controllers;

use App\Events\KanalOlusturuldu;
use App\Models\MesajKanal;
use App\Models\MesajKanalKatilimci;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KanalController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->all();

        $kanal = MesajKanal::create($validated);

        MesajKanalKatilimci::create([
            'mesaj_kanallari_id' => $kanal->mesaj_kanallari_id,
            'kullanicilar_id' => Auth::id(),
            'yoneticilikDurumu' => 1,
        ]);

        MesajKanalKatilimci::create([
            'mesaj_kanallari_id' => $kanal->mesaj_kanallari_id,
            'kullanicilar_id' => 2,
        ]);

        broadcast(new KanalOlusturuldu($kanal))->toOthers();

        return response()->json([
            'success' => true,
            'data' => $kanal->mesaj_kanallari_id,
        ], 201);
    }
}
