<?php

namespace Database\Seeders;

use App\Models\EtkinlikTur;
use Illuminate\Database\Seeder;

class EtkinlikTurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EtkinlikTur::insert([
            // 1
            [
            'baslik' => 'Konser',
            'tip' => 1,
            ],
            // 2
            [
            'baslik' => 'Kongre',
            'tip' => 1,
            ],
            // 3
            [
            'baslik' => 'Konferans',
            'tip' => 1,
            ],
            // 4
            [
            'baslik' => 'Festival',
            'tip' => 1,
            ],
            // 5
            [
            'baslik' => 'Gala',
            'tip' => 1,
            ],
            // 6
            [
            'baslik' => 'Etkinlik',
            'tip' => 1,
            ],
            // 7
            [
            'baslik' => 'Çalıştay',
            'tip' => 1,
            ],
            // 8
            [
            'baslik' => 'Sempozyum',
            'tip' => 1,
            ],
            // 9
            [
            'baslik' => 'Ortak alım',
            'tip' => 2,
            ],
            // 10
            [
            'baslik' => 'Sarf istek',
            'tip' => 2,
            ],
            // 11
            [
            'baslik' => 'Sponsor talep',
            'tip' => 2,
            ],
            // 12
            [
            'baslik' => 'Eğitim',
            'tip' => 2,
            ],
            // 13
            [
            'baslik' => 'Ziyaret',
            'tip' => 2,
            ],
        ]);
    }
}
