<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\KullaniciRequest;
use App\Models\Isletme;
use App\Models\IsletmeYetkili;
use App\Models\Kullanici;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function girisForm()
    {
        return view('main.auth.giris');
    }

    public function kayitForm()
    {
        $universiteler = Isletme::where('isletme_turleri_id', 1)->where('aktiflik', 1)->get();

        return view('main.auth.kayit', [
            'universiteler' => $universiteler
        ]);
    }

    public function girisYap(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            if (Auth::user()->email_verified_at == null) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->back()->with('error', 'Hesabınızı aktive etmek için e-posta adresinize gönderilen linke tıklayınız.');
            }
            $request->session()->regenerate();
            return redirect()->intended('yonetim');
        }
        return redirect()->back();
    }

    public function kayitYap(KullaniciRequest $request)
    {
        $validated = $request->all();

        $kullanici = Kullanici::create($validated);

        $kullanici->sendEmailVerificationNotification();

        return response()->json([
            'success' => true,
            'message' => 'Kayıt işlemi başarılı. Hesabınızı aktive etmek için e-posta adresinize gönderilen linke tıklayınız.'
        ]);
    }

    public function onayla(string $token)
    {
        try {
            $kullanicilar_id = decrypt($token);
            $kullanici = Kullanici::findOrFail($kullanicilar_id);

            if ($kullanici->email_verified_at != null) {
                return view('mail.yanit.hesap-onay', [
                    'success' => false,
                    'message' => 'Hesabınız zaten aktive edilmiş.'
                ]);
            }

            $kullanici->email_verified_at = now();
            $kullanici->save();

            [$domain, $uzanti] = explode('@', $kullanici->email);

            $isletme = Isletme::where('mailUzanti', $uzanti)->first();

            if (!empty($isletme)) {
                IsletmeYetkili::create([
                    'isletmeler_id' => $isletme->isletmeler_id,
                    'kullanicilar_id' => $kullanici->kullanicilar_id
                ]);
            }

            return view('mail.yanit.hesap-onay', [
                'success' => true,
                'message' => 'Hesabınız başarıyla aktive edildi.'
            ]);
        } catch (\Throwable $th) {
            return redirect()->route('error.404');
        }
    }

    public function cikis(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('main.index');
    }
}
