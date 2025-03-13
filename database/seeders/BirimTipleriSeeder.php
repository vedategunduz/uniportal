<?php

namespace Database\Seeders;

use App\Models\BirimTip;
use Illuminate\Database\Seeder;

class BirimTipleriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BirimTip::insert([
            [
                'baslik'             => "Fakülte",
                'isletme_turleri_id' => 1,
                'CSSClass'           => "bg-blue-300 border-blue-400"
            ],
            [
                'baslik'             => "Enstitü",
                'isletme_turleri_id' => 1,
                'CSSClass'           => "bg-green-300 border-green-400"
            ],
            [
                'baslik'             => "Yüksekokul",
                'isletme_turleri_id' => 1,
                'CSSClass'           => "bg-yellow-300 border-yellow-400"
            ],
            [
                'baslik'             => "Daire Başkanlığı",
                'isletme_turleri_id' => 1,
                'CSSClass'           => "bg-red-300 border-red-400"
            ],
            [
                'baslik'             => "Merkez",
                'isletme_turleri_id' => 1,
                'CSSClass'           => "bg-indigo-300 border-indigo-400"
            ],
            [
                'baslik'             => "Müdürlük",
                'isletme_turleri_id' => 1,
                "CSSClass"           => "bg-pink-300 border-pink-400"
            ],
            [
                'baslik'             => "Birim",
                'isletme_turleri_id' => 1,
                'CSSClass'           => "bg-purple-300 border-purple-400"
            ],
            [
                'baslik'             => "Meslek Yüksekokulu",
                'isletme_turleri_id' => 1,
                'CSSClass'           => "bg-gray-300 border-gray-400"
            ],
            [
                'baslik'             => "Genel İdare",
                'isletme_turleri_id' => 1,
                'CSSClass'           => "bg-teal-300 border-teal-400"
            ],
            [
                'baslik'             => "Yönetim",
                'isletme_turleri_id' => 4,
                'CSSClass'           => "bg-rose-300 border-rose-400"
            ],
        ]);
    }
}
