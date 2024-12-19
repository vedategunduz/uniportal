<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DataBaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            /*
            FirmaSeeder::class,
            KamuSeeder::class,
            IlSeeder::class,
            HizmetTurSeeder::class,
            FirmaHizmetSeeder::class,
            HizmetIlDetaylariSeeder::class,
            */
            KamuHizmetSeeder::class,
        ]);
    }
}
