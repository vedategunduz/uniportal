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
            //
            [
                'mesaj_kanallari_id' => 3,
                'kullanicilar_id' => 1,
            ],
            [
                'mesaj_kanallari_id' => 3,
                'kullanicilar_id' => 2,
            ],
            //
            [
                'mesaj_kanallari_id' => 4,
                'kullanicilar_id' => 1,
            ],
            [
                'mesaj_kanallari_id' => 4,
                'kullanicilar_id' => 2,
            ],
            //
            [
                'mesaj_kanallari_id' => 5,
                'kullanicilar_id' => 1,
            ],
            [
                'mesaj_kanallari_id' => 5,
                'kullanicilar_id' => 2,
            ],
            //
            [
                'mesaj_kanallari_id' => 6,
                'kullanicilar_id' => 1,
            ],
            [
                'mesaj_kanallari_id' => 6,
                'kullanicilar_id' => 2,
            ],
            //
            [
                'mesaj_kanallari_id' => 7,
                'kullanicilar_id' => 1,
            ],
            [
                'mesaj_kanallari_id' => 7,
                'kullanicilar_id' => 2,
            ],
            //
            [
                'mesaj_kanallari_id' => 8,
                'kullanicilar_id' => 1,
            ],
            [
                'mesaj_kanallari_id' => 8,
                'kullanicilar_id' => 2,
            ],
            //
            [
                'mesaj_kanallari_id' => 9,
                'kullanicilar_id' => 1,
            ],
            [
                'mesaj_kanallari_id' => 9,
                'kullanicilar_id' => 2,
            ],
            //
            [
                'mesaj_kanallari_id' => 10,
                'kullanicilar_id' => 1,
            ],
            [
                'mesaj_kanallari_id' => 10,
                'kullanicilar_id' => 2,
            ],
        ]);
    }
}
