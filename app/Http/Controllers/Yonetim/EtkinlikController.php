<?php

namespace App\Http\Controllers\Yonetim;

use App\Http\Controllers\Controller;
use App\Http\Requests\EtkinlikRequest;
use App\Models\Etkinlik;
use App\Models\EtkinlikTur;
use App\Models\Il;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EtkinlikController extends Controller
{
    public function index()
    {
        return view('yonetim.etkinlik.index');
    }

    public function create()
    {
        $etkinlik = null;

        $kategoriler = EtkinlikTur::all();
        $iller = Il::all();

        $html = view('yonetim.etkinlik.ekle-modal', compact(['etkinlik', 'iller', 'kategoriler']))->render();

        return response()->json([
            'success' => true,
            'html'    => $html
        ], 200);
    }

    public function store(EtkinlikRequest $request)
    {
        $validated = $request->validated();

        $validated['etkinlik_turleri_id'] = decrypt($validated['etkinlik_turleri_id']);
        $validated['isletmeler_id'] = decrypt($validated['isletmeler_id']);
        $validated['iller_id'] = decrypt($validated['iller_id']);

        $validated['yorumDurumu']         = $request->has('yorumDurumu');
        $validated['sosyalMedyadaPaylas'] = $request->has('sosyalMedyadaPaylas');
        $validated['mailDurumu']          = $request->has('mailDurumu');

        if ($request->file('kapakResmiYolu')) {
            $resim = $request->file('kapakResmiYolu');
            $folder = 'dosyalar/' . Auth::user()->anaIsletme->referans_kodu . '/' . Auth::user()->kod . '/etkinlik_dosyalari';
            $validated['kapakResmiYolu'] = uploadFile($resim, $folder);
        }

        $etkinlik = Etkinlik::create($validated);

        if ($request->file('dosyalar')) {
            $dosyalar = $request->file('dosyalar');
            $folder = 'dosyalar/' . Auth::user()->anaIsletme->referans_kodu . '/' . Auth::user()->kod . '/etkinlik_dosyalari';

            foreach ($dosyalar as $dosya) {
                $dosya = uploadFile($dosya, $folder);
                $etkinlik->resimler()->create(['dosyaYolu' => $dosya]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Etkinlik başarıyla oluşturuldu.'
        ], 200);
    }

    public function edit($etkinlik_id)
    {
        $etkinlik_id = decrypt($etkinlik_id);
        $etkinlik = Etkinlik::find($etkinlik_id);

        $kategoriler = EtkinlikTur::all();
        $iller = Il::all();

        $html = view('yonetim.etkinlik.ekle-modal', compact(['etkinlik', 'iller', 'kategoriler']))->render();

        return response()->json([
            'success' => true,
            'html'    => $html
        ], 200);
    }

    public function update(string $etkinlik_id, EtkinlikRequest $request)
    {
        $etkinlik_id = decrypt($etkinlik_id);
        $etkinlik = Etkinlik::find($etkinlik_id);

        $validated = $request->validated();

        $validated['etkinlik_turleri_id'] = decrypt($validated['etkinlik_turleri_id']);
        $validated['isletmeler_id']       = decrypt($validated['isletmeler_id']);
        $validated['iller_id']            = decrypt($validated['iller_id']);

        $validated['yorumDurumu']         = $request->has('yorumDurumu');
        $validated['sosyalMedyadaPaylas'] = $request->has('sosyalMedyadaPaylas');
        $validated['mailDurumu']          = $request->has('mailDurumu');

        if ($request->file('kapakResmiYolu')) {
            $resim = $request->file('kapakResmiYolu');
            $folder = 'dosyalar/' . Auth::user()->anaIsletme->referans_kodu . '/' . Auth::user()->kod . '/etkinlik_dosyalari';
            $validated['kapakResmiYolu'] = uploadFile($resim, $folder);
        }

        if ($request->file('dosyalar')) {
            $dosyalar = $request->file('dosyalar');
            $folder = 'dosyalar/' . Auth::user()->anaIsletme->referans_kodu . '/' . Auth::user()->kod . '/etkinlik_dosyalari';

            foreach ($dosyalar as $dosya) {
                $dosya = uploadFile($dosya, $folder);
                $etkinlik->resimler()->create(['dosyaYolu' => $dosya]);
            }
        }

        $etkinlik->update($validated);
        $etkinlik->save();

        return response()->json([
            'success' => true,
            'message' => 'Kampanya başarıyla güncellendi.'
        ], 200);
    }

    public function destroy(string $etkinlik_id)
    {
        $etkinlik_id = decrypt($etkinlik_id);
        $etkinlik = Etkinlik::find($etkinlik_id);

        $etkinlik->aktiflik = 0;
        $etkinlik->save();

        return response()->json([
            'success' => true,
            'message' => 'Kampanya başarıyla silindi.'
        ], 200);
    }

    public function dataTable(string $isletme_id)
    {
        $isletme_id = decrypt($isletme_id);

        $etkinlikler = Etkinlik::where('isletmeler_id', $isletme_id)
        ->where('aktiflik', 1)
        // ->where('etkinlik_turleri_id', '<=', 8)
        ->orderBy('created_at', 'desc')
        ->get();

        $data = [];
        // Etkinlik verilerini satır haline getiriyoruz.
        // Tablo satırlarını birleştiriyoruz.
        foreach ($etkinlikler as $etkinlik) {
            $row    = [];
            $row[]  = "<div class='min-w-12'><img src='$etkinlik->kapakResmiYolu' class='size-12 object-cover mx-auto rounded'></div>";
            $row[]  = '<a class="!text-blue-500 underline" target="_blank" title="' . $etkinlik->baslik . '" href="' . route('yonetim.kampanyalar.show', ['etkinlik_id' => encrypt($etkinlik->etkinlikler_id)]) . '">' . $etkinlik->baslik . '</a>';
            $row[]  = Carbon::parse($etkinlik->etkinlikBaslamaTarihi)->translatedFormat('d M, D Y - H:i') . '-' . Carbon::parse($etkinlik->etkinlikBitisTarihi)->translatedFormat('d M, D Y - H:i');
            $row[]  = '<a href="javascript:void(0)" class="etkinlik-duzenle-modal open-modal" data-id="' . encrypt($etkinlik->etkinlikler_id) . '" data-modal="etkinlik-modal">Düzenle</a>';
            $row[]  = '<a href="javascript:void(0)" class="etkinlik-sil" data-id="' . encrypt($etkinlik->etkinlikler_id) . '">Sil</a>';
            $data[] = $row;
        }
        // Tablo gövdesini gönderiyoruz.
        return response()->json([
            'success' => true,
            'data'    => $data
        ], 200);
    }
}
