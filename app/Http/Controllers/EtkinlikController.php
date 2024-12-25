<?php

namespace App\Http\Controllers;

use App\Models\Etkinlik;
use App\Models\EtkinlikTur;
use App\Models\Yetkili;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EtkinlikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $etkinlikTurleri = EtkinlikTur::select('etkinlik_turleri_id', 'tur')->get();

        // Yetkili olduğu kamuları alıyoruz
        $kamular = Yetkili::where('kullanicilar_id', Auth::user()->kullanicilar_id)
            ->with('kamuBilgileri')
            ->get();

        // Verileri view'e gönderiyoruz
        return view('etkinlik.create', compact(['etkinlikTurleri', 'kamular']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Etkinlik::create([
            'etkinlik_turleri_id' => decrypt($request->etkinlik_turleri_id),
            'kamular_id' => decrypt($request->kamular_id),
            'etkinlik_basvuru_tarihi' => $request->etkinlik_basvuru_tarihi,
            'etkinlik_basvuru_bitis_tarihi' => $request->etkinlik_basvuru_bitis_tarihi,
            'etkinlik_baslama_tarihi' => $request->etkinlik_baslama_tarihi,
            'etkinlik_bitis_tarihi' => $request->etkinlik_bitis_tarihi,
            'aciklama' => $request->aciklama,
        ]);

        return redirect()->route('etkinlik.ekle.create')->with('success', 'Etkinlik başarıyla eklendi.');
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
