<?php

namespace Database\Seeders;

use App\Models\EtkinlikYorumBegeniDetay;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class EtkinlikYorumBegeniSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create("tr_TR");

        EtkinlikYorumBegeniDetay::insert([
            [
                'etkinlik_yorumlari_id' => 1,
                'kullanicilar_id' => 2,
            ],
            [
                'etkinlik_yorumlari_id' => 1,
                'kullanicilar_id' => 3,
            ],
            [
                'etkinlik_yorumlari_id' => 2,
                'kullanicilar_id' => 1,
            ],
            [
                'etkinlik_yorumlari_id' => 4,
                'kullanicilar_id' => 2,
            ],
            [
                'etkinlik_yorumlari_id' => 4,
                'kullanicilar_id' => 3,
            ],
            [
                'etkinlik_yorumlari_id' => 5,
                'kullanicilar_id' => 1,
            ]
        ]);
    }
}
