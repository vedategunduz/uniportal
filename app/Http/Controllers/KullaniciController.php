<?php

namespace App\Http\Controllers;

use App\Models\Isletme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class KullaniciController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('kullanici.index');
    }

    public function kamular(Request $request)
    {
        $kamular = Isletme::where('isletme_turleri_id', 1)->orderBy('baslik', 'asc')->paginate(20);

        if ($request->ajax()) {
            // İçeriği render edin
            $html = '';
            foreach ($kamular as $kamu) {
                $html .= view(
                    'components.kamu',
                    [
                        'text' => $kamu->baslik,
                        'href' => "/$kamu->kamular_id",
                        'logoUrl' => $kamu->logoUrl,
                        'websiteUrl' => $kamu->websiteUrl,
                        'xUrl' => $kamu->xUrl,
                        'instagramUrl' => $kamu->instagramUrl,
                        'linkedinUrl' => $kamu->linkedinUrl,
                    ]
                )->render();
            }

            // Paginator'ı render edin (Tailwind paginator'ınızı kullandığınız Blade dosyasını belirtin)
            $pagination = $kamular->links('pagination::tailwind')->render();

            return response()->json([
                'html' => $html,
                'pagination' => $pagination,
            ]);
        }

        return view('kullanici.kamular.index', compact(['kamular']));
    }

    public function etkinlikler()
    {
        return view('kullanici.etkinlikler.index');
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

            return redirect()->intended('kullanici');
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
