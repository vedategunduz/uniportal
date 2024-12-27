<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\MenuRolIliski;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class KullaniciController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menuler = Menu::whereHas('MenuRolIliskiBaglantisi', function ($query) {
            $query->where('roller_id', Auth::user()->roller_id);
        })
            ->with('altMenuler')
            ->whereNull('bagli_menuler_id')
            ->orderBy('menu_sira')
            ->get();

        return view('kullanici.index', compact('menuler'));
    }


    public function menu()
    {
        $menuler = MenuRolIliski::with('menu')->where('roller_id', Auth::user()->roller_id)->get();
        return view('kullanici.menu', compact('menuler'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id = null) {}

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

    public function girisForm()
    {
        return view('kullanici.giris');
    }

    public function girisYap(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();

            return redirect('/');
        }
        return response('kullanıcı adı veya şifre hatalı.');
    }

    public function cikis(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return view('anasayfa.index');
    }
}
