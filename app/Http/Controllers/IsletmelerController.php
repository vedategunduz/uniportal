<?php

namespace App\Http\Controllers;

use App\Models\Isletme;
use Illuminate\Http\Request;

class IsletmelerController extends Controller
{
      /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $isletmeler = Isletme::orderBy('baslik', 'asc')->paginate(20);

        if ($request->ajax()) {
              // İçeriği render edin
            $html = '';
            foreach ($isletmeler as $kamu) {
                $html .= view('components.kamu',
                    [
                        'text'         => $kamu->baslik,
                        'href'         => "/$kamu->kamular_id",
                        'logoUrl'      => $kamu->logoUrl,
                        'websiteUrl'   => $kamu->websiteUrl,
                        'xUrl'         => $kamu->xUrl,
                        'instagramUrl' => $kamu->instagramUrl,
                        'linkedinUrl'  => $kamu->linkedinUrl,
                    ])->render();
            }

              // Paginator'ı render edin (Tailwind paginator'ınızı kullandığınız Blade dosyasını belirtin)
            $pagination = $isletmeler->links('pagination::tailwind')->render();

            return response()->json([
                'html'       => $html,
                'pagination' => $pagination,
            ]);
        }

        return view('isletmeler.index', compact('isletmeler'));
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
    public function store(Request $request)
    {
          //
    }

      /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
          //
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
