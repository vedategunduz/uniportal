<?php

namespace App\Http\Controllers;

use App\Models\Etkinlik;
use App\Models\EtkinlikYorum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EtkinlikYorumController extends Controller
{
    public function store($etkinlik_id, Request $request)
    {
        $validated = $request->all();
        $validated['yorum'] = cleanText($validated['yorum']);

        $etkinlik_id = decrypt($etkinlik_id);

        $etkinlik = Etkinlik::find($etkinlik_id);

        if (!empty($validated['etkinlik_yorumlari_id'])) {
            $yorum = $etkinlik->yorum()->find(decrypt($validated['etkinlik_yorumlari_id']));
            $yorum->yanit()->create([
                'kullanicilar_id' => Auth::id(),
                'etkinlikler_id' => $etkinlik_id,
                'yorum' => $validated['yorum'],
                'yorum_tipi' => $validated['yorum_tipi']
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Yorumunuz başarıyla eklendi.',
                'yorum' => $yorum,
                'tip' => 'yanit'
            ]);
        }

        $yorum = $etkinlik->yorum()->create([
            'kullanicilar_id' => Auth::id(),
            'yorum' => $validated['yorum'],
            'yorum_tipi' => $validated['yorum_tipi']
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Yorumunuz başarıyla eklendi.',
            'yorum' => $yorum,
            'tip' => 'yorum'
        ]);
    }

    public function begenToggle($etkinlik_id, $yorum_id)
    {
        $etkinlik_id = decrypt($etkinlik_id);
        $yorum_id = decrypt($yorum_id);

        $etkinlik = Etkinlik::find($etkinlik_id);
        $yorum = $etkinlik->yorum()->find($yorum_id);

        $yorum->begenToggle();

        return response()->json([
            'success' => true,
            'begeni' => $yorum->begeni()->count()
        ]);
    }

    public function destroy($etkinlik_id, $yorum_id)
    {
        $yorum_id = decrypt($yorum_id);
        $yorum = EtkinlikYorum::find($yorum_id);

        $yorum->aktiflik = 0;
        $yorum->save();

        return response()->json([
            'success' => true,
            'message' => 'Yorum başarıyla silindi.',
            'yorum' => $yorum
        ]);
    }
}
