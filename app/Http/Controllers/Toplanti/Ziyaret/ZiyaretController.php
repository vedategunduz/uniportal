<?php

namespace App\Http\Controllers\Toplanti\Ziyaret;

use App\Http\Controllers\Controller;
use App\Mail\OrnekMail;
use App\Mail\ZiyaretTalebiMail;
use App\Models\Etkinlik;
use App\Models\EtkinlikKatilim;
use Illuminate\Http\Request;
use App\Models\Isletme;
use App\Models\IsletmeYetkili;
use App\Models\Kullanici;
use App\Models\KullaniciBirimUnvan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ZiyaretController extends Controller
{
    public function ziyaretTalepModalGetir()
    {
        $isletmeler = IsletmeYetkili::aitOldugumIsletmeleriGetir();

        $tumIsletmeler = Isletme::all();

        $isletmeler = Isletme::select('isletmeler_id', 'baslik')->whereIn('isletmeler_id', $isletmeler)->get();

        $html = view(
            'components.yonetim.toplantilar.ziyaret.modal',
            [
                'isletmeler'    => $isletmeler,
                'tumIsletmeler' => $tumIsletmeler
            ]
        )->render();

        return response()->json([
            'success' => true,
            'html'    => $html
        ]);
    }

    public function personeller(Request $request)
    {
        $decrypted_isletmeler_id = decrypt($request->isletmeler_id);

        // İlgili işletmenin yetkilisi/kullanıcılarının ID'lerini pluck ile alıyoruz
        $kullanici_ids = IsletmeYetkili::where('isletmeler_id', $decrypted_isletmeler_id)
            ->whereNot('kullanicilar_id', 1)
            ->pluck('kullanicilar_id');

        // Arama parametresi
        $search = $request->search;
        $searchNot = $request->searchNot;

        $personellerQuery = Kullanici::whereIn('kullanicilar_id', $kullanici_ids);

        if (!empty($searchNot)) {
            $personellerQuery = $personellerQuery->whereNotIn('email', $searchNot);
        }

        // Eğer bir arama değeri varsa sorguya ekliyoruz
        if (!empty($search)) {
            $personellerQuery->where(function ($query) use ($search) {
                $query
                    ->where('ad', 'like', '%' . $search . '%')
                    ->orWhere('soyad', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        // Sorguyu çalıştırıp sonuçları alıyoruz
        $personeller = $personellerQuery->orderBy('ad', 'asc')->orderBy('soyad', 'asc')->get();

        // View'ı render ediyoruz
        $html = view(
            'components.yonetim.toplantilar.ziyaret.personeller',
            [
                'personeller' => $personeller
            ]
        )->render();

        // JSON döndürüyoruz
        return response()->json([
            'success' => true,
            'html'    => $html
        ]);
    }

    public function kurumPersoneller(Request $request)
    {
        $decrypted_isletmeler_id = decrypt($request->isletmeler_id);

        $kullanici_ids =  IsletmeYetkili::where('isletmeler_id', $decrypted_isletmeler_id)
            ->whereNot('kullanicilar_id', 1)
            ->pluck('kullanicilar_id');

        $birimPersonellerQuery = KullaniciBirimUnvan::query()
            ->with('unvan', 'birim', 'IzinliKullanici')
            ->join('isletme_birimleri', 'kullanici_birim_unvan_iliskileri.isletme_birimleri_id', '=', 'isletme_birimleri.isletme_birimleri_id')
            ->join('unvanlar', 'kullanici_birim_unvan_iliskileri.unvanlar_id', '=', 'unvanlar.unvanlar_id')
            ->whereIn('kullanicilar_id', $kullanici_ids);

        $search = $request->search;

        if (!empty($search)) {
            $birimPersonellerQuery->where(function ($query) use ($search) {
                $query->whereHas('unvan', function ($q) use ($search) {
                    $q->where('baslik', 'like', '%' . $search . '%');
                })
                    ->orWhereHas('birim', function ($q) use ($search) {
                        $q->where('baslik', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('IzinliKullanici', function ($q) use ($search) {
                        $q->where('ad', 'like', '%' . $search . '%')
                            ->orWhere('soyad', 'like', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%');
                    });
            });
        }

        $birimPersoneller = $birimPersonellerQuery->orderBy('isletme_birimleri.baslik', 'asc')
            ->orderBy('unvanlar.unvanSira', 'asc')
            ->get();

        $html = view(
            'components.yonetim.toplantilar.ziyaret.davet-personel',
            [
                'personeller' => $birimPersoneller
            ]
        )->render();

        return response()->json([
            'success' => true,
            'html'    => $html
        ]);
    }

    public function createCard($kullanici)
    {
        $html = view(
            'components.yonetim.toplantilar.ziyaret.personel-card',
            [
                'kullanici' => $kullanici
            ]
        )->render();

        return response()->json([
            'success' => true,
            'html'    => $html,
            'email'   => $kullanici->email
        ]);
    }

    public function createDavetCard($kullanici_id)
    {
        $kullanici = KullaniciBirimUnvan::with('unvan', 'birim', 'IzinliKullanici')
            ->where('kullanicilar_id', $kullanici_id)
            ->first();

        $html = view(
            'components.yonetim.toplantilar.ziyaret.davet-personel-card',
            [
                'personel' => $kullanici
            ]
        )->render();

        return response()->json([
            'success' => true,
            'html'    => $html
        ]);
    }

    public function personelCard(Request $request)
    {
        $decryptedId = decrypt($request->kullanicilar_id);
        $kullanici = Kullanici::find($decryptedId);

        return $this->createCard($kullanici);
    }

    public function kurumPersonelCard(Request $request)
    {
        $decryptedId = decrypt($request->kullanicilar_id);

        return $this->createDavetCard($decryptedId);
    }

    public function store(Request $request)
    {
        try {
            // $this->sendMails();
            $validated = $request->all();
            $validated['isletmeler_id']       = decrypt($request->olusturan_isletmeler_id);
            $validated['etkinlik_turleri_id'] = 9;

            $etkinlik = Etkinlik::create($validated);

            $ids = array_map('decrypt', $validated['kullanicilar_id']);
            $gidecekKullanicilar = Kullanici::whereIn('kullanicilar_id', $ids)->get();

            $ids = array_map('decrypt', $validated['davet_kullanicilar_id']);
            $kullanicilar = Kullanici::whereIn('kullanicilar_id', $ids)->get();

            $isletme = Isletme::find($validated['isletmeler_id']);

            foreach ($kullanicilar as $kullanici) {
                Mail::to($kullanici->email)
                    ->send(
                        new ZiyaretTalebiMail(
                            $isletme->baslik,
                            $validated['baslik'],
                            $etkinlik->etkinlikler_id,
                            $gidecekKullanicilar,
                            $validated['etkinlikBaslamaTarihi'],
                            $validated['etkinlikBitisTarihi'],
                            $validated['aciklama']
                        )
                    );
                EtkinlikKatilim::create([
                    'etkinlikler_id' => $etkinlik->etkinlikler_id,
                    'kullanicilar_id' => $kullanici->kullanicilar_id,
                    'isletmeler_id' => $validated['isletmeler_id'],
                    'durum' => 'beklemede',
                    'katilimciTipi' => 'davetli'
                ]);
            }

            foreach ($gidecekKullanicilar as $kullanici) {
                // Mail taslağı oluştur davet eden için
                EtkinlikKatilim::create([
                    'etkinlikler_id' => $etkinlik->etkinlikler_id,
                    'kullanicilar_id' => $kullanici->kullanicilar_id,
                    'isletmeler_id' => $validated['isletmeler_id'],
                    'durum' => 'beklemede',
                    'katilimciTipi' => 'davetEden'
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Ziyaret talebi başarıyla oluşturuldu.'
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], 500);
            Log::error($th->getMessage());
        }
    }
}
