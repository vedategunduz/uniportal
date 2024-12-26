<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EditorController extends Controller
{
    public function upload(Request $request)
    {
        // 1. Editor.js "byFile" isteğinde dosya "image" parametresiyle geliyor:
        //    (Bu isim, ImageTool konfigürasyonunda değişebilir, ama varsayılan genelde "image" veya "file"tır.)
        $uploadedFile = $request->file('image');

        if (!$uploadedFile) {
            return response()->json(['success' => 0, 'message' => 'Dosya bulunamadı'], 400);
        }

        // 2. Dosyayı storage klasörüne kaydet
        //    (public disk oluşturduysanız storage/app/public klasörüne gider)
        $path = $uploadedFile->store('images', 'public');

        // 3. Kaydettiğimiz resmin erişim URL’sini oluştur
        $url = Storage::url($path); // /storage/images/... şeklinde döner

        // 4. Editor.js’in beklediği formatta JSON döndür
        return response()->json([
            'success' => 1,
            'file' => [
                'url' => $url
            ]
        ]);
    }
    public function fetch(Request $request)
    {
        // 1. Editor.js body veya param içinde "url" gönderir.
        $imageUrl = $request->input('url');

        if (!$imageUrl) {
            return response()->json(['success' => 0, 'message' => 'URL bulunamadı'], 400);
        }

        // 2. Uzaktaki görseli alıp sunucumuza kaydedelim (en basit örnek)
        try {
            $imageContents = file_get_contents($imageUrl);
            // Rastgele bir isim oluşturalım
            $filename = 'images/' . uniqid() . '.jpg';
            Storage::disk('public')->put($filename, $imageContents);

            $url = Storage::url($filename);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'message' => 'Resim alınamadı'], 400);
        }

        // 3. Editor.js’in beklediği formatta JSON döndür
        return response()->json([
            'success' => 1,
            'file' => [
                'url' => $url
            ]
        ]);
    }
}
