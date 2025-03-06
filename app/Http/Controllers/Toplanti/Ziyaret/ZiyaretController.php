<?php

namespace App\Http\Controllers\Toplanti\Ziyaret;

use App\Http\Controllers\Controller;
use App\Http\Requests\ZiyaretRequest;
use App\Mail\Ziyaret\ZiyaretEkibiMail;
use App\Mail\Ziyaret\ZiyaretKatilimIptal;
use App\Mail\Ziyaret\ZiyaretTalebiMail;
use App\Models\Etkinlik;
use App\Models\EtkinlikKatilim;
use Illuminate\Http\Request;
use App\Models\Isletme;
use App\Models\IsletmeYetkili;
use App\Models\Kullanici;
use App\Models\KullaniciBirimUnvan;
use App\Models\MesajKanalKatilimci;
use App\Models\SohbetKanal;
use App\Models\SohbetKanalKatilimci;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ZiyaretController extends Controller
{
    public function ziyaretTalepModalGetir(string $etkinlik_id)
    {
        $isletmeler = Isletme::isletmelerimiGetir();

        $tumIsletmeler = Isletme::all();

        $etkinlik = [];
        $gidenKullanicilarEmails = [];
        $gidilecekKullanicilarEmails = [];

        if (!empty($etkinlik_id)) {
            $etkinlik_id = decrypt($etkinlik_id);

            $etkinlik = Etkinlik::find($etkinlik_id);

            $katilim = EtkinlikKatilim::ziyaretIsletmeler($etkinlik_id);

            if ($katilim) {
                $etkinlik->giden_isletme   = $katilim->giden_isletmeler_id;
                $etkinlik->gidilen_isletme = $katilim->gidilen_isletmeler_id;
            }

            $etkinlik->gidenKullanicilar = EtkinlikKatilim::katilimcilar($etkinlik_id, 'giden');
            $gidenKullanicilarEmails = $etkinlik->gidenKullanicilar->map(function ($item) {
                return $item->bilgi->email;
            });

            $etkinlik->gidilenKullanicilar = EtkinlikKatilim::katilimcilar($etkinlik_id, 'davetli');
            $gidilecekKullanicilarEmails = $etkinlik->gidilenKullanicilar->map(function ($item) {
                return $item->bilgi->email;
            });
        }

        $html = view(
            'components.yonetim.toplantilar.ziyaret.modal',
            [
                'etkinlik'      => $etkinlik,
                'isletmeler'    => $isletmeler,
                'tumIsletmeler' => $tumIsletmeler
            ]
        )->render();

        return response()->json([
            'success' => true,
            'html'    => $html,
            'gidenKullanicilarEmails' => $gidenKullanicilarEmails,
            'gidilecekKullanicilarEmails' => $gidilecekKullanicilarEmails
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
        $searchNot = $request->searchNot;

        // $birimPersonellerQuery = $birimPersonellerQuery->whereNotIn('IzinliKullanici.email', $searchNot);

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

        if (!empty($searchNot)) {
            $birimPersonellerQuery->where(function ($query) use ($searchNot) {
                $query->whereHas('IzinliKullanici', function ($q) use ($searchNot) {
                    $q->whereNotIn('email', $searchNot);
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

    public function createDavetCard($kullanici_birim_unvan_iliskileri)
    {
        $kullanici = KullaniciBirimUnvan::with('unvan', 'birim', 'IzinliKullanici')
            ->where('kullanici_birim_unvan_iliskileri_id', $kullanici_birim_unvan_iliskileri)
            ->first();

        $html = view(
            'components.yonetim.toplantilar.ziyaret.davet-personel-card',
            [
                'personel' => $kullanici
            ]
        )->render();

        return response()->json([
            'success' => true,
            'html'    => $html,
            'email'   => $kullanici->IzinliKullanici->email
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

    public function store(ZiyaretRequest $request)
    {
        $validated = $request->all();
        $validated['isletmeler_id']         = decrypt($request->olusturan_isletmeler_id);
        $validated['giden_isletmeler_id']   = decrypt($request->olusturan_isletmeler_id);
        $validated['gidilen_isletmeler_id'] = decrypt($request->gidilen_isletmeler_id);
        $validated['etkinlik_turleri_id']   = 13;

        $etkinlik = Etkinlik::create($validated);

        $mesaj_kanali = $etkinlik->sohbetKanaliOlustur('ziyaret');

        $ids = array_map('decrypt', $validated['kullanicilar_id']);
        $gidenKullaniciIds = Kullanici::whereIn('kullanicilar_id', $ids)->get();

        $ids = array_map('decrypt', $validated['davet_kullanicilar_id']);
        $kullanicilar = Kullanici::whereIn('kullanicilar_id', $ids)->get();

        $giden_isletme = Isletme::find($validated['giden_isletmeler_id']);
        $gidilen_isletme = Isletme::find($validated['gidilen_isletmeler_id']);

        foreach ($kullanicilar as $kullanici) {
            try {
                Mail::to($kullanici->email)
                    ->send(
                        new ZiyaretTalebiMail(
                            $kullanici,
                            $giden_isletme,
                            $gidenKullaniciIds,
                            $etkinlik
                        )
                    );
            } catch (\Throwable $th) {
                //throw $th;
            }
            EtkinlikKatilim::create([
                'etkinlikler_id'        => $etkinlik->etkinlikler_id,
                'kullanicilar_id'       => $kullanici->kullanicilar_id,
                'giden_isletmeler_id'   => $validated['giden_isletmeler_id'],
                'gidilen_isletmeler_id' => $validated['gidilen_isletmeler_id'],
                'durum'                 => 'beklemede',
                'katilimciTipi'         => 'davetli'
            ]);
        }

        foreach ($gidenKullaniciIds as $kullanici) {
            $yonetici = 0;

            if (Auth::id() == $kullanici->kullanicilar_id) {
                $yonetici = 1;
            }

            MesajKanalKatilimci::create([
                'mesaj_kanallari_id' => $mesaj_kanali->mesaj_kanallari_id,
                'kullanicilar_id'     => $kullanici->kullanicilar_id,
                'yoneticilikDurumu' => $yonetici
            ]);

            try {
                Mail::to($kullanici->email)
                    ->send(
                        new ZiyaretEkibiMail(
                            $etkinlik,
                            $kullanici,
                            $gidilen_isletme,
                            $kullanicilar,
                            $gidenKullaniciIds,
                        )
                    );
            } catch (\Throwable $th) {
                //throw $th;
            }
            // Mail taslağı oluştur davet eden için
            EtkinlikKatilim::create([
                'etkinlikler_id'        => $etkinlik->etkinlikler_id,
                'kullanicilar_id'       => $kullanici->kullanicilar_id,
                'giden_isletmeler_id'   => $validated['giden_isletmeler_id'],
                'gidilen_isletmeler_id' => $validated['gidilen_isletmeler_id'],
                'durum'                 => 'beklemede',
                'katilimciTipi'         => 'giden'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Ziyaret talebi başarıyla oluşturuldu.'
        ], 201);
    }

    public function duzenle(ZiyaretRequest $request)
    {
        $validated                          = $request->all();
        $etkinlikler_id                     = decrypt($request->etkinlikler_id);
        $validated['isletmeler_id']         = decrypt($request->olusturan_isletmeler_id);
        $validated['giden_isletmeler_id']   = decrypt($request->olusturan_isletmeler_id);
        $validated['gidilen_isletmeler_id'] = decrypt($request->gidilen_isletmeler_id);
        $validated['etkinlik_turleri_id']   = 13;

        $etkinlik = Etkinlik::find($etkinlikler_id);

        $eskiEtkinlikTumKullanicilar = EtkinlikKatilim::where('etkinlikler_id', $etkinlikler_id)->pluck('kullanicilar_id');

        $ids = array_map('decrypt', $validated['kullanicilar_id']);
        $gidenKullaniciIds = Kullanici::whereIn('kullanicilar_id', $ids)->pluck('kullanicilar_id');

        $ids = array_map('decrypt', $validated['davet_kullanicilar_id']);
        $gidilecekKullaniciIds = Kullanici::whereIn('kullanicilar_id', $ids)->pluck('kullanicilar_id');

        $etkinlikTumKullanicilar = $gidenKullaniciIds->merge($gidilecekKullaniciIds);

        $eklenecekKullanicilar = $etkinlikTumKullanicilar->diff($eskiEtkinlikTumKullanicilar)->values();

        $cikartilanKullanicilar = $eskiEtkinlikTumKullanicilar->diff($etkinlikTumKullanicilar)->values();

        $sabitKullanicilar = $etkinlikTumKullanicilar->diff($eklenecekKullanicilar)->values();

        $gidenKullanicilar = Kullanici::whereIn('kullanicilar_id', $gidenKullaniciIds)->get();
        $gidilecekKullanicilar = Kullanici::whereIn('kullanicilar_id', $gidilecekKullaniciIds)->get();

        $sohbet_kanali = SohbetKanal::where('etkinlikler_id', $etkinlikler_id)->where('tur', 'ziyaret')->first();

        foreach ($eklenecekKullanicilar as $kullanicilar_id) {
            $type = 'davetli';
            if (in_array($kullanicilar_id, $gidenKullaniciIds->toArray())) {
                SohbetKanalKatilimci::create([
                    'sohbet_kanallari_id' => $sohbet_kanali->sohbet_kanallari_id,
                    'kullanicilar_id'     => $kullanicilar_id
                ]);

                $type = 'giden';
            }
            EtkinlikKatilim::create([
                'etkinlikler_id'        => $etkinlikler_id,
                'kullanicilar_id'       => $kullanicilar_id,
                'giden_isletmeler_id'   => $validated['giden_isletmeler_id'],
                'gidilen_isletmeler_id' => $validated['gidilen_isletmeler_id'],
                'durum'                 => 'beklemede',
                'katilimciTipi'         => $type
            ]);

            $kullanici    = Kullanici::find($kullanicilar_id);
            $gidilenKurum = Isletme::find($validated['gidilen_isletmeler_id']);
            $gidenKurum    = Isletme::find($validated['giden_isletmeler_id']);

            try {
                if ($type == 'giden') {
                    Mail::to($kullanici->email)
                        ->send(new ZiyaretEkibiMail($etkinlik, $kullanici, $gidilenKurum, $gidilecekKullanicilar, $gidenKullanicilar, false));
                } else {
                    Mail::to($kullanici->email)
                        ->send(new ZiyaretTalebiMail($kullanici, $gidenKurum,  $gidenKullanicilar, $etkinlik, false));
                }
            } catch (\Throwable $th) {
                //throw $th;
            }
        }

        foreach ($sabitKullanicilar as $kullanicilar_id) {
            $type = 'davetli';
            if (in_array($kullanicilar_id, $gidenKullaniciIds->toArray())) {
                $type = 'giden';
            }

            $kullanici    = Kullanici::find($kullanicilar_id);
            $gidilenKurum = Isletme::find($validated['gidilen_isletmeler_id']);
            $gidenKurum   = Isletme::find($validated['giden_isletmeler_id']);

            try {
                if ($type == 'giden') {
                    Mail::to($kullanici->email)
                        ->send(new ZiyaretEkibiMail($etkinlik, $kullanici, $gidilenKurum, $gidilecekKullanicilar, $gidenKullanicilar, true));
                } else {
                    Mail::to($kullanici->email)
                        ->send(new ZiyaretTalebiMail($kullanici, $gidenKurum, $gidenKullanicilar, $etkinlik, true));
                }
            } catch (\Throwable $th) {
                //throw $th;
            }
        }

        foreach ($cikartilanKullanicilar as $kullanicilar_id) {
            $kullanici = Kullanici::find($kullanicilar_id);

            try {
                Mail::to($kullanici->email)
                    ->send(new ZiyaretKatilimIptal($kullanici, $etkinlik));
            } catch (\Throwable $th) {
                //throw $th;
            }

            EtkinlikKatilim::where('etkinlikler_id', $etkinlikler_id)
                ->where('kullanicilar_id', $kullanicilar_id)
                ->delete();
        }

        $etkinlik->update($validated);

        $etkinlik->save();

        return response()->json([
            'success' => true,
            'message' => 'Ziyaret talebi başarıyla güncellendi.'
        ], 200);
    }
}
