<?php

namespace App\Http\Controllers;

use App\Models\Editor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EditorController extends Controller
{
    public function store(Request $request)
    {
        $jsonData = $request->input('icerik');
        // Editor.js'den gelen veriyi (genellikle JS tarafında JSON.stringify() ile göndersiniz)
        // $jsonData bir array veya obje olarak gelecek.

        // Casting sayesinde otomatik JSON'a çevrilecek
        $editorEntry = Editor::create([
            'icerik' => $jsonData  // <-- json_encode yok
        ]);

        return response()->json([
            'success' => true,
            'editor_id' => $editorEntry->editor_id
        ]);
    }

    public function fileUpload(Request $request)
    {
        $uploadedFile = $request->file('file');

        if (!$uploadedFile) {
            return response()->json(['success' => 0, 'message' => 'Dosya bulunamadı'], 400);
        }

        // Örnek 1: Orijinal isim + uniqid prefix’i
        $originalName = $uploadedFile->getClientOriginalName();
        // Örnek: "dosya.docx"

        // İsim çakışmalarını önlemek için benzersiz bir prefix ekleyelim
        $filename = uniqid() . '_' . $originalName;
        // Örnek: "1695825443_dosya.docx"

        // storeAs ile istediğiniz disk ve klasörü belirtiyorsunuz
        $path = $uploadedFile->storeAs('files', $filename, 'public');

        // URL oluştur
        $url = Storage::url($path);

        return response()->json([
            'success' => 1,
            'file' => [
                'url' => $url,
                'name' => $filename
            ]
        ]);
    }

    public function imageUpload(Request $request)
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

    public function imageFetch(Request $request)
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
