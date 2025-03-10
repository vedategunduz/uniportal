<?php

namespace App\Http\Controllers\Yonetim;

use App\Http\Controllers\Controller;
use App\Http\Requests\ZiyaretRequest;
use App\Models\Etkinlik;
use App\Models\Isletme;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ToplantiController extends Controller
{
    public function index()
    {
        return view('yonetim.toplanti.index');
    }

    public function show($etkinlik_id)
    {
        $etkinlik_id = decrypt($etkinlik_id);
        $etkinlik = Etkinlik::find($etkinlik_id);

        return view('yonetim.kampanya.detay', compact('etkinlik'));
    }

    public function create()
    {
        $etkinlik = null;

        $tum_isletmeler = Isletme::where('aktiflik', 1)->get();

        $html = view('yonetim.toplanti.ekle-modal', compact('etkinlik', 'tum_isletmeler'))->render();

        return response()->json([
            'success' => true,
            'html'    => $html
        ], 200);
    }

    public function store(ZiyaretRequest $request)
    {
        $validated = $request->validated();

        $validated['etkinlik_turleri_id'] = decrypt($validated['etkinlik_turleri_id']);
        $validated['isletmeler_id'] = decrypt($validated['isletmeler_id']);

        $validated['yorumDurumu']         = $request->has('yorumDurumu');
        $validated['sosyalMedyadaPaylas'] = $request->has('sosyalMedyadaPaylas');
        $validated['mailDurumu']          = $request->has('mailDurumu');
        $validated['kod']                 = uniqid();

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
            'message' => 'Kampanya başarıyla oluşturuldu.'
        ], 200);
    }

    public function edit($etkinlik_id)
    {
        $etkinlik_id = decrypt($etkinlik_id);
        $etkinlik = Etkinlik::find($etkinlik_id);

        $html = view('yonetim.kampanya.ekle-modal', compact('etkinlik'))->render();

        return response()->json([
            'success' => true,
            'html'    => $html
        ], 200);

        // return view('yonetim.kampanya.ekle', compact('etkinlik'));
    }

    public function update(string $etkinlik_id, ZiyaretRequest $request)
    {
        $etkinlik_id = decrypt($etkinlik_id);
        $etkinlik = Etkinlik::find($etkinlik_id);

        $validated = $request->validated();

        $validated['etkinlik_turleri_id'] = decrypt($validated['etkinlik_turleri_id']);
        $validated['isletmeler_id'] = decrypt($validated['isletmeler_id']);

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
        // return redirect()->back()->with('success', 'Kampanya başarıyla güncellendi.');
        // return redirect()->route('yonetim.kampanyalar.show', ['etkinlik_id' => encrypt($etkinlik->etkinlikler_id)])->with('success', 'Kampanya başarıyla güncellendi.');
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

        $toplantilar = Etkinlik::where('isletmeler_id', $isletme_id)
            ->where('aktiflik', 1)
            ->where('etkinlik_turleri_id', 13)
            ->orderBy('created_at', 'desc')
            ->get();

        $data = [];
        // Etkinlik verilerini satır haline getiriyoruz.
        // Tablo satırlarını birleştiriyoruz.
        foreach ($toplantilar as $etkinlik) {
            $gidenler = $etkinlik->katilimcilar->where('katilimciTipi', 'giden');
            $gidilenler = $etkinlik->katilimcilar->where('katilimciTipi', 'gidilen');
            $row    = [];

            $row[]  = '<a class="!text-blue-500" target="_blank" href="#">' . $etkinlik->gidilenIsletme->baslik . '</a>';
            $row[]  = '<a title="' . $etkinlik->baslik . '" href="#">' . $etkinlik->baslik . '</a>';
            $row[]  = Carbon::parse($etkinlik->etkinlikBaslamaTarihi)->translatedFormat('d M, D Y - H:i') . '-' . Carbon::parse($etkinlik->etkinlikBitisTarihi)->translatedFormat('d M, D Y - H:i');
            $row[] = view('yonetim.toplanti.partials.avatar', ['kullanicilar' => $gidenler])->render();
            $row[] = view('yonetim.toplanti.partials.avatar', ['kullanicilar' => $gidilenler])->render();
            $row[]  = '<a href="javascript:void(0)" class="inline-flex p-2 bg-orange-400 text-xs !text-white rounded kampanya-duzenle-modal open-modal" data-id="' . encrypt($etkinlik->etkinlikler_id) . '" data-modal="etkinlik-modal"><i class="bi bi-pencil-square"></i></a>';
            $row[]  = '<a href="javascript:void(0)" class="inline-flex p-2 bg-gs-red text-xs !text-white rounded kampanya-sil" data-id="' . encrypt($etkinlik->etkinlikler_id) . '"><i class="bi bi-trash3"></i></a>';

            $data[] = $row;
        }
        // Tablo gövdesini gönderiyoruz.
        return response()->json([
            'success' => true,
            'data'    => $data
        ], 200);
    }
}
