<?php

namespace App\Http\Controllers;

use App\Models\Etkinlik;

class EtkinlikYorumController extends Controller
{
    public function begenToggle($etkinlik_id, $yorum_id)
    {
        $etkinlik_id = decrypt($etkinlik_id);
        $yorum_id = decrypt($yorum_id);

        $etkinlik = Etkinlik::find($etkinlik_id);
        $yorum = $etkinlik->yorum()->find($yorum_id);

        $yorum->begenToggle();

        return response()->json([
            'success' => true
        ]);
    }
}
