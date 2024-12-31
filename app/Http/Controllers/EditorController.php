<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EditorController extends Controller
{
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

        return response()->json(['url' => $url]);
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
}
