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
            MenuSeeder::class,
            MenuRolIliskiSeeder::class,
            KullaniciSeeder::class,
        ]);
    }
}
