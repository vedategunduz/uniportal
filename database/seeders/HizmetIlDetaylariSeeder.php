<?php

namespace Database\Seeders;

use App\Models\HizmetIlDetaylari;
use Illuminate\Database\Seeder;

class HizmetIlDetaylariSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HizmetIlDetaylari::factory()->count(10)->create();
    }
}
