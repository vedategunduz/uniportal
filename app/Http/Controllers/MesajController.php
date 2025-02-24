<?php

namespace App\Http\Controllers;

use App\Events\MesajGuncellendi;
use App\Events\MesajOkundu;
use App\Events\MesajOlusturuldu;
use App\Events\MesajSilindi;
use App\Models\Mesaj;
use App\Models\MesajDetay;
use App\Models\MesajKanalKatilimci;
use App\Models\MesajKullaniciGoruntuleme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mews\Purifier\Facades\Purifier;


class MesajController extends Controller
{
    public function index()
    {
        $html = view('components.mesaj.mesaj-wrapper')->render();

        return response()->json([
            'success' => true,
            'html' => $html,
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->all();
        $yd = decrypt($validated['yd']);

        if ($yd) {
            if (!Auth::user()->kanalYoneticisimi($validated['mesaj_kanallari_id'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bu kanalda mesaj gönderme yetkiniz yok.',
                ], 200);
            }
        }

        // Purifier::clean($validated['mesaj']);

        $pattern = '/(https?:\/\/\S+)/';
        $replacement = '<a href="$1" class="text-blue-700 hover:underline hover:text-blue-700" target="_blank">$1</a>';
        $validated['mesaj'] = preg_replace($pattern, $replacement, $validated['mesaj']);
        $validated['mesaj'] = Purifier::clean($validated['mesaj']);


        $validated['kullanicilar_id'] = Auth::id();
        $validated['isletmeler_id'] = Auth::user()->isletmeler_id;
        $validated['unvanlar_id'] = Auth::user()->unvanlar_id;

        if (!empty($validated['alintilanan_mesajlar_id'])) {
            $validated['alintilanan_mesajlar_id'] = decrypt($validated['alintilanan_mesajlar_id']);
        }

        $mesaj = Mesaj::create($validated);

        $kanalKullanicilari = MesajKanalKatilimci::where('mesaj_kanallari_id', $mesaj->mesaj_kanallari_id)->where('aktiflik', 1)->pluck('kullanicilar_id');

        foreach ($kanalKullanicilari as $kullanici) {
            if ($kullanici != Auth::id()) {
                MesajKullaniciGoruntuleme::create([
                    'mesajlar_id'        => $mesaj->mesajlar_id,
                    'kullanicilar_id'    => $kullanici,
                    'mesaj_kanallari_id' => $mesaj->mesaj_kanallari_id,
                ]);
            }
        }

        $mesaj = Mesaj::with(['kullanici', 'isletme', 'unvan', 'alinti.kullanici', 'detay.kullanici', 'detay.emoji'])->find($mesaj->mesajlar_id);

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

        broadcast(new MesajOkundu($kanalId))->toOthers();

        return response()->json([
            'success' => true,
            'message' => 'Mesajlar okundu olarak işaretlendi.',
        ], 200);
    }

    public function destroy($mesajId)
    {
        $mesajId = decrypt($mesajId);

        $mesaj = Mesaj::with(['kullanici', 'isletme', 'unvan'])->where('mesajlar_id', $mesajId)->where('kullanicilar_id', Auth::id())->first();

        $mesaj->durum = 'silindi';
        $mesaj->save();

        broadcast(new MesajSilindi($mesaj))->toOthers();

        return response()->json([
            'success' => true,
            'message' => "Mesaj silindi.",
        ], 200);
    }

    public function update($mesajId, Request $request)
    {
        $validated = $request->all();

        $mesajId = decrypt($mesajId);

        $mesaj = Mesaj::with(['kullanici', 'isletme', 'unvan', 'alinti.kullanici', 'detay.kullanici', 'detay.emoji'])->where('mesajlar_id', $mesajId)->where('kullanicilar_id', Auth::id())->first();

        $pattern = '/(https?:\/\/\S+)/';
        $replacement = '<a href="$1" class="text-blue-700 hover:underline hover:text-blue-700" target="_blank">$1</a>';
        $validated['mesaj'] = preg_replace($pattern, $replacement, $validated['mesaj']);

        $mesaj->mesaj = $validated['mesaj'];

        $mesaj->durum = 'düzenlendi';

        $mesaj->save();

        broadcast(new MesajGuncellendi($mesaj))->toOthers();

        return response()->json([
            'success' => true,
            'message' => "",
        ], 200);
    }

    public function alintiKaldir($mesajId)
    {
        $mesajId = decrypt($mesajId);

        $mesaj = Mesaj::with(['kullanici', 'isletme', 'unvan', 'detay.kullanici', 'detay.emoji'])->where('mesajlar_id', $mesajId)->where('kullanicilar_id', Auth::id())->first();

        $mesaj->alintilanan_mesajlar_id = null;

        $mesaj->save();

        broadcast(new MesajGuncellendi($mesaj))->toOthers();

        return response()->json([
            'success' => true,
            'message' => "",
        ], 200);
    }

    public function emoji($mesajId, $emojiId)
    {
        $mesajId = decrypt($mesajId);
        $emojiId = decrypt($emojiId);

        $mesaj = Mesaj::where('mesajlar_id', $mesajId)->first();

        $mesajDetay = MesajDetay::where('mesajlar_id', $mesajId)->where('emoji_tipleri_id', $emojiId)->where('kullanicilar_id', Auth::id())->first();

        MesajDetay::where('kullanicilar_id', Auth::id())->where('mesajlar_id', $mesajId)->delete();

        if (empty($mesajDetay)) {
            if ($mesaj->kullanicilar_id != Auth::id()) {
                MesajDetay::create([
                    'mesajlar_id'      => $mesajId,
                    'emoji_tipleri_id' => $emojiId,
                    'kullanicilar_id'  => Auth::id(),
                ]);
            }
        }

        $mesaj = Mesaj::where('mesajlar_id', $mesajId)->with(['kullanici', 'isletme', 'unvan', 'alinti.kullanici', 'detay.kullanici', 'detay.emoji'])->first();

        $emojiCount = MesajDetay::where('mesajlar_id', $mesajId)->where('emoji_tipleri_id', $emojiId)->count();

        broadcast(new MesajGuncellendi($mesaj))->toOthers();

        return response()->json([
            'success' => true,
            'message' => "Emoji eklendi.",
            'count' => $emojiCount,
        ], 201);
    }
}
