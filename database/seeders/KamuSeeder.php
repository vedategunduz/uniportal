<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kamu;

class KamuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kamu::factory()->count(5)->create();
    }
}
