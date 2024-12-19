<?php

namespace Database\Seeders;

use App\Models\HizmetTur;
use Illuminate\Database\Seeder;

class HizmetTurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HizmetTur::insert([
            [
                'baslik' => "Bilişim",
                'derinlik' => 0,
                'bagli_hizmet_turleri_id' => 0,
            ],
            [
                'baslik' => "Tefrişat",
                'derinlik' => 0,
                'bagli_hizmet_turleri_id' => 0,
            ],
            [
                'baslik' => "Bilgisayar",
                'derinlik' => 1,
                'bagli_hizmet_turleri_id' => 1,
            ],
            [
                'baslik' => "Sunucu - Depolama",
                'derinlik' => 1,
                'bagli_hizmet_turleri_id' => 1,
            ],
            [
                'baslik' => "Yazılım",
                'derinlik' => 1,
                'bagli_hizmet_turleri_id' => 1,
            ],
            [
                'baslik' => "Masa",
                'derinlik' => 1,
                'bagli_hizmet_turleri_id' => 2,
            ]
        ]);
    }
}
