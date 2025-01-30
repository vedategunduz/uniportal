<?php

namespace App\Http\Controllers\Yonetim;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\IsletmeBirim;
use App\Models\IsletmeYetkili;
use App\Models\Kullanici;
use App\Models\KullaniciBirimUnvan;
use App\Models\Unvan;

class KullaniciController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('yonetim.kullanicilar.index');
    }

    public function getTable(string $isletmeler_id)
    {
        $decryptedIsletmelerId = decrypt($isletmeler_id);

        $personeller = IsletmeYetkili::personeller($decryptedIsletmelerId);

        $data = [];

        foreach ($personeller as $personel) {
            $row = [];

            $personelinAitOlduguBirimler = KullaniciBirimUnvan::personelinBirimleri($personel->kullanicilar_id);

            $row[] = view('components.yonetim.kullanicilar.first-column', ['personel' => $personel])->render();
            $row[] = "<div>{$personel->anaUnvan->baslik}</div>";
            $row[] = view('components.yonetim.kullanicilar.second-column', ['birimBilgileri' => $personelinAitOlduguBirimler, 'kullanicilar_id' => $personel->kullanicilar_id])->render();
            $row[] = view('components.buttons.kullanicilar.duzenle-button', ['kullanicilar_id' => $personel->kullanicilar_id])->render();
            $row[] = view('components.buttons.kullanicilar.sil-button', ['kullanicilar_id' => $personel->kullanicilar_id])->render();

            $data[] = $row;
        }

        return response()->json([
            'data' => $data
        ], 200);
    }

    public function guncelleModalGetir(string $kullanicilar_id)
    {
        $decryptedKullanicilarId = decrypt($kullanicilar_id);

        $kullanici = Kullanici::find($decryptedKullanicilarId);

        $birimDetaylari = KullaniciBirimUnvan::with('unvan', 'birim')->where('kullanicilar_id', $decryptedKullanicilarId)->get();

        $unvanlar = Unvan::all();

        $html = view('components.yonetim.kullanicilar.detay-modal-content', [
            'kullanici' => $kullanici,
            'birimDetaylari' => $birimDetaylari,
            'unvanlar' => $unvanlar
        ])->render();

        return response()->json([
            "success" => true,
            "html" => $html
        ], 200);
    }

    public function silmeModalGetir(Request $request)
    {
        $kullanicilar_id = decrypt($request->kullanicilar_id);
        $isletmeler_id   = decrypt($request->isletmeler_id);

        $kullanici = Kullanici::find($kullanicilar_id);

        $html = view('components.yonetim.kullanicilar.isletmeden-silme-modal-content', [
            'isletmeler_id'   => $isletmeler_id,
            'kullanici' => $kullanici
        ])->render();

        return response()->json([
            "success" => true,
            "html" => $html
        ], 200);
    }

    public function birimdenCikarModalGetir(Request $request)
    {
        $kullanicilar_id = decrypt($request->kullanicilar_id);
        $isletme_birimleri_id   = decrypt($request->isletme_birimleri_id);

        $isletme_birimi = IsletmeBirim::find($isletme_birimleri_id);
        $kullanici = Kullanici::find($kullanicilar_id);

        $html = view('components.yonetim.kullanicilar.birimden-sil-modal-content', [
            'isletme_birimi'   => $isletme_birimi,
            'kullanici' => $kullanici
        ])->render();

        return response()->json([
            "success" => true,
            "html" => $html
        ], 200);
    }

    public function unvanDegistir(Request $request)
    {
        $kullanicilar_id      = decrypt($request->kullanicilar_id);
        $isletme_birimleri_id = decrypt($request->isletme_birimleri_id);
        $unvanlar_id          = decrypt($request->unvanlar_id);

        $kullaniciBirimUnvan = KullaniciBirimUnvan::where('kullanicilar_id', $kullanicilar_id)
            ->where('isletme_birimleri_id', $isletme_birimleri_id)
            ->first();

        $kullaniciBirimUnvan->update([
            'unvanlar_id' => $unvanlar_id
        ]);

        return response()->json([
            "success" => true,
            "message" => "Kullanıcı'nın unvanı başarıyla güncellendi."
        ]);
    }

    public function birimdenCikart(Request $request)
    {
        $kullanicilar_id = decrypt($request->kullanicilar_id);
        $isletme_birimleri_id = decrypt($request->isletme_birimleri_id);

        KullaniciBirimUnvan::where('kullanicilar_id', $kullanicilar_id)
            ->where('isletme_birimleri_id', $isletme_birimleri_id)
            ->delete();

        return response()->json([
            "success" => true,
            "message" => "Kullanıcı'nın birimle ilişiği kaldırıldı."
        ]);
    }

    public function personelGuncelle(Request $request)
    {
        $validated = $request->all();

        $validated['unvanlar_id'] = decrypt($request->unvanlar_id);

        $kullanicilar_id = decrypt($request->kullanicilar_id);

        $kullanici = Kullanici::find($kullanicilar_id);

        $kullanici->update($validated);

        return response()->json([
            "success" => true,
            "message" => "Kullanıcı başarıyla güncellendi."
        ], 200);
    }

    public function personelSil(Request $request)
    {
        $kullanicilar_id = decrypt($request->kullanicilar_id);
        $isletmeler_id   = decrypt($request->isletmeler_id);

        $isletmePersonel = IsletmeYetkili::where('kullanicilar_id', $kullanicilar_id)
            ->where('isletmeler_id', $isletmeler_id)
            ->first();

        $isletmeBirimleri = IsletmeBirim::where('isletmeler_id', $isletmeler_id)->pluck('isletme_birimleri_id');

        KullaniciBirimUnvan::where('kullanicilar_id', $kullanicilar_id)
            ->whereIn('isletme_birimleri_id', $isletmeBirimleri)
            ->delete();

        $isletmePersonel->update([
            'aktiflik' => 0
        ]);

        return response()->json([
            "success" => true,
            "message" => "Kullanıcı başarıyla kaldırıldı."
        ], 200);
    }

    public function davetGonderModalGetir()
    {
        return response()->json([
            "success" => true,
            "html" => view('components.yonetim.kullanicilar.davet-gonder-modal-content')->render()
        ], 200);
    }

    public function mailKontrol(Request $request)
    {
        $mailler = $request->mailler;

        $mailler = trim($mailler, '()');

        $maillerArray = explode(',', $mailler);

        $maillerArray = array_map('trim', $maillerArray);

        $gecerliMailler = [];
        $eduTrMailler = [];

        foreach ($maillerArray as $mail) {
            // E-posta formatını doğrulama
            if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                $gecerliMailler[] = $mail;

                $domain = substr(strrchr($mail, "@"), 1);

                // .edu.tr uzantılı olup olmadığını kontrol etme
                if (substr($domain, -6) === 'edu.tr') { // 'edu.tr' 6 karakter + nokta
                    $eduTrMailler[] = $mail;
                }
            }
        }

        $html = view('components.yonetim.kullanicilar.davet-kontrol-modal-content', [
            'mailler' => $eduTrMailler
        ])->render();

        return response()->json([
            "success" => true,
            "html" => $html
        ], 200);
    }
}
