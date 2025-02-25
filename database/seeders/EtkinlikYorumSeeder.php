<?php

namespace Database\Seeders;

use App\Models\EtkinlikYorum;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;


class EtkinlikYorumSeeder extends Seeder
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
                'kullanicilar_id' => 1,
                'yorum' => $faker->realText(200),
            ],
            [
                'etkinlikler_id' => 1,
                'kullanicilar_id' => 2,
                'yorum' => $faker->realText(200),
            ],
            [
                'etkinlikler_id' => 1,
                'kullanicilar_id' => 3,
                'yorum' => $faker->realText(200),
            ],
            [
                'etkinlikler_id' => 2,
                'kullanicilar_id' => 1,
                'yorum' => $faker->realText(200),
            ],
            [
                'etkinlikler_id' => 2,
                'kullanicilar_id' => 2,
                'yorum' => $faker->realText(200),
            ],
            [
                'etkinlikler_id' => 2,
                'kullanicilar_id' => 3,
                'yorum' => $faker->realText(200),
            ]
        ]);
    }
}
