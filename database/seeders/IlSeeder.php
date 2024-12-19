<?php

namespace Database\Seeders;

use App\Models\Il;
use Illuminate\Database\Seeder;

class IlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Il::factory()->count(81)->create();
    }
}
