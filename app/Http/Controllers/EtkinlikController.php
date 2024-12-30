<?php

namespace App\Http\Controllers;

use App\Models\Etkinlik;
use App\Models\Resim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
                // Dosya adını benzersiz yapmak için
                $name = time() . '_' . uniqid() . '_' . $image->getClientOriginalName();

                // Dosyayı 'public/images' dizinine kaydet
                $path = $image->storeAs('images', $name, 'public');
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

            if($request->hasFile('etkinlikDigerResimler')) {
                foreach($request->file('etkinlikDigerResimler') as $image) {
                    $name = time() . '_' . uniqid() . '_' . $image->getClientOriginalName();
                    // Dosyayı 'public/images' dizinine kaydet
                    $path = $image->storeAs('images', $name, 'public');

                    Resim::create([
                        'etkinlikler_id' => $etkinlik->etkinlikler_id,
                        'resimYolu' => $path
                    ]);
                }
            }

            return response()->json(['success' => 1]);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
