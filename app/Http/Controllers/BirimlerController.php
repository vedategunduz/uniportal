<?php

namespace App\Http\Controllers;

use App\Models\BirimTip;
use App\Models\IsletmeBirim;
use App\Models\IsletmeYetkili;
use App\Models\KullaniciBirimUnvan;
use Illuminate\Http\Request;

class BirimlerController extends Controller
{
    public function index()
    {
        $isletmeler = IsletmeYetkili::isletmeKullanicilariGetir();

        $isletmeBirimleri = IsletmeBirim::isletmeBirimleriGetir($isletmeler);

        return view('yonetim.birimler.index', compact('isletmeBirimleri'));
    }

    public function getModal(string $id)
    {
        $decryptedId = decrypt($id);
        $verileryeni = "";

        if ((int) $decryptedId > 0) {
            $verileryeni = IsletmeBirim::findOrFail($decryptedId);
        }

        $data = [
            'veriler' => $verileryeni,
            'birimTurleri' => BirimTip::birimTurleriGetir()
        ];

        $html = view('yonetim.birimler.components.birim-detay-modal', $data)->render();

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

        $html = view('yonetim.birimler.components.personel-popover-cart', $data)->render();

        return response()->json([
            'success' => true,
            'html' => $html
        ], 200);
    }

    public function getTable()
    {
        $isletmeler = IsletmeYetkili::isletmeKullanicilariGetir();

        $isletmeBirimleri = IsletmeBirim::isletmeBirimleriGetir($isletmeler);

        foreach ($isletmeBirimleri as $rowBirim) {
            $row = array();

            $row[] = '<div class="flex items-center justify-between gap-4"><span>'.$rowBirim->baslik.'</span><span class="inline-block text-white font-medium me-2 px-2 py-0.5 rounded border '. $rowBirim->isletmeBirimTipi->CSSClass .' "  style="font-size:11px">' . $rowBirim->isletmeBirimTipi->baslik . '</span></div>';
            $personelBilgileri = "";
            $birimPersonelleri = (new IsletmeBirim())->isletmeBirimPersonelBul($rowBirim->isletme_birimleri_id);
            $personelBilgileri .= '<div class="flex sm:24 lg:w-96 flex-wrap">';
            foreach ($birimPersonelleri as $rowPersonel) {
                $sifreli_kullanici_birim_unvan_iliskileri_id = encrypt($rowPersonel->kullanici_birim_unvan_iliskileri_id);
                $personelBilgileri .= '<img data-person-id="' . $sifreli_kullanici_birim_unvan_iliskileri_id . '" src="' . $rowPersonel->kullanici->profilFotoUrl . '" class="rounded-full size-10 shadow" alt="" data-popover-target="popover-default_' . $sifreli_kullanici_birim_unvan_iliskileri_id . '">';
                $personelBilgileri .= '
                <div data-popover id="popover-default_' . $sifreli_kullanici_birim_unvan_iliskileri_id . '"
                        role="tooltip"
                        class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:bg-gray-800 dark:border-gray-600">
                        <div class="p-3">
                            <div class="text-sm font-semibold leading-none text-gray-900 dark:text-white mb-3">
                                ' . $rowBirim->baslik . '
                            </div>
                            <div class="flex items-center justify-between mb-2">
                                <a href="#">
                                    <img class="size-14 rounded-full" src="' . $rowPersonel->kullanici->profilFotoUrl . '"
                                        alt="Jese Leos">
                                </a>
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" value="" class="sr-only peer">
                                    <div
                                        class="relative w-7 h-4 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[``] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-3 after:w-3 after:transition-all peer-checked:bg-blue-600">
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
                                <button type="button" data-modal="birimDegistir"
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
            <button type="button" data-modal="birimDetay" data-id="' . encrypt($rowBirim->isletme_birimleri_id) . '"
                class="open-modal birimDuzenle bg-yellow-400 text-white p-2 rounded">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-3 pointer-events-none"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" /></svg>
            </button>
            ';
            $row[] = '<button type="button" data-modal="confirmModal" data-id="' . encrypt($rowBirim->isletme_birimleri_id) . '"
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

    public function change(Request $request)
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

    public function birimSil(Request $request)
    {
        $id = decrypt($request->silme_hidden_isletme_birimleri_id);

        try {
            IsletmeBirim::isletmeBirimSil($id);

            return response()->json([
                'success' => true,
                'message' => 'Birim işletmeden kaldırıldı.'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error'   => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        $decryptedId = decrypt($id);
        try {
            KullaniciBirimUnvan::findOrFail($decryptedId)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Kullanıcı birimden kaldırıldı.'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error'   => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
