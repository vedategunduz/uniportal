<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DataBaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            IlSeeder::class,
            KamuSeeder::class,
            RolSeeder::class,
            KullaniciSeeder::class,
            YetkiliSeeder::class,
            MenuSeeder::class,
            MenuRolIliskiSeeder::class,
            HizmetTurSeeder::class,
            FirmaSeeder::class,
            EtkinlikTurSeeder::class,
            EtkinlikSeeder::class,
            EtkinlikKatilimSeeder::class,
            BirimTipleriSeeder::class,
            KamuBirimSeeder::class,
        ]);
    }
}
