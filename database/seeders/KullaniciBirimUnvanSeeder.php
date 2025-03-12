<?php

namespace Database\Seeders;

use App\Models\KullaniciBirimUnvan;
use Illuminate\Database\Seeder;

class KullaniciBirimUnvanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KullaniciBirimUnvan::insert([
            [
                'kullanicilar_id'      => 2,
                'isletmeler_id'        => 143,
                'isletme_birimleri_id' => 44,
                'unvanlar_id'          => 2
            ],
            [
                'kullanicilar_id'      => 7,
                'isletmeler_id'        => 143,
                'isletme_birimleri_id' => 46,
                'unvanlar_id'          => 2
            ],
            [
                'kullanicilar_id'      => 4,
                'isletmeler_id'        => 143,
                'isletme_birimleri_id' => 44,
                'unvanlar_id'          => 3
            ],
            [
                'kullanicilar_id'      => 3,
                'isletmeler_id'        => 143,
                'isletme_birimleri_id' => 44,
                'unvanlar_id'          => 3
            ],
            [
                'kullanicilar_id'      => 3,
                'isletmeler_id'        => 143,
                'isletme_birimleri_id' => 42,
                'unvanlar_id'          => 3
            ],
            [
                'kullanicilar_id'      => 5,
                'isletmeler_id'        => 143,
                'isletme_birimleri_id' => 70,
                'unvanlar_id'          => 3
            ]
        ]);
    }
}
