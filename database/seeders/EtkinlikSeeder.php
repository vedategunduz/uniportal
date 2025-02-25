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

        Etkinlik::insert(
            [
                [
                    'etkinlik_turleri_id'        => 1,
                    'isletmeler_id'              => 66,
                    'iller_id'                   => 34,
                    'baslik'                     => 'Kentte Özgür Adımlar – İstanbul ve Sokak Sanatı Festivali',
                    'aciklama'                   => $faker->realText(200),
                    'etkinlikBasvuruTarihi'      => $faker->dateTimeBetween('-1 day', '+1 day'),
                    'etkinlikBasvuruBitisTarihi' => $faker->dateTimeBetween('+1 day', '+2 day'),
                    'etkinlikBaslamaTarihi'      => $faker->dateTimeBetween('+2 day', '+3 day'),
                    'etkinlikBitisTarihi'        => $faker->dateTimeBetween('+3 day', '+4 day'),
                    'kapakResmiYolu'             => 'image/etkinlikresim.png',
                    'kontenjan'                  => 100,
                    'katilimTipi'                => 'genel',
                ],
                [
                    'etkinlik_turleri_id'        => 2,
                    'isletmeler_id'              => 143,
                    'iller_id'                   => 34,
                    'baslik'                     => 'Modülerlik Mezarlığı: Hangi Modülü Nereye Gömdüm?',
                    'aciklama'                   => 'Bir zamanlar düzenliydi... ya da ben öyle sanıyordum!... 🧐',
                    'etkinlikBasvuruTarihi'      => $faker->dateTimeBetween('-1 day', '+1 day'),
                    'etkinlikBasvuruBitisTarihi' => $faker->dateTimeBetween('+1 day', '+2 day'),
                    'etkinlikBaslamaTarihi'      => $faker->dateTimeBetween('+2 day', '+3 day'),
                    'etkinlikBitisTarihi'        => $faker->dateTimeBetween('+3 day', '+4 day'),
                    'kapakResmiYolu'             => 'image/404 Error with a cute animal-pana.png',
                    'kontenjan'                  => 500,
                    'katilimTipi'                => 'özel',
                ],
                [
                    'etkinlik_turleri_id'        => 2,
                    'isletmeler_id'              => 143,
                    'iller_id'                   => 34,
                    'baslik'                     => $faker->realText(rand(20, 100)),
                    'aciklama'                   => $faker->realText(rand(100, 1000)),
                    'etkinlikBasvuruTarihi'      => $faker->dateTimeBetween('-3 day', '-2 day'),
                    'etkinlikBasvuruBitisTarihi' => $faker->dateTimeBetween('+1 day', '+2 day'),
                    'etkinlikBaslamaTarihi'      => $faker->dateTimeBetween('-2 day', '-1 day'),
                    'etkinlikBitisTarihi'        => $faker->dateTimeBetween('+3 day', '+4 day'),
                    'kapakResmiYolu'             => 'https://placeholder.pagebee.io/api/random/2000/2000',
                    'kontenjan'                  => 500,
                    'katilimTipi'                => 'uniportal',
                ],
                [
                    'etkinlik_turleri_id'        => 2,
                    'isletmeler_id'              => 143,
                    'iller_id'                   => 34,
                    'baslik'                     => $faker->realText(rand(20, 100)),
                    'aciklama'                   => $faker->realText(rand(100, 1000)),
                    'etkinlikBasvuruTarihi'      => $faker->dateTimeBetween('-1 day', '+1 day'),
                    'etkinlikBasvuruBitisTarihi' => $faker->dateTimeBetween('+1 day', '+2 day'),
                    'etkinlikBaslamaTarihi'      => $faker->dateTimeBetween('-4 day', '-3 day'),
                    'etkinlikBitisTarihi'        => $faker->dateTimeBetween('-2 day', '-1 day'),
                    'kapakResmiYolu'             => 'https://placeholder.pagebee.io/api/random/1000/1000',
                    'kontenjan'                  => 500,
                    'katilimTipi'                => 'genel',

                ],
                [
                    'etkinlik_turleri_id'        => 2,
                    'isletmeler_id'              => 143,
                    'iller_id'                   => 34,
                    'baslik'                     => $faker->realText(rand(20, 100)),
                    'aciklama'                   => $faker->realText(rand(100, 1000)),
                    'etkinlikBasvuruTarihi'      => $faker->dateTimeBetween('-1 day', '+1 day'),
                    'etkinlikBasvuruBitisTarihi' => $faker->dateTimeBetween('+1 day', '+2 day'),
                    'etkinlikBaslamaTarihi'      => $faker->dateTimeBetween('-4 day', '-3 day'),
                    'etkinlikBitisTarihi'        => $faker->dateTimeBetween('-1 day', '0 day'),
                    'kapakResmiYolu'             => 'https://placeholder.pagebee.io/api/random/1920/1080',
                    'kontenjan'                  => 500,
                    'katilimTipi'                => 'genel',

                ]
            ]
        );
    }
}
