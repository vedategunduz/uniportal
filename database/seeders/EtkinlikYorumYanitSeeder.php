<?php

namespace Database\Seeders;

use App\Models\EtkinlikYorum;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class EtkinlikYorumYanitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create("tr_TR");

        EtkinlikYorum::insert([
            [
                'etkinlikler_id' => 1,
                'kullanicilar_id' => 2,
                'yanitlanan_etkinlik_yorumlari_id' => 1,
                'yorum' => $faker->realText(100),
            ],
            [
                'etkinlikler_id' => 1,
                'kullanicilar_id' => 3,
                'yanitlanan_etkinlik_yorumlari_id' => 1,
                'yorum' => $faker->realText(100),
            ],
            [
                'etkinlikler_id' => 1,
                'kullanicilar_id' => 1,
                'yanitlanan_etkinlik_yorumlari_id' => 2,
                'yorum' => $faker->realText(100),
            ],
            [
                'etkinlikler_id' => 2,
                'kullanicilar_id' => 2,
                'yanitlanan_etkinlik_yorumlari_id' => 4,
                'yorum' => $faker->realText(100),
            ],
            [
                'etkinlikler_id' => 2,
                'kullanicilar_id' => 3,
                'yanitlanan_etkinlik_yorumlari_id' => 4,
                'yorum' => $faker->realText(100),
            ],
            [
                'etkinlikler_id' => 2,
                'kullanicilar_id' => 1,
                'yanitlanan_etkinlik_yorumlari_id' => 5,
                'yorum' => $faker->realText(100),
            ]
        ]);
    }
}
