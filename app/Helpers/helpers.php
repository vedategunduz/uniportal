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
