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
                'durum' => 'onaylandi',
            ],
            [
                'etkinlikler_id' => 11,
                'kullanicilar_id' => 3,
                'katilimciTipi' => 'giden',
                'durum' => 'beklemede',
            ],
            [
                'etkinlikler_id' => 11,
                'kullanicilar_id' => 4,
                'katilimciTipi' => 'giden',
                'durum' => 'reddedildi',
            ],
            [
                'etkinlikler_id' => 11,
                'kullanicilar_id' => 1,
                'katilimciTipi' => 'gidilen',
                'durum' => 'reddedildi',
            ]
        ]);
    }
}
