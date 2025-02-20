<?php

namespace App\Http\Controllers;

use App\Events\KanalGuncellendi;
use App\Events\KanalOlusturuldu;
use App\Events\KanalSilindi;
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
        if (!Auth::user()->kanalKontrol($kanalId)) {
            return response()->json([
                'success' => false,
                'message' => 'Bu işlemi yapmaya yetkiniz yok.',
            ], 403);
        }

        $katilimcilar = MesajKanalKatilimci::with('kullanici')
            ->where('mesaj_kanallari_id', $kanalId)
            ->where('aktiflik', 1)
            ->get()
            ->map(fn($katilimci) => $katilimci->kullanici->email)
            ->toArray();

        $kanal = MesajKanal::with('aktifKatilimcilar.kullanici')->find($kanalId);

        // Yöneticileri filtreleyelim (yoneticilikDurumu değeri 1 olanlar)
        $yoneticiler = $kanal->aktifKatilimcilar
            ->where('yoneticilikDurumu', 1);

        // Eğer sadece yöneticilerin kullancilar_id değerlerine ihtiyacınız varsa:
        $yonetici_ids = $yoneticiler->pluck('kullanicilar_id')->toArray();

        $lefted = MesajKanalKatilimci::where('mesaj_kanallari_id', $kanalId)->where('kullanicilar_id', Auth::id())->whereNull('left_at')->exists();

        $html = view('components.mesaj.kanal.duzenle-modal', compact('kanal', 'yonetici_ids', 'lefted'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'searchNot' => $katilimcilar
        ], 200);
    }

    public function update($kanalId, Request $request)
    {
        $validated = $request->all();

        $kanal = MesajKanal::find($kanalId);

        $kanal->update($validated);

        if (!empty($validated['kullanicilar_id'])) {
            array_map(function ($kullanici) use ($kanal) {
                MesajKanalKatilimci::create([
                    'mesaj_kanallari_id' => $kanal->mesaj_kanallari_id,
                    'kullanicilar_id' => decrypt($kullanici),
                    'yoneticilikDurumu' => 0,
                ]);
            }, $validated['kullanicilar_id']);
        }

        broadcast(new KanalGuncellendi($kanal));

        return response()->json([
            'success' => true,
            'message' => 'Kanal başarıyla güncellendi.',
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

    public function katilimciSil($kanalId, $katilimciId)
    {
        $kanalId = decrypt($kanalId);
        $katilimciId = decrypt($katilimciId);

        $katilimci = MesajKanalKatilimci::where('mesaj_kanallari_id', $kanalId)
            ->where('kullanicilar_id', $katilimciId)->first();

        $katilimci->aktiflik = 0;
        $katilimci->left_at = now();

        $katilimci->save();

        $kanal = MesajKanal::find($kanalId);

        broadcast(new KanalGuncellendi($kanal));

        return response()->json([
            'success' => true,
            'message' => 'Katılımcı silindi.',
            'self' => $katilimciId == Auth::id(),
        ], 200);
    }

    public function destroy($kanalId)
    {
        $kanal = MesajKanalKatilimci::where('mesaj_kanallari_id', decrypt($kanalId))->where('kullanicilar_id', Auth::id())->first();

        $kanal->aktiflik = 0;
        $kanal->deleted_at = now();
        $kanal->save();

        return response()->json([
            'success' => true,
            'message' => 'Kanal silindi.',
        ], 200);
    }
}
