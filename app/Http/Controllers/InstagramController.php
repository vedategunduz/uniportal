<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class InstagramController extends Controller
{
    public function sendPost(Request $request)
    {

        $imageUrl    = $request->image_url;
        $caption     = $request->caption;
        // return response()->json(['error' => $imageUrl], 503);
        
        $igUserId    = env('IG_USER_ID');
        $accessToken = env('IG_ACCESS_TOKEN');

        try {
            // 1. Medya objesini oluşturma
            $createResponse = Http::post("https://graph.facebook.com/v21.0/{$igUserId}/media", [
                'image_url'    => $imageUrl,
                'caption'      => $caption,
                'access_token' => $accessToken,
            ]);

            if (!$createResponse->successful()) {
                return response()->json(['error' => 'Medya oluşturulamadı', 'details' => $createResponse->body()], 500);
            }

            $creationId = $createResponse->json('id');

            // 2. Medyayı yayınlama
            $publishResponse = Http::post("https://graph.facebook.com/v21.0/{$igUserId}/media_publish", [
                'creation_id'  => $creationId,
                'access_token' => $accessToken,
            ]);

            if (!$publishResponse->successful()) {
                return response()->json(['error' => 'Medya yayınlanamadı', 'details' => $publishResponse->body()], 500);
            }

            return response()->json([
                'success' => true,
                'data'    => $publishResponse->json()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error'   => 'İstek sırasında hata oluştu.',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
