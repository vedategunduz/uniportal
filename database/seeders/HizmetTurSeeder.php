<?php

namespace Database\Seeders;

use App\Models\HizmetTur;
use Illuminate\Database\Seeder;

class HizmetTurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HizmetTur::factory()->count(10)->create();
    }
}
