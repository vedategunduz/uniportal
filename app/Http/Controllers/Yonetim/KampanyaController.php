<?php

namespace App\Http\Controllers\Yonetim;

use App\Http\Controllers\Controller;
use App\Http\Requests\KampanyaRequest;
use App\Models\Etkinlik;

class KampanyaController extends Controller
{
    public function index()
    {
        return view('yonetim.kampanya.index');
    }

    public function store(KampanyaRequest $request)
    {
        $validated = $request->validated();

        $validated['etkinlik_turleri_id'] = decrypt($validated['etkinlik_turleri_id']);
        $validated['isletmeler_id'] = decrypt($validated['isletmeler_id']);

        $kampanya = Etkinlik::create($validated);

        return response()->json([
            'success' => 1,
            'message' => 'Kampanya başarıyla eklendi.'
        ]);
    }
}
