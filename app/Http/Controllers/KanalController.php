<?php

namespace App\Http\Controllers;

use App\Events\KanalOlusturuldu;
use App\Models\Kullanici;
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

        if (!empty($validated['kullanicilar_id'])) {
            array_map(function ($kullanici) use ($kanal) {
                MesajKanalKatilimci::create([
                    'mesaj_kanallari_id' => $kanal->mesaj_kanallari_id,
                    'kullanicilar_id' => decrypt($kullanici),
                    'yoneticilikDurumu' => 0,
                ]);
            }, $validated['kullanicilar_id']);
        }

        MesajKanalKatilimci::create([
            'mesaj_kanallari_id' => $kanal->mesaj_kanallari_id,
            'kullanicilar_id' => Auth::id(),
            'yoneticilikDurumu' => 1,
        ]);

        broadcast(new KanalOlusturuldu($kanal))->toOthers();

        return response()->json([
            'success' => true,
            'data' => $kanal->mesaj_kanallari_id,
        ], 201);
    }

    public function edit($kanalId)
    {
        $kanal = MesajKanal::with('katilimcilar')->find($kanalId);

        $html = view('components.mesaj.kanal.modal', compact('kanal'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
        ], 200);
    }

    public function katilimciListesi(Request $request)
    {
        $search = $request->search;
        $searchNot = $request->searchNot;

        if ($searchNot === "undefined" || empty($searchNot))
            $searchNot = [];
        elseif (!is_array($searchNot))
            $searchNot = explode(',', $searchNot);

        $personellerQuery = Kullanici::with('anaIsletme')
            ->where('veriGosterimIzni', 1)
            ->whereNotIn('kullanicilar_id', [Auth::id(), 1]);

        if (!empty($searchNot)) {
            $personellerQuery = $personellerQuery->whereNotIn('email', $searchNot);
        }

        // Eğer bir arama değeri varsa sorguya ekliyoruz
        if (!empty($search)) {
            $personellerQuery->where(function ($query) use ($search) {
                $query
                    ->where('ad', 'like', '%' . $search . '%')
                    ->orWhere('soyad', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhereHas('anaIsletme', function ($query) use ($search) {
                        $query->where('baslik', 'like', '%' . $search . '%');
                    });
            });
        }

        $kullanicilar = $personellerQuery->get();

        $html = view('components.mesaj.mesaj-kanal-katilimci-ekleme-listesi', compact('kullanicilar'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'data' => $request->all(),
            'search' => $searchNot,
        ], 200);
    }

    public function katilimciCardEkle(Request $request)
    {
        $kullanici = Kullanici::where('email', $request->email)->first();

        $html = view('components.mesaj.mesaj-kanal-katilimci', compact('kullanici'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
        ], 200);
    }
}
