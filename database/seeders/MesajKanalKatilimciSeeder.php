<?php

namespace Database\Seeders;

use App\Models\MesajKanalKatilimci;
use Illuminate\Database\Seeder;

class MesajKanalKatilimciSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MesajKanalKatilimci::insert([
            [
                'mesaj_kanallari_id' => 1,
                'kullanicilar_id' => 1,
            ],
            [
                'mesaj_kanallari_id' => 1,
                'kullanicilar_id' => 2,
            ],
            [
                'mesaj_kanallari_id' => 2,
                'kullanicilar_id' => 1,
            ],
            [
                'mesaj_kanallari_id' => 2,
                'kullanicilar_id' => 3,
            ],
        ]);
    }
}
