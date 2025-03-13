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
            IsletmeTurSeeder::class,
            IsletmeSeeder::class,
            UnvanSeeder::class,
            BirimTipleriSeeder::class,
            IsletmeBirimSeeder::class,
            KullaniciSeeder::class,
            IsletmeYetkiliSeeder::class,
            EtkinlikTurSeeder::class,
            EtkinlikSeeder::class,
            EtkinlikKatilimSeeder::class,
            KullaniciBirimUnvanSeeder::class,
            KullaniciRolIlıskiSeeder::class,
            MesajKanalSeeder::class,
            MesajKanalKatilimciSeeder::class,
            MesajSeeder::class,
            EmojiTipSeeder::class,
            EtkinlikYorumSeeder::class,
            EtkinlikYorumYanitSeeder::class,
            EtkinlikYorumBegeniSeeder::class,
        ]);
    }
}
