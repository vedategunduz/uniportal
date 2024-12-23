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
            ['baslik' => "Fakülte"],
            ['baslik' => "Enstitü"],
            ['baslik' => "Yüksekokul"],
            ['baslik' => "Daire Başkanlığı"],
            ['baslik' => "Merkez"],
            ['baslik' => "Müdürlük"],
            ['baslik' => "Birim"],
            ['baslik' => "Meslek Yüksekokulu"],
            ['baslik' => "Genel İdare"],
        ]);
    }
}
