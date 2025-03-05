<?php

namespace App\Http\Controllers;

use App\Models\Etkinlik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EtkinlikKatilimController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(string $etkinlik_id, Request $request)
    {
        $validated = $request->all();

        if ($validated['katilimSartlari'] != 'on') {
            return response()->json([
                'success' => false,
                'message' => 'Katılım şartlarını kabul etmelisiniz.'
            ]);
        }

        $etkinlik_id = decrypt($etkinlik_id);

        $etkinlik = Etkinlik::find($etkinlik_id);

        $etkinlik->katilimcilar()->attach(Auth::id(), [
            'aciklama' => $validated['aciklama']
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Etkinliğe katılımınız alınmıştır.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $etkinlik_id)
    {
        $etkinlik_id = decrypt($etkinlik_id);
        $etkinlik = Etkinlik::find($etkinlik_id);

        $html = view('main.etkinlik-katil-modal', compact('etkinlik'))->render();

        return response()->json([
            'success' => true,
            'html' => $html
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
