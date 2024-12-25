<?php

namespace Database\Seeders;

use App\Models\Yetkili;
use Illuminate\Database\Seeder;

class YetkiliSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Yetkili::create([
            'kullanicilar_id' => 1,
            'kamular_id' => 143,
        ]);
    }
}
