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

    public function storeMultipleImages($images, $referenceCode)
    {
        $paths = [];

        foreach ($images as $image) {
            $paths[] = ['resimYolu' => $this->storeSingleImage($image, $referenceCode)];
        }

        return $paths;
    }
}
