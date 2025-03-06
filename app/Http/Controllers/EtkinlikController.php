<?php

namespace App\Http\Controllers;

use App\Models\Etkinlik;

class EtkinlikController extends Controller
{
    public function index()
    {
        return view('main.etkinlik');
    }

    public function show($etkinlik_id)
    {
        $etkinlik_id = decrypt($etkinlik_id);
        $etkinlik = Etkinlik::find($etkinlik_id);

        $html = view('main.etkinlik-detay-modal', compact('etkinlik'))->render();

        return response()->json([
            'success' => true,
            'html' => $html
        ]);
    }

    public function begenToggle($etkinlik_id)
    {
        $etkinlik_id = decrypt($etkinlik_id);
        $etkinlik = Etkinlik::find($etkinlik_id);

        $etkinlik->begeniToggle();

        return response()->json([
            'success' => true,
            'begeni' => $etkinlik->begeni->count()
        ]);
    }

    public function incrementView($etkinlik_id)
    {
        $etkinlik_id = decrypt($etkinlik_id);
        $etkinlik = Etkinlik::find($etkinlik_id);

        $etkinlik->incrementView();

        return response()->json([
            'success' => true
        ]);
    }

    public function getViews($etkinlik)
    {
        $etkinlik = decrypt($etkinlik);
        $etkinlik = Etkinlik::find($etkinlik);

        return response()->json([
            'success' => true,
            'views' => $etkinlik->goruntulenmeSayisi
        ]);
    }
}
