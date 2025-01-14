<?php

namespace App\Http\Controllers;

use App\Http\Requests\EtkinlikRequest;
use App\Models\Etkinlik;
use App\Models\Isletme;
use App\Services\ImageUploadService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EventController extends Controller
{
    protected $imageService;

    public function __construct(ImageUploadService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index()
    {
        return view('yonetim.etkinlik.index');
    }
    /**
     * Etkinlik modal içeriğini getirir.
     * @param string $id
     * @return JsonResponse
     */
    public function modalGetir(string $id)
    {
        // Etkinlik id'sini çözüyoruz.
        $decryptedId = decrypt($id);
        // Veri değişkeni
        $data = [];
        // Eğer id 0 değilse etkinlik verisini çekiyoruz.
        if ($decryptedId != 0) {
            // Etkinlik verisini çekiyoruz.
            $etkinlik = Etkinlik::findOrFail($decryptedId);
            // Veriyi diziye atıyoruz.
            $data = [
                'etkinlik' => $etkinlik,
            ];
        }
        // Etkinlik modal içeriğini oluşturuyoruz.
        $html = view('components.etkinlik.etkinlik-modal-content', $data)->render();
        // Modal içeriğini döndürüyoruz.
        return response()->json([
            'success' => true,
            'html'    => $html
        ], 200);
    }
    /**
     * Etkinlik ekleme işlemi
     * @param EtkinlikRequest $request
     * @return JsonResponse
     */
    public function store(EtkinlikRequest $request)
    {
        try {
            // Resim ekleme işlemi için ImageUploadService sınıfını kullanıyoruz.
            $imageService = $this->imageService;
            // Gelen veriyi doğruluyoruz.
            $validatedData = $request->validated();
            // İşlemi başlatıyoruz.
            DB::transaction(function () use ($request, $validatedData, $imageService) {
                // Etkinlik ekleme işlemi
                $etkinlik = Etkinlik::ekle($validatedData);
                // Etkinlik resmini yükleme işlemi
                $image = $request->file('kapakResmiYolu');
                // İşletme id'sinin şifresini çözüyoruz.
                $isletmeler_id = decrypt($validatedData['isletmeler_id']);
                // İşletme referans kodunu alıyoruz.
                $isletmeReferansKodu =  Isletme::referans_kodu($isletmeler_id);
                // Resmi yüklüyoruz ve yolu alıyoruz.
                $path = $imageService->storeSingleImage($image, $isletmeReferansKodu);
                // Etkinlik resmi yolu güncelleme işlemi
                $etkinlik->update([
                    'kapakResmiYolu' => $path
                ]);

                $etkinlik->save();
            });
            // Başarılı bir şekilde kaydedildiğinde mesaj döndürülür.
            return response()->json([
                'success' => true,
                'message' => 'Etkinlik başarıyla kaydedildi.'
            ], 201);
        } catch (\Throwable $th) {
            // Hata oluştuğunda loglama işlemi yapılır.
            Log::error($th);
            // Hata mesajı döndürülür.
            return response()->json([
                'success' => false,
                'message' => 'Etkinlik kaydedilirken bir hata oluştu.'
            ], 500);
        }
    }

    public function getDataTableDatas()
    {
        // İşletme id'sini çözüyoruz.
        // $decryptedId = decrypt($isletmeler_id);
        $decryptedId = 143;
        // Etkinlik verilerini çekiyoruz.
        $etkinlikler = Etkinlik::where('isletmeler_id', $decryptedId)->get();
        // Tablo satırı değişkeni
        $data = [];
        // Etkinlik verilerini satır haline getiriyoruz.
        // Tablo satırlarını birleştiriyoruz.
        foreach ($etkinlikler as $etkinlik) {
            $row = [];
            $row[] = '<p class="w-48 text-wrap">' . $etkinlik->baslik . '</p>';
            $row[] = $etkinlik->kontenjan;
            $row[] = $etkinlik->etkinlikBasvuruTarihi;
            $row[] = $etkinlik->etkinlikBasvuruBitisTarihi;
            $row[] = $etkinlik->etkinlikBaslamaTarihi;
            $row[] = $etkinlik->etkinlikBitisTarihi;
            $row[] = view('components.buttons.events.duzenle-button', ['etkinlikler_id' => $etkinlik->etkinlikler_id])->render();
            $row[] = 'silme butonu';
            $data[] = $row;
        }
        // Tablo gövdesini gönderiyoruz.
        return response()->json([
            'success' => true,
            'data'    => $data
        ], 200);
    }
}
