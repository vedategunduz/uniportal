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
            KamuSeeder::class,
            MenuSeeder::class,
            KullaniciSeeder::class,
            MenuRolIliskiSeeder::class,
            /*
            FirmaSeeder::class,
            HizmetTurSeeder::class,
            FirmaHizmetSeeder::class,
            HizmetIlDetaylariSeeder::class,
            */
            // KamuHizmetSeeder::class,
        ]);
    }
}