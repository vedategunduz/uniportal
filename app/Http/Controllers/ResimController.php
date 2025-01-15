<?php

namespace App\Http\Controllers;

use App\Models\Resim;
use Illuminate\Support\Facades\Storage;

class ResimController extends Controller
{
    public function destroy(string $id)
    {
        $decryptedId = decrypt($id);
        $resim = Resim::findOrFail($decryptedId);

        if (Storage::disk('public')->exists($resim->resimYolu)) {
            Storage::disk('public')->delete($resim->resimYolu);
        }

        $resim->delete();

        return response()->json([
            'success' => true,
            'message' => 'Resim başarıyla silindi.'
        ], 200);
    }
}
