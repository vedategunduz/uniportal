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
            [
                'baslik' => 'Konser',
                'tip' => 1,
            ],
            [
                'baslik' => 'Kongre',
                'tip' => 1,
            ],
            [
                'baslik' => 'Konferans',
                'tip' => 1,
            ],
            [
                'baslik' => 'Festival',
                'tip' => 1,
            ],
            [
                'baslik' => 'Gala',
                'tip' => 1,
            ],
            [
                'baslik' => 'Etkinlik',
                'tip' => 1,
            ],
            [
                'baslik' => 'Çalıştay',
                'tip' => 1,
            ],
            [
                'baslik' => 'Sempozyum',
                'tip' => 1,
            ],
            [
                'baslik' => 'Ortak alım',
                'tip' => 2,
            ],
            [
                'baslik' => 'Sarf istek',
                'tip' => 2,
            ],
            [
                'baslik' => 'Sponsor talep',
                'tip' => 2,
            ],
            [
                'baslik' => 'Eğitim',
                'tip' => 2,
            ],
        ]);
    }
}
