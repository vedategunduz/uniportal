<?php

namespace App\Http\Controllers\Yonetim;

use App\Http\Controllers\Controller;
use App\Models\BirimTip;
use App\Models\IsletmeBirim;
use App\Models\IsletmeYetkili;
use App\Models\Kullanici;
use App\Models\KullaniciBirimUnvan;
use Illuminate\Http\Request;

class BirimlerController extends Controller
{
    public function index()
    {
        $isletmeler = IsletmeYetkili::aitOldugumIsletmeleriGetir();

        $isletmeBirimleri = IsletmeBirim::isletmeBirimleriGetir($isletmeler);

        $birimYerlesmemisKullanicilarSayisi = KullaniciBirimUnvan::birimeYerlesmemisPersonelSayisi($isletmeler[0]);

        return view('yonetim.birimler.index', compact('isletmeBirimleri', 'birimYerlesmemisKullanicilarSayisi'));
    }

    // ============= duzenle =================
    public function birimeYerlesmemisPersonelSayisi(string $isletmeler_id)
    {
        $isletmeler_id = decrypt($isletmeler_id);

        $birimYerlesmemisKullanicilarSayisi = KullaniciBirimUnvan::birimeYerlesmemisPersonelSayisi($isletmeler_id);

        return response()->json([
            'success' => true,
            'message' => $birimYerlesmemisKullanicilarSayisi
        ], 200);
    }

    public function personelEklemeListesi(string $birimler_id, string $search)
    {
        $isletmeBirimPersonelleri = IsletmeYetkili::birimPersoneller($birimler_id, 143);

        $kullanicilar = Kullanici::whereIn('kullanicilar_id', $isletmeBirimPersonelleri)
            ->where(function ($query) use ($search) {
                $query->where('ad', 'like', '%' . $search . '%')
                    ->orWhere('soyad', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            })
            ->where('aktiflik', '>', 0)
            ->whereNot('kullanicilar_id', 1)
            ->get();

        $data = [
            'kullanicilar' => $kullanicilar,
        ];

        $html = view('components.birimler.personel-ekleme-listesi', $data)->render();

        return response()->json([
            'success' => true,
            'html' => $html
        ], 200);
    }

    public function birimEkle(string $isletmeler_id, Request $request)
    {
        try {
            $isletmeler_id = decrypt($isletmeler_id);

            IsletmeBirim::create([
                'baslik'           => $request->baslik,
                'isletmeler_id'    => $isletmeler_id,
                'birim_tipleri_id' => decrypt($request->birim_tipleri_id),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Birim başarıyla eklendi.'
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Birim eklenirken bir hata oluştu.'
            ], 201);
        }
    }

    public function birimGuncelle(Request $request)
    {
        $isletmeler_id        = decrypt($request->isletmeler_id);
        $birim_tipleri_id     = decrypt($request->birim_tipleri_id);
        $isletme_birimleri_id = decrypt($request->isletme_birimleri_id);

        $isletmeBirimi = IsletmeBirim::findOrFail($isletme_birimleri_id);

        $isletmeBirimi->update([
            'baslik'           => $request->baslik,
            'isletmeler_id'    => $isletmeler_id,
            'birim_tipleri_id' => $birim_tipleri_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Birim başarıyla güncellendi.'
        ], 201);
    }

    public function personelBirimAta(Request $request)
    {
        try {
            foreach ($request->kullanicilar as $kullanici) {

                $kullanici = decrypt($kullanici);
                $kullaniciBilgisi = Kullanici::findOrFail($kullanici);

                KullaniciBirimUnvan::create([
                    'kullanicilar_id' => $kullanici,
                    'isletme_birimleri_id' => decrypt($request->isletme_birimleri_id),
                    'unvanlar_id' => $kullaniciBilgisi->unvanlar_id,
                ]);
            }
            return response()->json([
                'success' => true,
                'message' => 'Kullanıcılar başarıyla birime atandı.'
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Kullanıcı/Birim seçilmedi.'
            ], 201);
        }
    }

    public function modalBirimGoster(string $birimler_id)
    {
        $birimler_id = decrypt($birimler_id);
        $verileryeni = "";

        if ((int) $birimler_id > 0) {
            $verileryeni = IsletmeBirim::findOrFail($birimler_id);
        }

        $data = [
            'veriler' => $verileryeni,
            'birimTurleri' => BirimTip::birimTurleriGetir()
        ];

        $html = view('components.birimler.birim-detay-modal', $data)->render();

        return response()->json([
            'success' => true,
            'html' => $html
        ], 200);
    }

    public function getModalIsletmeKullanicilari(string $id)
    {
        $decryptedId = decrypt($id);

        $data = [
            'birimPersonelleri' => IsletmeBirim::isletmeBirimPersonelBul($decryptedId),
        ];

        $html = view('components.birimler.personel-popover-cart', $data)->render();

        return response()->json([
            'success' => true,
            'html' => $html
        ], 200);
    }

    public function getTable($isletmeler_id)
    {
        $isletmeler = decrypt($isletmeler_id);

        $isletmeBirimleri = IsletmeBirim::isletmeBirimleriGetir([$isletmeler]);

        $data = [];

        foreach ($isletmeBirimleri as $rowBirim) {
            $row = array();

            $row[] = '<div class="flex items-center justify-between gap-4" style="font-size: 14px"><span>' . $rowBirim->isletme_birimleri_id . ' ' . $rowBirim->baslik . '</span><span class="inline-block text-white font-medium me-2 px-2 py-0.5 rounded border ' . $rowBirim->isletmeBirimTipi->CSSClass . ' "  style="font-size:11px">' . $rowBirim->isletmeBirimTipi->baslik . '</span></div>';
            $personelBilgileri = "";
            $birimPersonelleri = (new IsletmeBirim())->isletmeBirimPersonelBul($rowBirim->isletme_birimleri_id);
            $personelBilgileri .= '<div class="flex sm:24 lg:w-96 flex-wrap">';
            foreach ($birimPersonelleri as $rowPersonel) {
                $sifreli_kullanici_birim_unvan_iliskileri_id = encrypt($rowPersonel->kullanici_birim_unvan_iliskileri_id);
                $personelBilgileri .= '<img data-person-id="' . $sifreli_kullanici_birim_unvan_iliskileri_id . '" src="' . $rowPersonel->kullanici->profilFotoUrl . '" class="rounded-full size-9 shadow" alt="" data-popover-target="popover-default_' . $sifreli_kullanici_birim_unvan_iliskileri_id . '">';
                $personelBilgileri .= '
                <div data-popover id="popover-default_' . $sifreli_kullanici_birim_unvan_iliskileri_id . '"
                        role="tooltip"
                        class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:bg-gray-800 dark:border-gray-600">
                        <div class="p-3">
                            <div class="font-semibold leading-none text-gray-900 dark:text-white mb-3" style="font-size: 14px">
                                ' . $rowBirim->baslik . '
                            </div>
                            <div class="flex items-center justify-between mb-2">
                                <a href="#">
                                    <img class="size-14 rounded-full object-contain" src="' . $rowPersonel->kullanici->profilFotoUrl . '"
                                        alt="Jese Leos">
                                </a>
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" value="" class="sr-only peer">
                                    <div
                                        class="relative w-7 h-4 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[\'\'] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-3 after:w-3 after:transition-all peer-checked:bg-blue-600">
                                    </div>
                                    <span class="ms-3 text-sm font-medium text-gray-900 select-none">Yetkili</span>
                                </label>
                            </div>
                            <p class="text-base font-semibold leading-none text-gray-900 dark:text-white">
                                <a
                                    href="#">' . $rowPersonel->kullanici->ad . " " . $rowPersonel->kullanici->soyad . '</a>
                            </p>
                            <p class="mb-3 text-sm font-normal">
                                <a href="#" class="hover:underline">' . $rowPersonel->kullanici->email . '</a>
                            </p>
                            <p class="text-sm text-blue-600">
                                ' . $rowPersonel->unvan->baslik . '
                            </p>
                            <div class="border-t my-2"></div>
                            <div>
                                <button type="button"
                                    onclick="birimdenCikart(`' . encrypt($rowPersonel->kullanici_birim_unvan_iliskileri_id) . '`, 0)"
                                    class="text-white bg-rose-700 hover:bg-rose-800 focus:ring-2 focus:ring-rose-300 font-medium rounded-lg text-xs px-2 py-1">Birimden
                                    çıkart</button>
                                <button type="button" data-modal="modal"
                                    data-id="' . encrypt($rowPersonel->kullanici_birim_unvan_iliskileri_id) . '" data-birimid="0"
                                    class="birimDegistir open-modal text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-2 focus:ring-yellow-400 font-medium rounded-lg text-xs px-2 py-1">Birim
                                    değiştir</button>

                            </div>
                        </div>
                        <div data-popper-arrow></div>
                    </div>
                ';
            }

            $personelBilgileri .= '</div>';
            $row[] = $personelBilgileri;
            $row[] = '
            <button type="button" data-modal="modal" data-id="' . encrypt($rowBirim->isletme_birimleri_id) . '"
                class="open-modal modalBirimGoster bg-yellow-400 text-white p-2 rounded">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-3 pointer-events-none"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" /></svg>
            </button>
            ';
            $row[] = '<button type="button" data-modal="modal" data-id="' . encrypt($rowBirim->isletme_birimleri_id) . '"
                class="open-modal birimSil bg-rose-500 text-white p-2 rounded" title="silme onay kutusunu aç">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-3 pointer-events-none">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>';

            $data[] = $row;
        }

        return response()->json([
            "data" => $data
        ], 200);
    }

    public function personelBirimDegistir(Request $request)
    {
        try {
            KullaniciBirimUnvan::findOrFail(decrypt($request->kullanici_birim_unvan_iliskileri_id))
                ->update([
                    'isletme_birimleri_id' => decrypt($request->isletme_birimleri_id)
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Kullanıcı\'nın birimi değiştirildi.'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error'   => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function birimDegistirmeModalContent(Request $request)
    {
        $islemeler_id = decrypt($request->isletmeler_id);

        $isletmeBirimleri = IsletmeBirim::isletmeBirimleriGetir([$islemeler_id]);

        $kullanici_birim_unvan_iliskileri_id = decrypt($request->kullanici_birim_unvan_iliskileri_id);

        $kullaniciBilgileri = KullaniciBirimUnvan::with('kullanici')
            ->where('kullanici_birim_unvan_iliskileri_id', $kullanici_birim_unvan_iliskileri_id)->first();

        $data = [
            'kullanici_birim_unvan_iliskileri_id' => $request->kullanici_birim_unvan_iliskileri_id,
            'isletmeBirimleri' => $isletmeBirimleri,
            'kullaniciBilgileri' => $kullaniciBilgileri->kullanici
        ];

        $html = view('components.birimler.birim-degistirme-modal-content', $data)->render();

        return response()->json([
            'success' => true,
            'html' => $html
        ], 200);
    }

    public function silmeModalContent(string $birimler_id)
    {
        $birimler_id = decrypt($birimler_id);

        $birim = IsletmeBirim::findOrFail($birimler_id);

        $data = [
            'birim' => $birim
        ];

        $html = view('components.birimler.silme-modal-content', $data)->render();

        return response()->json([
            'success' => true,
            'html' => $html
        ], 200);
    }

    public function birimeYerlesmemisPersonelModalContent(Request $request)
    {
        $islemeler_id = decrypt($request->isletmeler_id);

        $isletmeBirimleri = IsletmeBirim::isletmeBirimleriGetir([$islemeler_id]);

        // $birimYerlesmemisKullanicilar = KullaniciBirimUnvan::birimiOlmayanKullanicilar($islemeler_id)->pluck('kullanicilar_id');

        // $kullanicilar = Kullanici::whereIn('kullanicilar_id', $birimYerlesmemisKullanicilar)->get();

        $data = [
            'isletmeBirimleri' => $isletmeBirimleri,
        ];

        $html = view('components.birimler.birime-yerlesmemis-personel-modal-content', $data)->render();

        return response()->json([
            'success' => true,
            'html' => $html
        ], 200);
    }

    public function birimeYerlesmemisPersoneller(Request $request)
    {
        $islemeler_id = decrypt($request->isletmeler_id);

        $birimYerlesmemisKullanicilar = KullaniciBirimUnvan::birimiOlmayanKullanicilar($islemeler_id)->pluck('kullanicilar_id');

        $kullanicilar = Kullanici::whereIn('kullanicilar_id', $birimYerlesmemisKullanicilar)->get();

        $data = [
            'kullanicilar' => $kullanicilar,
        ];

        $html = view('components.birimler.birime-yerlesmemis-kullanicilar', $data)->render();

        return response()->json([
            'success' => true,
            'html' => $html
        ], 200);
    }

    public function birimSil(Request $request)
    {
        try {
            $isletme_birimleri_id = decrypt($request->isletme_birimleri_id);
            IsletmeBirim::isletmeBirimSil($isletme_birimleri_id);

            return response()->json([
                'success' => true,
                'message' => 'Birim işletmeden kaldırıldı.'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success'   => false,
                'message' => 'Birim silinirken bir hata oluştu.'
            ], 500);
        }
    }

    public function birimPersonelSil(string $id)
    {
        $decryptedId = decrypt($id);
        try {
            KullaniciBirimUnvan::find($decryptedId)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Kullanıcı birimden kaldırıldı.'
            ], 201);
        } catch (\Exception $e) {

        }
    }
}
