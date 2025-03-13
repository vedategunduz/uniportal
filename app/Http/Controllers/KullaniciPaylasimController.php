<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KullaniciPaylasimController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->all();

        Auth::user()->paylasimlar()->create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Paylaşım başarıyla oluşturuldu.',
        ], 201);
    }
}
