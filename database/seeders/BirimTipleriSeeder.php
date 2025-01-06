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
            ['baslik' => "Fakülte", 'isletme_turleri_id' => 1],
            ['baslik' => "Enstitü", 'isletme_turleri_id' => 1],
            ['baslik' => "Yüksekokul", 'isletme_turleri_id' => 1],
            ['baslik' => "Daire Başkanlığı", 'isletme_turleri_id' => 1],
            ['baslik' => "Merkez", 'isletme_turleri_id' => 1],
            ['baslik' => "Müdürlük", 'isletme_turleri_id' => 1],
            ['baslik' => "Birim", 'isletme_turleri_id' => 1],
            ['baslik' => "Meslek Yüksekokulu", 'isletme_turleri_id' => 1],
            ['baslik' => "Genel İdare", 'isletme_turleri_id' => 1],
        ]);
    }
}
