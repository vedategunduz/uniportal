<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            IlSeeder::class,
            RolSeeder::class,
            MenuSeeder::class,
            MenuRolIliskiSeeder::class,
            KullaniciSeeder::class,
            IsletmeTurSeeder::class,
            IsletmeSeeder::class,
            IsletmeYetkiliSeeder::class,
            EtkinlikTurSeeder::class,
            EtkinlikSeeder::class,
            BirimTipleriSeeder::class,
            IsletmeBirimSeeder::class,
            UnvanSeeder::class,
            KullaniciBirimUnvanSeeder::class,
            KullaniciRolIlıskiSeeder::class,
        ]);
    }
}
