<?php

use Mews\Purifier\Facades\Purifier;

if (!function_exists('cleanText')) {
    /**
     * Mesaj içindeki URL'leri link haline getirir ve temizler.
     *
     * @param string $message
     * @return string
     */
    function cleanText($message)
    {
        $pattern = '/(https?:\/\/\S+)/';
        $replacement = '<a href="$1" class="text-blue-700 hover:underline hover:text-blue-700" target="_blank">$1</a>';
        $message = preg_replace($pattern, $replacement, $message);
        $message = Purifier::clean($message);

        return $message;
    }
}

if (!function_exists('uploadFile')) {
    /**
     * Dosya yükler ve dosya linkini döndürür.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $folder
     * @return string
     */
    function uploadFile($file, $folder = 'image', $unique = true)
    {
        $destinationPath = public_path($folder);

        // Eğer klasör yoksa oluştur.
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        $filename =  $unique ? time() . '_' . $file->getClientOriginalName() : $file->getClientOriginalName();

        $file->move($destinationPath, $filename);

        return asset($folder . '/' . $filename);
    }
}
