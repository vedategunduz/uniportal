<?php

namespace App\Http\Controllers\Yonetim;

use App\Http\Requests\EtkinlikRequest;
use App\Models\Etkinlik;
use App\Models\Isletme;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\DosyaRequest;
use App\Models\Dosya;
use App\Models\EtkinlikDosya;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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
                'galeri' => $etkinlik->galeri
            ];
        }
        // Etkinlik modal içeriğini oluşturuyoruz.
        $modal_content = view('components.etkinlik.etkinlik-modal-content', $data)->render();
        // $modal_galeri = view('components.etkinlik.etkinlik-modal-galeri-resimleri', $data)->render();
        // Modal içeriğini döndürüyoruz.
        return response()->json([
            'success' => true,
            'html'    => $modal_content,
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
            // Yorum durumu ve sosyal medyada paylaşım durumunu kontrol ediyoruz.
            $validatedData['yorumDurumu']         = $request->has('yorumDurumu');
            $validatedData['sosyalMedyadaPaylas'] = $request->has('sosyalMedyadaPaylas');
            // İşlemi başlatıyoruz.
            DB::transaction(function () use ($request, $validatedData, $imageService) {
                // Etkinlik ekleme işlemi
                $etkinlik = Etkinlik::ekle($validatedData);
                // İşletme id'sinin şifresini çözüyoruz.
                $isletmeler_id = decrypt($validatedData['isletmeler_id']);
                // İşletme referans kodunu alıyoruz.
                $isletmeReferansKodu =  Isletme::referans_kodu($isletmeler_id);
                // Eğer etkinliğe ait galeri resimleri yüklendi ise
                if (!empty($request->file('resimYolu'))) {
                    // Etkinlik galeri resimlerini yükleme işlemi
                    $images = $request->file('resimYolu');
                    // Resimleri yüklüyoruz ve yollarını alıyoruz.
                    $paths = $imageService->storeMultipleImages($images, $isletmeReferansKodu);
                    // Etkinlik galeri resimlerini kaydetme işlemi
                    $etkinlik->galeri()->createMany($paths);
                }
                // Eğer etkinliğe kapak resmi yüklendi ise
                if (!empty($request->file('kapakResmiYolu'))) {
                    // Etkinlik resmini yükleme işlemi
                    $image = $request->file('kapakResmiYolu');
                    // Resmi yüklüyoruz ve yolu alıyoruz.
                    $path = $imageService->storeSingleImage($image, $isletmeReferansKodu);
                    // Etkinlik resmi yolu güncelleme işlemi
                    $etkinlik->update([
                        'kapakResmiYolu' => $path
                    ]);
                    // Etkinlik verisini kaydediyoruz.
                    $etkinlik->save();
                }
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

    /**
     * Etkinlik güncelleme işlemi
     * Etkinlik id'si request içerisinde şifrelenmiş olarak gelir.
     * @param EtkinlikRequest $request
     * @return JsonResponse
     */
    public function update(EtkinlikRequest $request)
    {
        try {
            // Resim ekleme işlemi için ImageUploadService sınıfını kullanıyoruz.
            $imageService = $this->imageService;
            // Gelen veriyi doğruluyoruz.
            $validatedData = $request->validated();
            // Yorum durumu ve sosyal medyada paylaşım durumunu kontrol ediyoruz.
            $validatedData['yorumDurumu']         = $request->has('yorumDurumu');
            $validatedData['sosyalMedyadaPaylas'] = $request->has('sosyalMedyadaPaylas');
            // Şifreli idleri çözüyoruz.
            $validatedData['etkinlikler_id']      = decrypt($request->etkinlikler_id);
            $validatedData['iller_id']            = decrypt($validatedData['iller_id']);
            $validatedData['isletmeler_id']       = decrypt($validatedData['isletmeler_id']);
            $validatedData['etkinlik_turleri_id'] = decrypt($validatedData['etkinlik_turleri_id']);
            // İşlemi başlatıyoruz.
            DB::transaction(function () use ($request, $validatedData, $imageService) {
                // Etkinlik verisini çekiyoruz.
                $etkinlik = Etkinlik::findOrFail($validatedData['etkinlikler_id']);
                // Etkinlik güncelleme işlemi
                $etkinlik->update($validatedData);
                // İşletme referans kodunu alıyoruz.
                $isletmeReferansKodu =  Isletme::referans_kodu($validatedData['isletmeler_id']);
                // Eğer resim yüklendi ise
                if ($request->hasFile('kapakResmiYolu')) {
                    // Etkinlik resmini yükleme işlemi
                    $image = $request->file('kapakResmiYolu');
                    // Resmi yüklüyoruz ve yolu alıyoruz.
                    $path = $imageService->storeSingleImage($image, $isletmeReferansKodu);
                    // Etkinlik resmi yolu güncelleme işlemi
                    $etkinlik->update([
                        'kapakResmiYolu' => $path
                    ]);
                }
                // Eğer etkinliğe ait galeri resimleri yüklendi ise
                if (!empty($request->file('resimYolu'))) {
                    // Etkinlik galeri resimlerini yükleme işlemi
                    $images = $request->file('resimYolu');
                    // Resimleri yüklüyoruz ve yollarını alıyoruz.
                    $paths = $imageService->storeMultipleImages($images, $isletmeReferansKodu);
                    // Etkinlik galeri resimlerini kaydetme işlemi
                    $etkinlik->galeri()->createMany($paths);
                }
                // Etkinlik verisini kaydediyoruz.
                $etkinlik->save();
            });
            // Başarılı bir şekilde kaydedildiğinde mesaj döndürülür.
            return response()->json([
                'success' => true,
                'message' => 'Etkinlik başarıyla güncellendi.'
            ], 200);
        } catch (\Throwable $th) {
            // Hata oluştuğunda loglama işlemi yapılır.
            Log::error($th);
            // Hata mesajı döndürülür.
            return response()->json([
                'success' => false,
                'message' => 'Etkinlik güncellenirken bir hata oluştu.'
            ], 500);
        }
    }

    public function getDataTableDatas(string $isletmeler_id)
    {
        // İşletme id'sini çözüyoruz.
        // $decryptedId = decrypt($isletmeler_id);
        $decryptedId = decrypt($isletmeler_id);
        // Etkinlik verilerini çekiyoruz.
        $etkinlikler = Etkinlik::where('isletmeler_id', $decryptedId)->where('aktiflik', 1)->where('etkinlik_turleri_id', '<=', 8)->orderBy('created_at', 'desc')->get();
        // Tablo satırı değişkeni
        $data = [];
        // Etkinlik verilerini satır haline getiriyoruz.
        // Tablo satırlarını birleştiriyoruz.
        foreach ($etkinlikler as $etkinlik) {
            $row = [];
            $row[] = '<p class="w-48 text-wrap">' . $etkinlik->baslik . '</p>';
            $row[] = Carbon::parse($etkinlik->etkinlikBasvuruTarihi)->translatedFormat('d M, D Y - H:i') . '<br>' . Carbon::parse($etkinlik->etkinlikBasvuruBitisTarihi)->translatedFormat('d M, D Y - H:i');
            $row[] = Carbon::parse($etkinlik->etkinlikBaslamaTarihi)->translatedFormat('d M, D Y - H:i') . '<br>' . Carbon::parse($etkinlik->etkinlikBitisTarihi)->translatedFormat('d M, D Y - H:i');
            $row[] = view('components.buttons.events.duzenle-button', ['etkinlikler_id' => $etkinlik->etkinlikler_id])->render();
            $row[] = view('components.buttons.events.sil-button', ['etkinlikler_id' => $etkinlik->etkinlikler_id])->render();
            $data[] = $row;
        }
        // Tablo gövdesini gönderiyoruz.
        return response()->json([
            'success' => true,
            'data'    => $data
        ], 200);
    }

    public function silmeModalGetir(string $etkinlik_id)
    {
        // Etkinlik id'sini çözüyoruz.
        $decryptedId = decrypt($etkinlik_id);
        // Etkinlik verisini çekiyoruz.
        $etkinlik = Etkinlik::findOrFail($decryptedId);
        // Veriyi diziye atıyoruz.
        $data = [
            'etkinlik' => $etkinlik
        ];
        // Etkinlik silme modal içeriğini oluşturuyoruz.
        $html = view('components.etkinlik.etkinlik-silme-modal-content', $data)->render();
        // Modal içeriğini döndürüyoruz.
        return response()->json([
            'success' => true,
            'html'    => $html,
        ], 200);
    }

    public function etkinlikSil(Request $request)
    {
        try {
            // Etkinlik id'sini çözüyoruz.
            $decryptedId = decrypt($request->etkinlikler_id);
            // Etkinlik verisini çekiyoruz.
            $etkinlik = Etkinlik::findOrFail($decryptedId);
            // Etkinlik aktiflik durumunu 0 yapıyoruz.
            $etkinlik->update([
                'aktiflik' => 0
            ]);
            // Etkinlik verisini kaydediyoruz.
            $etkinlik->save();
            // // Etkinlik galeri resimlerini silme işlemi
            // $etkinlik->galeri()->delete();
            // // Etkinlik verisini silme işlemi
            // $etkinlik->delete();
            // Başarılı bir şekilde silindiğinde mesaj döndürülür.
            return response()->json([
                'success' => true,
                'message' => 'Etkinlik başarıyla silindi.'
            ], 200);
        } catch (\Throwable $th) {
            // Hata oluştuğunda loglama işlemi yapılır.
            Log::error($th);
            // Hata mesajı döndürülür.
            return response()->json([
                'success' => false,
                'message' => 'Etkinlik silinirken bir hata oluştu.'
            ], 500);
        }
    }

    public function dosyaYukle(DosyaRequest $request)
    {
        $dosya = $request->file('dosya');

        $dosyaAdi = $dosya->getClientOriginalName();

        $dosyaYolu = uploadFile($dosya, "dosyalar/etkinlik_dosyalari/" . Auth::user()->kod);

        Dosya::create([
            'dosya_adi' => $dosyaAdi,
            'dosya_yolu' => $dosyaYolu
        ]);

        return response()->json([
            'success' => true,
            'url' => $dosyaYolu
        ], 201);
    }
}
