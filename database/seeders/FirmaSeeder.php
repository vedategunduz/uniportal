<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Firma;

class FirmaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Firma::factory()->count(10)->create();
    }
}
