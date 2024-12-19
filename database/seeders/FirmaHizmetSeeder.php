<?php

namespace Database\Seeders;

use App\Models\FirmaHizmet;
use Illuminate\Database\Seeder;

class FirmaHizmetSeeder extends Seeder
{
    public function run(): void
    {
        FirmaHizmet::factory()->count(10)->create();
    }
}
