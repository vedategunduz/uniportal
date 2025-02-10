<?php

namespace App\Http\Controllers;

use App\Events\MesajOlusturuldu;
use App\Models\Kullanici;
use App\Models\Mesaj;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MesajController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->all();

        $mesaj = Kullanici::find(Auth::id())->mesajlar()->create($validated);

        $mesaj = Mesaj::with('kullanici')->find($mesaj->mesajlar_id);

        broadcast(new MesajOlusturuldu($mesaj))->toOthers();

        $html = view('components.mesaj', [
            'mesaj' => $mesaj,
        ])->render();

        return response()->json([
            'success' => true,
            'html' => $html,
        ], 201);
    }
}
