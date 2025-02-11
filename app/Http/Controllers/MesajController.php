<?php

namespace App\Http\Controllers;

use App\Events\MesajOlusturuldu;
use App\Models\Mesaj;
use App\Models\MesajKanalKatilimci;
use App\Models\MesajKullaniciGoruntuleme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MesajController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->all();

        $pattern = '/(https?:\/\/\S+)/';
        $replacement = '<a href="$1" class="text-blue-700 hover:underline hover:text-blue-700" target="_blank">$1</a>';
        $validated['mesaj'] = preg_replace($pattern, $replacement, $validated['mesaj']);
        $validated['kullanicilar_id'] = Auth::id();

        $mesaj = Mesaj::create($validated);

        $kanalKullanicilari = MesajKanalKatilimci::where('mesaj_kanallari_id', $mesaj->mesaj_kanallari_id)->pluck('kullanicilar_id');

        foreach ($kanalKullanicilari as $kullanici) {
            if ($kullanici != Auth::id()) {
                MesajKullaniciGoruntuleme::create([
                    'mesajlar_id'     => $mesaj->mesajlar_id,
                    'kullanicilar_id' => $kullanici,
                    'mesaj_kanallari_id' => $mesaj->mesaj_kanallari_id,
                ]);
            }
        }

        $mesaj = Mesaj::with('kullanici')->find($mesaj->mesajlar_id);

        broadcast(new MesajOlusturuldu($mesaj))->toOthers();

        $html = view('components.mesaj', [
            'mesaj' => $mesaj,
        ])->render();

        return response()->json([
            'success' => true,
            'html' => $html,
        ], 201);
    }

    public function okundu($kanalId)
    {
        MesajKullaniciGoruntuleme::where('kullanicilar_id', Auth::id())
            ->where('mesaj_kanallari_id', $kanalId)
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Mesajlar okundu olarak işaretlendi.',
        ], 200);
    }
}
