<?php

namespace App\Http\Controllers;

use App\Http\Requests\EtkinlikRequest;
use App\Models\Etkinlik;
use App\Models\EtkinlikIlDetaylari;
use App\Models\Isletme;
use App\Models\Resim;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EtkinlikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $etkinlikler = Etkinlik::with('il', 'isletme')->paginate(10);

        foreach ($etkinlikler as $etkinlik) {
            // Başlangıç ve bitiş tarihlerini Carbon'a çeviriyoruz
            $baslangicTarihi = \Carbon\Carbon::parse($etkinlik->etkinlikBaslamaTarihi);
            $bitisTarihi     = \Carbon\Carbon::parse($etkinlik->etkinlikBitisTarihi);

            // Örnek format: "06 Ocak 2025 - 10 Ocak 2025, 11:02 - 16:00"
            // Tarih formatı (Türkçe ay adı, gün, yıl)
            $tarihFormat = $baslangicTarihi->translatedFormat('d F')
                . ' - '
                . $bitisTarihi->translatedFormat('d F Y');

            // Saat formatı (24 saat, dakika)
            // Örneğin "11:02" - "16:00"
            $saatFormat = $baslangicTarihi->format('H:i')
                . ' - '
                . $bitisTarihi->format('H:i');

            // Blade'de kolay kullanmak için tek satır string oluşturalım:
            $etkinlik->formatted_date_time = $tarihFormat . ', ' . $saatFormat;
        }

        return view('kullanici.etkinlikler.index', compact('etkinlikler'));
    }


    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(EtkinlikRequest $request)
    {
        try {
            // Transaction ile tüm veritabanı işlemleri tek seferde yönetilir
            return DB::transaction(function () use ($request) {
                // Form Request aracılığıyla doğrulanan verileri alıyoruz
                $validatedData = $request->validated();

                // Boolean alanlar
                $sosyalMedya = $request->boolean('etkinlikSosyalMedyadaPaylas');
                $yorumDurumu = $request->boolean('etkinlikYorumDurumu');

                // ID alanlarını decrypt ediyoruz
                $etkinlikTurId     = decrypt($validatedData['etkinlikTur']);
                $etkinlikIsletmeId = decrypt($validatedData['etkinlikIsletme']);
                $etkinlikIlId      = decrypt($validatedData['etkinlikIl']);

                // İşletme referans kodu -> resimleri doğru klasöre yüklemek için
                $isletme             = Isletme::findOrFail($etkinlikIsletmeId);
                $isletmeReferansKodu = $isletme->referans_kodu;

                // Kapak resmini yüklüyoruz (varsa)
                $kapakResmiYolu = null;
                if ($request->hasFile('etkinlikKapakResmi')) {
                    $kapakResmiYolu = $this->storeSingleImage(
                        $request->file('etkinlikKapakResmi'),
                        $isletmeReferansKodu
                    );
                }

                // Etkinlik kaydı oluştur
                $etkinlik = Etkinlik::create([
                    'etkinlik_turleri_id'        => $etkinlikTurId,
                    'isletmeler_id'              => $etkinlikIsletmeId,
                    'iller_id'                   => $etkinlikIlId,
                    'kontenjan'                  => $validatedData['etkinlikKontenjan'],
                    'etkinlikBasvuruTarihi'      => $validatedData['etkinlikBasvuru'],
                    'etkinlikBasvuruBitisTarihi' => $validatedData['etkinlikBasvuruBitis'],
                    'etkinlikBaslamaTarihi'      => $validatedData['etkinlikBaslangic'],
                    'etkinlikBitisTarihi'        => $validatedData['etkinlikBitis'],
                    'kapakResmiYolu'             => $kapakResmiYolu,
                    'baslik'                     => $validatedData['etkinlikBaslik'],
                    'aciklama'                   => $validatedData['etkinlikAciklama'],
                    'sosyalMedyadaPaylas'        => $sosyalMedya,
                    'yorumDurumu'                => $yorumDurumu,
                ]);

                // Katılım sınırlama (varsa)
                if (!empty($validatedData['katilimSinirlama'])) {
                    foreach ($validatedData['katilimSinirlama'] as $ilId) {
                        $realIlId = decrypt($ilId);
                        EtkinlikIlDetaylari::create([
                            'etkinlikler_id' => $etkinlik->etkinlikler_id,
                            'iller_id'       => $realIlId
                        ]);
                    }
                }

                // Diğer resimleri yükle (varsa)
                if (!empty($validatedData['etkinlikDigerResimler'])) {
                    $this->storeMultipleImages(
                        $validatedData['etkinlikDigerResimler'],
                        $etkinlik->etkinlikler_id,
                        $isletmeReferansKodu
                    );
                }

                // Başarılı sonuç
                return response()->json([
                    'success' => true,
                    'message' => 'Etkinlik başarıyla oluşturuldu.'
                ], 201);
            });
        } catch (\Exception $e) {
            // Herhangi bir hata olursa rollback yapılır ve buraya düşer
            return response()->json([
                'error'   => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Tek bir resmi diske kaydetmek için yardımcı (helper) metod.
     * Geriye yüklenen dosyanın tam yolunu (path) döndürür.
     */
    private function storeSingleImage($image, string $isletmeReferansKodu): string
    {
        // Dosya adı (benzersiz)
        $filename = uniqid() . '.' . $image->getClientOriginalExtension();

        // Dosyayı (storage/app/public/images/{referansKodu}) dizinine kaydet
        // storeAs parametre sırası: (path, filename, disk)
        return $image->storeAs(
            'images/' . $isletmeReferansKodu,
            $filename,
            'public'
        );
    }

    /**
     * Birden fazla resmi diske kaydetmek için yardımcı (helper) metod.
     * Her yükleme sonrası Resim tablosuna kaydeder.
     */
    private function storeMultipleImages(array $imageFiles, int $etkinlikId, string $isletmeReferansKodu)
    {
        foreach ($imageFiles as $image) {
            $path = $this->storeSingleImage($image, $isletmeReferansKodu);
            Resim::resimInsert([
                'etkinlikler_id' => $etkinlikId,
                'resimYolu'      => $path
            ]);
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(EtkinlikRequest $request, string $id)
    {
        try {
            // Tüm veritabanı işlemlerini transaction içinde yapıyoruz
            return DB::transaction(function () use ($request, $id) {
                // ID’yi çözerek ilgili etkinliği bulalım
                $etkinlikId = decrypt($id);
                $etkinlik   = Etkinlik::findOrFail($etkinlikId);

                // Form Request’ten doğrulanmış verileri alıyoruz
                $validatedData = $request->validated();

                // Boolean alanları çekiyoruz
                $sosyalMedya = $request->boolean('etkinlikSosyalMedyadaPaylas');
                $yorumDurumu = $request->boolean('etkinlikYorumDurumu');

                // ID alanlarını decrypt ederek gerçek ID’leri elde ediyoruz
                $etkinlikTurId     = decrypt($validatedData['etkinlikTur']);
                $etkinlikIsletmeId = decrypt($validatedData['etkinlikIsletme']);
                $etkinlikIlId      = decrypt($validatedData['etkinlikIl']);

                // İşletme referans kodu -> resimleri doğru klasöre yüklemek için
                $isletme             = Isletme::findOrFail($etkinlikIsletmeId);
                $isletmeReferansKodu = $isletme->referans_kodu;

                //   Kapak resmini yüklüyoruz (varsa). Yoksa eski resim yolunu koruyoruz
                $kapakResmiYolu = $etkinlik->kapakResmiYolu;
                if ($request->hasFile('etkinlikKapakResmi')) {
                    // İsterseniz storeSingleImage helper’ını burada da kullanabilirsiniz
                    $kapakResmiYolu = $this->storeSingleImage(
                        $request->file('etkinlikKapakResmi'),
                        $isletmeReferansKodu
                    );
                    // // Eski resmi silmek için
                    // Storage::disk('public')->delete($etkinlik->kapakResmiYolu);
                }

                // Form Request’ten gelen verileri güncelliyoruz
                $validatedData['etkinlikler_id']      = 1;
                $validatedData['etkinlik_turleri_id'] = $etkinlikTurId;
                $validatedData['isletmeler_id']       = $etkinlikIsletmeId;
                $validatedData['iller_id']            = $etkinlikIlId;
                $validatedData['sosyalMedyadaPaylas'] = $sosyalMedya;
                $validatedData['yorumDurumu']         = $yorumDurumu;
                $validatedData['etkinlikKapakResmi']  = $kapakResmiYolu;

                // Etkinlik tablosunu güncelliyoruz
                Etkinlik::etkinlikUpdate($validatedData);

                // Eski il detaylarını siliyoruz
                $etkinlik->etkinlikIlDetayi()->delete();

                //   // Katılım sınırlamalarını (varsa) yeniden ekliyoruz
                if (!empty($validatedData['katilimSinirlama'])) {
                    foreach ($validatedData['katilimSinirlama'] as $ilId) {
                        EtkinlikIlDetaylari::etkinlikIlDetayiInsert([
                            'etkinlikler_id' => $etkinlik->etkinlikler_id,
                            'iller_id'       => decrypt($ilId)
                        ]);
                    }
                }

                //   // Diğer resimler güncellemesi (varsa) -> Örneğin:
                if (!empty($validatedData['etkinlikDigerResimler'])) {
                      // storeMultipleImages metodunu kullanarak yükleyebilirsiniz
                    $this->storeMultipleImages(
                        $validatedData['etkinlikDigerResimler'],
                        $etkinlik->etkinlikler_id,
                        $isletmeReferansKodu
                    );
                }

                return response()->json([
                    'success' => true,
                    'message' => $validatedData,
                ], 200);
            });
        } catch (\Exception $e) {
            // Herhangi bir hata oluşursa rollback yapılır ve buraya düşer
            return response()->json([
                'error'   => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
