<?php

namespace App\Http\Controllers\Yonetim;

use App\Http\Controllers\Controller;
use App\Http\Requests\KampanyaRequest;
use App\Models\Dosya;
use App\Models\Etkinlik;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class KampanyaController extends Controller
{
    public function index()
    {
        return view('yonetim.kampanya.index');
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

        $html = view('yonetim.kampanya.ekle-modal', compact('etkinlik'))->render();

        return response()->json([
            'success' => true,
            'html'    => $html
        ], 200);

        // return view('yonetim.kampanya.ekle', compact('etkinlik'));
    }

    public function store(KampanyaRequest $request)
    {
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

        $etkinlik = Etkinlik::create($validated);

        $dosyalar = Dosya::where('islem_yapan_id', Auth::id())->get();
        $dosyalar->each->delete();

        $etkinlik->resimler()->createMany($dosyalar->toArray());

        return redirect()->route('yonetim.kampanyalar.show', compact('etkinlik'))->with('success', 'Kampanya başarıyla eklendi.');
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

    public function update(string $etkinlik_id, KampanyaRequest $request)
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

        $etkinlik->update($validated);
        $etkinlik->save();

        $dosyalar = Dosya::where('islem_yapan_id', Auth::id())->get();
        $dosyalar->each->delete();

        $etkinlik->resimler()->createMany($dosyalar->toArray());

        return response()->json([
            'success' => true,
            'message' => 'Kampanya başarıyla güncellendi.'
        ], 200);
        // return redirect()->back()->with('success', 'Kampanya başarıyla güncellendi.');
        // return redirect()->route('yonetim.kampanyalar.show', ['etkinlik_id' => encrypt($etkinlik->etkinlikler_id)])->with('success', 'Kampanya başarıyla güncellendi.');
    }

    public function dataTable(string $isletme_id)
    {
        $isletme_id = decrypt($isletme_id);

        $kampanyalar = Etkinlik::where('isletmeler_id', $isletme_id)->where('aktiflik', 1)->orderBy('created_at', 'desc')->get();

        $data = [];
        // Etkinlik verilerini satır haline getiriyoruz.
        // Tablo satırlarını birleştiriyoruz.
        foreach ($kampanyalar as $etkinlik) {
            $row = [];
            $row[] = "<img src='$etkinlik->kapakResmiYolu' class='w-12 rounded'>";
            $row[] = '<p class="w-48 text-wrap">' . $etkinlik->baslik . '</p>';
            $row[] = Carbon::parse($etkinlik->etkinlikBaslamaTarihi)->translatedFormat('d M, D Y - H:i') . '<br>' . Carbon::parse($etkinlik->etkinlikBitisTarihi)->translatedFormat('d M, D Y - H:i');
            $row[] =  '<a target="_blank" href="' . route('yonetim.kampanyalar.show', ['etkinlik_id' => encrypt($etkinlik->etkinlikler_id)]) . '">Detay</a>';
            $row[] =  '<a href="javascript:void(0)" class="kampanya-duzenle-modal open-modal" data-id="' . encrypt($etkinlik->etkinlikler_id) . '" data-modal="etkinlik-modal">Düzenle</a>';
            // $row[] = view('components.buttons.events.sil-button', ['etkinlikler_id' => $etkinlik->etkinlikler_id])->render();
            $data[] = $row;
        }
        // Tablo gövdesini gönderiyoruz.
        return response()->json([
            'success' => true,
            'data'    => $data
        ], 200);
    }
}
