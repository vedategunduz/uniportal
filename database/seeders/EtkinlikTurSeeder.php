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
                'baslik' => 'konser veya performans',
            ],
            [
                'baslik' => 'eğitim',
            ],
            [
                'baslik' => 'kongre',
            ],
            [
                'baslik' => 'konferans',
            ],
            [
                'baslik' => 'festival veya fuar',
            ],
            [
                'baslik' => 'gala',
            ],
        ]);
    }
}
