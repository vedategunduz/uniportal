<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DataBaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            IlSeeder::class,
            RolSeeder::class,
            /*
            FirmaSeeder::class,
            KamuSeeder::class,
            HizmetTurSeeder::class,
            FirmaHizmetSeeder::class,
            HizmetIlDetaylariSeeder::class,
            */
            // KamuHizmetSeeder::class,
            KullaniciSeeder::class,
        ]);
    }
}
