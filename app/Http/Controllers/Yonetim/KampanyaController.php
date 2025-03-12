<?php

namespace App\Http\Controllers\Yonetim;

use App\Http\Controllers\Controller;
use App\Http\Requests\KampanyaRequest;
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
    }

    public function store(KampanyaRequest $request)
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

        $kampanyalar = Etkinlik::where('isletmeler_id', $isletme_id)->where('aktiflik', 1)->orderBy('etkinlikBaslamaTarihi', 'desc')->get();

        $data = [];
        // Etkinlik verilerini satır haline getiriyoruz.
        // Tablo satırlarını birleştiriyoruz.
        foreach ($kampanyalar as $etkinlik) {
            $row    = [];
            $row[]  = "<div class='min-w-12'><img src='$etkinlik->kapakResmiYolu' class='size-12 object-cover mx-auto rounded'></div>";
            $row[]  = '<a class="!text-blue-500" target="_blank" title="' . $etkinlik->baslik . '" href="' . route('etkinlikler.detay', ['etkinlik_id' => encrypt($etkinlik->etkinlikler_id)]) . '">' . $etkinlik->baslik . '</a>';
            $row[]  = '<span class="text-xs">' . Carbon::parse($etkinlik->etkinlikBaslamaTarihi)->translatedFormat('d M, D Y - H:i') . '<br>' . Carbon::parse($etkinlik->etkinlikBitisTarihi)->translatedFormat('d M, D Y - H:i') . '</span>';
            $row[]  = '<a href="javascript:void(0)" class="inline-flex items-center gap-2 p-2 bg-blue-400 text-xs !text-white rounded" data-id="' . encrypt($etkinlik->etkinlikler_id) . '"><i class="bi bi-chat-left-text"></i>
                        <span>' . $etkinlik->yorum->where('yorum_tipi', 0)->count() . '</span></a>';
            $row[]  = '<a href="javascript:void(0)" class="inline-flex items-center gap-2 p-2 bg-rose-400 text-xs !text-white rounded" data-id="' . encrypt($etkinlik->etkinlikler_id) . '"><i class="bi bi-heart"></i>
                        <span>' . $etkinlik->begeni->count() . '</span></a>';
            $row[]  = '
                <div class="flex items-stretch">
                <a href="javascript:void(0)" class="kampanya-sohbet-baslat inline-flex items-center gap-2 p-2 bg-green-400 text-xs !text-white rounded rounded-r-none" data-id="' . encrypt($etkinlik->etkinlikler_id) . '" data-name="' . $etkinlik->baslik . '"><span>Sohbet başlat</span></a>
                <a href="javascript:void(0)" class="kampanya-kanallar inline-flex items-center gap-2 p-2 bg-green-300 text-xs !text-white rounded rounded-l-none" data-name="' . $etkinlik->kod . '"><span>'. $etkinlik->mesajKanallari->count() .'</span><i class="bi bi-chat-dots-fill"></i></a>
                </div>
            ';
            $row[]  = '<a href="javascript:void(0)" class="kampanya-duzenle-modal open-modal inline-flex p-2 bg-orange-400 text-xs !text-white rounded" data-id="' . encrypt($etkinlik->etkinlikler_id) . '" data-modal="etkinlik-modal"><i class="bi bi-pencil-square"></i></a>';
            $row[]  = '<a href="javascript:void(0)" class="kampanya-sil inline-flex p-2 bg-gs-red text-xs !text-white rounded" data-id="' . encrypt($etkinlik->etkinlikler_id) . '"><i class="bi bi-trash3"></i></a>';
            $data[] = $row;
        }
        // Tablo gövdesini gönderiyoruz.
        return response()->json([
            'success' => true,
            'data'    => $data
        ], 200);
    }
}
