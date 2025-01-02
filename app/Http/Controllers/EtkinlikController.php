<?php

namespace App\Http\Controllers;

use App\Models\Etkinlik;
use App\Models\EtkinlikIlDetaylari;
use App\Models\Isletme;
use App\Models\Resim;
use Illuminate\Http\Request;

class EtkinlikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('etkinlikler.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('etkinlik.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $sosyalMedya = $request->boolean('etkinlikSosyalMedyadaPaylas');
            $yorumDurumu = $request->boolean('etkinlikYorumDurumu');

            if ($request->hasFile('etkinlikKapakResmi')) {
                $image = $request->file('etkinlikKapakResmi');

                // İşletme referans kodunu çekme
                $isletmeId = decrypt($request->etkinlikIsletme);
                $isletmeReferansKodu = Isletme::find($isletmeId)->referans_kodu;

                // Dosya adını benzersiz yapmak için
                $name = time() . '_' . uniqid() . '_' . $image->getClientOriginalName();

                // Dosyayı belirli bir işletme referans kodu klasörüne kaydet
                $path = $image->storeAs('images/' . $isletmeReferansKodu, $name, 'public');
            }

            $etkinlik = Etkinlik::create([
                'etkinlik_turleri_id' => decrypt($request->etkinlikTur),
                'isletmeler_id' => decrypt($request->etkinlikIsletme),
                'iller_id' => decrypt($request->etkinlikIl),
                'kontenjan' => $request->etkinlikKontenjan,
                'etkinlikBasvuruTarihi' => $request->etkinlikBasvuru,
                'etkinlikBasvuruBitisTarihi' => $request->etkinlikBasvuruBitis,
                'etkinlikBaslamaTarihi' => $request->etkinlikBaslangic,
                'etkinlikBitisTarihi' => $request->etkinlikBitis,
                'kapakResmiYolu' => $path ?? null,
                'baslik' => $request->etkinlikBaslik,
                'aciklama' => $request->etkinlikAciklama,
                'sosyalMedyadaPaylas' => $sosyalMedya,
                'yorumDurumu' => $yorumDurumu,
            ]);

            if ($request->has('katilimSinirlama')) {
                try {
                    foreach ($request->katilimSinirlama as $iller) {
                        EtkinlikIlDetaylari::create([
                            'etkinlikler_id' => $etkinlik->etkinlikler_id,
                            'iller_id' => decrypt($iller)
                        ]);
                    }
                } catch (\Exception $e) {
                    return response()->json(['error', 'İl detayları eklenirken bir sorun oluştu: ' . $e->getMessage()]);
                }
            }

            if ($request->hasFile('etkinlikDigerResimler')) {

                $isletmeReferansKodu = Isletme::select('referans_kodu')->find(decrypt($request->etkinlikIsletme));

                foreach ($request->file('etkinlikDigerResimler') as $image) {
                    $name = time() . '_' . uniqid() . '_' . $image->getClientOriginalName();
                    // Dosyayı 'public/images' dizinine kaydet
                    $path = $image->storeAs('images/' . $isletmeReferansKodu, $name, 'public');

                    Resim::create([
                        'etkinlikler_id' => $etkinlik->etkinlikler_id,
                        'resimYolu' => $path
                    ]);
                }
            }

            return response()->json(['success' => 'Etkinlik oluşturuldu.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $id = decrypt($id);

            $sosyalMedya = $request->boolean('etkinlikSosyalMedyadaPaylas');
            $yorumDurumu = $request->boolean('etkinlikYorumDurumu');

            if ($request->hasFile('etkinlikKapakResmi')) {
                $image = $request->file('etkinlikKapakResmi');

                // İşletme referans kodunu çekme
                $isletmeId = decrypt($request->etkinlikIsletme);
                $isletmeReferansKodu = Isletme::find($isletmeId)->referans_kodu;

                // Dosya adını benzersiz yapmak için
                $name = time() . '_' . uniqid() . '_' . $image->getClientOriginalName();

                // Dosyayı belirli bir işletme referans kodu klasörüne kaydet
                $path = $image->storeAs('images/' . $isletmeReferansKodu, $name, 'public');
            }

            $etkinlik = Etkinlik::find($id);

            $etkinlik->update([
                'etkinlik_turleri_id' => decrypt($request->etkinlikTur),
                'isletmeler_id' => decrypt($request->etkinlikIsletme),
                'iller_id' => decrypt($request->etkinlikIl),
                'kontenjan' => $request->etkinlikKontenjan,
                'etkinlikBasvuruTarihi' => $request->etkinlikBasvuru,
                'etkinlikBasvuruBitisTarihi' => $request->etkinlikBasvuruBitis,
                'etkinlikBaslamaTarihi' => $request->etkinlikBaslangic,
                'etkinlikBitisTarihi' => $request->etkinlikBitis,
                'baslik' => $request->etkinlikBaslik,
                'aciklama' => $request->etkinlikAciklama,
                'sosyalMedyadaPaylas' => $sosyalMedya,
                'yorumDurumu' => $yorumDurumu,
            ]);

            $etkinlik->kapakResmiYolu = $path ?? $etkinlik->kapakResmiYolu;

            $etkinlik->save();

            // if ($request->hasFile('etkinlikDigerResimler')) {

            //     $isletmeReferansKodu = Isletme::select('referans_kodu')->find(decrypt($request->etkinlikIsletme));

            //     foreach ($request->file('etkinlikDigerResimler') as $image) {
            //         $name = time() . '_' . uniqid() . '_' . $image->getClientOriginalName();
            //         // Dosyayı 'public/images' dizinine kaydet
            //         $path = $image->storeAs('images/' . $isletmeReferansKodu, $name, 'public');

            //         Resim::create([
            //             'etkinlikler_id' => $etkinlik->etkinlikler_id,
            //             'resimYolu' => $path
            //         ]);
            //     }
            // }

            return response()->json(['success' => 'Etkinlik güncellendi.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
