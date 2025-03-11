<?php

namespace App\Http\Controllers\Yonetim;

use App\Http\Controllers\Controller;
use App\Http\Requests\EtkinlikRequest;
use App\Models\Etkinlik;
use App\Models\EtkinlikTur;
use App\Models\Il;
use Carbon\Carbon;
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
        $validated['isletmeler_id']       = decrypt($validated['isletmeler_id']);
        $validated['iller_id']            = decrypt($validated['iller_id']);

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
            $row[]  = '<a class="!text-blue-500" target="_blank" title="' . $etkinlik->baslik . '" href="' . route('etkinlikler.detay', ['etkinlik_id' => encrypt($etkinlik->etkinlikler_id)]) . '">' . $etkinlik->baslik . '</a>';
            $row[]  = '<span class="text-xs">' . Carbon::parse($etkinlik->etkinlikBaslamaTarihi)->translatedFormat('d M, Y - H:i') . '<br>' . Carbon::parse($etkinlik->etkinlikBitisTarihi)->translatedFormat('d M, Y - H:i') . '</span>';
            $row[]  = '<a target="_blank" href="' . route('etkinlikler.detay', ['etkinlik_id' => encrypt($etkinlik->etkinlikler_id)]) . '" class="inline-flex items-center gap-2 p-2 bg-blue-400 text-xs !text-white rounded" data-id="' . encrypt($etkinlik->etkinlikler_id) . '"><i class="bi bi-chat-left-text"></i>
            <span>' . $etkinlik->yorum->where('yorum_tipi', 0)->count() . '</span></a>';
            $row[]  = '<a href="javascript:void(0)" class="inline-flex items-center gap-2 p-2 bg-rose-400 text-xs !text-white rounded" data-id="' . encrypt($etkinlik->etkinlikler_id) . '"><i class="bi bi-heart"></i>
            <span>' . $etkinlik->begeni->count() . '</span></a>';
            $row[]  = '
            <div class="flex items-stretch">
            <a href="javascript:void(0)" class="ziyaret-sohbet-baslat inline-flex items-center gap-2 p-2 bg-green-400 text-xs !text-white rounded rounded-r-none text-nowrap" data-id="' . encrypt($etkinlik->etkinlikler_id) . '" data-name="' . $etkinlik->baslik . '"><span>Sohbet başlat</span></a>
            <a href="javascript:void(0)" class="ziyaret-kanallar inline-flex items-center gap-2 p-2 bg-green-300 text-xs !text-white rounded rounded-l-none" data-name="' . $etkinlik->kod . '"><span>' . $etkinlik->mesajKanallari->count() . '</span><i class="bi bi-chat-dots-fill"></i></a>
            </div>';

            $str = $etkinlik->katilimcilar->where('durum', 'beklemede')->count() ? '<span style="font-size:9px" class="absolute -top-2 -left-2 size-5 flex items-center justify-center bg-rose-400 rounded-full border border-white">' . $etkinlik->katilimcilar->where('durum', 'beklemede')->count() . '</span>' : '';

            $row[]  = '
            <a href="javascript:void(0)" class="relative inline-flex items-center gap-2 p-2 bg-purple-400 text-xs !text-white rounded" data-id="' . encrypt($etkinlik->etkinlikler_id) . '">
                <i class="bi bi-people-fill"></i>
                <span>' . $etkinlik->katilimcilar->count() . '</span>
                ' . $str . '
            </a>';
            $row[]  = '<a href="javascript:void(0)" class="inline-flex p-2 bg-orange-400 text-xs !text-white rounded etkinlik-duzenle-modal open-modal" data-id="' . encrypt($etkinlik->etkinlikler_id) . '" data-modal="etkinlik-modal"><i class="bi bi-pencil-square"></i></a>';
            $row[]  = '<a href="javascript:void(0)" class="inline-flex p-2 bg-gs-red text-xs !text-white rounded etkinlik-sil" data-id="' . encrypt($etkinlik->etkinlikler_id) . '"><i class="bi bi-trash3"></i></a>';
            $data[] = $row;
        }
        // Tablo gövdesini gönderiyoruz.
        return response()->json([
            'success' => true,
            'data'    => $data
        ], 200);
    }
}
