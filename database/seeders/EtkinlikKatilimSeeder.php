<?php

namespace Database\Seeders;

use App\Models\EtkinlikKatilim;
use Illuminate\Database\Seeder;

class EtkinlikKatilimSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EtkinlikKatilim::insert([
            [
                'etkinlikler_id' => 11,
                'kullanicilar_id' => 2,
                'katilimciTipi' => 'giden',
                'durum' => 'Onaylandı',
            ],
            [
                'etkinlikler_id' => 11,
                'kullanicilar_id' => 3,
                'katilimciTipi' => 'giden',
                'durum' => 'Beklemede',
            ],
            [
                'etkinlikler_id' => 11,
                'kullanicilar_id' => 4,
                'katilimciTipi' => 'giden',
                'durum' => 'Reddedildi',
            ],
            [
                'etkinlikler_id' => 11,
                'kullanicilar_id' => 1,
                'katilimciTipi' => 'gidilen',
                'durum' => 'Reddedildi',
            ]
        ]);
        EtkinlikKatilim::insert([
            [
                'etkinlikler_id' => 3,
                'kullanicilar_id' => 5,
                'durum' => 'Beklemede',
            ],
            [
                'etkinlikler_id' => 3,
                'kullanicilar_id' => 3,
                'durum' => 'Beklemede',
            ],
            [
                'etkinlikler_id' => 3,
                'kullanicilar_id' => 4,
                'durum' => 'Beklemede',
            ],
            [
                'etkinlikler_id' => 3,
                'kullanicilar_id' => 1,
                'durum' => 'Beklemede',
            ]
        ]);
    }
}
