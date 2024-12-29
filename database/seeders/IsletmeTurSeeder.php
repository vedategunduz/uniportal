<?php

namespace Database\Seeders;

use App\Models\IsletmeTur;
use Illuminate\Database\Seeder;

class IsletmeTurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        IsletmeTur::insert([
            ['baslik' => 'Kamu'],
            ['baslik' => 'Firma'],
            ['baslik' => 'Sendika'],
        ]);
    }
}
