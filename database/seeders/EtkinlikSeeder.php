<?php

namespace Database\Seeders;

use App\Models\Etkinlik;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class EtkinlikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create("tr_TR");

        Etkinlik::insert([
            'etkinlik_turleri_id' => 1,
            'isletmeler_id' => 66,
            'iller_id' => 34,
            'baslik' => 'Kentte Özgür Adımlar – İstanbul ve Sokak Sanatı Festivali',
            'aciklama' => $faker->realText(200),
            'etkinlikBasvuruTarihi' => $faker->dateTimeBetween('-1 day', '+1 day'),
            'etkinlikBasvuruBitisTarihi' => $faker->dateTimeBetween('+1 day', '+2 day'),
            'etkinlikBaslamaTarihi' => $faker->dateTimeBetween('+2 day', '+3 day'),
            'etkinlikBitisTarihi' => $faker->dateTimeBetween('+3 day', '+4 day'),
            'kontenjan' => 100,
        ]);
    }
}
