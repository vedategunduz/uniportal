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
                'class' => 'bg-red-700 text-white',
                'tip' => 1,
            ],
            // 2
            [
                'baslik' => 'Kongre',
                'class' => 'bg-orange-700 text-white',
                'tip' => 1,
            ],
            // 3
            [
                'baslik' => 'Konferans',
                'class' => 'bg-amber-700 text-white',
                'tip' => 1,
            ],
            // 4
            [
                'baslik' => 'Festival',
                'class' => 'bg-lime-700 text-white',
                'tip' => 1,
            ],
            // 5
            [
                'baslik' => 'Gala',
                'class' => 'bg-yellow-700 text-white',
                'tip' => 1,
            ],
            // 6
            [
                'baslik' => 'Etkinlik',
                'class' => 'bg-green-700 text-white',
                'tip' => 1,
            ],
            // 7
            [
                'baslik' => 'Çalıştay',
                'class' => 'bg-emerald-700 text-white',
                'tip' => 1,
            ],
            // 8
            [
                'baslik' => 'Sempozyum',
                'class' => 'bg-teal-700 text-white',
                'tip' => 1,
            ],
            // 9
            [
                'baslik' => 'Ortak alım',
                'class' => 'bg-sky-700 text-white',
                'tip' => 2,
            ],
            // 10
            [
                'baslik' => 'Sarf istek',
                'class' => 'bg-violet-700 text-white',
                'tip' => 2,
            ],
            // 11
            [
                'baslik' => 'Sponsor talep',
                'class' => 'bg-fuchsia-700 text-white',
                'tip' => 2,
            ],
            // 12
            [
                'baslik' => 'Eğitim',
                'class' => 'bg-rose-700 text-white',
                'tip' => 2,
            ],
            // 13
            [
                'baslik' => 'Ziyaret',
                'class' => 'bg-gray-700 text-white',
                'tip' => 3,
            ],
            [
                'baslik' => 'Kampanya',
                'class' => 'bg-blue-700 text-white',
                'tip' => 4,
            ],
        ]);
    }
}
