<?php

namespace App\Services;

class ImageUploadService
{
    public function storeSingleImage($image, string $folder = ''): string
    {
        $filename = uniqid() . '.' . $image->getClientOriginalExtension();
        return $image->storeAs(
            'images/' . $folder,
            $filename,
            'public'
        );
    }

    // private function storeMultipleImages(array $imageFiles, int $etkinlikId, string $folder)
    // {
    //     foreach ($imageFiles as $image) {
    //         $path = $this->storeSingleImage($image, $folder);
    //         Resim::create([]);
    //     }
    // }
}
