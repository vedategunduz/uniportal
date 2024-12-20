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
        EtkinlikKatilim::create([
            'etkinlikler_id' => 1,
            'kullanicilar_id' => 1,
            'firmalar_id' => null,
            'kamular_id' => null,
            'durum' => 'beklemede',
        ]);
    }
}
