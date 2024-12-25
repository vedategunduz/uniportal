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
                'tur' => 'ETKİNLİK_TÜRÜ_1',
            ],
            [
                'tur' => 'ETKİNLİK_TÜRÜ_2',
            ],
            [
                'tur' => 'ETKİNLİK_TÜRÜ_3',
            ],
        ]);
    }
}
