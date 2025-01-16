<?php

namespace App\Http\Controllers\Yonetim;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use App\Models\IsletmeYetkili;

class KullaniciController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('yonetim.kullanici.index');
    }

    public function show(string $isletmeler_id) {
        $isletmePersonelleri = IsletmeYetkili::personeller($isletmeler_id);
    }

    public function girisForm()
    {
        return view('yonetim.giris');
    }

    public function girisYap(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect()->intended('yonetim');
        }
        return redirect()->back();
    }

    public function cikis(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('main.index');
    }
}
