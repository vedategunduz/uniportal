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
        $etkinlik_turleri = EtkinlikTur::all();


        // $kamular = Yetkili::where('kullanicilar_id', Auth::user()->kullanicilar_id)
        //     ->with('YetkiliOlduguKamular')
        //     ->get();

        // Yetkili olduğu kamuları alıyoruz
        $kamular = Yetkili::Deneme();

        // Verileri view'e gönderiyoruz
        return view('auth.etkinlik-ekle', compact(['etkinlik_turleri', 'kamular']));
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

        return redirect()->route('etkinlik_ekleme_sayfasi')->with('success', 'Etkinlik başarıyla eklendi.');
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
