<?php

namespace App\Http\Controllers;

use App\Models\Etkinlik;

class EventController extends Controller
{
    public function index()
    {
        return view('yonetim.etkinlik.index');
    }

    public function modalGetir(string $id)
    {
        $decryptedId = decrypt($id);

        $data = [];

        if ($decryptedId != 0) {
            $etkinlik = Etkinlik::findOrFail($decryptedId);

            $data = [
                'etkinlik' => $etkinlik,
            ];
        }

        $html = view('components.etkinlik.etkinlik-modal-content', $data)->render();

        return response()->json([
            'success' => true,
            'html'    => $html
        ], 200);
    }
}
