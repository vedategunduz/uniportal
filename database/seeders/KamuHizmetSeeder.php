<?php

namespace Database\Seeders;

use App\Models\KamuHizmet;
use Illuminate\Database\Seeder;

class KamuHizmetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KamuHizmet::factory()->count(5)->create();
    }
}
